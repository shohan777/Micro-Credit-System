@extends('layouts.template')

@section('page-title')
Loan Account
@stop

@section('page-css')
<style>
.sm-font tr td {
    font-size: .9em;
}
</style>
@endsection

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
                <h3 class="panel-title">Loan Account</h3>
            </div>
            <div class="bs-example" data-example-id="single-button-dropdown" style="float:right;padding: 14px 29px 0 0;">
                <div class="btn-group">
                    <form class="form-inline ng-pristine ng-valid" action="{{URL::to('loan-accounts')}}" method="get">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" id="search" placeholder="{{ trans('app.search_for_action')}}"
                                value="{{Request::get('search')}}">

                            <button type="submit" class="btn btn-outline btn-success"><i class="icon fa-search"
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
                            <table class="table sm-font">
                                <thead>
                                    <tr>
                                        <th>Loan Acc</th>
                                        <th>Name</th>
                                        <th>Loan No</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                        <th>Terms</th>
                                        <th>Instalment</th>
                                        <th>End</th>
                                        <th>Permission</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($loan_accounts)
                                    @foreach($loan_accounts as $customer)
                                    @php
                                        if($customer->loanstatus == 'active') {
                                            $status = ucfirst($customer->loanstatus);
                                            $status_format = "<span style='color:#d6c700;font-weight:700'>{$status}</span>";
                                        } elseif ($customer->loanstatus == 'success') {
                                            $status = ucfirst($customer->loanstatus);
                                            $status_format = "<span style='color:#36ab7a;font-weight:700'>{$status}</span>";
                                        } else {
                                            $status = ucfirst($customer->loanstatus);
                                            $status_format = "<span style='color:#f96868;font-weight:700'>{$status}</span>";
                                        }
                                        $terms = explode('-', $customer->loanterms);
                                    @endphp
                                    <tr>
                                        <td><a href="javascript:void(0)">#{{ $customer->loanaccount }}</a></td>
                                        <td>{{ $customer->fullname }}</td>
                                        <td style="color:#ec9940;font-weight:700;">#{{ $customer->loanno }}</td>
                                        <td class="money-digit text-right">{{ number_format($customer->loanamount, 0, '.', ',') }} BDT</td>
                                        <td class="money-digit text-right">{{ number_format($customer->loantotal, 2, '.', ',') }} BDT</td>
                                        <td class="text-center">{{ $terms[0].' / '.$terms[1] }} <span style="font-size:12px">days</span></td>
                                        <td class="money-digit">{{ $customer->dailyamount }} BDT</td>
                                        <td>
                                            <span class="text-muted"><i class="wb wb-calendar"></i> {{ date('M d, Y',
                                                strtotime($customer->loanending)) }}</span>
                                        </td>
                                        <td class="text-center">{{ ucfirst($customer->loanpermission) }}</td>
                                        <td class="text-center">{!! $status_format !!}</td>
                                        <td class="text-center"><a style="text-decoration: none;" href="{{ url('/loan-account-detail', $customer->id) }}">
                                                <i class="icon fa-eye" aria-hidden="true"></i> view</a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div style="clear:both;"></div><br/>

                            <!--{{ $loan_accounts->render() }}-->
                            {{ $loan_accounts->appends(Request::only('search'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop