@extends('layouts.template')

@section('page-title')
{{ $fdr_account_detail['fullname'] }} Detail
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
    background: #DBEFEE
}
.table-horizon > tbody tr td {
    border: 1px solid #93e0dc
}
</style>
@stop

@section('content')
<link rel="stylesheet" href="{{URL::to('/')}}/assets/examples/css/pages/profile.css">
<div class="page-header">
    <h1 class="page-title font_lato">FDR Profile </h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/dashboard')}}">{{ trans('app.home')}}</a></li>
            <li><a href="{{URL::to('/fdr-account')}}">{{ trans('Fdr Account')}}</a></li>
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
                            @if($fdr_account_detail['customerpic'])
                            <img src="{{URL::to('/uploads', $fdr_account_detail['customerpic'])}}" alt="...">
                            @else
                            <img src="{{URL::to('/')}}/global/portraits/5.jpg" alt="...">
                            @endif
                        </a>
                        @php
                        $gurdian_name = explode('-', $fdr_account_detail['fathername']);
                        @endphp
                        <h4 class="profile-user">{{ $fdr_account_detail['fullname'] }}</h4>
                        <p class="profile-job">{{ $gurdian_name[0] == 'F' ? 'Father Name ' : 'Husband Name ' }}: {{
                            $gurdian_name[1] }}</p>
                        <p class="profile-job"><a href="javascript:void(0);">Account No: #{{
                                $fdr_account_detail['accountNo'] }}</a></p>
                        <p class="profile-job"><a href="javascript:void(0);">FDR No: #{{
                                $fdr_account_detail['fdrno'] }}</a></p>
                        <p class="profile-job"><a href="javascript:void(0);">FDR Balance: {{
                                number_format($fdr_account_detail['fdramount'] - $fdr_account_detail['returnamount'], 0, '.', ',') }} BDT</a></p>
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
                        <li role="presentation" style="display: block;"><a data-toggle="tab" href="#fdr_withdraw_history"
                                aria-controls="fdr_withdraw_history" role="tab">History</a></li>
                        @if($fdr_account_detail['fdrstatus'] == 'active')
                        <li class="danger-tab" role="presentation" style="display: block;"><a style="color:red" data-toggle="tab" href="#fdr_close"
                            aria-controls="fdr_close" role="tab">FDR Account Close</a></li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        @if($fdr_account_detail)
                        <div class="tab-pane animation-slide-left" id="fdr_summary" role="tabpanel">
                            <div class="meta-wrapper">
                                <div style="float:left">
                                    <h4>FDR Summary</h4>
                                </div>
                                <div class="next-expected-date">
                                    <span class="next-deposite-date pull-right">Status: <strong>{{
                                            ($fdr_account_detail['fdrstatus'] == 'active' &&
                                            $fdr_account_detail['fdrpermission'] ==
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
                                                    <p>Fdr No</p>
                                                </th>
                                                <td>
                                                    <p>#{{ $fdr_account_detail['fdrno'] }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Tranx Id</p>
                                                </th>
                                                <td>
                                                    <p>#{{ $fdr_account_detail['tranxid'] }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>FDR Amount</p>
                                                </th>
                                                <td>
                                                    <p>{{ number_format($fdr_account_detail['fdramount'], 0, '.', ',')
                                                        }} BDT</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Profit Rate</p>
                                                </th>
                                                <td>
                                                    <p>{{ $fdr_account_detail['profitrate'] }} %</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>FDR Year</p>
                                                </th>
                                                <td>
                                                    <p>{{ ($fdr_account_detail['numberofyear'] > 1) ?
                                                        $fdr_account_detail['numberofyear'].' Years' :
                                                        $fdr_account_detail['numberofyear']. ' Year' }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>FDR Terms</p>
                                                </th>
                                                <td>
                                                    <p>{{ str_replace('-', ' / ', $fdr_account_detail['fdrterms']) }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Monthly Amount</p>
                                                </th>
                                                <td>
                                                    <p>{{ str_replace('-', ' / ', $fdr_account_detail['monthlyamount'])
                                                        }} BDT</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Next Profit Date</p>
                                                </th>
                                                <td>
                                                    <p><i class="fa fa-calendar"></i> {{ date('F d, Y',
                                                            strtotime($fdr_account_detail['nextwithdrawdate'])) }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>Apply Date</p>
                                                </th>
                                                <td>
                                                    <p><i class="fa fa-calendar"></i> {{ date('F d, Y',
                                                        strtotime($fdr_account_detail['openingdate'])) }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>End Date</p>
                                                </th>
                                                <td>
                                                    <p><i class="fa fa-calendar"></i> {{ date('F d, Y',
                                                        strtotime($fdr_account_detail['serviceenddate'])) }}</p>
                                                </td>
                                            </tr>
                                            @if($fdr_account_detail['fdrclosedate'])
                                            <tr>
                                                <th>
                                                    <p>Close Date</p>
                                                </th>
                                                <td>
                                                    <p><i class="fa fa-calendar"></i> {{ date('F d, Y',
                                                        strtotime($fdr_account_detail['fdrclosedate'])) }}</p>
                                                </td>
                                            </tr>
                                            @endif
                                            @if($fdr_account_detail['returnamount'])
                                            <tr>
                                                <th>
                                                    <p>Withdraw</p>
                                                </th>
                                                <td>
                                                    <p>Yes</p>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Example Basic -->
                        </div>
                        @endif
                        {{-- FDR Summary End --}}

                        {{-- FDR history --}}
                        <div class="tab-pane animation-slide-left" id="fdr_withdraw_history" role="tabpanel">
                            <!-- Example Responsive -->
                            <div class="example-wrap">
                                <div style="margin-top:20px">
                                    <h3>FDR History</h3>
                                </div>
                                <div class="example">
                                    <div class="table-responsive table-condensed">
                                        <table class="table table-horizon">
                                            <thead>
                                                <tr>
                                                    <th>Credited Date</th>
                                                    <th>Amount</th>
                                                    <th>Terms</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($fdr_records)
                                                @foreach($fdr_records as $record)
                                                <tr>
                                                    <td>
                                                        <span class="text-muted"><i class="fa fa-calendar"></i> {{
                                                            date('F d, Y', strtotime($record['withdrawdate'])) }}</span>
                                                    </td>
                                                    <td>{{ $record['monthlyamount'] }} BDT</td>
                                                    <td>{{ $record['fdrterms'] }}</td>
                                                    <td>{{ ($record['paymentstatus'] == 'paid') ? 'Transferred' : '' }}</td>
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
                        {{-- FDR history END --}}
                        {{-- FDR Close --}}
                        <div class="tab-pane animation-slide-left" id="fdr_close" role="tabpanel">
                            <!-- Example Basic Form -->
                            <div class="example-wrap">
                                <div style="margin-top:20px">
                                    <h3>FDR Close</h3>
                                </div>
                                <div class="example">
                                    <form  action="{{ url('/fdr-account-close', $fdr_account_detail['id']) }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="returnamount" value="{{ $fdr_account_detail['fdramount'] }}">
                                        <div class="form-group">
                                            <div class="checkbox-custom checkbox-default">
                                                <input type="checkbox" id="closefdraccount" name="closefdraccount"
                                                 autocomplete="off" />
                                                <label for="closefdraccount">I want to close the Fdr Account</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="fdrclosedate">Closing Date</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" class="form-control datepicker" id="fdrclosedate"
                                                    name="fdrclosedate" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="icon fa fa-calendar" aria-hidden="true"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="validateButton2">Close Fdr Account</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Example Basic Form -->
                        </div>
                        {{-- FDR Close END --}}
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