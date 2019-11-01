@extends('layouts.template')

@section('page-title')
{{ $fdr_account_detail['fullname'] }} Detail
@stop

@section('page-css')
<style>

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
    border-radius: 3px;
}
</style>
@stop

@section('content')
<link rel="stylesheet" href="{{URL::to('/')}}/assets/examples/css/pages/profile.css">
{{-- <div class="page-header">
    <h1 class="page-title font_lato">FDR Ledger </h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/dashboard')}}">{{ trans('app.home')}}</a></li>
            <li><a href="{{URL::to('/fdr-account')}}">{{ trans('Fdr Account')}}</a></li>
            <li class="active">Detail</li>
        </ol>
    </div>
</div> --}}
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
        <div class="col-md-12">
            <!-- Panel -->
            <div class="panel">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $gurdian_name = explode('-', $fdr_account_detail['fathername']);
                            @endphp
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <th class="col-sm-3">Name:</th>
                                        <td>{{ $fdr_account_detail['fullname'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-sm-3">{{ ($gurdian_name[0] == 'F') ? 'Father Name:' : 'Husband Name:' }}</th>
                                        <td>{{ $gurdian_name[1] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-sm-3">SB Account:</th>
                                        <td>#{{ $fdr_account_detail['accountNo'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-sm-3">FDR No:</th>
                                        <td>#{{ $fdr_account_detail['fdrno'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <th class="col-sm-4">Rate of Interest:</th>
                                        <td>{{ $fdr_account_detail['profitrate'] }} %</td>
                                    </tr>
                                    <tr>
                                        <th class="col-sm-4">Date Of Issue:</th>
                                        <td style="color:#00ff39;font-weight:700">{{ $fdr_account_detail['openingdate'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-sm-4">Period of Deposite:</th>
                                        <td style="color:#00ff39;font-weight:700">{{ $fdr_account_detail['numberofyear'] * 12 }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-sm-4">Date of Maturity:</th>
                                        <td style="color:#00ff39;font-weight:700">{{ $fdr_account_detail['serviceenddate'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="table-header">
                    <p class="text-center" style="font-weight:700;margin:10px 0 0px;font-size:18px;color:#f32121;text-decoration:underline;">FDR Ledger</p>
                </div>
                <div class="panel-body" style="padding-top:0">
                    <!-- Example Responsive -->
                    <div class="example-wrap">
                        <div class="example">
                            <div class="table-responsive table-condensed">
                                <table class="table table-horizon">
                                    <thead>
                                        <tr>
                                            <th>Credited Date</th>
                                            <th>Terms</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($fdr_records)
                                        <tr style="background:#00fff1">
                                            <td>
                                                <span class="text-muted"><i class="fa fa-calendar"></i> {{
                                                    date('F d, Y', strtotime($fdr_account_detail['openingdate'])) }}</span>
                                            </td>
                                            <td>Opening</td>
                                            <td>{{ number_format($fdr_account_detail['fdramount'], 0, '.', ',') }} BDT</td>
                                            <td style="color:#e9595b;font-weight:700">{{ number_format($fdr_account_detail['fdramount'], 0, '.', ',') }} BDT</td>
                                        </tr>
                                        @foreach($fdr_records as $record)
                                        <tr>
                                            <td>
                                                <span class="text-muted"><i class="fa fa-calendar"></i> {{
                                                    date('F d, Y', strtotime($record['withdrawdate'])) }}</span>
                                            </td>
                                            <td>{{ $record['fdrterms'] }}</td>
                                            <td>{{ $record['monthlyamount'] }} BDT</td>
                                            <td style="color:#e9595b;font-weight:700">{{ number_format($fdr_account_detail['fdramount'], 0, '.', ',') }} BDT</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Example Responsive -->
                </div>
            </div>
            <!-- End Panel -->
        </div>
</div>
<br />
@stop

@section('page-js')
<script>
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });
</script>
@stop