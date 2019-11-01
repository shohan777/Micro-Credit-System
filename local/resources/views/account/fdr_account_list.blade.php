@extends('layouts.template')

@section('page-title')
Fdr Account
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
                <h3 class="panel-title">FDR Account</h3>
            </div>
            <div class="bs-example" data-example-id="single-button-dropdown" style="float:right;padding: 14px 29px 0 0;">
                <div class="btn-group">
                    <form class="form-inline ng-pristine ng-valid" action="{{URL::to('fdr-account')}}" method="get">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" id="search" placeholder="{{ trans('app.search_for_action')}}"
                                value="{{Request::get('search')}}">

                            <button type="submit" class="btn btn-outline btn-default"><i class="icon fa-search"
                                    aria-hidden="true"></i></button>

                            @if (Request::get('search') != '')
                            <a href="{{URL::to('fdr-account')}}" class="btn btn-outline btn-danger" type="button">
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
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Account Number</th>
                                        <th>Name</th>
                                        <th>FDR No</th>
                                        <th>FDR Amount</th>
                                        <th>FDR Terms</th>
                                        <th>Monthly Profit</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($fdr_accounts)
                                    @foreach($fdr_accounts as $customer)
                                    <tr>
                                        <td><a href="javascript:void(0)">#{{ $customer->accountNo }}</a></td>
                                        <td>{{ $customer->fullname }}</td>
                                        <td>#{{ $customer->fdrno }}</td>
                                        <td class="money-digit">{{ number_format($customer->fdramount, 0, '.', ',') }} BDT</td>
                                        <td>{{ $customer->fdrterms }}</td>
                                        <td class="money-digit">{{ $customer->monthlyamount }} BDT</td>
                                        <td>
                                            <span class="text-muted"><i class="wb wb-time"></i> {{ date('M d, Y',
                                                strtotime($customer->serviceenddate)) }}</span>
                                        </td>
                                        <td>{{ ucfirst($customer->fdrstatus) }}</td>
                                        {{-- <td>
                                            <div class="label label-table label-{{ ($customer->status == 1) ? 'success' : 'danger' }}">{{
                                                ($customer->status == 1) ? 'Active' : 'Inactive' }}</div>
                                        </td> --}}
                                        <td class="text-center"><a style="text-decoration: none;" href="{{ url('/fdr-account-ledger/detail', $customer->id) }}">
                                                <i class="icon fa-eye" aria-hidden="true"></i> view</a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div style="clear:both;"></div><br/>

                            <!--{{ $fdr_accounts->render() }}-->
                            {{ $fdr_accounts->appends(Request::only('search'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop