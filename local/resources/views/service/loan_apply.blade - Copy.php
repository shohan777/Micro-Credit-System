@extends('layouts.template')

@section('page-title')
Apply Loan
@stop

@section('page-css')
<link rel="stylesheet" href="{{URL::to('/')}}/global/vendor/bootstrap-sweetalert/sweet-alert.css">
<style>
    .customer-short-profile {
        background: #62a8ea4a;
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
</style>
@stop

@section('content')

<div class="page-content padding-20 container-fluid">
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
            <div class="panel-heading" style="float:left;">
                <h3 class="panel-title">Apply Loan</h3>
            </div>
            <div style="clear:both;"></div>
            <div class="panel-body" style="padding-top: 0">
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
                                            <input type="number" class="form-control round" id="accountNo" name="accountNo" placeholder="Account No...">
                                            <span class="input-group-btn">
                                            <a href="javascript:void(0)" class="btn btn-primary" onclick="getCustomerloan(this)"><i class="icon wb-search" aria-hidden="true"></i></a>
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
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="validateButton2">Apply Loan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <button style="visibility: hidden" id="failed-trigger" class="btn btn-outline btn-default" data-plugin="bootbox" data-title="Warning"
                  data-message="You are not eligible for loan" data-classname="modal-fall"
                  type="button">Fall</button>
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
                            <p><strong>Father Name: <span id="profile_father_name"></span></strong></p>
                        </div>
                    </div>
                    <div class="customer-short-profile-else text-center">
                        no data found
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('page-js')
<script>
    function getCustomerloan(ele) {
        var account_id = $(ele).parent().siblings().val();
        
        $.ajax({
            url: '{{ url('/getCustomerLoan') }}',
            type: 'GET',
            data: 'account_id=' + account_id,
            dataType: 'json',
            beforeSend: function() {
                $(".profile-loading").show();
            },
            success: function(data) {
                
                if(data.status === 'not-permit') {
                    // alert('not eligble');
                    $("#failed-trigger").trigger('click');
                } else {
                    if(data != null) {
                    $(".customer-short-profile-else").fadeOut();
                    $(".customer-short-profile").fadeIn();
                    $("#profile_img").attr('src', '{{ url("/uploads") }}/' + data.customerpic);
                    $("#profile_name").text(data.fullname);
                    $("#profile_account_no").text(data.accountNo);
                    $("#profile_father_name").text(data.fathername);
                    $("#accountNo").val(account_id);
                    $(".dps-apply-field").show();
                    console.log(data.customerpic);
                    } else {
                        $(".dps-apply-field").hide();
                        $(".customer-short-profile").fadeOut(50);
                        $(".customer-short-profile-else").fadeIn(400);
                    }
                }
            },
            complete: function() {
                $(".profile-loading").hide();
            }
        });
    }

</script>
@stop

@section('page-js')

<script src="{{URL::to('/')}}/global/vendor/bootstrap-sweetalert/sweet-alert.js"></script>

@stop