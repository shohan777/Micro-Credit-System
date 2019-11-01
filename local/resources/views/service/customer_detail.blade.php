@extends('layouts.template')

@section('page-title')
{{ $customer_list['fullname'] }} Detail
@stop

@section('page-css')
<style>
    .widget-header-content {
    position: relative
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
    background: #f2a654;
    margin-bottom: 0;
    color: #000;
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
</style>
@stop

@section('content')
<link rel="stylesheet" href="{{URL::to('/')}}/assets/examples/css/pages/profile.css">
<div class="page-header">
    <h1 class="page-title font_lato">Profile </h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/dashboard')}}">{{ trans('app.home')}}</a></li>
            <li><a href="{{URL::to('/customer-list')}}">{{ trans('app.customer')}}</a></li>
            <li class="active">Profile</li>
        </ol>
    </div>
</div>
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
        <div class="alert dark alert-icon alert-danger alert-dismissible alertDismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="icon wb-check" aria-hidden="true"></i>
            {{session('msg_delete')}}
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-3">
            <!-- Page Widget -->
            <div class="widget widget-shadow text-center">
                <div class="widget-header">
                    <div class="widget-header-content">
                        <span class="close-edit"><a href=""><i class="icon fa-pencil" aria-hidden="true"></i> Edit</a></span>
                        <a class="avatar avatar-lg" href="javascript:void(0)">
                            @if($customer_list['customerpic'])
                                <img src="{{URL::to('/uploads', $customer_list['customerpic'])}}" alt="...">
                            @else
                                <img src="{{URL::to('/')}}/global/portraits/5.jpg" alt="...">
                            @endif
                        </a>
                        <form id="profile_image_edit" role="form" action="{{URL::to('/customerImageUpload')}}/{{$customer_list['id']}}"
                            method="post" enctype="multipart/form-data" novalidate="novalidate">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <label id="class_userfile" class="error" for="userfile"></label>

                                    <span class="btn btn-light-grey btn-file"><span class="fileupload-new btn btn-default"><i
                                                class="fa fa-picture-o "></i> {{ trans('app.select_image')}} </span><span
                                            class="fileupload-exists"><i class="fa fa-picture-o"></i> {{
                                            trans('app.change')}}</span>
                                        <input type="file" name="logo" class="userfile" id="uploadImage" onchange="PreviewImage();">

                                    </span>
                                    <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                        <i class="fa fa-times"></i> {{ trans('app.remove')}}
                                    </a>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <button type="submit" class="btn btn-primary ladda-button" data-plugin="ladda" data-style="expand-left">
                                <span aria-hidden="true" class="glyphicon glyphicon-refresh"></span> {{
                                trans('app.update_settings')}}
                                <span class="ladda-spinner"></span>
                                <div class="ladda-progress" style="width: 0px;"></div>
                            </button>
                        </form>
                        <h4 class="profile-user">{{ $customer_list['fullname'] }}</h4>
                        <p class="profile-job"><a href="javascript:void(0);">Account No: #{{
                                $customer_list['accountNo'] }}</a></p>
                        <p style="font-size: 12px;font-weight: 700;" class="profile-job">Create Date: {{ date('M d, Y',
                            strtotime($customer_list['created_at'])) }}</p>
                    </div>
                </div>
            </div>
            <!-- End Page Widget -->
        </div>
        <div class="col-md-9">
            <!-- Panel -->
            <div class="panel">
                <div class="panel-body nav-tabs-animate nav-tabs-horizontal">
                    <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                        {{-- Summary --}}
                        @if(!empty($services->count()))
                        <li class="dropdown" role="presentation" style="display: block;">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="caret"></span> Summary </a>
                            <ul class="dropdown-menu" role="menu">
                                @if($services)
                                    @foreach($services as $service)
                                        @switch($service['servicename'])
                                            @case('DPS')
                                            <li role="presentation" style="display: block;"><a data-toggle="tab" href="#dps_summary"
                                            aria-controls="dps_summary" role="tab">{{ $service['servicename'] }}</a></li>
                                                @break
                                            @case('FDR')
                                            <li role="presentation" style="display: block;"><a data-toggle="tab" href="#fdr_summary"
                                                aria-controls="fdr_summary" role="tab">{{ $service['servicename'] }}</a></li>
                                                @break
                                            @default
                                            <li role="presentation"><a data-toggle="tab" href="#loan_summary" aria-controls="loan_summary"
                                                role="tab">{{ $service['servicename'] }}</a></li>
                                        @endswitch
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                        @endif
                        {{-- Service --}}
                        @if(!empty($services->count()))
                        <li class="dropdown" role="presentation" style="display: block;">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="caret"></span> Services </a>
                            <ul class="dropdown-menu" role="menu">
                                @if($services)
                                    @foreach($services as $service)
                                        @switch($service['servicename'])
                                            @case('DPS')
                                            <li role="presentation" style="display: block;"><a data-toggle="tab" href="#dps_deposite"
                                            aria-controls="dps_deposite" role="tab">{{ $service['servicename'] }}</a></li>
                                                @break
                                            @case('FDR')
                                            <li role="presentation" style="display: block;"><a data-toggle="tab" href="#fdr_deposite"
                                                aria-controls="fdr_deposite" role="tab">{{ $service['servicename'] }}</a></li>
                                                @break
                                            @default
                                            <li role="presentation"><a data-toggle="tab" href="#loan_deposite" aria-controls="loan_deposite"
                                                role="tab">{{ $service['servicename'] }}</a></li>
                                        @endswitch
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                        @endif
                        {{-- History --}}
                        @if(!empty($services->count()))
                        <li class="dropdown" role="presentation" style="display: block;">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="caret"></span> History </a>
                            <ul class="dropdown-menu" role="menu">
                                @if($services)
                                    @foreach($services as $service)
                                        @switch($service['servicename'])
                                            @case('DPS')
                                            <li role="presentation" style="display: block;"><a data-toggle="tab" href="#dps_deposite_history"
                                                aria-controls="dps_deposite_history" role="tab">{{ $service['servicename'] }}</a></li>
                                                @break
                                            @case('FDR')
                                            <li role="presentation" style="display: block;"><a data-toggle="tab" href="#fdr_withdraw_history"
                                                aria-controls="fdr_withdraw_history" role="tab">{{ $service['servicename'] }}</a></li>
                                                @break
                                            @default
                                            <li role="presentation"><a data-toggle="tab" href="#loan_deposite_history" aria-controls="loan_deposite_history"
                                                role="tab">{{ $service['servicename'] }}</a></li>
                                        @endswitch
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                        @endif
                        <li class="active" role="presentation"><a data-toggle="tab" href="#personal" aria-controls="personal"
                                role="tab">Personal</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#nominee" aria-controls="nominee" role="tab">Nominee</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#introducer" aria-controls="introducer" role="tab">Introducer</a></li>
                    </ul>
                    <div class="tab-content">
                        {{-- Loan Summary --}}
                        @if($loan_data)
                        <div class="tab-pane animation-slide-left" id="loan_summary" role="tabpanel">
                            <div class="meta-wrapper">
                                <div style="float:left">
                                    <h4>Loan Summary</h4>
                                </div>
                                <div class="next-expected-date">
                                    <span class="next-deposite-date pull-right">Status: <strong>{{ ($loan_data['loanstatus'] == 'active' && $loan_data['loanpermission'] == 'approved') ? 'Running' : '' }}</strong></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Example Basic -->
                            <div class="example-wrap">
                                <div class="example table-responsive">
                                    <table class="table no-border">
                                        <tbody>
                                            <tr>
                                                <th><p>Loan No</p></th>
                                                <td><p>#{{ $loan_data['loanno'] }}</p></td>
                                            </tr>
                                            <tr>
                                                <th><p>Tranx Id</p></th>
                                                <td><p>#{{ $loan_data['loanapplytranxid'] }}</p></td>
                                            </tr>
                                        <tr>
                                            <th><p>Loan Amount</p></th>
                                            <td><p>{{ number_format($loan_data['loanamount'], 0, '.', ',') }} BDT</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Loan Total Amount</p></th>
                                            <td><p>{{ number_format($loan_data['loantotal'], 0, '.', ',') }} BDT</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Loan Due</p></th>
                                            <td><p>{{ number_format($loan_data['loandue'], 0, '.', ',') }} BDT</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Current Loan Terms</p></th>
                                            <td><p>{{ str_replace('-', ' / ', $loan_data['loanterms']) }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>Collection Fail</p></th>
                                            <td><p>{{ $loan_data['loanfailcount']}}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>End Date</p></th>
                                            <td><p><i class="fa fa-calendar"></i>  {{ date('F d, Y', strtotime($loan_data['loanending'])) }}</p></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Example Basic -->
                        </div>
                        @endif
                        {{-- Loan Summary End --}}
                        {{-- FDr Summary --}}
                        @if($fdr_data)
                        <div class="tab-pane animation-slide-left" id="fdr_summary" role="tabpanel">
                            <div class="meta-wrapper">
                                <div style="float:left">
                                    <h4>FDR Summary</h4>
                                </div>
                                <div class="next-expected-date">
                                    <span class="next-deposite-date pull-right">Status: <strong>{{ ($fdr_data['fdrstatus'] == 'active' && $fdr_data['fdrpermission'] == 'approved') ? 'Running' : '' }}</strong></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Example Basic -->
                            <div class="example-wrap">
                                <div class="example table-responsive">
                                    <table class="table no-border">
                                        <tbody>
                                            <tr>
                                                <th><p>Fdr No</p></th>
                                                <td><p>#{{ $fdr_data['fdrno'] }}</p></td>
                                            </tr>
                                            <tr>
                                                <th><p>Tranx Id</p></th>
                                                <td><p>#{{ $fdr_data['tranxid'] }}</p></td>
                                            </tr>
                                        <tr>
                                            <th><p>FDR Amount</p></th>
                                            <td><p>{{ number_format($fdr_data['fdramount'], 0, '.', ',') }} BDT</p></td>
                                        </tr>
                                        {{-- <tr>
                                            <th><p>FDR Total Amount</p></th>
                                            <td><p>{{ number_format($fdr_data['totalamount'], 0, '.', ',') }} BDT</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>FDR Due</p></th>
                                            <td><p>{{ number_format($fdr_data['dueamount'], 0, '.', ',') }} BDT</p></td>
                                        </tr> --}}
                                        <tr>
                                            <th><p>FDR Terms</p></th>
                                            <td><p>{{ str_replace('-', ' / ', $fdr_data['fdrterms']) }}</p></td>
                                        </tr>
                                        <tr>
                                            <th><p>End Date</p></th>
                                            <td><p><i class="fa fa-calendar"></i>  {{ date('F d, Y', strtotime($fdr_data['serviceenddate'])) }}</p></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Example Basic -->
                        </div>
                        @endif
                        {{-- FDR Summary End --}}
                        {{-- Summary END --}}
                        {{-- DPS deposite --}}
                        <div class="tab-pane animation-slide-left" id="dps_deposite" role="tabpanel">
                            <div class="meta-wrapper">
                                <div style="float:left">
                                    <h4>DPS Deposite</h4>
                                </div>
                                <div class="next-expected-date">
                                    <span class="next-deposite-date pull-right">Next Deposite Date: <strong>{{ date('F d, Y', strtotime($dps_record['nextdate'])) }}</strong></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Example Basic Form -->
                            <div class="example-wrap">
                                <div class="example">
                                    <form action="{{ url('/dps-deposite') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="accountNo" value="{{ $customer_list['accountNo'] }}">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="monthlyamount">Montly Balance</label>
                                                <input type="text" class="form-control round" id="monthlyamount" name="monthlyamount"
                                            placeholder="Montly Balance" value="{{ $customer_list['monthlyamount'] }}" autocomplete="off" readonly/>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="date">Deposite Date</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" class="form-control round datepicker" id="date" name="date" autocomplete="off" >
                                                    <span class="input-group-addon">
                                                        <span class="icon fa fa-calendar" aria-hidden="true"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 dps-apply-field">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary" id="validateButton2">Deposite</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <!-- End Example Basic Form -->
                        </div>
                        {{-- FDR deposite --}}
                        <div class="tab-pane animation-slide-left" id="fdr_deposite" role="tabpanel">
                            <div class="meta-wrapper">
                                <div style="float:left">
                                    <h4>FDR Deposite</h4>
                                </div>
                                <div class="next-expected-date">
                                    <span class="next-deposite-date pull-right">Next Withdraw Date: <strong>{{ date('F d, Y', strtotime($fdr_data['nextwithdrawdate'])) }}</strong></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Example Basic Form -->
                            <div class="example-wrap">
                                <div class="example">
                                    <form action="{{ url('/fdr-deposite') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="accountNo" value="{{ $fdr_data['accountNo'] }}">
                                        <input type="hidden" name="fdrno" value="{{ $fdr_data['fdrno'] }}">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="monthlyamount">Montly Balance</label>
                                                <input type="text" class="form-control round" id="monthlyamount" name="monthlyamount"
                                            placeholder="Montly Balance" value="{{ $fdr_data['monthlyamount'] }}" autocomplete="off" readonly/>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="withdrawdate">Withdraw Date</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" class="form-control round datepicker" id="withdrawdate" name="withdrawdate" autocomplete="off" >
                                                    <span class="input-group-addon">
                                                        <span class="icon fa fa-calendar" aria-hidden="true"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 dps-apply-field">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary" id="validateButton2">Withdraw</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <!-- End Example Basic Form -->
                        </div>
                        {{-- FDR Deposite END --}}
                        {{-- Loan Deposite --}}
                        <div class="tab-pane animation-slide-left" id="loan_deposite" role="tabpanel">
                            <div class="meta-wrapper">
                                <div style="float:left">
                                    <h4>Loan Deposite</h4>
                                </div>
                                @if($loan_data)
                                <div class="next-expected-date pull-right">
                                    <span class="next-deposite-date">Next Deposite Date: <strong>{{ date('F d, Y', strtotime($loan_data['next_collection_date'])) }}</strong></span>
                                    <span class="loan-miss-count">Late Count ( <strong>{{ $loan_data['loanfailcount'] }}</strong> )</span>
                                </div>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <!-- Example Basic Form -->
                            <div class="example-wrap">
                                <div class="example">
                                    @if($loan_data)
                                    @php
                                        $loanterms = explode('-', $loan_data['loanterms']);
                                        
                                    @endphp
                                    <form action="{{ url('/loan-deposite') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="accountNo" value="{{ $customer_list['accountNo'] }}">
                                        @if($loan_data)
                                        <input type="hidden" name="loanno" value="{{ $loan_data['loanno'] }}">
                                        <input type="hidden" name="currentterms" value="{{ $loanterms[0] + 1 }}">
                                        <input type="hidden" name="loantargetdays" value="{{ $loanterms[1] }}">
                                        <input type="hidden" name="dailyamount" value="{{ $loan_data['dailyamount'] }}">
                                        @endif
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="dailyamount">Daily Collection</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" class="form-control round" id="dailyamount" name="dailyamount"
                                            placeholder="Daily Collection" value="{{ ($loan_data['dailyamount']) ? $loan_data['dailyamount'] : '' }}" autocomplete="off" readonly/>
                                                    <span class="input-group-addon">
                                                        <span>৳</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="date">Deposite Date</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" class="form-control round datepicker" id="date" name="receivedate" autocomplete="off" >
                                                    <span class="input-group-addon">
                                                        <span class="icon fa fa-calendar" aria-hidden="true"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 dps-apply-field">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary" id="validateButton2">Loan Deposite</button>
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
                        {{-- Dps history --}}
                        <div class="tab-pane animation-slide-left" id="dps_deposite_history" role="tabpanel">
                            <!-- Example Responsive -->
                            <div class="example-wrap">
                                <div style="margin-top:20px">
                                    <h3>DPS Deposite History</h3>
                                </div>
                                <div class="example">
                                <div class="table-responsive table-condensed">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                        <th>Tranx ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Interest Rate</th>
                                        <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($dps_records)
                                        @foreach($dps_records as $record)
                                        <tr>
                                            <td><a href="javascript:void(0)">{{ $record['trnxNo'] }}</a></td>
                                            <td>
                                                <span class="text-muted"><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($record['date'])) }}</span>
                                            </td>
                                            <td>{{ $record['monthlyamount'] }} BDT</td>
                                            <td>{{ $record['monthlyinterest'] }}</td>
                                            <td>{{ $record['monthlytotal'] }} BDT</td>
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
                        {{-- Dps history END --}}
                        {{-- FDR history --}}
                        <div class="tab-pane animation-slide-left" id="fdr_withdraw_history" role="tabpanel">
                            <!-- Example Responsive -->
                            <div class="example-wrap">
                                <div style="margin-top:20px">
                                    <h3>FDR Writhdrawal History</h3>
                                </div>
                                <div class="example">
                                <div class="table-responsive table-condensed">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tranx ID</th>
                                            <th>Withdrawal Date</th>
                                            <th>Amount</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($fdr_record_data)
                                        @foreach($fdr_record_data as $record)
                                        <tr>
                                            <td><a href="javascript:void(0)">{{ $record['trnxNo'] }}</a></td>
                                            <td>
                                                <span class="text-muted"><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($record['withdrawdate'])) }}</span>
                                            </td>
                                            <td>{{ $record['monthlyamount'] }} BDT</td>
                                            <td>{{ $record['paymentstatus'] }}</td>
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
                        {{-- Loan history --}}
                        <div class="tab-pane animation-slide-left" id="loan_deposite_history" role="tabpanel">
                            <!-- Example Responsive -->
                            <div class="meta-wrapper">
                                <div style="float:left">
                                    <h4>Loan Deposite History</h4>
                                </div>
                                @if($loan_data)
                                <div class="next-expected-date pull-right">
                                    <span class="loan-miss-count">Late Count ( <strong>{{ $loan_data['loanfailcount'] }}</strong> )</span>
                                </div>
                                @endif
                            </div>
                            <div class="example-wrap">
                                <div class="clearfix"></div>
                                @if($loan_data)
                                @if($loan_records)
                                <div class="example">
                                <div class="table-responsive table-condensed">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                        <th>Tranx ID</th>
                                        <th>Loan No</th>
                                        <th>Date</th>
                                        <th>Daily Amount</th>
                                        <th>Terms</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($loan_records as $record)
                                        @if($record->loantranxid)
                                        <tr>
                                            <td><a href="javascript:void(0)">#{{ $record->loantranxid }}</a></td>
                                            <td>#{{ $record->loanno }}</td>
                                            <td>
                                                <span class="text-muted"><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($record->receivedate)) }}</span>
                                            </td>
                                            <td>{{ $record->dailyamount }} BDT</td>
                                            <td>{{ $record->currentterms.' / '.$record->loantargetdays }}</td>
                                        </tr>
                                        @else
                                        <tr class="danger">
                                            <td><a href="javascript:void(0)">Not Collected</a></td>
                                            <td>#{{ $record->loanno }}</td>
                                            <td>
                                                <span><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($record->receivedate)) }}</span>
                                            </td>
                                            <td>0</td>
                                            <td>Nill</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    
                                    </tbody>
                                    </table>
                                @endif
                                </div>
                                </div>
                                {{ $loan_records->appends(Request::only('search'))->links() }}
                                @else
                                    {{ 'No active loan found' }}
                                @endif
                            </div>
                            <!-- End Example Responsive -->
                        </div>
                        {{-- Loan history END --}}
                        <div class="tab-pane active animation-slide-left" id="personal" role="tabpanel">
                            @if($customer_list != null)
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Account Number</th>
                                            <td><a href="javascript:void(0)">#{{ $customer_list['accountNo'] }}</a></td>
                                        </tr>
                                        <tr>
                                            <th>Field</th>
                                            <td><a href="javascript:void(0)">{{ $customer_list['fieldname'] }}</a></td>
                                        </tr>
                                        <tr>
                                            <th>Full Name</th>
                                            <td>{{ $customer_list['fullname'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Father/Husband Name</th>
                                            <td>{{ $customer_list['fathername'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mother Name</th>
                                            <td>{{ $customer_list['mothername'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Present Address</th>
                                            <td>{{ $customer_list['presentaddress'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Permanent Address</th>
                                            <td>{{ $customer_list['permanentaddress'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Occupation</th>
                                            <td>{{ $customer_list['occupation'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nationality</th>
                                            <td>{{ $customer_list['nationality'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>NID</th>
                                            <td>{{ $customer_list['nidno'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <td>{{ $customer_list['age'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mobile</th>
                                            <td>{{ $customer_list['mobile'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane animation-slide-left" id="nominee" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Full Name</th>
                                            <td>{{ $customer_list['nomname'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Father/Husband Name</th>
                                            <td>{{ $customer_list['nomfathername'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mother Name</th>
                                            <td>{{ $customer_list['nommothername'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Present Address</th>
                                            <td>{{ $customer_list['nompresentaddress'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Permanent Address</th>
                                            <td>{{ $customer_list['nompermanentaddress'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Occupation</th>
                                            <td>{{ $customer_list['nomoccupation'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Relation</th>
                                            <td>{{ $customer_list['relationship'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>NID</th>
                                            <td>{{ $customer_list['nomnidno'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <td>{{ $customer_list['nomage'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mobile</th>
                                            <td>{{ $customer_list['nommobile'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane animation-slide-left" id="introducer" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Introducer Name</th>
                                            <td>{{ $customer_list['introducername'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Introducer Address</th>
                                            <td>{{ $customer_list['introducerpermanentaddress'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
    $(document).ready(function () {
        $(".close-edit a").click(function (event) {
            event.preventDefault();
            $("#profile_image_edit").toggle()
        })
    });

    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });
</script>
@stop