@extends('layouts.template')
@section('page-title')
Daily Collection Report
@stop
@section('content')
@section('content')
<link rel="stylesheet" href="{{URL::to('/')}}/global/vendor/filament-tablesaw/tablesaw.css">
<div class="page-header">
    <h1 class="page-title font_lato">{{ trans('Daily Collection Report')}}</h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/dashboard')}}">{{ trans('app.home')}}</a></li>
            <li class="active">{{ trans('app.users')}}</li>
        </ol>
    </div>
</div>
<div class="page-content">
    <div class="panel">
        <div class="panel-body container-fluid">
            <!------------------------start insert, update, delete message ---------------->
            <div class="row">
                @if(session('msg_success'))
                <div class="alert dark alert-icon alert-success alert-dismissible alertDismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <i class="icon wb-check" aria-hidden="true"></i>
                    {{session('msg_success')}}
                </div>
                @endif
                @if(session('msg_update'))
                <div class="alert dark alert-icon alert-info alert-dismissible alertDismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <i class="icon wb-check" aria-hidden="true"></i>
                    {{session('msg_update')}}
                </div>
                @endif
                @if(session('msg_delete'))
                <div class="alert dark alert-icon alert-danger alert-dismissible alertDismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <i class="icon wb-check" aria-hidden="true"></i>
                    {{session('msg_delete')}}
                </div>
                @endif
            </div>
            @if(Auth::user()->hasRole('Admin'))
            <div class="bs-example" style="float:left;">
                <h3>{{ ($field_name) ? $field_name['fieldname'] : '' }}</h3>
            </div>
            @endif
            <div class="bs-example" data-example-id="single-button-dropdown" style="float:right;">
                @if(Auth::user()->hasRole('Admin'))
                <div class="btn-group">
                    <form class="form-inline ng-pristine ng-valid" action="{{URL::to('/daily-loan-collection')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="search">Filter By Field: </label>
                            <div class="form-group" style="margin-right: -5px;">
                                <select class="form-control" name="field_id">
                                    <option>Select Field</option>
                                    @if($field_lists)
                                    @foreach($field_lists as $field)
                                    <option value="{{ $field->id }}" {{ ($field_name && $field_name['fieldname'] == $field->fieldname) ? 'selected' : '' }}>{{ $field->fieldname }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <button style="border-color:#cecece" type="submit" class="btn btn-outline btn-default"><i class="icon fa-search"
                                    aria-hidden="true"></i></button>

                            @if (Request::get('from_date') != '')
                            <a href="{{URL::to('/income-report')}}" class="btn btn-outline btn-danger" type="button">
                                <i class="icon fa-remove" aria-hidden="true"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
                @endif
                @if(!Auth::user()->hasRole('Admin'))
                <div class="btn-group">
                    <a href="{{URL::to('daily-loan-collection-print')}}" class="btn btn-outline btn-default" target="_blank" data-toggle="tooltip"
                        data-placement="top" data-original-title="{{ trans('app.print')}}"> <i class="icon fa-print"
                            aria-hidden="true"></i> {{ trans('app.print')}}</a>
                </div>
                <div class="btn-group">
                    <a href="{{URL::to('daily-loan-collection-pdf')}}" class="btn btn-outline btn-default" data-toggle="tooltip"
                        data-placement="top" data-original-title="{{ trans('app.pdf')}}"><i class="fa fa-file-pdf-o"
                            aria-hidden="true"></i> {{ trans('app.pdf')}}</a>
                </div>
                @endif
            </div>
            <div style="clear:both;"></div><br />

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>{{ trans('Loan Acc')}}</th>
                        <th>{{ trans('Loan No')}}</th>
                        <th>{{ trans('Customer Name')}}</th>
                        <th>{{ trans('Terms')}}</th>
                        <th>{{ trans('Receive Date')}}</th>
                        <th>{{ trans('Daily Collection')}}</th>
                    </tr>
                </thead>
                @if($daily_collection_report)
                <tbody>
                    
                    @php $total_collection_today = 0; @endphp
                    @foreach($daily_collection_report as $view)
                    <tr>
                        <td class="tablesaw-priority-4">#{{$view->loanaccount}}</td>
                        <td class="tablesaw-priority-4">#{{$view->loanno}}</td>
                        <td class="tablesaw-priority-5 tablesaw-cell-visible">{{$view->fullname}}</td>
                        <td class="tablesaw-priority-4">{{$view->currentterms .' / '.$view->loantargetdays}}</td>
                        <td class="tablesaw-priority-4">{{$view->receivedate}}</td>
                        <td class="tablesaw-priority-4">{{$view->dailyamount}} BDT</td>
                    </tr>
                    @php $total_collection_today +=  $view->dailyamount @endphp
                    @endforeach
                    
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th>Total</th>
                        <th>={{ number_format($total_collection_today, 0, '.', ',') }} BDT</th>
                    </tr>
                </tfoot>
                @endif
            </table>
            <div style="clear:both;"></div><br />

            {{--
            <!--{{ $userdata->render() }}-->
            {{ $userdata->appends(Request::only('search'))->links() }} --}}
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div><br />
@stop