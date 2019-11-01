<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use View;
use App\Foo;
use App\Dps;
use App\Fdr;
use App\DpsSetting;
use App\DpsRecords;
use App\FdrRecord;
use App\Service;
use App\Loan;
use App\Holiday;
use DateTime;

class ServiceController extends Controller
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
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dpsApply(Request $request)
    {
        
        $dps_record = array();
        $dps_settings = DpsSetting::where('id', 1)->first();
        $dps_year_figure = explode(',', $dps_settings['yearfigure']);
        
        $dps_apply_data = $request->all();
        
        if($dps_apply_data) {
            $dps_record['accountNo'] = $dps_apply_data['accountNo'];
            $dps_record['monthlyamount'] = $dps_apply_data['monthlyamount'];
            $dps_record['trnxNo'] = "Trx-".date('D').time();
            $dps_record['terms'] = '1-'.$dps_apply_data['numberofyear'] * 12;
            $dps_record['date'] = date('Y-m-d');
            $dps_record['nextdate'] = date("Y-m-d", strtotime("next month +1 day"));
            $dps_record['late'] = 0;
            $dps_record['monthlyinterest'] = (float)$dps_settings['interestrate'];
            $dps_record['monthlytotal'] = (float)$dps_apply_data['monthlyamount'] + $dps_settings['interestrate'];
            

            // DPS Registration
            $inserted_dps = Dps::create($dps_apply_data);
            $inserted_service = Service::create(array('accountNo'=> $dps_apply_data['accountNo'], 'servicename' => 'DPS'));
            if($inserted_dps->id > 0 && $inserted_service->id > 0) {

                // Add First Month Record
                $inserted_dps_record = DpsRecords::create($dps_record);

                return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
            }
            
        }
        
        return view('service.dps_apply', compact('dps_year_figure'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dpsDeposite(Request $request)
    {
        $dps_deposite_data = $request->except('_token');

        $dps_settings = DpsSetting::where('settingfor', 'DPS')->first();
        $dps_record = DpsRecords::where('accountNo', $dps_deposite_data['accountNo'])->orderBy('id', 'desc')->first();

        // Get Terms
        $get_terms = explode('-', $dps_record['terms']);
        // Get Next Date
        $fdate = $dps_record['nextdate'];
        $tdate = $dps_deposite_data['date'];
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        $days_diff = $interval->format('%R%a');

        // check before
        $days_sign = substr($days_diff, 0, 1);
        $days_number = (int)substr($days_diff, 1);
        // late rule
        $late_days = (int)$dps_settings['latedateno'];
        // dd($days_number);
        
        if ($dps_deposite_data) {
            
            $dps_deposite_data['trnxNo'] = "Trx-".date('D').time();
            $dps_deposite_data['terms'] = (int)($get_terms[0] + 1).'-'.$get_terms[1];
            $dps_deposite_data['date'] = date('Y-m-d', strtotime($dps_deposite_data['date']));
            $dps_deposite_data['nextdate'] = date('Y-m-d', strtotime('next month', strtotime($dps_record['nextdate'])));
            if($days_sign == '-') {
                $late_status = 0;
            } else {
                if($days_number >= $late_days) {
                    $late_status = $days_number - $late_days;
                } else {
                    $late_status = 0;
                }
            }
            $dps_deposite_data['late'] = $late_status;
            $dps_deposite_data['monthlyinterest'] = (float)$dps_settings['interestrate'];
            $dps_deposite_data['monthlytotal'] = (float)($dps_deposite_data['monthlyamount'] + $dps_settings['interestrate']);


            $inserted = DpsRecords::create($dps_deposite_data);
            if($inserted->id > 0) {

                return Redirect::back()->with('msg_success', trans('app.insert_success_message'));

            }
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fdrApply(Request $request)
    {
        
        $fdr_record = array();
        $banking_settings = DpsSetting::where('settingfor', 'FDR')->first();
        $dps_year_figure = explode(',', $banking_settings['yearfigure']);
        
        $fdr_apply_data = $request->except('_token');

        
        if($request->isMethod('post') && $fdr_apply_data) {
            $today = date('Y-m-d');
            // get Prev Fdr
            $get_prev_fdr = Fdr::where('accountNo', $fdr_apply_data['accountNo'])
                ->where('fdrstatus', 'active')
                ->orWhere('fdrstatus', 'success')
                ->orderBy('id', 'DESC')
                ->first();

            // dd($get_prev_fdr);
            if($get_prev_fdr == null) {
                $fdr_record['fdrno'] = 1;
            } else {
                $fdr_record['fdrno'] = (int)$get_prev_fdr['fdrno'] + 1;
            }
            // dd($fdr_record['fdrno']);
            // FDR Registration Data
            $fdr_year = "+".$fdr_apply_data['numberofyear']." year";
            $next_day = date('Y-m-d', strtotime('next day'));
            $next_month = date('Y-m-d', strtotime('next month', strtotime($next_day)));
            $end_year = date('Y-m-d', strtotime($fdr_year, strtotime($next_day)));
            $fdr_apply_data['profitrate'] = $banking_settings['interestrate'];
            $fdr_apply_data['serviceenddate'] = date("Y-m-d", strtotime($fdr_year));

            // number of month
            $number_of_month = (int)$fdr_apply_data['numberofyear'] * 12;
            
            // Interest Calculation
            $interest_amount = ((int)$fdr_apply_data['fdramount'] * (float)$banking_settings['interestrate']) / 100;
            // monthly amount
            $monthly_amount = ($fdr_apply_data['fdramount'] + $interest_amount) / $number_of_month;

            // data
            $fdr_record['accountNo'] = $fdr_apply_data['accountNo'];
            $fdr_record['fdramount'] = $fdr_apply_data['fdramount'];
            $fdr_record['tranxid'] = "Trx-fdr-".('D').time();
            $fdr_record['totalamount'] = ($fdr_apply_data['fdramount'] + $interest_amount);
            $fdr_record['dueamount'] = ($fdr_apply_data['fdramount'] + $interest_amount);
            $fdr_record['profitrate'] = $banking_settings['interestrate'];
            $fdr_record['fdrterms'] = "0-".$number_of_month;
            $fdr_record['monthlyamount'] = $monthly_amount;
            $fdr_record['numberofyear'] = $fdr_apply_data['numberofyear'];
            $fdr_record['serviceenddate'] = $end_year;
            $fdr_record['nextwithdrawdate'] = $next_month;
            $fdr_record['fdrpermission'] = 'approved';
            $fdr_record['fdrstatus'] = 'active';
            
            // dd($fdr_record);
            // FDR Registration
            $inserted_dps = Fdr::insert($fdr_record);

            // Check Loan Exists
            $check_fdr_number = Service::where('accountNo', $fdr_record['accountNo'])
                                        ->where('serviceno', $fdr_record['fdrno'])
                                        ->where('servicename', 'FDR')
                                        ->first();
            // dd($check_fdr_number);
            if($check_fdr_number == null) {

                Service::insert(array('accountNo'=> $fdr_record['accountNo'], 'servicename'=> 'FDR', 'serviceno'=>$fdr_record['fdrno'], 'status'=> 1));
                return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
            }

            // if($inserted_dps > 0) {

            //     $fdr_record['trnxNo'] = "Trx-fdrd-".('D').time();
            //     $fdr_record['date'] = date('Y-m-d');
            //     $fdr_record['nextdate'] = date('Y-m-d', strtotime('next month', strtotime($fdr_record['date'])));
            //     // Add First Month Record
            //     $inserted_dps_record = FdrRecords::create($dps_record);

            //     return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
            // }
            
        }
        
        return view('service.fdr_apply', compact('dps_year_figure'));
    }

    // Fdr Deposite
    public function fdrDeposite(Request $request)
    {
        $fdr_withdraw_data = $request->except('_token');
        
        $banking_settings = DpsSetting::where('settingfor', 'DPS')->first();
        
        
        if ($fdr_withdraw_data) {
            
            $fdr_data = Fdr::where('accountNo', $fdr_withdraw_data['accountNo'])
                                ->where('fdrno', $fdr_withdraw_data['fdrno'])
                                ->where('fdrstatus', 'active')
                                ->where('fdrpermission', 'approved')
                                ->first();
            
            // Get Terms
            $get_terms = explode('-', $fdr_data['fdrterms']);
            // Get Next Date
            $fdate = $fdr_data['nextwithdrawdate'];
            $tdate = $fdr_withdraw_data['withdrawdate'];
            $datetime1 = new DateTime($fdate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days_diff = $interval->format('%R%a');

            // check before
            $days_sign = substr($days_diff, 0, 1);
            $days_number = (int)substr($days_diff, 1);
            if($days_sign == '-') {
                return Redirect::back()->with('msg_warning', trans('Wrong date selected'));
            }
                
                
            $fdr_withdraw_data['trnxNo'] = "Trx-fd".date('D').time();
            $fdr_withdraw_data['fdrterms'] = (int)($get_terms[0] + 1).'-'.$get_terms[1];
            $fdr_withdraw_data['monthlyamount'] = $fdr_withdraw_data['monthlyamount'];
            $fdr_withdraw_data['nextdate'] = date('Y-m-d', strtotime('next month', strtotime($fdr_data['nextwithdrawdate'])));
            $fdr_withdraw_data['paymentstatus'] = 'paid';
            

            $inserted = FdrRecord::insert($fdr_withdraw_data);
            if($inserted > 0) {
                $fdr_update = array();

                $fdr_update['dueamount'] = $fdr_data['dueamount'] - $fdr_withdraw_data['monthlyamount'];
                $fdr_update['fdrterms'] = (int)($get_terms[0] + 1).'-'.$get_terms[1];
                $fdr_update['nextwithdrawdate'] = $fdr_withdraw_data['nextdate'];

                if( $fdr_update['dueamount'] == 0 && (int)($get_terms[0] + 1) == $get_terms[1] ) {
                    $fdr_update['fdrpermission'] = 'close';
                    $fdr_update['fdrstatus'] = 'success';

                    $close_service = Service::where('accountNo', $fdr_withdraw_data['accountNo'])
                            ->where('servicename', 'FDR')
                            ->where('serviceno', $fdr_withdraw_data['fdrno'])
                            ->update(array('status'=> 0));
                }

                $fdr_updated = Fdr::where('accountNo', $fdr_withdraw_data['accountNo'])
                    ->where('fdrno', $fdr_withdraw_data['fdrno'])
                    ->update($fdr_update);

                if($fdr_updated) {
                    return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
                }

            }
            
        }
    }

    public function loanApply(Request $request)
    {
        
        $loan_apply_save = array();
        $loan_settings = DpsSetting::where('settingfor', 'LOAN')->first();
        $loan_timeline = explode(',', $loan_settings['yearfigure']);

        $loan_apply_list = Loan::where('loanstatus', 'inactive')
                                ->where('loanpermission', 'pending')
                                ->get();
        $loan_approve_list = Loan::where('loanstatus', 'active')
                                ->where('loanpermission', 'approved')
                                ->orderBy('loandate', 'DESC')
                                ->get();

        $loan_apply_data = $request->all();
        
        if($request->isMethod('post') && $loan_apply_data) {
            $loan_apply_save['accountNo'] = $loan_apply_data['accountNo'];
            $loan_apply_save['loanapplytranxid'] = "Trx-ln-".('D').time();
            $loan_apply_save['loanamount'] = $loan_apply_data['loanamount'];
            $loan_apply_save['loanstatus'] = 'inactive';
            $loan_apply_save['loanpermission'] = 'pending';
            

            // Loan add
            $inserted_loan_apply = Loan::create($loan_apply_save);

            if($inserted_loan_apply->id > 0) {

                return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
            }
            
        }
        
        // return view('service.dps_apply', compact('dps_year_figure'));
        return view('service.loan_apply', compact('loan_apply_list', 'loan_approve_list', 'loan_timeline'));
    }

    function loanApproval(Request $request) {

        $from_date= date('Y-m-d', strtotime('2018-11-19'));
        $to_date= date('Y-m-d', strtotime('2018-11-23'));


        $loan_settings = DpsSetting::where('settingfor', 'LOAN')->first();

        $loan_approval = $request->all();
        if($loan_approval) {
            
            $loanapplytranxid = $loan_approval['loanapplytranxid'];
            $accountNo = $loan_approval['accountNo'];    

            // Approve Loan
            if($loan_approval['loanpermission'] == 'approved') {
                
                $loan_terms_format = "+".$loan_approval['loanterms']."days";
                $enddate = date('Y-m-d', strtotime($loan_terms_format));
                $holidayCountBetweenDates = $this->holidayCountBetweenDates(date('Y-m-d'), $enddate);
                $dayCountBetweenDates = $this->dayCountBetweenDates(date('Y-m-d'), $enddate);
                
                $total_dayoff = $holidayCountBetweenDates + $dayCountBetweenDates;
                $total_dayoff_format = "+$total_dayoff day";
                $loanEndingDate = date('Y-m-d', strtotime($total_dayoff_format, strtotime($enddate)));
                // Check ending date is friday
                if(date("N",strtotime($loanEndingDate)) == 5) {
                    $loanEndingDate = date('Y-m-d', strtotime('next day', strtotime($loanEndingDate)));
                }

                $get_last_loan_no = Loan::where('accountNo', $loan_approval['accountNo'])
                ->where('loanno', '!=', null)
                ->where('loanno', '!=', 0)
                ->orderBy('id', 'desc')
                ->first();
                $loan_approval['loanno'] = $get_last_loan_no['loanno'] + 1;
                $loan_approval['loandate'] = date('Y-m-d');
                $next_collection_date_start = date('Y-m-d', strtotime('next day'));
                // echo $next_collection_date_start;
                // die;
                if($loan_settings['interestrate'] == 0 || $loan_settings['interestrate'] == null) {
                    $loantotal = $loan_approval['loanamount'];
                } else {
                    $loantotal = $loan_approval['loanamount'] + (($loan_approval['loanamount'] * $loan_settings['interestrate']) / 100);
                }
                $dailyamount = ceil(($loantotal / (int)$loan_approval['loanterms']));
                
                unset($loan_approval['_token']);
                unset($loan_approval['loanamount']);
                unset($loan_approval['accountNo']);
                unset($loan_approval['loanapplytranxid']);

                // check next day holiday
                
                $next_working_day = $this->getNextWorkingDayIncludeFriday($loan_approval['loandate']);
                
                // Next working day END
                
                $loan_approval['loantotal'] = $loantotal;
                $loan_approval['loandue'] = $loantotal;
                $loan_approval['loaninterest'] = $loan_settings['interestrate'];
                $loan_approval['loanterms'] = "0-".$loan_approval['loanterms'];
                $loan_approval['dailyamount'] = $dailyamount;
                $loan_approval['loanending'] = $loanEndingDate;
                $loan_approval['loanfailcount'] = 0;
                $loan_approval['next_collection_date'] = $next_working_day;
                $loan_approval['loanstatus'] = 'active';
                $loan_approval['loanpermission'] = 'approved';

                // dd($loan_approval);
                                
                $updated_apply_loan = Loan::where('loanapplytranxid', $loanapplytranxid)
                                          ->where('accountNo', $accountNo)
                                          ->update($loan_approval);
                
                if($updated_apply_loan > 0) {
                    // Check Loan Exists
                    $check_loan_number = Service::where('accountNo', $accountNo)
                            ->where('serviceno', $loan_approval['loanno'])
                            ->where('servicename', 'LOAN')
                            ->first();
                    
                    if($check_loan_number == null) {
                        Service::insert(array('accountNo'=> $accountNo, 'servicename'=> 'LOAN', 'serviceno'=>$loan_approval['loanno'], 'status'=> 1));
                    }
                    return Redirect::back()->with('msg_success', trans('Loan successfully approved'));
                    
                }
            } else { // Canceled Loan
                unset($loan_approval['_token']);
                unset($loan_approval['loanterms']);
                unset($loan_approval['accountNo']);
                unset($loan_approval['loanapplytranxid']);

                $loan_approval['loanstatus'] = 'inactive';
                $loan_approval['loanpermission'] = 'canceled';

                $updated_apply_loan = Loan::where('loanapplytranxid', $loanapplytranxid)
                                          ->where('accountNo', $accountNo)
                                          ->update($loan_approval);
                
                if($updated_apply_loan > 0) {
                    return Redirect::back()->with('msg_warning', trans('Successfully updated loan without approve'));
                }
                
            }
                        
        }
        
    }

    function loanDeposite(Request $request) {
        $get_loan_deposite = $request->except('_token');
        // dd($get_loan_deposite);
        // get Loan data
        $get_loan_data = Loan::where('loanno', $get_loan_deposite['loanno'])
                            ->where('accountNo', $get_loan_deposite['accountNo'])
                            ->where('loanstatus', 'active')
                            ->where('loanpermission', 'approved')
                            ->first();
        
        if($get_loan_deposite) {
            $receive_date = date('Y-m-d', strtotime($get_loan_deposite['receivedate']));
            $date_should_be = $get_loan_data['next_collection_date'];

            // dd($date_should_be);
            if ($receive_date == $date_should_be) {
                
                $get_loan_deposite['loantranxid'] = "Trx-lnD-".('D').time();
                $get_loan_deposite['next_collection_date'] = $this->getNextWorkingDayIncludeFriday($get_loan_deposite['receivedate']);

                $inserted_id = DB::table('loan_rocords')->insertGetId($get_loan_deposite);
                
                // update loan data after daily collection
                if($inserted_id) {
                    $update_data = array();
                    
                    if($get_loan_data != null) {

                        // decrease Due
                        $update_data['loandue'] = $get_loan_data['loandue'] - $get_loan_deposite['dailyamount'];

                        // update Loan Terms
                        $prev_terms = explode('-', $get_loan_data['loanterms']);
                        $update_terms = $prev_terms[0] + 1;
                        $update_data['loanterms'] = $update_terms.'-'.$prev_terms[1];

                        $update_data['next_collection_date'] = $get_loan_deposite['next_collection_date'];

                        // Checking for Loan Complitation
                        if(date('Y-m-d', strtotime('2018-12-9')) == $get_loan_data['loanending']) {
                            if($prev_terms[1] == $update_terms) {
                                if($update_data['loandue'] == 0) {
                                    $update_data['loanstatus'] = 'success'; // Successfully completed
                                    $update_data['loanpermission'] = 'close';
                                } else {
                                    $update_data['loanstatus'] = 'fail'; // Fail
                                    $update_data['loanpermission'] = 'suspend';
                                }
                            } else {
                                $update_data['loanstatus'] = 'fail'; // Fail
                                $update_data['loanpermission'] = 'suspend';
                            }
                            
                            // Next Collection date not needed
                            $update_data['next_collection_date'] = null;
                            // Inactive service table
                            Service::where('accountNo', $get_loan_deposite['accountNo'])
                                    ->where('serviceno', $get_loan_deposite['loanno'])
                                    ->update(['status'=> 0]);
                        }
                        
                        $loan_update = Loan::where('loanno', $get_loan_deposite['loanno'])
                                            ->where('accountNo', $get_loan_deposite['accountNo'])
                                            ->where('loanstatus', 'active')
                                            ->where('loanpermission', 'approved')
                                            ->update($update_data);
                        if($loan_update > 0) {
                            return Redirect::back()->with('msg_success', trans('Collection Successfully Received'));
                        }
                    }
                }

            } elseif ($date_should_be < $receive_date) { // For Late
                
                $update_data = array();
                $get_loan_deposite['loantranxid'] = "Trx-lnD-".('D').time();
                $get_loan_deposite['next_collection_date'] = $this->getNextWorkingDayIncludeFriday($get_loan_deposite['receivedate']);
                
                // Late record Insert
                $late_record_inserted = DB::table('loan_rocords')->insert(
                    [
                        'accountNo' => $get_loan_deposite['accountNo'],
                        'loanno' => $get_loan_deposite['loanno'],
                        'receivedate' => $get_loan_data['next_collection_date'],
                        'currentterms' => 'late',
                    ]
                );
                // Increase Late Count
                if($late_record_inserted) {
                    $update_data['loanfailcount'] = (int)$get_loan_data['loanfailcount'] + 1;
                }
                // Loan Daily Record Insert
                $inserted_id = DB::table('loan_rocords')->insertGetId($get_loan_deposite);
                
                // update loan data after daily collection
                if($inserted_id) {
                                                        
                    if($get_loan_data != null) {

                        // decrease Due
                        $update_data['loandue'] = $get_loan_data['loandue'] - $get_loan_deposite['dailyamount'];

                        // update Loan Terms
                        $prev_terms = explode('-', $get_loan_data['loanterms']);
                        $update_terms = $prev_terms[0] + 1;
                        $update_data['loanterms'] = $update_terms.'-'.$prev_terms[1];

                        $update_data['next_collection_date'] = $get_loan_deposite['next_collection_date'];
                        
                        $loan_update = Loan::where('loanno', $get_loan_deposite['loanno'])
                                            ->where('accountNo', $get_loan_deposite['accountNo'])
                                            ->where('loanstatus', 'active')
                                            ->where('loanpermission', 'approved')
                                            ->update($update_data);
                        if($loan_update > 0) {
                            return Redirect::back()->with('msg_delete', trans('Collection Successfully Received With Late Count'));
                        }
                    }
                }

                // return Redirect::back()->with('msg_delete', trans('Collection Not Received! Wrong date selected.'));
            } else {
                return Redirect::back()->with('msg_warning', trans('Collection Not Received! Wrong Date selected.'));
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // @param1 Start Date
    // @param2 End Date
    // get Friday count
    function dayCountBetweenDates($f_date, $t_date) {

        $from_date= $f_date;
        $to_date= $t_date;

        $counter = 0;
        while(strtotime($from_date) <= strtotime($to_date)){

            //5 for count Friday, 6 for Saturday , 7 for Sunday

            if(date("N",strtotime($from_date)) == 5){
                $counter++;
            }
            $from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));

        }

        return $counter;
    }

    // @param1 Start Date
    // @param2 End Date
    function holidayCountBetweenDates($f_date, $t_date) {

        $from_date = $f_date;
        $to_date = $t_date;

        $days_count = Holiday::select(DB::raw('sum(holidaycount) as Total'))
                ->whereBetween('holidaystartdate', [$from_date, $to_date])
                ->first();
                
        return $days_count['Total'];
    }

    // Get Next Working Day
    function getNextWorkingDay($date_start) {
        // $date_start = date('Y-m-d', strtotime('next day'));

        // $next_holiday = date('Y-m-d', strtotime("next day", strtotime($date_start)));
        
        $i = 0;
        while($i == 0) {
            
            $get_holiday = Holiday::where('holidaystatus', '1')
                                    ->where('holidaystartdate', $date_start)
                                    ->first();
            
            if($get_holiday == null) {
                return $date_start;
                $i = 1;
            }
            $date_start = date('Y-m-d', strtotime("next day", strtotime($get_holiday['holidaystartdate'])));
            
        }
        
    }

    function getNextWorkingDayIncludeFriday($given_date) {

        // $given_date = date('Y-m-d');
        $next_collection_date_start = date('Y-m-d', strtotime('next day', strtotime($given_date)));

        $check_friday = date('l', strtotime("next day", strtotime($given_date)));
          
        if($check_friday != 'Friday') {
            // is not friday
            $get_holiday_next = $this->getNextWorkingDay($next_collection_date_start);
            
            if(date('l', strtotime($get_holiday_next)) == 'Friday') {
                $holiday_plus_friday_next = date('Y-m-d', strtotime("next day", strtotime($get_holiday_next)));
                $holiday_plus_friday_next_working_day = $this->getNextWorkingDay($holiday_plus_friday_next);

                if(date('l', strtotime($holiday_plus_friday_next_working_day)) == 'Friday') {
                    $holiday_plus_friday_next = date('Y-m-d', strtotime("next day", strtotime($holiday_plus_friday_next_working_day)));
                    $holiday_plus_friday_next_working_day = $this->getNextWorkingDay($holiday_plus_friday_next);

                    if(date('l', strtotime($holiday_plus_friday_next_working_day)) == 'Friday') {
                        $holiday_plus_friday_next = date('Y-m-d', strtotime("next day", strtotime($holiday_plus_friday_next_working_day)));
                        $holiday_plus_friday_next_working_day = $this->getNextWorkingDay($holiday_plus_friday_next);

                        $loan_approval['next_collection_date'] = $holiday_plus_friday_next_working_day;
                    } else {
                        $loan_approval['next_collection_date'] = $holiday_plus_friday_next_working_day;
                    }
                } else {
                    $loan_approval['next_collection_date'] = $holiday_plus_friday_next_working_day;
                }
                
            } else {
                $loan_approval['next_collection_date'] = $get_holiday_next;
            }
            
        } else {
            // is friday
            $firday_next_day = date('Y-m-d', strtotime("next day", strtotime($next_collection_date_start)));
            $get_holiday_next = $this->getNextWorkingDay($firday_next_day);
            if(date('l', strtotime($get_holiday_next)) == 'Friday') {
                $holiday_plus_friday_next = date('Y-m-d', strtotime("next day", strtotime($get_holiday_next)));
                $holiday_plus_friday_next_working_day = $this->getNextWorkingDay($holiday_plus_friday_next);
                if(date('l', strtotime($holiday_plus_friday_next_working_day)) == 'Friday') {
                    $holiday_plus_friday_next = date('Y-m-d', strtotime("next day", strtotime($holiday_plus_friday_next_working_day)));
                    $holiday_plus_friday_next_working_day = $this->getNextWorkingDay($holiday_plus_friday_next);

                    if(date('l', strtotime($holiday_plus_friday_next_working_day)) == 'Friday') {
                        $holiday_plus_friday_next = date('Y-m-d', strtotime("next day", strtotime($holiday_plus_friday_next_working_day)));
                        $holiday_plus_friday_next_working_day = $this->getNextWorkingDay($holiday_plus_friday_next);

                        $loan_approval['next_collection_date'] = $holiday_plus_friday_next_working_day;
                    } else {
                        $loan_approval['next_collection_date'] = $holiday_plus_friday_next_working_day;
                    }
                } else {
                    $loan_approval['next_collection_date'] = $holiday_plus_friday_next_working_day;
                }
            } else {
                $loan_approval['next_collection_date'] = $get_holiday_next;
            }
        }

        return $loan_approval['next_collection_date'];
    }
}
