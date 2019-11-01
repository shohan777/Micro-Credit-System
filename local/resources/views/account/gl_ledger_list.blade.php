@extends('layouts.template')

@section('page-title')
General Ledger
@stop

@section('page-css')
<style>
.table {
    text-align: center;
}
.table>thead>tr>th {
    text-align: center;
    font-weight: 700
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
                <h3 class="panel-title">General Ledger</h3>
            </div>
            <div style="clear:both;"></div>
            <div class="panel-body" style="padding-top: 0">
                <!-- Example Responsive -->
                <div class="example-wrap">
                    <div class="example">
                        <div class="table-responsive">
                            @if(!$gl_heads->isEmpty())
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="col-sm-2">Sl</th>
                                        <th>GL Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($gl_heads as $head)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td style="color:#4CAF50;font-weight:700">{{ $head->headname }}</td>
                                        <td class="text-center"><a style="text-decoration: none;" href="{{ url('/gl-ledger/detail', $head->id) }}"><i class="icon fa-eye" aria-hidden="true"></i> View</a></td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            @else
                            <p>No Data Found</p>
                            @endif
                            <div style="clear:both;"></div><br/>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop