<?php
namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\User;
use App\Setting;
use App\DpsSetting;
use DB;
use Auth;
use Session;
use App\Foo;
use App\Holiday;
use View;
use DateTime;


class SettingController extends Controller
{
	
	  /**
     * Display a listing of the __construct.
     *
     * @return \Illuminate\Http\Response
     */
	protected $foo;
	public function __construct(Foo $foo)
	{		
       $this->middleware('auth');	 
	   $this->foo = $foo;
	   $this->middleware('permission:settings.general');	  
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function index(Request $request){
        $settingdata = DB::table('settings')->get();
        
		return view('setting.general_setting',compact('settingdata')); 
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
	public function sidebar()
    {
	  $sidebaractivity = DB::table('user_activity')
		->leftJoin('users', 'users.id', '=', 'user_activity.user_id')
		->orderBy('user_activity.id','DES')->limit(5)->get();
		
		$sidebarusers = DB::table('users')->orderBy('id','DES')->limit(5)->get(); 
		
		$sidebarsettings = DB::table('settings')->first();		 
       return view('setting.sidebar',compact('sidebaractivity','sidebarusers','sidebarsettings')); 
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		 $input = $request->all();
		 $settingid = $request->input('settingid');
		 $countdata = DB::table('settings')->groupBy('id')->count();		
		 if(!empty($input)){
			  if($countdata<1){
				 Setting::create($input);
				 return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
			  }else{
				  $data = Setting::findOrFail($settingid);
				  $data->update($input);
				 return Redirect::back()->with('msg_update', trans('app.update_success_message'));
			  }
		 }
		 
	}
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $id)
    {	
		$input = $request->all();	
		$rules = array('logo' => 'required | mimes:jpeg,jpg,png,gif | max:5120');
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
            return Redirect::back()
                ->with('msg_delete', "Please choose file jpeg,jpg,png,gif & maximum size 5mb !");
        }		
		$logo = $request->file('logo');
		if(!empty($logo)){
		$filename  = time() . '.' . $logo->getClientOriginalExtension();
		 $request->file('logo')->move('./uploads/', $filename );
		 $data = Setting::findOrFail($id);
		  $data->logo = $filename;
		  $data->save();
		  /*for user activity */
        $description = array('description'=>'User Updated.');
	    $this->foo->users_activity($description);
			return Redirect::back()->with('msg_success', "Image Upload success!");
		}
		return Redirect::back()->with('msg_delete', "Image Upload Failed!");
	  
    }

    
    // Holiday
    public function holiday(Request $request) {
        $get_data = $request->except('_token');
        $multipledate = array();
        if($request->isMethod('post') && $get_data) {
            
            // dd($get_data);
            if($get_data['holidayname'] != '' && $get_data['holidaystartdate'] != '') {

                $holidayyear = date('Y', strtotime($get_data['holidaystartdate']));
                $holidaystartdate = date('Y-m-d', strtotime($get_data['holidaystartdate']));
                $holidaystatus = 1;

                $get_data['holidayyear'] = $holidayyear;
                $get_data['holidaystatus'] = 1;

                
                $get_data['holidaystartdate'] = date('Y-m-d', strtotime($get_data['holidaystartdate']));
                if($get_data['holidayenddate'] != '') {

                    $get_data['holidayenddate'] = date('Y-m-d', strtotime($get_data['holidayenddate']));

                    $fdate = $get_data['holidaystartdate'];
                    $tdate = $get_data['holidayenddate'];
                    $datetime1 = new DateTime($fdate);
                    $datetime2 = new DateTime($tdate);
                    $interval = $datetime1->diff($datetime2);
                    $days_diff = $interval->format('%R%a');

                    // check before
                    $days_sign = substr($days_diff, 0, 1);
                    $days_number = (int)substr($days_diff, 1);
                    if($days_sign == '-') {
                        return Redirect::back()->with('msg_delete', "Wrong Date Seletion");
                    } else {
                        $get_data['holidaycount'] = $days_number + 1;
                        
                        $i = 0;
                        for($i; $i <= $days_number; $i++) {

                            $nextday = "+$i days";
                            $nextholidaystartdate = $nextholidaystartdate = date('Y-m-d', strtotime($nextday, strtotime($holidaystartdate)));
                            $checkDayName = date('l', strtotime($nextholidaystartdate));
                            
                            if($checkDayName != 'Friday') {
                                $multipledate[$i] = array(
                                'holidayname' => $get_data['holidayname'],
                                'holidaystartdate' => $nextholidaystartdate,
                                'holidaycount'=> 1, 
                                'holidayyear'=>$holidayyear, 
                                'holidaystatus'=> 1,
                                'holidaytype'=> $get_data['holidaytype'],
                                'holidayremarks'=> $get_data['holidayremarks']
                                );
                            }
                            
                        }
                        
                        // dd($multipledate);
                        $insert_holiday = Holiday::insert($multipledate);
                        if($insert_holiday) {
                            return Redirect::back()->with('msg_success', "Holiday Save Successfully");
                        }
                    }
                } else {
                    $get_data['holidaycount'] = 1;
                    $checkDayName = date('l', strtotime($get_data['holidaystartdate']));
                    if($checkDayName != 'Friday') {
                        $insert_holiday = Holiday::create($get_data);
                        if($insert_holiday->id > 0) {
                            return Redirect::back()->with('msg_success', "Holiday Save Successfully");
                        }
                    } else {
                        return Redirect::back()->with('msg_success', "Holiday Save Successfully");
                    }
                    
                }
            } else {
                return Redirect::back()->with('msg_delete', "Holiday Name Or Start Date is missing");
            }
            
        }

        // $holidays = Holiday::all();
        $holidays = Holiday::groupBy('holidayname')
                            ->select('*', DB::raw('sum(holidaycount) as total'))
                            ->orderBy('holidaystartdate')
                            ->paginate(10);
        
        return view('holiday.holiday', compact('holidays')); 
    }

    // Banking Setting
    public function bankingSetting(Request $request) {
        $get_data = $request->all();
        $get_setting_from_db = DpsSetting::all();
        
        if($request->isMethod('post')) {
            if($get_data['settingfor'] == 'LOAN') {
                
                $updated = DpsSetting::where('settingfor', $get_data['settingfor'])->update(array('interestrate'=>$get_data['interestrate'], 'latedateno'=>$get_data['latedateno'], 'latefees'=>$get_data['latefees'], 'yearfigure'=>$get_data['yearfigure']));
                if($updated) {
                    return Redirect::back()->with('msg_success', trans('Setting has been saved'));
                }
            } elseif($get_data['settingfor'] == 'FDR') {
                $updated = DpsSetting::where('settingfor', $get_data['settingfor'])->update(array('interestrate'=>$get_data['interestrate'], 'latedateno'=>$get_data['latedateno'], 'latefees'=>$get_data['latefees'], 'yearfigure'=>$get_data['yearfigure']));
                if($updated) {
                    return Redirect::back()->with('msg_success', trans('Setting has been saved'));
                }
            } else {
                $updated = DpsSetting::where('settingfor', $get_data['settingfor'])->update(array('interestrate'=>$get_data['interestrate'], 'latedateno'=>$get_data['latedateno'], 'latefees'=>$get_data['latefees'], 'yearfigure'=>$get_data['yearfigure']));
                if($updated) {
                    return Redirect::back()->with('msg_success', trans('Setting has been saved'));
                }
            }
            
        }
        return view('setting.banking_setting', compact('get_setting_from_db'));
    }

    public function field(Request $request) {

        $get_field = $request->except('_token');
        $fields = DB::table('fields')->get();
        // dd($fields);
        if($request->isMethod('post')) {

            $get_field['fieldstatus'] = 1;
            
            $inserted = DB::table('fields')->insert($get_field);

            if($inserted) {
                return Redirect::back()->with('msg_success', trans('Field has been added'));
            }
        }
        
        return view('field.field', compact('fields')); 

    }

    public function transactionHead(Request $request) {
        $get_head_data = $request->except('_token');

        $transaction_head_lists = DB::table('transaction_head')->get();

        if($get_head_data && $request->isMethod('post')) {

            if(array_key_exists('assetfor', $get_head_data)) {
                $get_head_data['assetfor'] = $get_head_data['assetfor'];
            } else {
                $get_head_data['assetfor'] = null;
            }

            $inserted = DB::table('transaction_head')->insert($get_head_data);

            if($inserted) {
                return Redirect::back()->with('msg_success', trans('Head has been added'));
            }

        }
        
        return view('setting.transaction_head', compact('transaction_head_lists')); 

    }

}
