<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Foo;
use App\Customer;
use View;
use App\DpsRecords;
use App\FdrRecord;
use App\Loan;
use App\Fdr;
use App\Service;

class CustomerController extends Controller
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
     * Get Customer Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomer(Request $request)
    {
        $customer = $request->all();
        // dd($customer);

        $customerData = Customer::where('accountNo', $customer['account_id'])->first();

        // dd($customerData);

        return json_encode($customerData);
    }

    public function getCustomerLoan(Request $request)
    {
        $customer = $request->all();
        // return json_encode($customer);
        $field_no = Auth::user()->field;
        $customerData = Customer::where('accountNo', $customer['account_id'])->where('field', $field_no)->first();
        if($customerData != null) {
            return json_encode($customerData);
        } else {
            $customerData = null;
            return json_encode($customerData);
        }
        
        // dd($customerData);

    }

    public function getCustomerFdr(Request $request)
    {
        $customer = $request->all();
        // return json_encode($customer);

        $customerData = Customer::where('accountNo', $customer['account_id'])->first();

        return json_encode($customerData);

    }

    /**
     * Registration.
     *
     * @return \Illuminate\Http\Response
     */
    public function registration(Request $request)
    {   
        $get_reg_data = $request->except('_token');
        
        if($request->isMethod('post') && isset($get_reg_data) && !empty($get_reg_data)) {
           
            
            $get_reg_data['accountNo'] = $get_reg_data['accountNo'];
            $get_reg_data['balance'] = $get_reg_data['balance'];
            $get_reg_data['opening_date'] = $get_reg_data['opening_date'];
            
            if($get_reg_data['inputfatherorhus'] == 1) {
                $get_reg_data['fathername'] = 'F-'.$get_reg_data['fathername'];
            } else {
                $get_reg_data['fathername'] = 'H-'.$get_reg_data['fathername'];
            }

            // For Nominee
            if($get_reg_data['nomfatherorhus'] == 1) {
                $get_reg_data['nomfathername'] = 'F-'.$get_reg_data['nomfathername'];
            } else {
                $get_reg_data['nomfathername'] = 'H-'.$get_reg_data['nomfathername'];
            }
            
            // Image Upload
            $rules = array('logo' => 'required | mimes:jpeg,jpg,png,gif | max:5120');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with('msg_delete', "Please choose file jpeg,jpg,png,gif & maximum size 5mb !");
            }		
            $logo = $request->file('logo');
            $signaturepic = $request->file('signaturepic');
            $nompic = $request->file('nompic');
            $nomsignature = $request->file('nomsignature');
            
            $get_reg_data['field'] = Auth::user()->field;
            
            $transaction_data = array();
            $transaction_data['accountNo'] = $get_reg_data['accountNo'];
            $transaction_data['trans_date'] = $get_reg_data['opening_date'];
            $transaction_data['type'] = 'credit';
            $transaction_data['purpose'] = 'opening';
            $transaction_data['amount'] = $get_reg_data['balance'];
            $transaction_data['current_balance'] = $get_reg_data['balance'];
            $transaction_data['status'] = '1';
            // unset($get_reg_data['logo']);
            // Image Upload ENd
            // dd($get_reg_data);
            // Insert to database
            $insert_reg = Customer::create($get_reg_data);
            // Signature Upload
            if(!empty($signaturepic) && $insert_reg->id > 0){

                $filename  = time() . '-sig.' . $signaturepic->getClientOriginalExtension();
                $request->file('signaturepic')->move('./uploads/', $filename );
                $data = Customer::findOrFail($insert_reg->id);
                $data->signaturepic = $filename;
                $data->save();

            }
            // Nominee Pic Upload
            if(!empty($nompic) && $insert_reg->id > 0){

                $filename  = time() . '-nompic.' . $nompic->getClientOriginalExtension();
                $request->file('nompic')->move('./uploads/', $filename );
                $data = Customer::findOrFail($insert_reg->id);
                $data->nompic = $filename;
                $data->save();

            }
            // Nominee Signature Upload
            if(!empty($nomsignature) && $insert_reg->id > 0){

                $filename  = time() . '-nomsig.' . $nomsignature->getClientOriginalExtension();
                $request->file('nomsignature')->move('./uploads/', $filename );
                $data = Customer::findOrFail($insert_reg->id);
                $data->nomsignature = $filename;
                $data->save();

            }
            // picture upload
            if(!empty($logo) && $insert_reg->id > 0){

                $filename  = time() . '-pic.' . $logo->getClientOriginalExtension();
                $request->file('logo')->move('./uploads/', $filename );
                $data = Customer::findOrFail($insert_reg->id);
                $data->customerpic = $filename;
                $data->save();

                DB::table('customer_transaction_history')->insert($transaction_data);

            }
            
            return Redirect::to('customer-list')->with('msg_success', trans('app.insert_success_message'));
            
        }

        
        return view('customer.customer_registration');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imageUpload(Request $request, $id)
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
		 $data = Customer::findOrFail($id);
		  $data->customerpic = $filename;
		  $data->save();
			return Redirect::back()->with('msg_success', "Image Upload success!");
		}
		return Redirect::back()->with('msg_delete', "Image Upload Failed!");
	  
    }

    // Loan Archive
    public function loanArchive(Request $request) {

        $searchname = $request->input('search');
        if($searchname) {
            $searth_hit = true;
            $loan_archive = DB::table('loans')
                            ->leftJoin('customers', 'loans.accountNo', '=', 'customers.accountNo')
                            ->where('loans.loanstatus', '!=', 'active')
                            ->where('loans.accountNo', $searchname)
                            ->orWhere('loans.loanapplytranxid', $searchname)
                            ->orWhere('loans.loanamount', $searchname)
                            ->orderBy('loans.id', 'DESC')
                            ->paginate(20);
        } else {
            $searth_hit = false;
        }

        return view('archive.archive_loan_list', compact('loan_archive', 'searth_hit'));
    }

    // FDR Archive
    public function fdrArchive(Request $request) {

        $searchname = $request->input('search');
        if($searchname) {
            $searth_hit = true;
            $fdr_archive = DB::table('fdrs')
                            ->leftJoin('customers', 'fdrs.accountNo', '=', 'customers.accountNo')
                            ->where('fdrs.fdrstatus', '!=', 'active')
                            ->where('fdrs.accountNo', $searchname)
                            ->orWhere('fdrs.tranxid', $searchname)
                            ->orWhere('fdrs.fdramount', $searchname)
                            ->orderBy('fdrs.id', 'DESC')
                            ->paginate(20);
        } else {
            $searth_hit = false;
        }

        return view('archive.archive_fdr_list', compact('fdr_archive', 'searth_hit'));
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
     * Display the list of Customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerList(Request $request)
    {
        // dd(Auth::user()->hasRole('Admin'));

        $searchname = $request->input('search');
        if(Auth::user()->hasRole('Admin')) {
            // dd('admin');
            $customer_list = Customer::whereRaw("fullname like '%{$searchname}%'")
                                    ->orWhere('accountNo', 'LIKE', '%'. $searchname .'%')
                                    ->orWhere('mobile', 'LIKE', '%'. $searchname .'%')
                                    ->orWhere('presentaddress', 'LIKE', '%'. $searchname .'%')
                                    ->orderBy('id', 'DESC')
                                    ->paginate(20);
        } else {
            $customer_list = Customer::where('field', Auth::user()->field)
                                    ->whereRaw("fullname like '%{$searchname}%'")
                                    ->orWhere('accountNo', 'LIKE', '%'. $searchname .'%')
                                    ->orWhere('mobile', 'LIKE', '%'. $searchname .'%')
                                    ->orWhere('presentaddress', 'LIKE', '%'. $searchname .'%')
                                    ->orderBy('id', 'DESC')
                                    ->paginate(20);
        }
        
        // $customer_list = Customer::where('status', 1)->get();
        // dd($customer_list);
        return view('customer.customer_list', compact('customer_list'));
    }

    /**
     * Display the Detail of Customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customerDetail($id)
    {
        // $customer_list = Customer::where('id', $id)->first();
        
        $customer_list = DB::table('customers')
                            ->leftJoin('dps', 'customers.accountNo', '=', 'dps.accountNo')
                            ->leftJoin('fields', 'customers.field', '=', 'fields.id')
                            ->where('customers.id', $id)
                            ->select('customers.*', 'dps.monthlyamount', 'fields.fieldname')
                            ->first();
        
        // dd($customer_list->accountNo);
        $transaction_history = DB::table('customer_transaction_history')->where('accountNo', $customer_list->accountNo)
                                                                        ->orderBy('id', 'DESC')
                                                                        ->paginate(10);
        // dd($transaction_history);
        if($customer_list != null) {
            $customer_list = collect($customer_list);
            $customer_list = $customer_list->toArray();
            $dps_record = DpsRecords::where('accountNo', $customer_list['accountNo'])->orderBy('id', 'desc')->first();
            $dps_records = DpsRecords::where('accountNo', $customer_list['accountNo'])->orderBy('id', 'asc')->get();
            $services = Service::where('accountNo', $customer_list['accountNo'])
                                ->where('status', 1)
                                ->get();
            // dd($services);
            // Get FDR Data
            $fdr_data = Fdr::where('accountNo', $customer_list['accountNo'])
                            ->where('fdrstatus', 'active')
                            ->where('fdrpermission', 'approved')
                            ->first();

            // Get FDR Records
            $fdr_record_data = FdrRecord::where('accountNo', $customer_list['accountNo'])
                                        ->where('fdrno', $fdr_data['fdrno'])
                                        ->orderBy('fdrno', 'DESC')
                                        ->get();
            // dd($fdr_record_data);
        } else {
            $customer_list = null;
        }
        
        $loan_data = Loan::where('accountNo', $customer_list['accountNo'])
                        ->where('loanstatus', 'active')
                        ->where('loanpermission', 'approved')
                        ->first();


        $loan_records = DB::table('loan_rocords')
                        ->where('loanno', $loan_data['loanno'])
                        ->where('accountNo', $loan_data['accountNo'])
                        ->orderBy('receivedate', 'DESC')
                        ->paginate(10);
        // dd($loan_data);
        return view('customer.customer_detail', compact(['customer_list', 'dps_record', 'dps_records', 'services', 'loan_data', 'loan_records', 'fdr_data', 'fdr_record_data', 'transaction_history']));
    }

    public function customerEdit(Request $request, $id) {
        $customer_data = Customer::where('id', $id)->first()->toArray();
        $get_reg_data = $request->except('_token');
        if($request->isMethod('post') && isset($get_reg_data) && !empty($get_reg_data)) {

            if($get_reg_data['inputfatherorhus'] == 1) {
                $get_reg_data['fathername'] = 'F-'.$get_reg_data['fathername'];
            } else {
                $get_reg_data['fathername'] = 'H-'.$get_reg_data['fathername'];
            }

            // For Nominee
            if($get_reg_data['nomfatherorhus'] == 1) {
                $get_reg_data['nomfathername'] = 'F-'.$get_reg_data['nomfathername'];
            } else {
                $get_reg_data['nomfathername'] = 'H-'.$get_reg_data['nomfathername'];
            }

            unset($get_reg_data['inputfatherorhus']); 
            unset($get_reg_data['nomfatherorhus']); 
            // dd($get_reg_data);
            // Insert to database
            $insert_reg = Customer::where('id', $id)->update($get_reg_data);

            if($insert_reg) {
                return Redirect::to('customer-list')->with('msg_success', trans("Updated Successfully"));
            }
        }
        
        return view('customer.customer_edit', compact(['customer_data']));
    }

    /**
     * Every Transaction.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customer_transaction(Request $request)
    {
        $get_tranx_data = $request->except('_token');
        $get_last_tranx_data = DB::table('customer_transaction_history')->where('accountNo', $get_tranx_data['accountNo'])
                                                                        ->orderBy('id', 'DESC')
                                                                        ->first();
                           
        if($get_tranx_data['tranx_type'] === 'customer_deposite') {

            if($get_last_tranx_data) {
                $current_balance = $get_last_tranx_data->current_balance;
                $new_current_balance = $current_balance + $get_tranx_data['amount'];
                // Call Transaction Helper Function
                $get_tranx_no = customer_transaction($get_tranx_data['accountNo'], $get_tranx_data['receipt_no'], $get_tranx_data['trans_date'], 'credit', 'current', $get_tranx_data['amount'], $new_current_balance);
                $msg = "Deposited Successfully. Tranx Id: \"{$get_tranx_no}\"";
                if($get_tranx_no) {
                    Customer::where('accountNo', $get_tranx_data['accountNo'])->update(['balance' => $new_current_balance]);
                    return Redirect::back()->with('msg_success', trans($msg));
                }
                
            }
        } else {

            if($get_last_tranx_data) {

                $current_balance = $get_last_tranx_data->current_balance;
                if($current_balance >= $get_tranx_data['amount'] ) {

                    $new_current_balance = $current_balance - $get_tranx_data['amount'];
                    // Call Transaction Helper Function
                    $get_tranx_no = customer_transaction($get_tranx_data['accountNo'], $get_tranx_data['receipt_no'], $get_tranx_data['trans_date'], 'debit', 'current', $get_tranx_data['amount'], $new_current_balance);
                    $msg = "Withdraw Successfully. Tranx Id: \"{$get_tranx_no}\"";
                    if($get_tranx_no) {
                        Customer::where('accountNo', $get_tranx_data['accountNo'])->update(['balance' => $new_current_balance]);
                        return Redirect::back()->with('msg_success', trans($msg));
                    }

                } else {
                    return Redirect::back()->with('msg_delete', trans("You don't have sufficient balance."));
                }
                
                
            }
        }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
