@extends('layouts.template')

@section('page-title')
GL Head Balance
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
                <h3 class="panel-title">GL Head Balance</h3>
            </div>
            <div style="clear:both;"></div>
            <div class="panel-body" style="padding-top: 0">
                <!-- Example Responsive -->
                <div class="example-wrap">
                    <div class="example">
                        <div class="table-responsive">
                            @if($balance)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="col-sm-1">Sl</th>
                                        <th>Head Name</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @foreach($balance as $head)
                                    <tr>
                                        <td>{{ $index }}</td>
                                        <td style="color:#4CAF50;font-weight:700">{{ $head['head'] }}</td>
                                        <td style="color:#4CAF50;font-weight:700">{{ $head['debit'] }} /-</td>
                                        <td style="color:#4CAF50;font-weight:700">{{ $head['credit'] }} /-</td>
                                    </tr>
                                    @php
                                        $index++;
                                    @endphp
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