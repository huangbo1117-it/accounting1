<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Debtors By Collector</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">



</head>

<body>

<div id="page-wrap">

    <textarea id="header">Invoice Report</textarea>


    <div style="clear:both"></div>



    <table id="items">

        <tr>
            <th>Inv Date</th>
            <th>Paid Date</th>
            <th>Creditor ID</th>
            <th>Debtor ID</th>
            <th>Debtor Name</th>
            <th>Inv #</th>
            <th>Collected</th>
            <th>Net Fee</th>
        </tr>

        @foreach($results as $ss)
            <tr class="item-row">
                <td >{{$ss->InvDate}}</td>
                <td >{{$ss->PaidDate}}</td>
                <td >{{$ss->CreditorID}}</td>
                <td>${{$ss->DebtorID}}</td>
                <td>{{$ss->DebtorName}}</td>
                <td>{{$ss->InvoiceNumb}}</td>
                <td>{{$ss->Collected}}</td>
                <td>{{$ss->DueInv}}</td>
            </tr>
        @endforeach



    </table>



</div>

</body>

</html>


