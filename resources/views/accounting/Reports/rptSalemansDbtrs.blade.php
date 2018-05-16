<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Salemans Debtors</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">


<style>
    #header{
        letter-spacing: 5px !important;
    }
</style>
</head>

<body>

<div id="page-wrap">

    <div id="header">MONTHLY NEW PLACEMENTS PER SALEMAN</div>


    <div style="clear:both"></div>



    <table id="items">

        <tr>
            <th>Debtor Name</th>
            <th>Date PL</th>
            <th>Creditor</th>
            <th>Amount Pl</th>
            <th>Amount Pd</th>
            <th>Balance Due</th>
            <th>Status</th>
            <th>ColID</th>
        </tr>

        @foreach($results as $ss)
            <tr class="item-row">
                <td class="item-name"><div class="delete-wpr">{{$ss->DebtorName}}</div></td>
                <td >{{$ss->DateEntered}}</td>
                <td>{{$ss->CreditorID}}</td>
                <td>{{round($ss->AmountPlaced,2)}}</td>
                <td>{{round(floatval($ss->SumOfAmountPaid)+floatval($ss->SumOfNetClient),2)}}</td>
                <td>{{round(floatval($ss->AmountPlaced)-floatval($ss->SumOfAmountPaid)-floatval($ss->SumOfNetClient),2)}}</td>
                <td>{{$ss->StatusID}}</td>
                <td>{{$ss->ColID}}</td>
            </tr>
        @endforeach



    </table>



</div>

</body>

</html>