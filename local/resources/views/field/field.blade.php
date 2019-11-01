@extends('layouts.template')

@section('page-title')
Field
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
                            Fields</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" href="#holidayAdd" aria-controls="profile"
                            role="tab" aria-expanded="false"> <i class="fa fa-lock"></i> Add Field</a></li>
                </ul>
            </div>
            <div style="clear:both;"></div><br>
            <div class="tab-content">
                <!-------------- Field List ----------------->
                <div id="holidaylist" class="tab-pane fade in active">
                <!-- Example Responsive -->
                <div class="example-wrap">
                        <div class="example">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1">Sl</th>
                                            <th>Field Name</th>
                                            <th>Field Location</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($fields)
                                        @foreach($fields as $field)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $field->fieldname }}</td>
                                            <td>{{ $field->fieldlocation }}</td>
                                            <td>{{ ($field->fieldstatus == 1) ? 'Active' : 'Inactive' }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div style="clear:both;"></div><br/>
    
                                {{-- {{ $fields->appends(Request::only('search'))->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!--------- Add Field ---------->
                <div id="holidayAdd" class="tab-pane fade">
                    <div class="col-md-12">
                        <!-- Example Basic Form -->
                        <div class="example-wrap">
                            <div class="example">
                                <form action="{{ url('/field') }}" method="POST" autocomplete="off" id="exampleStandardForm">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="control-label" for="fieldname">Field Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="fieldname" name="fieldname"
                                            placeholder="Field Name" autocomplete="off" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="fieldlocation">Field Location</label>
                                        <textarea class="form-control" rows="5" name="fieldlocation" placeholder="Field Location"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="validateButton2">Add Field</button>
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