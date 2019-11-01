@extends('layouts.template')
@section('content')
<style>
    table th {
        font-size: 12px;
    }
    table td {
        font-size: 10px;
    }
@page{
    margin-top: 0px;
    margin-bottom: 0px;
    size: auto;   /* auto is the initial value */
}
</style>
<div id="page-wrapper">
<br/>
    <div style="text-align:center;margin-bottom:20px">
        <h3 style="margin-bottom:0">{{ $setting['app_title'] }}</h3>
        <span>{{ $setting['address'] }}</span>
        <h4 style="margin:0;margin-top:0">Daily Collection Report</h4>
        <h5 style="text-decoration: underline;color: #484398;margin: 4px;">{{ $setting['date'] }}</h5>
        <p style="text-align:center;background: yellow;font-weight: 700;padding: 2px;margin-top: 8px;color: #249e28;width: 30%;margin: 0 auto;">Area: {{ $setting['field']->fieldname }}</p>
    </div>
    <div style="width: 99%;margin: 0 auto;">
    <table class="table" id="testTable" style="width:100%">
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
      <tbody>
          @php
              $total_collection_today = 0;
          @endphp
      @foreach($daily_collection_report as $view)
        <tr>
            <td>#{{$view->loanaccount}}</td>
            <td>#{{$view->loanno}}</td>
            <td>{{$view->fullname}}</td>
            <td>{{$view->currentterms .' / '.$view->loantargetdays}}</td>
            <td>{{$view->receivedate}}</td>
            <td>{{$view->dailyamount}} BDT</td>
        </tr>
        @php
            $total_collection_today += $view->dailyamount;
        @endphp
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
    </table>
</div>
<div style="clear:both;"></div>
<!-- /.row (nested) -->
<!-- /.col-lg-12 -->
<!-- /.row -->
</div>
<!-- /#page-wrapper -->
<script>
    window.print();
</script>
@stop



