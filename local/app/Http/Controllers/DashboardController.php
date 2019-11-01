<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\User;
use DB;
use Auth;
use Carbon\Carbon;
use Session;
use App\Foo;
use View;
use App\Helpers\Helper;
use App\Fdr;
use App\FdrRecord;
use App\Customer;



class DashboardController extends Controller
{
	
	  /**
     * Display a listing of the __construct.
     *
     * @return \Illuminate\Http\Response
     */
	 private $activities;
	 protected $foo;
	public function __construct(Foo $foo)
	{	
       $this->middleware('auth');	 
	   $this->foo = $foo;
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function index(Request $request){
        // Transfer Fdr Profit to customer sb account
        $this->fdrProfitTransfer();

		if (Auth::user()->hasRole('Admin')) {
			$totaluser = DB::table('users')->count();
			$newuser = DB::table('users')->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
			$todayvisitor = count(DB::table('user_activity')->groupBy('ip_address')->whereDate('created_at', '=', date('Y-m-d'))->get());
			$monthvisitor = count(DB::table('user_activity')->select([DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') AS `date`"),])->groupBy('ip_address')->groupBy('date')->where('created_at', '>=', Carbon::now()->startOfMonth())->get());			
			$recentuser = DB::table('users')->orderBy('id','DES')->limit(5)->get(); 			
			$graphregister = DB::table('users')->select([DB::raw("DATE_FORMAT(created_at, '%Y-%m') AS `date`,DATE_FORMAT(created_at, '%m') AS `month`"),
			DB::raw('COUNT(id) AS count'),])->groupBy('date')->orderBy('date', 'ASC')->get();
			
			return view('dashboard.dashboard_page',compact('todayvisitor','monthvisitor','totaluser','newuser','recentuser','recentactivity','graphregister')); 
        }
        
        // dd(Auth::user()->field);
        
		return $this->defaultDashboard();
		
			
		
	}
	
	 private function defaultDashboard(){
		 $id = Auth::id();
         $startDate  =  Carbon::now();
          $endDate =  Carbon::now()->subWeeks(3);
           $endDatetotal =  $startDate->diffInDays($endDate);
			for($x = $endDatetotal; $x>=0; $x--){
			$loopdate = Carbon::now()->subDays($x);			
			$stringdate =   $loopdate ->toDateString();
		   $todayvisitor[$x]['datet'] = $stringdate;
		   $todayvisitor[$x]['countdata'] = DB::table('user_activity')->groupBy('ip_address')->where('user_id',$id)->whereDate('created_at', '=', $stringdate)->count();		
		}	
		return view('dashboard.dashboard_user',compact('todayvisitor')); 
    }

    
    public function fdrProfitTransfer() {
        // System Today
        $today = date('Y-m-d');
        $get_today_profit_transfer = Fdr::where('fdrstatus', 'active')->where('nextwithdrawdate', $today)->get()->toArray();
        // dd($get_today_profit_transfer);

        foreach($get_today_profit_transfer as $single) {
            // Fdr Record Table
            $fdr_record_data = array();
            // Get Terms
            $get_terms = explode('-', $single['fdrterms']);
            
            $fdr_record_data['accountNo'] = $single['accountNo'];
            $fdr_record_data['fdrno'] = $single['fdrno'];
            $fdr_record_data['trnxNo'] = "Trx-fd".date('D').time();
            $fdr_record_data['fdrterms'] = (int)($get_terms[0] + 1).'-'.$get_terms[1];
            $fdr_record_data['withdrawdate'] = $today;
            $fdr_record_data['monthlyamount'] = $single['monthlyamount'];
            $fdr_record_data['nextdate'] = date('Y-m-d', strtotime('next month', strtotime($single['nextwithdrawdate'])));
            $fdr_record_data['paymentstatus'] = 'paid';

            FdrRecord::insert($fdr_record_data);
            // Fdr Record Table END

            // Customer transaction History Table
            $customer_prev_transaction_data = DB::table('customer_transaction_history')->where('accountNo', $single['accountNo'])->orderBy('id', 'DESC')->first();
            $customer_transaction_history = array();
            $customer_transaction_history['accountNo'] = $single['accountNo'];
            $customer_transaction_history['tranx_id'] = "Trx-".time();
            $customer_transaction_history['trans_date'] = $today;
            $customer_transaction_history['type'] = 'credit';
            $customer_transaction_history['purpose'] = "fdr {$single['fdrno']} profit";
            $customer_transaction_history['amount'] = $single['monthlyamount'];
            $customer_transaction_history['current_balance'] = $customer_prev_transaction_data->current_balance + $single['monthlyamount'];
            
            DB::table('customer_transaction_history')->insert($customer_transaction_history);
            // Customer transaction History Table END

            // Customer Table
            $customer = array();
            $customer_data = Customer::where('accountNo', $single['accountNo'])->pluck('balance')->toArray();
            $udate_balance = $customer_data[0] + $single['monthlyamount'];
            Customer::where('accountNo', $single['accountNo'])->update(['balance'=> $udate_balance]);
            // Customer Table END

            // Fdr Table
            $fdr_update = array();

            $fdr_update['fdrterms'] = (int)($get_terms[0] + 1).'-'.$get_terms[1];
            $fdr_update['nextwithdrawdate'] = date('Y-m-d', strtotime('next month', strtotime($single['nextwithdrawdate'])));

            if( (int)($get_terms[0] + 1) == $get_terms[1] ) {
                $fdr_update['fdrpermission'] = 'close';
                $fdr_update['fdrstatus'] = 'success';

                // $close_service = Service::where('accountNo', $fdr_withdraw_data['accountNo'])
                //         ->where('servicename', 'FDR')
                //         ->where('serviceno', $fdr_withdraw_data['fdrno'])
                //         ->update(array('status'=> 0));
            }

            $fdr_updated = Fdr::where('accountNo', $single['accountNo'])
                ->where('fdrno', $single['fdrno'])
                ->update($fdr_update);
            // Fdr Table END
            if($fdr_updated) {
                return Redirect::back()->with('msg_success', trans('All Fdr profit transfer Successfully')); 
            }

        }

        
    }

	
	
	

}
