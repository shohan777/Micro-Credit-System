@extends('layouts.template')

@section('page-title')
Income
@stop
@section('content')

@section('content')
<div class="page-header">
    <h1 class="page-title font_lato"> {{ trans('app.general_settings')}} </h1>
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
                <div class="panel" id="customerList">
                    <div class="panel-heading" style="float:left;">
                        <h3 class="panel-title">Expense Transaction</h3>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="panel-body" style="padding:0;">
                        <!-- Example Basic Form -->
                        <div class="example-wrap">
                            <div class="example">
                                <form action="{{ url('expense-trans') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="control-label" for="amount">Amount</label>
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                placeholder="Amount" autocomplete="off" />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="control-label" for="date">Deposite Date</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" class="form-control datepicker" id="date" name="date" autocomplete="off" >
                                                <span class="input-group-addon">
                                                    <span class="icon fa fa-calendar" aria-hidden="true"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="control-label" for="entryby">Entry By</label>
                                            <input type="text" class="form-control" id="entryby" name="entryby"
                                                placeholder="Entry By" autocomplete="off" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label" for="purpose">Purpose</label>
                                            <select class="form-control" id="purpose" name="purpose">
                                                <option value="">Select Purpose</option>
                                                @if($expense_heads)
                                                @foreach($expense_heads as $head)
                                                <option value="{{ $head->id }}">{{ $head->headname }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="remarks" rows="5" placeholder="Briefly Describe This Trunsaction"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="validateButton2">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End Example Basic Form -->
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
            <!-- /.row -->
        </div>
    </div><br />
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
@endsection