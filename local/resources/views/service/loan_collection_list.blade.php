@extends('layouts.template')

@section('page-title')
Loan Collection
@stop

@section('page-css')
<link rel="stylesheet" href="{{URL::to('/')}}/global/vendor/filament-tablesaw/tablesaw.css">
<style>
table th {
    text-align: center
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
                <h3 class="panel-title">Today Due Collection</h3>
            </div>
            <div class="bs-example" data-example-id="single-button-dropdown" style="float:right; ">
                <div class="btn-group">
                    <a href="{{URL::to('daily-loan-not-collect-pdf', 'print')}}" class="btn btn-outline btn-default" target="_blank" data-toggle="tooltip"
                        data-placement="top" data-original-title="{{ trans('app.print')}}"> <i class="icon fa-print"
                            aria-hidden="true"></i> {{ trans('app.print')}}</a>
                </div>
                <div class="btn-group">
                    <a href="{{URL::to('daily-loan-not-collect-pdf', 'pdf')}}" class="btn btn-outline btn-default" data-toggle="tooltip"
                        data-placement="top" data-original-title="{{ trans('app.pdf')}}"><i class="fa fa-file-pdf-o"
                            aria-hidden="true"></i> {{ trans('app.pdf')}}</a>
                </div>
            </div>
            <div style="clear:both;"></div><br />
            <div style="clear:both;"></div>
            <div class="panel-body" style="padding-top: 0">
                <!-- Example Responsive -->
                <div class="example-wrap">
                    <div class="example">
                        <div class="table-responsive">
                                @if($customer_not_collected)
                            <table style="text-align:center" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Loan Acc</th>
                                        <th>Loan No</th>
                                        <th>Customer Name</th>
                                        <th>Loan Total</th>
                                        <th>Daily Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($customer_not_collected as $customer)
                                    <tr>
                                        <td><a href="javascript:void(0)">#{{ $customer['loanaccount'] }}</a></td>
                                        <td>#{{ $customer['loanno'] }}</td>
                                        <td>{{ $customer['fullname'] }}</td>
                                        <td>{{ number_format($customer['loantotal'], 2, '.', ',') }} /-</a></td>
                                        <td>{{ number_format($customer['dailyamount'], 2, '.', ',') }} /-</td>
                                        <td class="text-center"><a style="text-decoration: none;" href="{{ url('/loan-account-detail', $customer['loan_id']) }}">
                                            <i class="icon fa-eye" aria-hidden="true"></i> view</a></td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            @else
                                <p class="text-center" style="font-weight:700;color:red">No Due Collection has exists today</p>
                            @endif
                            <div style="clear:both;"></div><br/>

                            {{-- {{ $customer_list->render() }}
                            {{ $customer_list->appends(Request::only('search'))->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop