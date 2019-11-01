@extends('layouts.template')

@section('page-title')
Loan Archive
@stop

@section('page-css')
<link rel="stylesheet" href="{{URL::to('/')}}/global/vendor/filament-tablesaw/tablesaw.css">
<style>
.danger .text-muted {
    color: #ffd24d;
    font-weight: 700;
}
.danger .label-danger {
    background-color: #ff070a;
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
                <h3 class="panel-title">Loan Archive</h3>
            </div>
            <div class="bs-example" data-example-id="single-button-dropdown" style="float:right;padding: 14px 29px 0 0;">
                <div class="btn-group">
                    <form class="form-inline ng-pristine ng-valid" action="{{URL::to('/loan-archive')}}" method="get">
                        <div class="form-group">
                            <label for="search">Search For Account: </label>
                            <input type="text" name="search" class="form-control" id="search" placeholder="{{ trans('app.search_for_action')}}"
                                value="{{Request::get('search')}}">

                            <button type="submit" class="btn btn-outline btn-primary"><i class="icon fa-search"
                                    aria-hidden="true"></i></button>

                            @if (Request::get('search') != '')
                            <a href="{{URL::to('/loan-archive')}}" class="btn btn-outline btn-danger" type="button">
                                <i class="icon fa-remove" aria-hidden="true"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div style="clear:both;"></div>
            <div class="panel-body" style="padding-top: 0">
                <!-- Example Responsive -->
                <div class="example-wrap">
                    <div class="example">
                        @if($searth_hit == true)
                        @if(!empty(!$loan_archive->isEmpty()))
                        <div class="table-responsive">
                            <table class="table tablesaw table-striped table-bordered" data-tablesaw-mode="swipe"
                            data-tablesaw-mode-switch data-tablesaw-minimap data-tablesaw-mode-exclude="columntoggle">
                                <thead>
                                    <tr>
                                        <th>Account Number</th>
                                        <th>Customer Name</th>
                                        <th>Tranx ID</th>
                                        <th>Loan Date</th>
                                        <th>End Date</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                        <th>Due</th>
                                        <th>Terms</th>
                                        <th>Fail Count</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan_archive as $customer)
                                    <tr class="{{ ($customer->loanstatus == 'success' || $customer->loanpermission == 're-permit' || $customer->loanpermission == 're-collected') ? '' : 'danger' }}">
                                        <td><a href="javascript:void(0)">#{{ $customer->accountNo }}</a></td>
                                        <td>{{ $customer->fullname }}</td>
                                        <td>{{ $customer->loanapplytranxid }}</td>
                                        <td>
                                            <span class="text-muted"><i class="wb wb-calendar"></i> {{ $customer->loandate }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted"><i class="wb wb-calendar"></i> {{ $customer->loanending }}</span>
                                        </td>
                                        <td>{{ number_format($customer->loanamount, 0, '.', ',') }} BDT</td>
                                        <td>{{ number_format($customer->loantotal, 0, '.', ',') }} BDT</td>
                                        <td>{{ number_format($customer->loandue, 0, '.', ',') }} BDT</td>
                                        <td>{{ str_replace('-', ' / ', $customer->loanterms) }}</td>
                                        <td>{{ $customer->loanfailcount }}</td>
                                        {{-- <td>{{ $customer->loanstatus }}</td>( --}}
                                        <td>
                                            <div class="label label-table label-{{ ($customer->loanstatus == 'success') ? 'success' : 'danger' }}">{{
                                                ($customer->loanstatus == 'success') ? 'Success' : 'Loan Fail' }}</div>
                                        </td>
                                        <td class="text-center">
                                            @if($customer->loanstatus != 'success' && $customer->loanpermission == 'suspend')
                                            <form action="{{ url('repermit-loan') }}" method="POST"> 
                                                {{ csrf_field() }}
                                                <input type="hidden" name="loanapplytranxid" value="{{ $customer->loanapplytranxid }}">
                                                <input type="submit" class="btn btn-warning btn-xs" value="Re Permission">
                                            </form>
                                            <button class="btn btn-warning btn-xs" data-accountno="{{ $customer->accountNo }}" data-loanno="{{ $customer->loanno }}" data-trxnno="{{ $customer->loanapplytranxid }}" data-toggle="modal" data-target="#customCollection" onclick="customCollectionModel(this)">Custom Collect</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Modal -->
                            <div class="modal fade" id="customCollection" role="dialog">
                                <div class="modal-dialog">
                                
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Modal Header</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('/custom-collection') }}" method="POST" autocomplete="off" id="exampleStandardFormtt">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="loanno" name="loanno">
                                            <input type="hidden" id="loanapplytranxid" name="loantranxid">
                                            <input type="hidden" id="accountNo" name="accountNo">
                                            <div class="row">
                                                <div class="form-group col-sm-12">
                                                    <label class="control-label" for="initialInvest">Account No</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="accountNo"
                                                            placeholder="Account No..." readonly>
                                                        <span class="input-group-btn">
                                                            <a href="javascript:void(0)" class="btn btn-primary""><i
                                                                    class="icon wb-search" style="vertical-align: initial;" aria-hidden="true"></i></a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label class="control-label" for="dailyamount">Amount</label>
                                                    <div class="input-group input-group-icon">
                                                        <input class="form-control" type="number" id="dailyamount" name="dailyamount"
                                                        placeholder="Daily Amount" autocomplete="off" required/>
                                                        <span class="input-group-addon">৳</span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="control-label" for="receivedate">Deposite Date</label>
                                                    <div class="input-group input-group-icon">
                                                        <input type="text" class="form-control datepicker" id="receivedate" name="receivedate" autocomplete="off" required>
                                                        <span class="input-group-addon">
                                                            <span class="icon fa fa-calendar" aria-hidden="true"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" id="validateButton2tt">Collected</button>
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
                            {{ $loan_archive->appends(Request::only('search'))->links() }}
                        </div>
                        @else
                        <p class="text-center" style="font-weight:700;color:red">No Archive Found</p>
                        @endif
                        @else
                        <p class="text-center" style="font-weight:700;color:#57c7d4">Please Search For Result...</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('page-js')
<script>
    function customCollectionModel(ele) {
        var getTranxno = $(ele).attr('data-trxnno');
        var getAccountno = $(ele).attr('data-accountno');
        var getloanno = $(ele).attr('data-loanno');
        console.log(getTranxno);
        $("#customCollection .modal-title").text(getTranxno);
        $("#customCollection #accountNo").val(getAccountno);
        $("#customCollection #loanno").val(getloanno);
        $("#customCollection #loanapplytranxid").val(getTranxno);
    }

    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });
</script>
@stop