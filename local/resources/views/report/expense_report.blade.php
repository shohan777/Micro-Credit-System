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
                <h3 class="panel-title">Expense Report</h3>
            </div>
            <div class="bs-example" data-example-id="single-button-dropdown" style="float:right;padding: 14px 29px 0 0;">
                <div class="btn-group">
                    <form class="form-inline ng-pristine ng-valid" action="{{URL::to('/expense-report')}}" method="get">
                        <div class="form-group">
                            <label for="search">Search For Expense: </label>
                            <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="{{ trans('From Date')}}" value="{{Request::get('from_date')}}">
                            <input type="text" name="to_date" class="form-control datepicker" id="to_search" placeholder="{{ trans('To Date')}}"
                                value="{{Request::get('to_search')}}">
                            <button type="submit" class="btn btn-outline btn-primary"><i class="icon fa-search"
                                    aria-hidden="true"></i></button>

                            @if (Request::get('from_date') != '')
                            <a href="{{URL::to('/expense-report')}}" class="btn btn-outline btn-danger" type="button">
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
                        @if($search_hit == true)
                        @if(!empty(!$expense_data->isEmpty()))
                        <div class="table-responsive">
                            <table class="table tablesaw table-striped table-bordered" data-tablesaw-mode="swipe"
                            data-tablesaw-mode-switch data-tablesaw-minimap data-tablesaw-mode-exclude="columntoggle">
                                <thead>
                                    <tr>
                                        <th>Voucher no</th>
                                        <th>Deposite Amount</th>
                                        <th>Date</th>
                                        <th>Entry By</th>
                                        <th>Purpose</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expense_data as $data)
                                    <tr>
                                        <td><a href="javascript:void(0)">#{{ $data->voucherno }}</a></td>
                                        <td>{{ number_format($data->amount, 0, '.', ',') }} BDT</td>
                                        <td>
                                            <span class="text-muted"><i class="wb wb-calendar"></i> {{ $data->date }}</span>
                                        </td>
                                        <td>{{ $data->entryby }}</td>
                                        <td>{{ $data->purpose }}</td>
                                        <td>{{ $data->remarks }}</td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="clear:both;"></div><br/>
                            {{-- {{ $customer_list->render() }} --}}
                            {{ $expense_data->appends(Request::only('search'))->links() }}
                        </div>
                        @else
                        <p class="text-center" style="font-weight:700;color:red">No Result Found</p>
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

    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });
</script>
@stop