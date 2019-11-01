@extends('layouts.template')

@section('page-title')
Add holiday
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
                    <li class="active" role="presentation"><a data-toggle="tab" href="#holidaylist" aria-controls="activities"
                            role="tab" aria-expanded="true"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            Holidays</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" href="#holidayAdd" aria-controls="profile"
                            role="tab" aria-expanded="false"> <i class="fa fa-lock"></i> Add Holiday</a></li>
                </ul>
            </div>
            <div style="clear:both;"></div><br>
            <div class="tab-content">
                <!-------------- Holiday List ----------------->
                <div id="holidaylist" class="tab-pane fade in active">
                <!-- Example Responsive -->
                <div class="example-wrap">
                        <div class="example">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Holiday Name</th>
                                            <th>Holiday Type</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Day Count</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($holidays)
                                        @foreach($holidays as $holiday)
                                        @php
                                            $enddate = "+$holiday->total day";
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $holiday->holidayname }}</td>
                                            <td>{{ $holiday->holidaytype }}</td>
                                            <td>
                                                <span class="text-muted"><i class="wb wb-time"></i> {{ date('M d, Y',
                                                    strtotime($holiday->holidaystartdate)) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted"><i class="wb wb-time"></i> {{ date('M d, Y',
                                                    strtotime($enddate, strtotime($holiday->holidaystartdate))) }}</span>
                                            </td>
                                            <td>{{ $holiday->total }} {{ ($holiday->total > 1) ? 'days' : 'day' }}</td>
                                            <td>
                                                <div class="label label-table label-{{ ($holiday->holidaystatus == 1) ? 'success' : 'danger' }}">{{
                                                    ($holiday->holidaystatus == 1) ? 'Active' : 'Inactive' }}</div>
                                            </td>
                                            <td>{{ $holiday->holidayremarks }}</td>
                                            {{-- <td class="text-center"><a style="text-decoration: none;" href="{{ url('/holiday-detail', $holiday->id) }}">
                                                    <i class="icon fa-eye" aria-hidden="true"></i> view</a></td> --}}
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div style="clear:both;"></div><br/>
    
                                {{-- {{ $customer_list->render() }} --}}
                                {{ $holidays->appends(Request::only('search'))->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!--------- Add Holiday ---------->
                <div id="holidayAdd" class="tab-pane fade">
                    <div class="col-md-12">
                        <!-- Example Basic Form -->
                        <div class="example-wrap">
                            <div class="example">
                                <form action="{{ url('/holiday') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="control-label" for="holidayname">Holiday Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="holidayname" name="holidayname"
                                                placeholder="Holiday Name" autocomplete="off" required />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="control-label" for="holidaytype">Holiday Type</label>
                                            <select class="form-control" id="holidaytype" name="holidaytype">
                                                <option value="public">Public</option>
                                                <option value="custom">Custom</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="control-label" for="holidaystartdate">Start Date <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="holidaystartdate" name="holidaystartdate"
                                                placeholder="Start Date"  autocomplete="off" data-provide="datepicker" data-fv-field="date"/>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="control-label" for="holidayenddate">End Date</label>
                                            <input type="text" class="form-control" id="holidayenddate" name="holidayenddate"
                                                placeholder="End Date"  autocomplete="off" data-provide="datepicker" data-fv-field="date" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Remarks</label>
                                        <textarea class="form-control" name="holidayremarks" placeholder="Briefly Describe About Holiday"></textarea>
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