@extends('layouts.template')

@section('page-title')
Saving Ledger Detail
@stop

@section('page-css')
<style>
.page-header .table > tbody tr th,
.page-header .table > tbody tr td {
    border: none;
    color: #fff;
}
.page-header .table {
    margin-bottom: 0;
}
.page-header {
    background: #9EA5DB;
}
</style>
@stop

@section('content')

<div class="page-content container-fluid">
    <!------------------------start insert, update, delete message ---------------->
    <!------------------------start insert, update, delete message ---------------->
    <div class="row">
        @if(session('msg_success'))
        <div class="alert dark alert-icon alert-success alert-dismissible alertDismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="icon wb-check" aria-hidden="true"></i>
            {{session('msg_success')}}
        </div>
        @endif
        @if(session('msg_update'))
        <div class="alert dark alert-icon alert-info alert-dismissible alertDismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="icon wb-check" aria-hidden="true"></i>
            {{session('msg_update')}}
        </div>
        @endif
        @if(session('msg_delete'))
        <div class="alert dark alert-icon alert-danger alert-dismissible alertDismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="icon wb-check" aria-hidden="true"></i>
            {{session('msg_delete')}}
        </div>
        @endif
    </div>
    <div class="col-md-12">
        <!-- Panel Wizard Form Container -->
        <div class="panel" id="customerList">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6">
                        @php
                            $gurdian_name = explode('-', $customer_detail['fathername']);
                        @endphp
                        <table class="table table-condensed">
                            <tbody>
                                <tr>
                                    <th class="col-sm-3">Name:</th>
                                    <td>{{ $customer_detail['fullname'] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-sm-3">{{ ($gurdian_name[0] == 'F') ? 'Father Name:' : 'Husband Name:' }}</th>
                                    <td>{{ $gurdian_name[1] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-sm-3">Address:</th>
                                    <td>{{ $customer_detail['presentaddress'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-condensed">
                            <tbody>
                                <tr>
                                    <th class="col-sm-3">Mobile:</th>
                                    <td>{{ $customer_detail['mobile'] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-sm-3">Account No:</th>
                                    <td><a href="javascript:void(0)">#{{ $customer_detail['accountNo'] }}</a></td>
                                </tr>
                                <tr>
                                    <th class="col-sm-3">Balance:</th>
                                    <td style="color:#00ff39;font-weight:700">{{ $customer_detail['balance'] }} BDT</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
            <div class="table-header">
                <p class="text-center" style="font-weight:700;margin:10px 0 0px;font-size:18px;color:#f32121;text-decoration:underline;">Saving Ledger</p>
            </div>
            <div class="panel-body" style="padding-top: 0">
                <!-- Example Responsive -->
                <div class="example-wrap">
                    <div class="example">
                        <div class="table-responsive">
                            @if($transaction_history)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tranx ID</th>
                                        <th>Receipt No</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Purpose</th>
                                        <th>Amount</th>
                                        <th>Current Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction_history as $history)
                                    @php
                                    $plusorminus = ($history->type == 'debit') ? "<span style='color:red'>(-)</span>" : "<span style='color:#60ab00'>(+)</span>";
                                    @endphp
                                    <tr>
                                        <td><a href="javascript:void(0)">{{ ($history->tranx_id != null) ? '#'.$history->tranx_id : 'Null' }}</a></td>
                                        <td>{{ ($history->receipt_no != null) ? '#'.$history->receipt_no : 'Null' }}</td>
                                        <td>
                                            <span class="text-muted"><i class="wb wb-time"></i> {{ date('F d, Y', strtotime($history->trans_date)) }}</span>
                                        </td>
                                        <td style="color:{{ ($history->type == 'debit') ? 'red' : 'green'  }}">{{ ucfirst($history->type) }}</td>
                                        <td>{{ $history->purpose }}</td>
                                        <td> {!! $plusorminus !!} {{ $history->amount }} BDT</td>
                                        <td style="color:#60ab00">{{ $history->current_balance }} BDT</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $transaction_history->appends(Request::only('search'))->links() }}
                            @else
                                <p>No Data Found</p>
                            @endif
                            <div style="clear:both;"></div><br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop