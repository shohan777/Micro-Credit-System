<?php

use App\Customer;
if(!function_exists('customer_transaction')) {
    function customer_transaction($accountNo, $receipt_no, $trans_date, $type, $purpose, $amount, $current_balance) {

        $tranx_id = "Trx-".time();

        $get_data = DB::table('customer_transaction_history')->insert(
            [
                'accountNo' => $accountNo,
                'tranx_id' => $tranx_id,
                'receipt_no' => $receipt_no,
                'trans_date' => $trans_date,
                'type' => $type,
                'purpose' => $purpose,
                'amount' => $amount,
                'current_balance' => $current_balance
            ]
        );

        if($get_data > 0) {
            return $tranx_id;
        } else {
            return false;
        }

    }
}

// Get Field wise Customer
if(!function_exists('field_customer')) {
    function field_customer($field_no, $all = false) {

        if($all) {
            $customer_all_data = Customer::where('field', $field_no)->orderBy('id', 'DESC')->paginate(10);
            return $customer_all_data;
        } else {
            $customer_data = Customer::where('field', $field_no)->orderBy('id', 'DESC')->pluck('accountNo')->toArray();
            return $customer_data;
        }

    }
}