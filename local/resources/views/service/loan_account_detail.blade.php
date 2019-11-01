@extends('layouts.template')

@section('page-title')
{{ $loan_account_detail['fullname'] }} Detail
@stop

@section('page-css')
<style>
    .widget {
    background: #9EA5DB;
    color: #fff;
}
.widget a {
    color: #fff;
    font-weight: 700
}
.widget-header-content {
    position: relative
}
.profile-user {
    font-weight: 900;
    color: #fff;
}
.widget-header-content span.close-edit {
    position: absolute;
    right: 0;
    top: 0;
    background: #efe2e2;
    font-size: 10px;
    border-bottom-left-radius: 3px;
    border-top-left-radius: 3px;
    padding: 5px
}
.widget-header-content span.close-edit a {
    color: #ec9940
}
#profile_image_edit {
    display: none;
}
.next-deposite-date {
    background: #000;
    color: #e4eaec;
    padding: 4px;
    border-radius: 3px;
    font-size: 12px;
    border: 1px solid #37474f;
}
.next-deposite-date strong {
    color: #00ff94;
}
.meta-wrapper {
    margin-top: 20px;
}
.app-mailbox .table td {
    font-size: 12px;
}
.text-muted {
    color: #00b6ff;
}
.loan-miss-count {
    background: #FFBABA;
    color: #D8000C;
    font-weight: 700;
    padding: 4px;
    border-radius: 3px;
    border: 1px solid #e9595b;
    font-size: 12px
}
.loan-miss-count strong {
    color: #D8000C;
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
    border: 1px solid #85ccc8;
    color:#828282
}
</style>
@stop

@section('content')
<link rel="stylesheet" href="{{URL::to('/')}}/assets/examples/css/pages/profile.css">
<div class="page-header">
    <h1 class="page-title font_lato">Loan Profile </h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/dashboard')}}">{{ trans('app.home')}}</a></li>
            <li><a href="{{URL::to('/loan-accounts')}}">{{ trans('Loan Account')}}</a></li>
            <li class="active">Detail</li>
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
    <div class="row">
        <div class="col-md-12">
            <!-- Page Widget -->
            <div class="widget widget-shadow text-center">
                <div class="widget-header">
                    <div class="widget-header-content">
                        <a class="avatar avatar-lg" href="javascript:void(0)">
                            @if($loan_account_detail['customerpic'])
                            <img src="{{URL::to('/uploads', $loan_account_detail['customerpic'])}}" alt="...">
                            @else
                            <img src="{{URL::to('/')}}/global/portraits/5.jpg" alt="...">
                            @endif
                        </a>
                        @php
                        $gurdian_name = explode('-', $loan_account_detail['fathername']);
                        @endphp
                        <h4 class="profile-user">{{ $loan_account_detail['fullname'] }}</h4>
                        <p class="profile-job">{{ $gurdian_name[0] == 'F' ? 'Father Name ' : 'Husband Name ' }}: {{
                            $gurdian_name[1] }}</p>
                        <p class="profile-job"><a style="color:#016ef1" href="javascript:void(0);">Account No: #{{
                                $loan_account_detail['accountNo'] }}</a></p>
                        <p class="profile-job"><a style="color:#016ef1" href="javascript:void(0);">Loan Account No: #{{
                                $loan_account_detail['loanaccount'] }}</a></p>
                        <p class="profile-job"><a style="color:#016ef1" href="javascript:void(0);">Loan No: #{{
                                $loan_account_detail['loanno'] }}</a></p>
                    </div>
                </div>
            </div>
            <!-- End Page Widget -->
        </div>
        <div class="col-md-12">
            <!-- Panel -->
            <div class="panel">
                <div class="panel-body nav-tabs-animate nav-tabs-horizontal">
                    <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                        <li role="presentation" style="display: block;"><a data-toggle="tab" href="#fdr_summary"
                                aria-controls="fdr_summary" role="tab">Summary</a></li>
                        @if($loan_account_detail['loanstatus'] === 'active')
                        <li role="presentation" style="display: block;"><a data-toggle="tab" href="#loan_collection"
                                aria-controls="fdr_close" role="tab">Daily Instalment</a></li>
                        @endif
                        <li role="presentation" style="display: block;"><a data-toggle="tab" href="#fdr_withdraw_history"
                                aria-controls="fdr_withdraw_history" role="tab">History</a></li>
                        @if($loan_account_detail['loanstatus'] == 'fail')
                        <li role="presentation" style="display: block;"><a data-toggle="tab" href="#loan_fail"
                            aria-controls="loan_fail" role="tab">Loan Fail</a></li>
                        @endif
                        @if($loan_account_detail['loanpermission'] == 'custom')
                        <li role="presentation" style="display: block;"><a data-toggle="tab" href="#custom_collection"
                            aria-controls="loan_fail" role="tab">Custom Collection</a></li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        @if($loan_account_detail)
                        <div class="tab-pane animation-slide-left" id="fdr_summary" role="tabpanel">
                            <div class="meta-wrapper">
                                <div style="float:left">
                                    <h4>FDR Summary</h4>
                                </div>
                                <div class="next-expected-date">
                                    <span class="next-deposite-date pull-right">Status: <strong>{{
                                            ($loan_account_detail['loanstatus'] == 'active' &&
                                            $loan_account_detail['loanpermission'] ==
                                            'approved') ? 'Running' : 'Close' }}</strong></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Example Basic -->
                            <div class="example-wrap">
                                <div class="example table-responsive">
                                    <table class="table no-border">
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <p>Loan Account No</p>
                                                </th>
                                                <td>
                                                    <p>#{{ $loan_account_detail['loanaccount'] }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Loan No</p>
                                                </th>
                                                <td>
                                                    <p>#{{ $loan_account_detail['loanno'] }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Tranx Id</p>
                                                </th>
                                                <td>
                                                    <p>#{{ $loan_account_detail['loanapplytranxid'] }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Loan Sanction Date</p>
                                                </th>
                                                <td>
                                                    <p><i class="fa fa-calendar"></i> {{ date('F d, Y',
                                                        strtotime($loan_account_detail['loandate'])) }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Loan Amount</p>
                                                </th>
                                                <td>
                                                    <p>{{ number_format($loan_account_detail['loanamount'], 0, '.',
                                                        ',')
                                                        }} BDT</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Total</p>
                                                </th>
                                                <td>
                                                    <p>{{ number_format($loan_account_detail['loantotal'], 2, '.', ',')
                                                        }} BDT</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Due</p>
                                                </th>
                                                <td>
                                                    <p>{{ number_format($loan_account_detail['loandue'], 0, '.', ',')
                                                        }} BDT</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Service Charge</p>
                                                </th>
                                                <td>
                                                    <p>{{ $loan_account_detail['loaninterest'] }} %</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Loan Terms</p>
                                                </th>
                                                <td>
                                                    <p>{{ $loan_account_detail['loanterms'] }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Instalment</p>
                                                </th>
                                                <td>
                                                    <p>{{ number_format($loan_account_detail['dailyamount'], 2, '.',
                                                        ',') }} BDT</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Next Collection Date</p>
                                                </th>
                                                <td>
                                                    <p><i class="fa fa-calendar"></i> {{ date('F d, Y',
                                                        strtotime($loan_account_detail['next_collection_date'])) }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>End Date</p>
                                                </th>
                                                @php
                                                // $today = date('Y-m-d', strtotime('2019-01-26'));
                                                $today = date('Y-m-d');
                                                $enddate = date('Y-m-d',
                                                strtotime($loan_account_detail['loanending']));
                                                $date_str = "<span style='color:#ff8383;font-weight:700'>".date('F d,
                                                    Y', strtotime($loan_account_detail['loanending']))."</span>";
                                                $format_date = ($today === $enddate) ? $date_str : date('F d, Y',
                                                strtotime($loan_account_detail['loanending']));
                                                @endphp
                                                <td>
                                                    <p><i class="fa fa-calendar"></i> {!! $format_date !!}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Collection Fail Count</p>
                                                </th>
                                                <td>
                                                    <p>{{ $loan_account_detail['loanfailcount'] }}</p>
                                                </td>
                                            </tr>
                                            {{-- @if($loan_account_detail['fdrclosedate'])
                                            <tr>
                                                <th>
                                                    <p>Close Date</p>
                                                </th>
                                                <td>
                                                    <p><i class="fa fa-calendar"></i> {{ date('F d, Y',
                                                        strtotime($loan_account_detail['fdrclosedate'])) }}</p>
                                                </td>
                                            </tr>
                                            @endif
                                            @if($loan_account_detail['returnamount'])
                                            <tr>
                                                <th>
                                                    <p>Withdraw</p>
                                                </th>
                                                <td>
                                                    <p>Yes</p>
                                                </td>
                                            </tr>
                                            @endif --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Example Basic -->
                        </div>
                        @endif
                        {{-- Loan Summary End --}}

                        {{-- Loan history --}}
                        <div class="tab-pane animation-slide-left" id="fdr_withdraw_history" role="tabpanel">
                            <!-- Example Responsive -->
                            <div class="example-wrap">
                                <div style="margin-top:20px">
                                    <h3>Loan History</h3>
                                </div>
                                <div class="example">
                                    <div class="table-responsive table-condensed">
                                        <table class="table table-horizon">
                                            <thead>
                                                <tr>
                                                    <th>Tranx ID</th>
                                                    <th>Collection Date</th>
                                                    <th>Terms</th>
                                                    <th>Instalment</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($loan_records)
                                                <tr style="background:#00fff1">
                                                    <td>Null</td>
                                                    <td>
                                                        <span class="text-muted"><i class="fa fa-calendar"></i> {{
                                                            date('F d, Y', strtotime($loan_account_detail['loandate']))
                                                            }}</span>
                                                    </td>
                                                    <td>Opening</td>
                                                    <td></td>
                                                    <td>{{ number_format($loan_account_detail['loantotal'], 2, '.',
                                                        ',') }} BDT</td>
                                                </tr>
                                                @foreach($loan_records as $record)
                                                @php
                                                    if($record->currentterms != 0) {
                                                        $terms_str = $record->currentterms.' / '.$record->loantargetdays;
                                                    } elseif ($record->currentterms == 'custom') {
                                                        $terms_str = '<span style="color:tomato">Custom Collection</span>';
                                                    } else {
                                                        $terms_str = '';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $record->loantranxid }}</td>
                                                    <td>
                                                        <span class="text-muted"><i class="fa fa-calendar"></i> {{
                                                            date('F d, Y', strtotime($record->receivedate)) }}</span>
                                                    </td>
                                                    <td>{!! $terms_str !!}</td>
                                                    <td>{{ ($record->dailyamount != 0) ?
                                                        number_format($record->dailyamount, 2, '.', ',').' BDT' : 0 }}
                                                    </td>
                                                    <td>{{ ($record->currentdue != 0) ?
                                                        number_format($record->currentdue, 2, '.', ',').' BDT' : 0 }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $loan_records->appends(Request::only('search'))->links() }}
                                    </div>
                                </div>
                            </div>
                            <!-- End Example Responsive -->
                        </div>
                        {{-- Loan history END --}}
                        {{-- Loan Instalment Collection --}}
                        <div class="tab-pane animation-slide-left" id="loan_collection" role="tabpanel">
                            <div class="meta-wrapper">
                                <div style="float:left">
                                    <h4>Loan Collection</h4>
                                </div>
                                @if($loan_account_detail)
                                <div class="next-expected-date pull-right">
                                    <span class="next-deposite-date">Next Deposite Date: <strong>{{ date('F d, Y',
                                            strtotime($loan_account_detail['next_collection_date'])) }}</strong></span>
                                    <span class="loan-miss-count">Late Count ( <strong>{{
                                            $loan_account_detail['loanfailcount']
                                            }}</strong> )</span>
                                </div>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <!-- Example Basic Form -->
                            <div class="example-wrap">
                                <div class="example">
                                    @if($loan_account_detail)
                                    @php
                                    $loanterms = explode('-', $loan_account_detail['loanterms']);
                                    @endphp
                                    <form action="{{ url('/loan-deposite') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="accountNo" value="{{ $loan_account_detail['accountNo'] }}">
                                        @if($loan_account_detail)
                                        <input type="hidden" name="loanno" value="{{ $loan_account_detail['loanno'] }}">
                                        <input type="hidden" name="currentterms" value="{{ $loanterms[0] + 1 }}">
                                        <input type="hidden" name="loantargetdays" value="{{ $loanterms[1] }}">
                                        <input type="hidden" name="dailyamount" value="{{ $loan_account_detail['dailyamount'] }}">
                                        @endif
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="dailyamount">Daily Collection</label>
                                                <div class="input-group input-group-icon">
                                                    <input style="color:#009688;font-weight:700" type="text" class="form-control"
                                                        id="dailyamount" name="dailyamount" placeholder="Daily Collection"
                                                        value="{{ ($loan_account_detail['dailyamount']) ? $loan_account_detail['dailyamount'] : '' }}"
                                                        autocomplete="off" />
                                                    <span class="input-group-addon">
                                                        <span>৳</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="date">Deposite Date</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" class="form-control datepicker" id="date" name="receivedate"
                                                        autocomplete="off">
                                                    <span class="input-group-addon">
                                                        <span class="icon fa fa-calendar" aria-hidden="true"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 dps-apply-field">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary" id="validateButton2">Loan
                                                        Deposite</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                    {{ 'No active Loan Found' }}
                                    @endif
                                </div>
                            </div>
                            <!-- End Loan Deposite -->
                        </div>
                        {{-- Loan instalment END --}}
                        {{-- Loan Fail --}}
                        <div class="tab-pane animation-slide-left" id="loan_fail" role="tabpanel">
                            <div class="clearfix"></div>
                            <!-- Example Basic Form -->
                            <div class="example-wrap">
                                <div class="example">
                                    <form action="{{ url('/repermit-loan') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="loanapplytranxid" value="{{ $loan_account_detail['loanapplytranxid'] }}">
                                        <div class="form-group">
                                            <label class="control-label">How to process this loan?</label>
                                            <div>
                                                <div class="radio-custom radio-default radio-inline">
                                                    <input type="radio" id="loanrenew" name="loanpermission" value="renew" {{ ($loan_account_detail['loanpermission'] == 'renew') ? 'checked' : ''}}/>
                                                    <label for="loanrenew">Renew Loan</label>
                                                </div>
                                                <div class="radio-custom radio-default radio-inline">
                                                <input type="radio" id="loancustom" name="loanpermission" value="custom" {{ ($loan_account_detail['loanpermission'] == 'custom') ? 'checked' : '' }}/>
                                                    <label for="loancustom">Custom Collection</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 dps-apply-field">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary" id="validateButton2">Fail Loan Process</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Loan Deposite -->
                        </div>
                        {{-- Loan Fail END --}}
                        {{-- Loan Custom Collection --}}
                        <div class="tab-pane animation-slide-left" id="custom_collection" role="tabpanel">
                            <div class="clearfix"></div>
                            <!-- Example Basic Form -->
                            <div class="example-wrap">
                                <div class="example">
                                    <h3>Custom Collection</h3>
                                    <form action="{{ url('/custom-collection') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="accountNo" value="{{ $loan_account_detail['accountNo'] }}">
                                        @if($loan_account_detail)
                                        <input type="hidden" name="loanaccount" value="{{ $loan_account_detail['loanaccount'] }}">
                                        <input type="hidden" name="loanno" value="{{ $loan_account_detail['loanno'] }}">
                                        <input type="hidden" name="currentterms" value="{{ $loanterms[0] + 1 }}">
                                        <input type="hidden" name="loantargetdays" value="{{ $loanterms[1] }}">
                                        <input type="hidden" name="dailyamount" value="{{ $loan_account_detail['dailyamount'] }}">
                                        <input type="hidden" name="loantranxid" value="{{ $loan_account_detail['loanapplytranxid'] }}">
                                        @endif
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="dailyamount">Daily Collection</label>
                                                <div class="input-group input-group-icon">
                                                    <input style="color:#009688;font-weight:700" type="text" class="form-control"
                                                        id="dailyamount" name="dailyamount" placeholder="Daily Collection"
                                                        value="{{ ($loan_account_detail['dailyamount']) ? $loan_account_detail['dailyamount'] : '' }}"
                                                        autocomplete="off" />
                                                    <span class="input-group-addon">
                                                        <span>৳</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="date">Deposite Date</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" class="form-control datepicker" id="date" name="receivedate"
                                                        autocomplete="off">
                                                    <span class="input-group-addon">
                                                        <span class="icon fa fa-calendar" aria-hidden="true"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 dps-apply-field">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary" id="validateButton2">Custom Collection</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Loan Deposite -->
                        </div>
                        {{-- Loan Custom Collection END --}}
                    </div>
                </div>
            </div>
            <!-- End Panel -->
        </div>
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