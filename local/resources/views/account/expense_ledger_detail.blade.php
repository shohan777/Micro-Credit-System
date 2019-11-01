@extends('layouts.template')

@section('page-title')
Income Ledger
@stop

@section('page-css')
<style>
    .table {
    text-align: center
}
.table-header {
    padding: 15px 0 ;
}
.no-border th, .no-border td {
    border: none!important
}
.no-border tr p {
    background: #358B88;
    margin-bottom: 0;
    color: #cefffd;
    padding: 5px;
    border-radius: 3px;
}
.no-border tr td p {
    padding: 7px;
    color:#fff
}
.pagination {
    margin: 0
}
.table-horizon tbody tr {
    background: #a3fffa
}
.table-horizon > tbody tr td {
    border: 1px solid #93e0dc
}
.table>thead>tr>th {
    font-weight: 700;
    text-align: center;
}
</style>
@stop

@section('content')
<link rel="stylesheet" href="{{URL::to('/')}}/assets/examples/css/pages/profile.css">
<div class="page-header">
    <h1 class="page-title font_lato"> {{ trans('INCOME TRANSACTION')}} </h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/dashboard')}}"> {{ trans('app.home')}} </a></li>
            <li><a href="{{URL::to('income-ledger')}}"> {{ trans('Income Ledger')}} </a></li>
            <li class="active"> {{ $expense_head->headname }} </li>
        </ol>
    </div>
</div>
<div class="page-content container-fluid">
    <!------------------------start insert, update, delete message ---------------->
    <!------------------------start insert, update, delete message ---------------->
    <div class="row">
        @if(session('msg_success'))
        <div class="alert dark alert-icon alert-success alert-dismissible " role="alert">
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
        @if(session('msg_warning'))
        <div class="alert dark alert-icon alert-warning alert-dismissible alertDismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="icon wb-check" aria-hidden="true"></i>
            {{session('msg_warning')}}
        </div>
        @endif
        @if(session('msg_delete'))
        <div class="alert dark alert-icon alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="icon wb-check" aria-hidden="true"></i>
            {{session('msg_delete')}}
        </div>
        @endif
    </div>
    <!-- Panel -->
    <div class="panel">
        <div class="table-header">
            <p class="text-center" style="font-weight:700;margin:10px 0 0px;font-size:26px;color:#f32121;text-decoration:underline;">{{
                $expense_head->headname }}</p>
        </div>
        <div class="panel-body" style="padding-top:0">
            <!-- Example Responsive -->
            <div class="example-wrap">
                <div class="example">
                    <div class="">
                        @if(!$expense_transaction->isEmpty())
                        <table class="table table-horizon">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Particulars</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $grand_total = 0;
                                @endphp
                                @foreach($expense_transaction as $record)
                                @php
                                $grand_total += $record->total_amount
                                @endphp
                                <tr>
                                    <td>
                                        <span class="text-muted"><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($record->date)) }}</span>
                                    </td>
                                    <td>{{ $record->remarks }}</td>
                                    <td>{{ $record->total_amount }} /-</td>
                                    <td style="color:#e9595b;font-weight:700">{{ number_format($grand_total, 0, '.',
                                        ',') }} /-</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-center" style="font-weight:700;color:red">No Data Found</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End Example Responsive -->
        </div>
    </div>
</div>
<br />
@stop