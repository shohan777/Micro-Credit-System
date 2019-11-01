@extends('layouts.template')

@section('page-title')
{{ $loan_account_detail['fullname']}} Detail
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
    background: #DBEFEE
}
.table-horizon > tbody tr td {
    border: 1px solid #93e0dc
}
.page-header .table > tbody tr th,
.page-header .table > tbody tr td {
    border: none;
    color: #fff;
}
.panel .page-header .table {
    margin-bottom: 0;
}
.panel .page-header {
    background: #9EA5DB;
    border-radius: 3px;
}
.table-horizon tbody tr {
    background: #a3fffa
}
.table-horizon > tbody tr td {
    border: 1px solid #85ccc8;
    color:#828282
}
.date-filter {
    float: left;
    margin-top: -5px;
    margin-right: 10px;
}
#filter_form {
    display: none;
}
@media print {
  .page-top {
      display:none;
  }
  footer {
      display:none;
  }
  .print-col {
      float:left;
      width:50%;
  }
  .table {
      width: 99%
  }
  .less-width {
      width:17%;
  }
}
</style>
@stop

@section('content')
<div class="page-header page-top">
    <h1 class="page-title font_lato"> Loan Ledger</h1>
    <div class="page-header-actions">
        <div class="date-filter">
            @if(!isset($type))
                <button class="btn btn-sm btn-primary" style="margin-right:15px" onclick="toggleFilter()">Filter</button>
            @else
                <a href="{{ url('/loan-account-ledger/detail', $loan_account_detail['id']) }}" class="btn btn-sm btn-danger" style="margin-right:15px">Clear</a>
            @endif
            
            <div id="filter_form" class="bs-example" data-example-id="single-button-dropdown" style="float:right;margin-top:2px">
                <div class="btn-group">
                    <form class="form-inline ng-pristine ng-valid" action="{{URL::to('/loan-account-ledger/detail', $loan_account_detail['id'])}}" method="post" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="search">Search by Date: </label>
                            <input style="height:32px" type="text" name="receivedate" class="form-control datepicker" id="from_date" placeholder="{{ trans('From Date')}}" value="{{Request::get('from_date')}}">
                            <button type="submit" class="btn btn-sm btn-outline btn-primary"><i class="icon fa-search"
                                    aria-hidden="true"></i></button>

                            @if (Request::get('from_date') != '')
                            <a href="{{URL::to('/expense-report')}}" class="btn btn-sm btn-outline btn-danger" type="button">
                                <i class="icon fa-remove" aria-hidden="true"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <ol class="breadcrumb" style="float:right">
            <li><a href="{{URL::to('/dashboard')}}"> {{ trans('app.home')}} </a></li>
            <li><a href="{{URL::to('loan-account-ledger')}}"> {{ trans('Loan Ledger')}} </a></li>
            <li class="active"> {{ $loan_account_detail['fullname'] }} </li>
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
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 print-col">
                        @php
                            $gurdian_name = explode('-', $loan_account_detail['fathername']);
                        @endphp
                        <table class="table table-condensed">
                            <tbody>
                                <tr>
                                    <th class="col-sm-3">Name:</th>
                                    <td>{{ $loan_account_detail['fullname'] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-sm-3">{{ ($gurdian_name[0] == 'F') ? 'Father Name:' : 'Husband Name:' }}</th>
                                    <td>{{ $gurdian_name[1] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-sm-3">SB Account:</th>
                                    <td>#{{ $loan_account_detail['accountNo'] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-sm-3">Loan No:</th>
                                    <td>#{{ $loan_account_detail['loanaccount'].' / '.$loan_account_detail['loanno'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 print-col">
                        <table class="table table-condensed">
                            <tbody>
                                <tr>
                                    <th class="col-sm-4">Rate of Interest:</th>
                                    <td>{{ $loan_account_detail['loaninterest'] }} %</td>
                                </tr>
                                <tr>
                                    <th class="col-sm-4">Date Of Issue:</th>
                                    <td style="color:#00ff39;font-weight:700">{{ $loan_account_detail['loandate'] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-sm-4">Instalment:</th>
                                    <td style="color:#00ff39;font-weight:700">{{ $loan_account_detail['loanterms'] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-sm-4">Date of Maturity:</th>
                                    <td style="color:#00ff39;font-weight:700">{{ $loan_account_detail['loanending'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
            <div class="table-header">
                <p class="text-center" style="font-weight:700;margin:10px 0 0px;font-size:18px;color:#f32121;text-decoration:underline;">Loan Ledger</p>
            </div>
            <div class="panel-body" style="padding-top:0">
                <!-- Example Responsive -->
                <div class="example-wrap">
                    <div class="example">
                        <div class="table-responsive table-condensed table-horizon">
                            <table class="table table-horizon">
                                <thead>
                                    <tr>
                                        <th>Collection Date</th>
                                        <th class="col-sm-2 less-width">Terms</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($loan_records)
                                    @if(!isset($type))
                                        <tr style="background:#00fff1">
                                            <td>
                                                <span class="text-muted"><i class="fa fa-calendar"></i> {{
                                                    date('F d, Y', strtotime($loan_account_detail['loandate'])) }}</span>
                                            </td>
                                            <td>Opening</td>
                                            <td></td>
                                            <td style="color:#e9595b;font-weight:700">{{ number_format($loan_account_detail['loantotal'], 2, '.', ',') }} BDT</td>
                                        </tr>
                                    @endif
                                    @foreach($loan_records as $record)
                                    <tr>
                                        <td>
                                            <span class="text-muted"><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($record->receivedate)) }}</span>
                                        </td>
                                        <td>#{{ $record->currentterms }}</td>
                                        <td>{{ number_format($record->dailyamount, 2, '.', ',') }} BDT</td>
                                        <td style="color:#e9595b;font-weight:700">{{ number_format($record->currentdue, 2, '.', ',') }} BDT</td>
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

    function toggleFilter() {
        $("#filter_form").toggle(100);
    }
</script>
@stop