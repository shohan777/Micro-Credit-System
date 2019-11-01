<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Foo;
use Auth;
use App\Customer;
use App\Fdr;
use App\FdrRecord;
use App\Loan;
use App\Field;

class AccountController extends Controller
{
    protected $foo;
	public function __construct(Foo $foo)
	{		
       $this->middleware('auth');	 
	//    $this->foo = $foo;
	//    $this->middleware('permission:settings.general');	  
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

    public function incomeTrans(Request $request)
    {
        $get_income_data = $request->except('_token');
        $income_heads = DB::table('transaction_head')->where('headtype', 'income')->where('headstatus', 'active')->get();

        $prev_income_data = DB::table('income_trans')->orderBy('id', 'DESC')->first();
        if($prev_income_data) {
            $current_balance = $prev_income_data->total;
        } else {
            $current_balance = 0;
        }
        if($get_income_data && $request->isMethod('post')) {
            $get_income_data['voucherno'] = "Trx-".time();
            $get_income_data['total'] = $current_balance + $get_income_data['amount'];
            $inserted = DB::table('income_trans')->insert($get_income_data);
            if($inserted) {
                return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
            }
            
        }

        return view('account.income_trans', compact('income_heads'));
    }

    public function expenseTrans(Request $request)
    {
        $get_expense_data = $request->except('_token');
        $expense_heads = DB::table('transaction_head')->where('headtype', 'expense')->where('headstatus', 'active')->get();

        $prev_expense_data = DB::table('expense_trans')->orderBy('id', 'DESC')->first();
        if($prev_expense_data) {
            $current_balance = $prev_expense_data->total;
        } else {
            $current_balance = 0;
        }

        if($get_expense_data && $request->isMethod('post')) {
            $get_expense_data['voucherno'] = "Trx-".time();
            $get_expense_data['total'] = $current_balance + $get_expense_data['amount'];
            $inserted = DB::table('expense_trans')->insert($get_expense_data);
            if($inserted) {
                return Redirect::back()->with('msg_success', trans('app.insert_success_message'));
            }
            
        }

        return view('account.expense_trans', compact('expense_heads'));
    }

    public function incomeReport(Request $request)
    {
        $searchname = $request->all();
        
        if($searchname) {
            // dd($searchname);
            $search_hit = true;
            if($searchname['to_date'] != '') {
                $income_data = DB::table('income_trans')
                            ->whereBetween('date', array($searchname['from_date'], $searchname['to_date']))
                            ->orderBy('id', 'DESC')
                            ->paginate(20);
            } else {
                $income_data = DB::table('income_trans')
                            ->where('date', $searchname['from_date'])
                            ->orderBy('id', 'DESC')
                            ->paginate(20);
            }
            
        } else {
            $search_hit = false;
        }

        return view('report.income_report', compact('income_data', 'search_hit'));
    }

    public function expenseReport(Request $request)
    {
        $searchname = $request->all();
        
        if($searchname) {
            // dd($searchname);
            $search_hit = true;
            if($searchname['to_date'] != '') {
                $expense_data = DB::table('expense_trans')
                            ->whereBetween('date', array($searchname['from_date'], $searchname['to_date']))
                            ->orderBy('id', 'DESC')
                            ->paginate(20);
            } else {
                $expense_data = DB::table('expense_trans')
                            ->where('date', $searchname['from_date'])
                            ->orderBy('id', 'DESC')
                            ->paginate(20);
            }
            
        } else {
            $search_hit = false;
        }

        return view('report.expense_report', compact('expense_data', 'search_hit'));
    }

    function savingsAccountLedger() {
        if(Auth::user()->hasRole('Admin')) {
            $field_no = Auth::user()->field;
            $customer_list = Customer::orderBy('id', 'DESC')->paginate(10);
        } else {
            $field_no = Auth::user()->field;
            $customer_list = field_customer($field_no, true);
            
        }
        return view('account.customer_list', compact('customer_list'));
    }

    function savingsLedgerDetail($accountNo) {
        if(Auth::user()->hasRole('Admin')) {

            $transaction_history = DB::table('customer_transaction_history')->where('accountNo', $accountNo)
                                                                            ->orderBy('id', 'DESC')
                                                                            ->paginate(10);
            $customer_detail = Customer::where('accountNo', $accountNo)->first()->toArray();

        } else {

            $transaction_history = DB::table('customer_transaction_history')->where('accountNo', $accountNo)
                                                                            ->orderBy('id', 'DESC')
                                                                            ->paginate(10);
            $customer_detail = Customer::where('accountNo', $accountNo)->first()->toArray();

            // dd($customer_detail);
        }
        return view('account.saving_ledger_detail', compact('transaction_history', 'customer_detail'));
    }

    function fdrAccountLedger() {
        
        $fdr_accounts = Fdr::leftJoin('customers', 'fdrs.accountNo', '=', 'customers.accountNo')->select('fdrs.*', 'customers.fullname')->orderBy('fdrs.id', 'DESC')->paginate(20);
        return view('account.fdr_account_list', compact('fdr_accounts'));
    }

    function fdrLedgerDetail($id) {
        $fdr_account_detail = Fdr::where('fdrs.id', $id)
                                ->leftJoin('customers', 'customers.accountNo', '=', 'fdrs.accountNo')
                                ->select('fdrs.*', 'customers.fullname', 'customers.fathername', 'customers.customerpic')
                                ->first()->toArray();
        $fdr_records = FdrRecord::where('accountNo', $fdr_account_detail['accountNo'])->where('fdrno', $fdr_account_detail['fdrno'])->get();

        return view('account.fdr_ledger_detail', compact('fdr_account_detail', 'fdr_records'));
    }

    function loanAccountLedger(Request $request) {
        $filter_field = $request->except('_token');
        $field_lists = Field::where('fieldstatus', 1)->get();
        $field_no = Auth::user()->field;
        $field_name = '';
        $searchname = $request->input('search');
        if(Auth::user()->hasRole('Admin')) {

            if($request->isMethod('POST')) {
                if($filter_field['field_id'] > 0) {
                    $field_name = Field::where('id', $filter_field['field_id'])->first();
                    $loan_accounts = Loan::leftJoin('customers', 'loans.accountNo', '=', 'customers.accountNo')->where('loanaccount', 'LIKE', '%'. $searchname .'%')->where('customers.field', $filter_field['field_id'])->select('loans.*', 'customers.fullname')->orderBy('loans.id', 'DESC')->paginate(20);
                } else {
                    $field_name = Field::where('id', $filter_field['field_id'])->first();
                    $loan_accounts = Loan::leftJoin('customers', 'loans.accountNo', '=', 'customers.accountNo')->where('loanaccount', 'LIKE', '%'. $searchname .'%')->select('loans.*', 'customers.fullname')->orderBy('loans.id', 'DESC')->paginate(20);
                }
            } else {
                $loan_accounts = Loan::leftJoin('customers', 'loans.accountNo', '=', 'customers.accountNo')->where('loanaccount', 'LIKE', '%'. $searchname .'%')->select('loans.*', 'customers.fullname')->orderBy('loans.id', 'DESC')->paginate(20);
            }

        } else {

            $loan_accounts = Loan::where('customers.field', $field_no)->leftJoin('customers', 'loans.accountNo', '=', 'customers.accountNo')->select('loans.*', 'customers.fullname')->orderBy('loans.id', 'DESC')->paginate(20);

        }
        
        
        return view('account.loan_account_list', compact('loan_accounts', 'field_lists', 'field_name'));
    }

    function loanLedgerDetail(Request $request, $id) {
        $field_no = Auth::user()->field;
        $date_filter = $request->except('_token');
        
        if(Auth::user()->hasRole('Admin')) {
            $loan_account_detail = Loan::where('loans.id', $id)
                                ->leftJoin('customers', 'customers.accountNo', '=', 'loans.accountNo')
                                ->select('loans.*', 'customers.fullname', 'customers.fathername', 'customers.customerpic')
                                ->first()
                                ->toArray();
        
            if($request->isMethod('post') && $date_filter) {
                $type = 'date_filter';
                $loan_records = DB::table('loan_rocords')
                            ->where('accountNo', $loan_account_detail['accountNo'])
                            ->where('loanno', $loan_account_detail['loanno'])
                            ->whereBetween('receivedate', [$date_filter['receivedate'], date('Y-m-d')])
                            ->get();
            } else {
                $loan_records = DB::table('loan_rocords')
                            ->where('accountNo', $loan_account_detail['accountNo'])
                            ->where('loanno', $loan_account_detail['loanno'])
                            ->get();
            }

        } else {
            $loan_account_detail = Loan::where('loans.id', $id)
                                ->where('customers.field', $field_no)
                                ->leftJoin('customers', 'customers.accountNo', '=', 'loans.accountNo')
                                ->select('loans.*', 'customers.fullname', 'customers.fathername', 'customers.customerpic')
                                ->first()
                                ->toArray();
        
            if($request->isMethod('post') && $date_filter) {
                
                $type = 'date_filter';
                $loan_records = DB::table('loan_rocords')
                            ->where('accountNo', $loan_account_detail['accountNo'])
                            ->where('loanno', $loan_account_detail['loanno'])
                            ->whereBetween('receivedate', [$date_filter['receivedate'], date('Y-m-d')])
                            ->get();
            } else {
                $loan_records = DB::table('loan_rocords')
                            ->where('accountNo', $loan_account_detail['accountNo'])
                            ->where('loanno', $loan_account_detail['loanno'])
                            ->get();
            }
        }
        
        
        return view('account.loan_ledger_detail', compact('loan_account_detail', 'loan_records', 'type'));
    }

    // Income
    function incomeAccountLedger() {
        
        $income_heads = DB::table('transaction_head')->where('headtype', 'income')->where('headstatus', 'active')->get();
        return view('account.income_list', compact('income_heads'));
    }

    function incomeLedgerDetail($id) {
        
        $income_head = DB::table('transaction_head')->where('id', $id)->first();
        
        $income_transaction = DB::table('income_trans')->select(DB::raw('sum(amount) as total_amount, date, total, remarks'))->where('purpose', $id)->groupBy('date')->orderBy('date', 'ASC')->get();

        return view('account.income_ledger_detail', compact('income_transaction', 'income_head'));
    }

    // Expense
    function expenseAccountLedger() {
        
        $expense_heads = DB::table('transaction_head')->where('headtype', 'expense')->where('headstatus', 'active')->get();
        return view('account.expense_list', compact('expense_heads'));
    }

    function expenseLedgerDetail($id) {
        
        $expense_head = DB::table('transaction_head')->where('id', $id)->first();
        
        $expense_transaction = DB::table('expense_trans')->select(DB::raw('sum(amount) as total_amount, date, total, remarks'))->where('purpose', $id)->groupBy('date')->orderBy('date', 'ASC')->get();

        return view('account.expense_ledger_detail', compact('expense_transaction', 'expense_head'));
    }

    // General Ledger Entry
    function generalLedgerList($type) {
        
        $gl_heads = DB::table('transaction_head')->where('headtype', 'gl')->where('headstatus', 'active')->get();

        if($type == 'entry') {
            return view('account.gl_list', compact('gl_heads'));
        } elseif($type == 'ledger') {
            return view('account.gl_ledger_list', compact('gl_heads'));
        }
        
    }

    function generalLedger($id) {
        
        $gl_heads = DB::table('transaction_head')->where('id', $id)->first();
        $general_ledger = DB::table('general_ledger')->where('glid', $id)->get();
        
        // dd($general_ledger);
        return view('account.gl_ledger_detail', compact('general_ledger', 'gl_heads'));
    }

    function generalLedgerEntry(Request $request, $id) {
        $gl_entry_data = $request->except('_token');
        
        
        $gl_head_data = DB::table('transaction_head')->where('id', $id)->first();

        if($gl_entry_data && $request->isMethod('post')) {
        
            $prev_gl_data = DB::table('general_ledger')->where('glid', $id)->orderBy('id', 'DESC')->first();

            if($prev_gl_data) {
                $current_gl_balance = $prev_gl_data->balance;
                
                if($gl_head_data->assetfor == 'company') {
                    
                    if($gl_entry_data['type'] == 'debit') {
                        $gl_entry_data['balance'] = $current_gl_balance + $gl_entry_data['amount'];
                    } else {
                        $gl_entry_data['balance'] = $current_gl_balance - $gl_entry_data['amount'];
                    }

                } else {

                    if($gl_entry_data['type'] == 'debit') {
                        $gl_entry_data['balance'] = $current_gl_balance - $gl_entry_data['amount'];
                    } else {
                        $gl_entry_data['balance'] = $current_gl_balance + $gl_entry_data['amount'];
                    }

                }
            } else {
                $gl_entry_data['balance'] = $gl_entry_data['amount'];
                $gl_entry_data['type'] = 'opening';
            }


            // dd($gl_entry_data);
            $inserted = DB::table('general_ledger')->insert($gl_entry_data);
            if($inserted) {
                return Redirect::back()->with('msg_success', trans('Gl has been added'));
            }
        }

        return view('account.gl_entry', compact('gl_head_data'));
    }

    function headBalance() {
        
        $today = date('Y-m-d');
        $balance = array();
        // Loan
        $loan_balance_debit = Loan::where('loandate', $today)->sum('loanamount');
        $loan_balance_credit = DB::table('loan_rocords')->where('receivedate', $today)->sum('dailyamount');
        // Fdr
        $fdr_balance_debit = Fdr::where('openingdate', $today)->sum('fdramount');
        $fdr_balance_credit = FdrRecord::where('withdrawdate', $today)->sum('monthlyamount');
        // Savings
        $sb_balance_credit = DB::table('customer_transaction_history')->where('trans_date', $today)->where('type', 'credit')->sum('amount');
        $sb_balance_debit = DB::table('customer_transaction_history')->where('trans_date', $today)->where('type', 'debit')->sum('amount');
        // Income
        $income_balance_debit = DB::table('income_trans')->where('date', $today)->sum('amount');
        // Expense
        $expense_balance_debit = DB::table('expense_trans')->where('date', $today)->sum('amount');
        
        // Cash In Hand
        $cash_in_hand_debit = $loan_balance_credit + $fdr_balance_debit + $sb_balance_debit + $income_balance_debit;
        $cash_in_hand_credit = $loan_balance_debit + $fdr_balance_credit + $sb_balance_debit + $expense_balance_debit;

        // Make Array
        $balance = array(
            0 => array(
                'head' => 'Loan Micro Credit',
                'debit' => $loan_balance_debit,
                'credit' => $loan_balance_credit
            ),
            1 => array(
                'head' => 'Fdr Account',
                'debit' => $fdr_balance_debit,
                'credit' => $fdr_balance_credit
            ),
            2 => array(
                'head' => 'SB Account',
                'debit' => $sb_balance_debit,
                'credit' => $sb_balance_credit
            ),
            3 => array(
                'head' => 'Income & Expenditure',
                'debit' => $income_balance_debit,
                'credit' => $expense_balance_debit
            ),
            4 => array(
                'head' => 'Cash In Hand',
                'debit' => $cash_in_hand_debit,
                'credit' => $cash_in_hand_credit
            ),
        );

        // dd($balance);
        return view('account.gl_head_balance', compact('balance'));
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
