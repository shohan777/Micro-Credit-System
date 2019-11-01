@extends('layouts.template')

@section('page-title')
Apply Loan
@stop

@section('page-css')
<link rel="stylesheet" href="{{URL::to('/')}}/global/vendor/bootstrap-sweetalert/sweet-alert.css">
<style>
    .customer-short-profile {
        background: #9EA5DB;
        display: none;
        border-radius: 5px;
    }
    .customer-short-profile .img {
        width: 70%;
        margin: 0 auto;
    }
    .customer-short-profile .img img {
        width: 100%;
    }
    .dps-apply-field {
        display: none;
    }
    .customer-short-profile-else {
        display: none;
        color: #ffa700;
        text-transform: capitalize;
        font-weight: 700;
    }
    .dps-profile-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 124px;
    }
    .profile-loading {
        display: none;
    }
    .modal-fall .modal-content {
        background: #e9595b;
        color: #fff;
        font-weight: 700;
    }
    .modal-fall .modal-title {
        color: #f2a654;
    }
</style>
@stop

@section('content')
<div class="page-header">
    <h1 class="page-title font_lato"> {{ trans('Loan')}} </h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/dashboard')}}"> {{ trans('app.home')}} </a></li>
            <li><a href="{{URL::to('userlist')}}"> {{ trans('app.users')}} </a></li>
            <li class="active"> {{ trans('app.settings')}} </li>
        </ol>
    </div>
</div>
<div class="page-content" ng-app="">
    <div class="panel">
        <div class="panel-body container-fluid">
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
                <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                    <li role="presentation" class=""><a data-toggle="tab" href="#loanadd" aria-controls="profile"
                            role="tab" aria-expanded="false"> <i class="fa fa-lock"></i> Apply Loan</a></li>
                    <li class="" role="presentation"><a data-toggle="tab" href="#loanapplylist" aria-controls="activities"
                        role="tab" aria-expanded="false" aria-hidden="true"><span class="glyphicon glyphicon-eye-open"></span>
                        Pending Loan</a></li>
                    <li class="active" role="presentation"><a data-toggle="tab" href="#approvedLoan" aria-controls="approvedLoan"
                            role="tab" aria-expanded="true"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            Approved Loan</a></li>
                    
                </ul>
            </div>
            <div style="clear:both;"></div><br>
            <div class="tab-content">
                <!-------------- Approved loan List ----------------->
                <div id="approvedLoan" class="tab-pane fade in active">
                    <div class="example-wrap">
                        <div class="example">
                            <div class="">
                                <table class="table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">Sl</th>
                                            <th>Account No</th>
                                            <th>Loan Account No</th>
                                            <th>Loan No</th>
                                            <th>Tranx No</th>
                                            <th>Loan Amount</th>
                                            <th>Apply Date</th>
                                            <th>Ending Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($loan_approve_list)
                                        @foreach($loan_approve_list as $loan_apply)
                                        <tr class="success">
                                            <td class="col-md-1">{{ $loop->index + 1 }}</td>
                                            <td>#{{ $loan_apply->accountNo }}</td>
                                            <td>#{{ $loan_apply->loanaccount }}</td>
                                            <td>#{{ $loan_apply->loanno }}</td>
                                            <td>{{ $loan_apply->loanapplytranxid }}</td>
                                            <td>{{ number_format($loan_apply->loanamount, 0, '.', ',') }} <span>BDT</span></td>
                                            <td>
                                                <span class="text-muted"><i class="wb wb-time"></i> {{ date('M d, Y',
                                                    strtotime($loan_apply->created_at)) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted"><i class="wb wb-time"></i> {{ date('M d, Y',
                                                    strtotime($loan_apply->loanending)) }}</span>
                                            </td>
                                            <td>{{ ucfirst($loan_apply->loanstatus) }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                
                                <div style="clear:both;"></div><br/>
    
                                {{-- {{ $customer_list->render() }} --}}
                                {{-- {{ $customer_list->appends(Request::only('search'))->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------- Pending loan List ----------------->
                <div id="loanapplylist" class="tab-pane fade in">
                    <div class="example-wrap">
                        <div class="example">
                            <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1">Sl</th>
                                            <th>Account No</th>
                                            <th>Loan Acc</th>
                                            <th>Tranx No</th>
                                            <th>Loan Amount</th>
                                            <th>Apply Date</th>
                                            <th>Permission</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($loan_apply_list)
                                        @foreach($loan_apply_list as $loan_apply)
                                        @php
                                            foreach($loan_account_no as $loan_acc_key => $loan_acc_val) {
                                                if($loan_apply->accountNo == $loan_acc_key) {
                                                    $loan_account = $loan_acc_val;
                                                }
                                            }
                                        @endphp
                                        <tr class="info">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>#{{ $loan_apply->accountNo }}</td>
                                            <td>#{{ $loan_account }}</td>
                                            <td>{{ $loan_apply->loanapplytranxid }}</td>
                                            <td>{{ number_format($loan_apply->loanamount, 0, '.', ',') }} <span>BDT</span></td>
                                            <td>
                                                <span>
                                                    <i class="wb wb-calendar"></i>{{ date('M d, Y', strtotime($loan_apply->created_at)) }}
                                                </span>
                                            </td>
                                            <td>{{ $loan_apply->loanpermission }}</td>
                                            <td>{{ $loan_apply->loanstatus }}</td>

                                            <td class="text-center">
                                                <button class="btn btn-primary"data-loanaccount="{{ $loan_account }}" data-fullname="{{ $loan_apply->fullname }}" data-loaninterest="{{ $loan_apply->loaninterest }}" data-accountno="{{ $loan_apply->accountNo }}" data-loanapplytranxid="{{ $loan_apply->loanapplytranxid }}" data-loanamount="{{ $loan_apply->loanamount }}" data-trxnno="{{ $loan_apply->loanapplytranxid }}" data-toggle="modal" data-target="#myModal" onclick="updateLoanPermission(this)"><i class="icon fa-eye" aria-hidden="true"></i> Action</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                    
                                    <!-- Modal content-->
                                    <div class="modal-content" style="background-color:#ccd5db">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color:#016ef1">Modal Header</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('/loan-approval') }}" method="POST" autocomplete="off" id="exampleStandardFormtt">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="loanamount" name="loanamount">
                                                <input type="hidden" id="loanapplytranxid" name="loanapplytranxid">
                                                <input type="hidden" id="loaninterest" name="loaninterest">
                                                <div class="row">
                                                    <div class="form-group col-sm-12">
                                                        <label class="control-label" for="initialInvest">Account No</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="accountNo" name="accountNo"
                                                                placeholder="Account No..." readonly>
                                                            <span class="input-group-btn">
                                                                <a href="javascript:void(0)" class="btn btn-primary""><i
                                                                        class="icon wb-search" style="vertical-align: initial;" aria-hidden="true"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <div class="checkbox-custom checkbox-default">
                                                            <input type="checkbox" id="repermit" name="repermit"
                                                             autocomplete="off" />
                                                            <label for="repermit">Loan Renew</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <select class="form-control" id="loanpermission" name="loanpermission" onchange="hideLoanTerms(this)">
                                                            <option value="approved">Approved</option>
                                                            <option value="canceled">Canceled</option>
                                                        </select>
                                                    </div>
                                                    <div class="condition-wrap" id="loanterms">
                                                        <div class="form-group col-sm-6">
                                                            <label class="control-label" for="loanaccount">Loan Account No</label>
                                                            <input type="number" class="form-control" id="loanaccount" name="loanaccount"
                                                            placeholder="Loan Account No">
                                                        </div>
                                                        <div class="form-group col-sm-6">
                                                            <label class="control-label" for="loanterms">Instalment</label>
                                                            <select class="form-control" id="loanterms" name="loanterms">
                                                                @if($loan_timeline)
                                                                    @foreach($loan_timeline as $day)
                                                                    <option value="{{ $day }}">{{ $day }} days</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary" id="validateButton2tt">Approval</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    
                                    </div>
                                </div>
                                {{-- Modal END --}}
                                <div style="clear:both;"></div><br/>
    
                                {{-- {{ $customer_list->render() }} --}}
                                {{-- {{ $customer_list->appends(Request::only('search'))->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!--------- Add Loan ---------->
                <div id="loanadd" class="tab-pane fade">
                    <div class="col-md-8">
                        <!-- Example Basic Form -->
                        <div class="example-wrap">
                            <div class="example">
                                <form action="{{ url('/loan-apply') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label class="control-label" for="initialInvest">Account No</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control round" id="accountNo" name="accountNo"
                                                    placeholder="Account No..." required>
                                                <span class="input-group-btn">
                                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="getCustomerloan(this)"><i
                                                            class="icon wb-search" style="vertical-align: initial;" aria-hidden="true"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dps-apply-field">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="loanamount">Loan Amount</label>
                                                <input type="number" class="form-control round" id="loanamount" name="loanamount"
                                                    placeholder="Loan Amount" autocomplete="off" />
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label" for="loaninterest">Loan Interest</label>
                                                <input type="number" value="{{ $loan_settings['interestrate'] }}" placeholder="1.00" step="0.01" min="0" max="18" class="form-control round" id="loaninterest" name="loaninterest" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="validateButton2">Apply Loan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <button style="visibility: hidden" id="failed-trigger" class="btn btn-outline btn-default"
                                data-plugin="bootbox" data-title="Warning" data-message="You are not eligible for loan"
                                data-classname="modal-fall" type="button">Fall</button>
                        </div>
                        <!-- End Example Basic Form -->
                    </div>
                    <div class="col-md-4 dps-profile-wrapper">
                        <img class="profile-loading" src="{{ url('assets/profile-loading.gif') }}" alt="">
                        <div class="customer-short-profile text-center">
                            <div class="img">
                                <img id="profile_img" src="{{ url('/uploads/') }}" alt="">
                            </div>
                            <div class="meta">
                                <h3 id="profile_name"></h3>
                                <p><strong>Account Number: <a href="javascript:void(0)"><span id="profile_account_no"></span></a></strong></p>
                                <p><strong><span id="gurdian_name">Father Name</span>: <span id="profile_father_name"></span></strong></p>
                            </div>
                        </div>
                        <div class="customer-short-profile-else text-center">
                            Customer not Exists
                        </div>
                    </div>
                </div>

            </div>
            <div style="clear:both;"></div>
        </div>
        <!-- /.row -->
    </div>
</div><br />
@stop

@section('page-js')
<script src="{{URL::to('/')}}/global/vendor/bootstrap-sweetalert/sweet-alert.js"></script>
<script>
    
    function getCustomerloan(ele) {
        var account_id = $(ele).parent().siblings().val();
        $(".dps-apply-field").hide();
        $(".customer-short-profile").fadeOut();
        $.ajax({
            url: '{{ url('/getCustomerLoan') }}',
            type: 'GET',
            data: 'account_id=' + account_id,
            dataType: 'json',
            beforeSend: function () {
                $(".profile-loading").show();
            },
            success: function (data) {
                
                if (data != null) {
                    $(".customer-short-profile-else").fadeOut();
                    $(".customer-short-profile").fadeIn();
                    $("#profile_img").attr('src', '{{ url("/uploads") }}/' + data.customerpic);
                    $("#profile_name").text(data.fullname);
                    $("#profile_account_no").text(data.accountNo);
                    
                    $("#accountNo").val(account_id);
                    if(data.fathername.substr(0,1) == 'F') {
                        $("#gurdian_name").text("Father Name");
                        $("#profile_father_name").text(data.fathername.substr(2));
                    } else {
                        $("#gurdian_name").text("Husband Name");
                        $("#profile_father_name").text(data.fathername.substr(2));
                    }
                    $(".dps-apply-field").show();
                } else {
                    $(".profile-loading").hide();
                    $(".dps-apply-field").hide();
                    $(".customer-short-profile").fadeOut(50);
                    $(".customer-short-profile-else").fadeIn(400);
                }
            },
            complete: function () {
                $(".profile-loading").hide();
            }
        });
    }

    function updateLoanPermission(ele) {
        var getTranxno = $(ele).attr('data-trxnno');
        var getAccountno = $(ele).attr('data-accountno');
        var getLoanamount = $(ele).attr('data-loanamount');
        var loanapplytranxid = $(ele).attr('data-loanapplytranxid');
        var loaninterest = $(ele).attr('data-loaninterest');
        var fullname = $(ele).attr('data-fullname');
        var loanaccount = $(ele).attr('data-loanaccount');
        console.log(loanaccount);
        $("#myModal .modal-title").text(fullname);
        $("#myModal #accountNo").val(getAccountno);
        $("#myModal #loanamount").val(getLoanamount);
        $("#myModal #loanapplytranxid").val(loanapplytranxid);
        $("#myModal #loaninterest").val(loaninterest);
        $("#myModal #loanaccount").val(loanaccount);
    }

    function hideLoanTerms(ele) {
        var selected_val = $(ele).find(":selected").val();
        if(selected_val == 'canceled') {
            $("#loanterms").hide();
        } else {
            $("#loanterms").show();
        }
        console.log(selected_val);
    }
</script>
@stop
