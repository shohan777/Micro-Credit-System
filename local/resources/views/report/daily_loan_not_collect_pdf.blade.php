<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }

    th,
    td {
        padding: 5px;
    }

    body {
        font-family: 'Montserrat', sans-serif !important;
    }
</style>
<div style="text-align:center;margin-bottom:20px">
    <h2 style="margin-bottom:0">{{ $setting['app_title'] }}</h2>
    <span>{{ $setting['address'] }}</span>
    <h3 style="margin:0;margin-top:0">Daily Loan Collection</h3>
    <h5 style="text-decoration: underline;color: #484398;margin: 4px;">{{ $setting['date'] }}</h5>
    <p style="text-align:center;font-weight: 700;padding: 2px;margin-top: 8px;color: #249e28;width: 30%;margin: 0 auto;">Area:
        {{ $setting['field']->fieldname }}</p>
</div>
@if($customer_not_collected)
<table style="width:100%;text-align:center">
    <thead>
        <tr>
            <th>{{ trans('Loan Acc')}}</th>
            <th>{{ trans('Loan No')}}</th>
            <th>{{ trans('Customer Name')}}</th>
            <th>{{ trans('Loan Total')}}</th>
            <th>{{ trans('Daily Amount')}}</th>
            <th>{{ trans('Received Amount')}}</th>
        </tr>
    </thead>
    <tbody>

        @foreach($customer_not_collected as $customer)
        <tr>
            <td><a href="javascript:void(0)">#{{ $customer['loanaccount'] }}</a></td>
            <td>#{{ $customer['loanno'] }}</td>
            <td>{{ $customer['fullname'] }}</td>
            <td>{{ number_format($customer['loantotal'], 2, '.', ',') }} BDT</a></td>
            <td>{{ number_format($customer['dailyamount'], 2, '.', ',') }} BDT</td>
            <td></td>
        </tr>
        @endforeach

    </tbody>
</table>
@endif

@if($type == 'print') 

<script>
    window.print();
</script>

@endif