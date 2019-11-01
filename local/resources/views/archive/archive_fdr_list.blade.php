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
                <h3 class="panel-title">FDR Archive</h3>
            </div>
            <div class="bs-example" data-example-id="single-button-dropdown" style="float:right;padding: 14px 29px 0 0;">
                <div class="btn-group">
                    <form class="form-inline ng-pristine ng-valid" action="{{URL::to('/fdr-archive')}}" method="get">
                        <div class="form-group">
                            <label for="search">Search For Account: </label>
                            <input type="text" name="search" class="form-control" id="search" placeholder="{{ trans('app.search_for_action')}}"
                                value="{{Request::get('search')}}">

                            <button type="submit" class="btn btn-outline btn-primary"><i class="icon fa-search"
                                    aria-hidden="true"></i></button>

                            @if (Request::get('search') != '')
                            <a href="{{URL::to('/fdr-archive')}}" class="btn btn-outline btn-danger" type="button">
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
                        @if(!empty(!$fdr_archive->isEmpty()))
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
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fdr_archive as $customer)
                                    <tr class="{{ ($customer->fdrstatus == 'success') ? '' : 'danger' }}">
                                        <td><a href="javascript:void(0)">#{{ $customer->accountNo }}</a></td>
                                        <td>{{ $customer->fullname }}</td>
                                        <td>{{ $customer->tranxid }}</td>
                                        <td>
                                            <span class="text-muted"><i class="wb wb-calendar"></i> {{ $customer->created_at }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted"><i class="wb wb-calendar"></i> {{ $customer->serviceenddate }}</span>
                                        </td>
                                        <td>{{ number_format($customer->fdramount, 0, '.', ',') }} BDT</td>
                                        <td>{{ number_format($customer->totalamount, 0, '.', ',') }} BDT</td>
                                        <td>{{ number_format($customer->dueamount, 0, '.', ',') }} BDT</td>
                                        <td>{{ str_replace('-', ' / ', $customer->fdrterms) }}</td>
                                        <td>
                                            <div class="label label-table label-{{ ($customer->fdrstatus == 'success') ? 'success' : 'danger' }}">{{
                                                ($customer->fdrstatus == 'success') ? 'Success' : 'Loan Fail' }}</div>
                                        </td>
                                        {{-- <td>{{ $customer->presentaddress }}</td> --}}
                                        {{-- <td class="text-center"><a style="text-decoration: none;" href="{{ url('/customer-detail', $customer->id) }}">
                                                <i class="icon fa-eye" aria-hidden="true"></i> view</a></td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="clear:both;"></div><br/>
                            {{-- {{ $customer_list->render() }} --}}
                            {{ $fdr_archive->appends(Request::only('search'))->links() }}
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