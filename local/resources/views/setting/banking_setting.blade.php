@extends('layouts.template')

@section('page-title')
Settings
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
                    <li class="active" role="presentation"><a data-toggle="tab" href="#loansetting" aria-controls="loansetting"
                            role="tab" aria-expanded="true"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            Loan Setting</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" href="#fdrsetting" aria-controls="fdrsetting"
                            role="tab" aria-expanded="false"> <i class="fa fa-lock"></i> {{
                            trans('FDR Setting')}}</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" href="#dpssetting" aria-controls="dpssetting" role="tab"
                            aria-expanded="false"><i class="glyphicon glyphicon-plus"></i> {{
                            trans('DPS Setting')}}</a></li>
                </ul>
            </div>
            <div style="clear:both;"></div><br>
            <div class="tab-content">
                <!-------------- Loan setting ----------------->
                <div id="loansetting" class="tab-pane fade in active">
                    @if($get_setting_from_db)
                    @foreach($get_setting_from_db as $setting)
                    @if($loop->index == 2)
                    <form action="{{URL::to('/banking-setting')}}" method="POST" novalidate="">
                        <input type="hidden" name="settingfor" value="LOAN">
                        {{ csrf_field() }}
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="interestrate"> Interest Rate </label>
                                    <div class="input-group input-group-icon">
                                        <input type="text" value="{{ $setting->interestrate }}" name="interestrate" id="interestrate"
                                            class="form-control" required>
                                        <span class="input-group-addon">
                                            <span>%</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="yearfigure"> Year Figure </label>
                                    <div class="">
                                        <input type="text" value="{{ $setting->yearfigure }}" name="yearfigure" id="yearfigure"
                                            class="form-control" required>
                                        <span class="help-block">Please type year figure with comma separate and
                                            without space</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="latedateno"> Late Date No </label>
                                    <div class="input-group input-group-icon">
                                        <input type="text" value="{{ $setting->latedateno }}" name="latedateno" id="latedateno"
                                            class="form-control" required>
                                        <span class="input-group-addon">
                                            <span>Days</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="latefees"> Late Fee </label>
                                    <div class="input-group input-group-icon">
                                        <input type="text" value="{{ $setting->latefees }}" name="latefees" id="latefees"
                                            class="form-control" required>
                                        <span class="input-group-addon">
                                            <span>BDT</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-example">
                                <button ng-disabled="userForm.$invalid" class="btn btn-primary ladda-button"
                                    data-plugin="ladda" data-style="expand-left">
                                    <span aria-hidden="true" class="glyphicon glyphicon-refresh"></span> {{
                                    trans('app.update_settings')}}
                                    <span class="ladda-spinner"></span>
                                    <div class="ladda-progress" style="width: 0px;"></div>
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                    @endforeach
                    @endif
                </div>

                <!--------- FDR Setting ---------->
                <div id="fdrsetting" class="tab-pane fade">
                    @if($get_setting_from_db)
                    @foreach($get_setting_from_db as $setting)
                    @if($loop->index == 1)
                    <form action="{{URL::to('/banking-setting')}}" method="POST" novalidate="">
                        <input type="hidden" name="settingfor" value="FDR">
                        {{ csrf_field() }}
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="interestrate"> Interest Rate </label>
                                    <div class="input-group input-group-icon">
                                        <input type="text" value="{{ $setting->interestrate }}" name="interestrate" id="interestrate"
                                            class="form-control" required>
                                        <span class="input-group-addon">
                                            <span>%</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="yearfigure"> Year Figure </label>
                                    <div class="">
                                        <input type="text" value="{{ $setting->yearfigure }}" name="yearfigure" id="yearfigure"
                                            class="form-control" required>
                                        <span class="help-block">Please type year figure with comma separate and
                                            without space</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="latedateno"> Late Date No </label>
                                    <div class="input-group input-group-icon">
                                        <input type="text" value="{{ $setting->latedateno }}" name="latedateno" id="latedateno"
                                            class="form-control" required>
                                        <span class="input-group-addon">
                                            <span>Days</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="latefees"> Late Fee </label>
                                    <div class="input-group input-group-icon">
                                        <input type="text" value="{{ $setting->latefees }}" name="latefees" id="latefees"
                                            class="form-control" required>
                                        <span class="input-group-addon">
                                            <span>BDT</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-example">
                                <button ng-disabled="userForm.$invalid" class="btn btn-primary ladda-button"
                                    data-plugin="ladda" data-style="expand-left">
                                    <span aria-hidden="true" class="glyphicon glyphicon-refresh"></span> {{
                                    trans('app.update_settings')}}
                                    <span class="ladda-spinner"></span>
                                    <div class="ladda-progress" style="width: 0px;"></div>
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                    @endforeach
                    @endif
                </div>
                <!----------------------DPS Setting-------------------------->
                <div id="dpssetting" class="tab-pane fade">
                    @if($get_setting_from_db)
                        @foreach($get_setting_from_db as $setting)
                        @if($loop->index == 0)
                        <form action="{{URL::to('/banking-setting')}}" method="POST" novalidate="">
                            <input type="hidden" name="settingfor" value="DPS">
                            {{ csrf_field() }}
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="interestrate"> Interest Rate </label>
                                        <div class="input-group input-group-icon">
                                            <input type="text" value="{{ $setting->interestrate }}" name="interestrate"
                                                id="interestrate" class="form-control" required>
                                            <span class="input-group-addon">
                                                <span>%</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="yearfigure"> Year Figure </label>
                                        <div class="">
                                            <input type="text" value="{{ $setting->yearfigure }}" name="yearfigure" id="yearfigure"
                                                class="form-control" required>
                                            <span class="help-block">Please type year figure with comma separate and
                                                without space</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="latedateno"> Late Date No </label>
                                        <div class="input-group input-group-icon">
                                            <input type="text" value="{{ $setting->latedateno }}" name="latedateno" id="latedateno"
                                                class="form-control" required>
                                            <span class="input-group-addon">
                                                <span>Days</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="latefees"> Late Fee </label>
                                        <div class="input-group input-group-icon">
                                            <input type="text" value="{{ $setting->latefees }}" name="latefees" id="latefees"
                                                class="form-control" required>
                                            <span class="input-group-addon">
                                                <span>BDT</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-example">
                                    <button ng-disabled="userForm.$invalid" class="btn btn-primary ladda-button"
                                        data-plugin="ladda" data-style="expand-left">
                                        <span aria-hidden="true" class="glyphicon glyphicon-refresh"></span> {{
                                        trans('app.update_settings')}}
                                        <span class="ladda-spinner"></span>
                                        <div class="ladda-progress" style="width: 0px;"></div>
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif
                        @endforeach
                        @endif
                </div>
                <!----------------------end DPS Setting--------------------------->
            </div>
            <div style="clear:both;"></div>
        </div>
        <!-- /.row -->
    </div>
</div><br />
@stop