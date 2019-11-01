@extends('layouts.template')

@section('page-title')
Transaction Head
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
                <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                    <li class="active" role="presentation"><a data-toggle="tab" href="#head_list" aria-controls="head_list"
                            role="tab" aria-expanded="true"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            Transaction Head</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" href="#headadd" aria-controls="headadd" role="tab"
                            aria-expanded="false"> <i class="fa fa-lock"></i> Add Head</a></li>
                </ul>
            </div>
            <div style="clear:both;"></div><br>
            <div class="tab-content">
                <!-------------- Holiday List ----------------->
                <div id="head_list" class="tab-pane fade in active">
                    <!-- Example Responsive -->
                    <div class="example-wrap">
                        <div class="example">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">Sl</th>
                                            <th>Head Name</th>
                                            <th>Head Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($transaction_head_lists)
                                        @foreach($transaction_head_lists as $item)
                                        @php
                                        if($item->headtype == 'income') {
                                        $head_color = '#4CAF50';
                                        $head_text = $item->headtype;
                                        } elseif($item->headtype == 'expense') {
                                        $head_color = '#ff5722';
                                        $head_text = $item->headtype;
                                        } else {
                                        $head_color = '#00BCD4';
                                        $head_text = 'general ledger';
                                        }
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->headname }}</td>
                                            <td style="color:{{ $head_color }};font-weight:700">{{
                                                ucfirst($head_text) }}</td>
                                            <td>{{ ucfirst($item->headstatus) }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div style="clear:both;"></div><br />

                                {{-- {{ $customer_list->render() }} --}}
                                {{-- {{ $holidays->appends(Request::only('search'))->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!--------- Add Holiday ---------->
                <div id="headadd" class="tab-pane fade">
                    <div class="col-md-12">
                        <!-- Example Basic Form -->
                        <div class="example-wrap">
                            <div class="example">
                                <form action="{{ url('/transaction-head') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="headstatus" value="active">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="control-label" for="headname">Head Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="headname" name="headname"
                                                placeholder="Head Name" autocomplete="off" required />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="control-label" for="headtype">Head Type</label>
                                            <select class="form-control" id="headtype" name="headtype" onchange="hideGlHead(this)">
                                                <option value="">Select Type</option>
                                                <option value="income">Income</option>
                                                <option value="expense">Expense</option>
                                                <option value="gl">General Ledger</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="assetFor" class="form-group" style="background: #d9c9ff;padding: 20px;border-radius: 3px;">
                                        <label style="color:#016ef1;font-weight:700" class="control-label">Asset For <span style="color:#e91e63" class="required">*</span></label>
                                        <div>
                                            <div class="radio-custom radio-default radio-inline">
                                                <input type="radio" id="assetforCompany" name="assetfor" value="company" />
                                                <label for="assetforCompany">Company</label>
                                            </div>
                                            <div class="radio-custom radio-default radio-inline">
                                                <input type="radio" id="assetforCustomer" name="assetfor" value="customer" />
                                                <label for="assetforCustomer">Customer</label>
                                            </div>
                                        </div>
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

            </div>
            <div style="clear:both;"></div>
        </div>
        <!-- /.row -->
    </div>
</div><br />
@stop

@section('page-js')
<script>
    $("#assetFor").hide();
function hideGlHead(ele) {
    var selected_val = $(ele).find(":selected").val();
    if(selected_val != 'gl') {
        $("#assetFor").hide();
    } else {
        $("#assetFor").show();
    }
}
</script>
@stop