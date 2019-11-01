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
use App\Customer;
use App\Field;
use Auth;
use App\Loan;
use App\Holiday;
use DateTime;
use App\Setting;
use PDF;

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
            // // Check DPS Exists
            // $check_fdr_number = Service::where('accountNo', $fdr_record['accountNo'])
            //                             ->where('serviceno', $fdr_record['fdrno'])
            //                             ->where('servicename', 'DPS')
            //                             ->first();
            
            // if($check_fdr_number == null) {

            //     Service::insert(array('accountNo'=> $fdr_record['accountNo'], 'servicename'=> 'FDR', 'serviceno'=>$fdr_record['fdrno'], 'status'=> 1));
            //     return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
            // }

            $inserted_service = Service::create(array('accountNo'=> $dps_apply_data['accountNo'], 'servicename' => 'DPS', 'status'=> 1));
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

            // Auto Fdr No if Needed
            // if($get_prev_fdr == null) {
            //     $fdr_record['fdrno'] = 1;
            // } else {
            //     $fdr_record['fdrno'] = (int)$get_prev_fdr['fdrno'] + 1;
            // }
            // Auto Fdr No if Needed END
            // Else
            $fdr_record['fdrno'] = $fdr_apply_data['fdrno'];

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
            $interest_amount = ((int)$fdr_apply_data['fdramount'] * (float)$fdr_apply_data['fdrprofitrate']) / 100;
            // monthly amount
            $monthly_amount = ($interest_amount) / $number_of_month;

            // data
            $fdr_record['accountNo'] = $fdr_apply_data['accountNo'];
            $fdr_record['fdramount'] = $fdr_apply_data['fdramount'];
            $fdr_record['openingdate'] = $today;
            $fdr_record['tranxid'] = "Trx-fdr-".('D').time();
            $fdr_record['profitrate'] = (float)$fdr_apply_data['fdrprofitrate'];
            $fdr_record['fdrterms'] = "0-".$number_of_month;
            $fdr_record['monthlyamount'] = number_format($monthly_amount, 2, '.', ',');
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
        
        return view('service.fdr_apply', compact('dps_year_figure', 'banking_settings'));
    }

    public function fdrAccount(Request $request) {
        $searchname = $request->input('search');
        $fdr_accounts = Fdr::where('fdrs.accountNo', 'LIKE', '%'. $searchname .'%')->leftJoin('customers', 'fdrs.accountNo', '=', 'customers.accountNo')->select('fdrs.*', 'customers.fullname')->orderBy('fdrs.id', 'DESC')->paginate(20);

        return view('service.fdr_account_list', compact('fdr_accounts'));
    }

    public function fdrAccountDetail($id) {
        $fdr_account_detail = Fdr::where('fdrs.id', $id)
                                ->leftJoin('customers', 'customers.accountNo', '=', 'fdrs.accountNo')
                                ->select('fdrs.*', 'customers.fullname', 'customers.fathername', 'customers.customerpic')
                                ->first()->toArray();
        $fdr_records = FdrRecord::where('accountNo', $fdr_account_detail['accountNo'])->where('fdrno', $fdr_account_detail['fdrno'])->orderBy('id', 'DESC')->get();
        
        return view('service.fdr_account_detail', compact('fdr_account_detail', 'fdr_records'));
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

    public function closeFdrAccount(Request $request, $id) {
        $close_data = $request->except('_token');
        if($close_data && $close_data['closefdraccount'] == 'on') {
            
            $updated = Fdr::where('id', $id)->update([ 'fdrclosedate'=>$close_data['fdrclosedate'], 'returnamount'=>$close_data['returnamount'], 'fdrstatus'=>'close' ]);

            if($updated) {
                return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
            }
        }
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

                if( (int)($get_terms[0] + 1) == $get_terms[1] ) {
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

        $customer_list = Customer::where('field', Auth::user()->field)
                                        ->pluck('accountNo')
                                        ->toArray();
        // dd($customer_list);
        $loan_account_no = Loan::whereIn('accountNo', $customer_list)->groupBy('accountNo')->pluck('loanaccount', 'accountNo')->toArray();
        // dd($loan_list);
        $loan_apply_list = Loan::leftJoin('customers', 'loans.accountNo', '=', 'customers.accountNo')
                                ->where('loans.loanstatus', 'inactive')
                                ->where('loans.loanpermission', 'pending')
                                ->whereIn('loans.accountNo', $customer_list)
                                ->select('loans.*', 'customers.fullname')
                                ->get();
        // dd($loan_apply_list);
        $loan_approve_list = Loan::where('loanstatus', 'active')
                                ->where('loanpermission', 'approved')
                                ->whereIn('accountNo', $customer_list)
                                ->orderBy('loandate', 'DESC')
                                ->get();

        $loan_apply_data = $request->all();
        
        if($request->isMethod('post') && $loan_apply_data) {
            $loan_apply_save['accountNo'] = $loan_apply_data['accountNo'];
            $loan_apply_save['loanapplytranxid'] = "Trx-ln-".('D').time();
            $loan_apply_save['loanamount'] = $loan_apply_data['loanamount'];
            $loan_apply_save['loaninterest'] = $loan_apply_data['loaninterest'];
            $loan_apply_save['loanstatus'] = 'inactive';
            $loan_apply_save['loanpermission'] = 'pending';
            
            // dd($loan_apply_data);
            // Loan add
            $inserted_loan_apply = Loan::insert($loan_apply_save);

            if($inserted_loan_apply > 0) {

                return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
            }
            
        }
        
        // return view('service.dps_apply', compact('dps_year_figure'));
        return view('service.loan_apply', compact('loan_apply_list', 'loan_approve_list', 'loan_timeline', 'loan_settings', 'loan_account_no'));
    }

    function loanApproval(Request $request) {

        $from_date= date('Y-m-d', strtotime('2018-11-19'));
        $to_date= date('Y-m-d', strtotime('2018-11-23'));


        $loan_settings = DpsSetting::where('settingfor', 'LOAN')->first();

        $loan_approval = $request->all();
        // dd($loan_approval);
        if($loan_approval) {
            $apply_loan_amount = $loan_approval['loanamount'];
            $is_renew_loan = (array_key_exists('repermit', $loan_approval)) ? $loan_approval['repermit'] : null;
            // dd($loan_approval);
            $loanapplytranxid = $loan_approval['loanapplytranxid'];
            $accountNo = $loan_approval['accountNo'];    

            // Approve Loan
            if($loan_approval['loanpermission'] == 'approved') {
                
                $loan_terms_format = "+".$loan_approval['loanterms']."days";
                $enddate = date('Y-m-d', strtotime($loan_terms_format));
                $holidayCountBetweenDates = $this->holidayCountBetweenDates(date('Y-m-d', strtotime('next day')), $enddate);
                
                $dayCountBetweenDates = $this->dayCountBetweenDates(date('Y-m-d', strtotime('next day')), $enddate);
                
                
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
                $loan_approval['loanaccount'] = $loan_approval['loanaccount'];
                $loan_approval['loandate'] = date('Y-m-d');
                $next_collection_date_start = date('Y-m-d', strtotime('next day'));
                // echo $next_collection_date_start;
                // die;
                if($loan_approval['loaninterest'] == 0 || $loan_approval['loaninterest'] == null) {
                    $loantotal = $loan_approval['loanamount'];
                } else {
                    $loantotal = $loan_approval['loanamount'] + (($loan_approval['loanamount'] * $loan_approval['loaninterest']) / 100);
                }
                $dailyamount = ($loantotal / (int)$loan_approval['loanterms']);
                // dd($loan_approval);
                unset($loan_approval['_token']);
                unset($loan_approval['loanamount']);
                unset($loan_approval['accountNo']);
                unset($loan_approval['loanapplytranxid']);
                unset($loan_approval['repermit']);

                // check next day holiday
                
                $next_working_day = $this->getNextWorkingDayIncludeFriday($loan_approval['loandate']);
                
                // Next working day END
                
                $loan_approval['loantotal'] = $loantotal;
                $loan_approval['loandue'] = $loantotal;
                $loan_approval['loaninterest'] = $loan_approval['loaninterest'];
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
                    
                    if($is_renew_loan == null) {
                        // Transfer Loan Amount to SB Account
                        $get_last_tranx_data = DB::table('customer_transaction_history')->where('accountNo', $accountNo)
                                                ->orderBy('id', 'DESC')
                                                ->first();
                        if($get_last_tranx_data) {
                            $current_balance = $get_last_tranx_data->current_balance;
                            $new_current_balance = $current_balance + $apply_loan_amount;
                            $get_tranx_no = customer_transaction($accountNo, null, $loan_approval['loandate'], 'credit', 'loan', $apply_loan_amount, $new_current_balance);

                            if($get_tranx_no) {
                                Customer::where('accountNo', $accountNo)->update(['balance' => $new_current_balance]);
                                }
                            }
                    }
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

    public function loanAccount(Request $request) {
        $field_no = Auth::user()->field;
        $searchname = $request->input('search');
        $field_customers = field_customer($field_no);
        $field_customers_comma = implode(',', $field_customers);
        
        $loan_accounts = Loan::where('loanaccount', 'LIKE', '%'. $searchname .'%')->where('loans.loanstatus', '<>', 'inactive')->whereIn('loans.accountNo', $field_customers)->leftJoin('customers', 'loans.accountNo', '=', 'customers.accountNo')->select('loans.*', 'customers.fullname')->orderBy('loans.id', 'DESC')->paginate(20);
        // dd($loan_accounts);

        return view('service.loan_account_list', compact('loan_accounts'));
    }

    public function loanAccountDetail($id) {
        $loan_account_detail = Loan::where('loans.id', $id)
                                ->leftJoin('customers', 'customers.accountNo', '=', 'loans.accountNo')
                                ->select('loans.*', 'customers.fullname', 'customers.fathername', 'customers.customerpic')
                                ->first()->toArray();
        $loan_records = DB::table('loan_rocords')
                                ->where('loanno', $loan_account_detail['loanno'])
                                ->where('accountNo', $loan_account_detail['accountNo'])
                                ->paginate(10);
        
        return view('service.loan_account_detail', compact('loan_account_detail', 'loan_records'));
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
                
                $get_loan_deposite['loanaccount'] = $get_loan_data['loanaccount'];
                $get_loan_deposite['loantranxid'] = "Trx-lnD-".('D').time();
                $get_loan_deposite['currentdue'] = $get_loan_data['loandue'] - $get_loan_deposite['dailyamount'];
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
                        if(date('Y-m-d') == $get_loan_data['loanending']) {
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
                $get_loan_deposite['currentdue'] = $get_loan_data['loandue'] - $get_loan_deposite['dailyamount'];
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

                        // Checking for Loan Complitation
                        if(date('Y-m-d') == $get_loan_data['loanending']) {
                            // dd(1);
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
                        } elseif(date('Y-m-d') > $get_loan_data['loanending']) {
                            // dd(2);
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

    function loanCollection() {

        if(date("N") != 5){

            $days_count = Holiday::where('holidaystartdate', date('Y-m-d'))->first();
            if($days_count == null) {

                $customer_list = Customer::where('field', Auth::user()->field)
                                        ->pluck('accountNo')
                                        ->toArray();

                $current_user_customer_loan = DB::table('loans')
                                                ->leftJoin('customers', 'loans.accountNo', '=', 'customers.accountNo')
                                                ->select('loans.*', 'loans.id as loan_id', 'customers.fullname', 'customers.id as customer_id')
                                                ->whereIn('loans.accountNo', $customer_list)
                                                ->where('loans.loanstatus', 'active')
                                                ->where('loans.loanpermission', 'approved')
                                                ->get();
                // dd($current_user_customer_loan);
                $index = 0;
                $customer_not_collected = array();
                foreach($current_user_customer_loan as $loan) {
                    // Chekc today loan collection
                    $check_collection_has = DB::table('loan_rocords')->where('receivedate', date('Y-m-d'))->where('accountNo', $loan->accountNo)->first();
                    
                    if($check_collection_has == null) {
                        
                        $customer_not_collected[$index]['loan_id'] = $loan->loan_id;
                        $customer_not_collected[$index]['loanaccount'] = $loan->loanaccount;
                        $customer_not_collected[$index]['loanno'] = $loan->loanno;
                        $customer_not_collected[$index]['fullname'] = $loan->fullname;
                        $customer_not_collected[$index]['customer_id'] = $loan->customer_id;
                        $customer_not_collected[$index]['loanapplytranxid'] = $loan->loanapplytranxid;
                        $customer_not_collected[$index]['accountNo'] = $loan->accountNo;
                        $customer_not_collected[$index]['loandate'] = $loan->loandate;
                        $customer_not_collected[$index]['loanending'] = $loan->loanending;
                        $customer_not_collected[$index]['loanamount'] = $loan->loanamount;
                        $customer_not_collected[$index]['loantotal'] = $loan->loantotal;
                        $customer_not_collected[$index]['loandue'] = $loan->loandue;
                        $customer_not_collected[$index]['loaninterest'] = $loan->loaninterest;
                        $customer_not_collected[$index]['loanterms'] = $loan->loanterms;
                        $customer_not_collected[$index]['dailyamount'] = $loan->dailyamount;
                        $customer_not_collected[$index]['next_collection_date'] = $loan->next_collection_date;
                        $customer_not_collected[$index]['loanending'] = $loan->loanending;
                        $customer_not_collected[$index]['loanfailcount'] = $loan->loanfailcount;
                    }
                    $index++;
                }
                
                // dd($customer_not_collected);
            }
        } else {
            $customer_not_collected = array();
        }


        return view('service.loan_collection_list', compact('customer_not_collected'));
    }

    function rePermitLoan(Request $request) {
        $get_repermit_data = $request->except('_token');
        // dd($get_repermit_data);
        if($get_repermit_data && $request->isMethod('post')) {
            // dd($get_repermit_data);
            $updated = Loan::where('loanapplytranxid', $get_repermit_data['loanapplytranxid'])->update(array('loanpermission'=> $get_repermit_data['loanpermission']));
            if($updated > 0) {
                return Redirect::back()->with('msg_success', trans('Loan Re Permited Successfully'));
            }
        }
    }

    // Custom Collection For Loan After Fail
    function customCollection(Request $request) {
        $custom_collection_data = $request->except('_token');
        // dd($custom_collection_data);
        $udated_loan_data = array();
        $insert_loan_record_data = array();
        if($custom_collection_data && $request->isMethod('post')) {
            $custom_collection_loan_data = Loan::where('accountNo', $custom_collection_data['accountNo'])
                                            ->where('loanno', $custom_collection_data['loanno'])
                                            ->where('loanapplytranxid', $custom_collection_data['loantranxid'])
                                            ->first();
            
            if($custom_collection_loan_data['loandue'] > $custom_collection_data['dailyamount']) {

                $insert_loan_record_data['accountNo'] = $custom_collection_data['accountNo'];
                $insert_loan_record_data['loanno'] = $custom_collection_data['loanno'];
                $insert_loan_record_data['loantranxid'] = "Trx-lnD-".('D').time();
                $insert_loan_record_data['receivedate'] = $custom_collection_data['receivedate'];
                $insert_loan_record_data['currentterms'] = 'custom';
                $insert_loan_record_data['dailyamount'] = $custom_collection_data['dailyamount'];
                $insert_loan_record_data['currentdue'] = $custom_collection_loan_data['loandue'] - $custom_collection_data['dailyamount'];

                $inserted_record = DB::table('loan_rocords')->insert($insert_loan_record_data);
                

                $udated_data['loandue'] = $custom_collection_loan_data['loandue'] - $custom_collection_data['dailyamount'];
                if($inserted_record > 0) {
                    $updated_record = Loan::where('accountNo', $custom_collection_data['accountNo'])
                                            ->where('loanno', $custom_collection_data['loanno'])
                                            ->where('loanapplytranxid', $custom_collection_data['loantranxid'])
                                            ->update($udated_data);
                    if($updated_record > 0) {
                        return Redirect::back()->with('msg_success', trans('Custom Collection Successfully received'));
                    }
                }
            } elseif($custom_collection_loan_data['loandue'] == $custom_collection_data['dailyamount']) {

                $insert_loan_record_data['accountNo'] = $custom_collection_data['accountNo'];
                $insert_loan_record_data['loanno'] = $custom_collection_data['loanno'];
                $insert_loan_record_data['loantranxid'] = "Trx-lnD-".('D').time();
                $insert_loan_record_data['receivedate'] = $custom_collection_data['receivedate'];
                $insert_loan_record_data['currentterms'] = 'custom';
                $insert_loan_record_data['dailyamount'] = $custom_collection_data['dailyamount'];
                $insert_loan_record_data['currentdue'] = $custom_collection_loan_data['loandue'] - $custom_collection_data['dailyamount'];

                $inserted_record = DB::table('loan_rocords')->insert($insert_loan_record_data);
                

                $udated_data['loandue'] = $custom_collection_loan_data['loandue'] - $custom_collection_data['dailyamount'];
                $udated_data['loanstatus'] = 'success';
                $udated_data['loanpermission'] = 're-collected';
                if($inserted_record > 0) {
                    $updated_record = Loan::where('accountNo', $custom_collection_data['accountNo'])
                                            ->where('loanno', $custom_collection_data['loanno'])
                                            ->where('loanapplytranxid', $custom_collection_data['loantranxid'])
                                            ->update($udated_data);
                    if($updated_record > 0) {
                        return Redirect::back()->with('msg_success', trans('Custom Collection Successfully received'));
                    }
                }

            } else {
                return Redirect::back()->with('msg_warning', trans('Wrong Amount Submitted'));
            }
            
            // dd($udated_data);
        }
    }

    function dailyLoanNotCollectPdf($type) {
        $setting = Setting::where('app_name', 'New Uttara Shanchoi')->first()->toArray();
        $setting['date'] = date('F d, Y');
        $setting['field'] = DB::table('fields')->where('id', Auth::user()->field)->first();

        if(date("N") != 5){

            $days_count = Holiday::where('holidaystartdate', date('Y-m-d'))->first();
            if($days_count == null) {

                $customer_list = Customer::where('field', Auth::user()->field)
                                        ->pluck('accountNo')
                                        ->toArray();

                $current_user_customer_loan = DB::table('loans')
                                                ->leftJoin('customers', 'loans.accountNo', '=', 'customers.accountNo')
                                                ->select('loans.*', 'loans.id as loan_id', 'customers.fullname', 'customers.id as customer_id')
                                                ->whereIn('loans.accountNo', $customer_list)
                                                ->where('loans.loanstatus', 'active')
                                                ->where('loans.loanpermission', 'approved')
                                                ->get();
                // dd($current_user_customer_loan);
                $index = 0;
                $customer_not_collected = array();
                foreach($current_user_customer_loan as $loan) {
                    // Chekc today loan collection
                    $check_collection_has = DB::table('loan_rocords')->where('receivedate', date('Y-m-d'))->where('accountNo', $loan->accountNo)->first();
                    
                    if($check_collection_has == null) {
                        
                        $customer_not_collected[$index]['loan_id'] = $loan->loan_id;
                        $customer_not_collected[$index]['loanaccount'] = $loan->loanaccount;
                        $customer_not_collected[$index]['loanno'] = $loan->loanno;
                        $customer_not_collected[$index]['fullname'] = $loan->fullname;
                        $customer_not_collected[$index]['customer_id'] = $loan->customer_id;
                        $customer_not_collected[$index]['loanapplytranxid'] = $loan->loanapplytranxid;
                        $customer_not_collected[$index]['accountNo'] = $loan->accountNo;
                        $customer_not_collected[$index]['loandate'] = $loan->loandate;
                        $customer_not_collected[$index]['loanending'] = $loan->loanending;
                        $customer_not_collected[$index]['loanamount'] = $loan->loanamount;
                        $customer_not_collected[$index]['loantotal'] = $loan->loantotal;
                        $customer_not_collected[$index]['loandue'] = $loan->loandue;
                        $customer_not_collected[$index]['loaninterest'] = $loan->loaninterest;
                        $customer_not_collected[$index]['loanterms'] = $loan->loanterms;
                        $customer_not_collected[$index]['dailyamount'] = $loan->dailyamount;
                        $customer_not_collected[$index]['next_collection_date'] = $loan->next_collection_date;
                        $customer_not_collected[$index]['loanending'] = $loan->loanending;
                        $customer_not_collected[$index]['loanfailcount'] = $loan->loanfailcount;
                    }
                    $index++;
                }
                
                // dd($customer_not_collected);
            }
        } else {
            $customer_not_collected = array();
        }

        if($type == 'pdf') {
            $pdf = PDF::loadView('report.daily_loan_not_collect_pdf',compact('customer_not_collected', 'setting', 'type')); 
            return $pdf->download(date('Y-m-d').'_daily_loan_collection_due_'.$setting['field']->fieldname.'.pdf');
            // return view('report.daily_loan_not_collect_pdf',compact('customer_not_collected', 'setting'));
        } elseif($type == 'print') {

            return view('report.daily_loan_not_collect_pdf',compact('customer_not_collected', 'setting', 'type'));
        }

        
    }


    // Daily Loan Collection Report
    function dailyLoanCollection(Request $request) {
        $filter_field = $request->except('_token');
        $field_no = Auth::user()->field;
        $field_lists = Field::where('fieldstatus', 1)->get();
        $field_name = '';
        if(Auth::user()->hasRole('Admin')) {
            
            if($request->isMethod('POST')) {
                $field_name = Field::where('id', $filter_field['field_id'])->first();
                // dd($field_name['fieldname']);
                $daily_collection_report = DB::table('loan_rocords')
                                        ->leftJoin('customers', 'loan_rocords.accountNo', '=', 'customers.accountNo')
                                        ->leftJoin('fields', 'customers.field', '=', 'fields.id')
                                        ->select('loan_rocords.*', 'customers.id as customer_id', 'customers.fullname', 'customers.field', 'fields.fieldname')
                                        ->where('receivedate', date('Y-m-d'))
                                        ->where('customers.field', $filter_field['field_id'])
                                        ->get();
            } else {
                $daily_collection_report = [];
            }
            
            
        } else {
            $field_no = Auth::user()->field;
            $daily_collection_report = DB::table('loan_rocords')
                                        ->leftJoin('customers', 'loan_rocords.accountNo', '=', 'customers.accountNo')
                                        ->leftJoin('fields', 'customers.field', '=', 'fields.id')
                                        ->select('loan_rocords.*', 'customers.id as customer_id', 'customers.fullname', 'customers.field', 'fields.fieldname')
                                        ->where('receivedate', date('Y-m-d'))
                                        ->where('customers.field', $field_no)
                                        ->get();
            
        }
        

        // dd($daily_collection_report );
        return view('report.daily_loan_collection', compact('daily_collection_report', 'field_lists', 'field_name'));
    }

    function dailyLoanCollectionPdf() {

        $setting = Setting::where('app_name', 'New Uttara Shanchoi')->first()->toArray();
        $setting['date'] = date('F d, Y');
        $setting['field'] = DB::table('fields')->where('id', Auth::user()->field)->first();
        // dd($setting);
        $daily_collection_report = DB::table('loan_rocords')
          ->leftJoin('customers', 'loan_rocords.accountNo', '=', 'customers.accountNo')
          ->leftJoin('fields', 'customers.field', '=', 'fields.id')
          ->select('loan_rocords.*', 'customers.id as customer_id', 'customers.fullname', 'customers.field', 'fields.fieldname')
          ->where('receivedate', date('Y-m-d'))
          ->where('customers.field', Auth::user()->field)
          ->get();

        $pdf = PDF::loadView('report.daily_loan_collection_pdf',compact('daily_collection_report', 'setting')); 
        return $pdf->download(date('Y-m-d').'_loan_collection_'.$setting['field']->fieldname.'.pdf');
        // return view('report.daily_loan_collection_pdf',compact('daily_collection_report', 'setting'));
    }

    public function dailyLoanCollectionPrint(){	
        $setting = Setting::where('app_name', 'New Uttara Shanchoi')->first()->toArray();
        $setting['date'] = date('F d, Y');
        $setting['field'] = DB::table('fields')->where('id', Auth::user()->field)->first();
        // dd($setting);
        $daily_collection_report = DB::table('loan_rocords')
          ->leftJoin('customers', 'loan_rocords.accountNo', '=', 'customers.accountNo')
          ->leftJoin('fields', 'customers.field', '=', 'fields.id')
          ->select('loan_rocords.*', 'customers.id as customer_id', 'customers.fullname', 'customers.field', 'fields.fieldname')
          ->where('receivedate', date('Y-m-d'))
          ->where('customers.field', Auth::user()->field)
          ->get();

		return view('report.daily_loan_collection_print',compact('daily_collection_report', 'setting')); 
	}

    // Daily Loan Collection Report
    function monthlyLoanCollection() {
        $from_date = date('Y-m-1');
        $to_date = date('Y-m-31');

        $daily_collection_report = DB::table('loan_rocords')
          ->leftJoin('customers', 'loan_rocords.accountNo', '=', 'customers.accountNo')
          ->leftJoin('fields', 'customers.field', '=', 'fields.id')
          ->select('loan_rocords.*', 'customers.id as customer_id', 'customers.fullname', 'customers.field', 'fields.fieldname')
          ->whereBetween('receivedate', [$from_date, $to_date])
          ->groupBy('loan_rocords.accountNo')
          ->get();

        // dd($daily_collection_report );
        return view('report.daily_loan_collection', compact('daily_collection_report'));
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
