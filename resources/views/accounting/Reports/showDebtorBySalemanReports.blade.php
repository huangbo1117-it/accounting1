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

    <textarea id="header">Debtors By Collector</textarea>


    <div style="clear:both"></div>



    <table id="items">

        <tr>
            <th>Creditor ID</th>
            <th>Debtor ID</th>
            <th>Debtor Name</th>
            <th>Amount Placed</th>
            <th>Status ID</th>
            <th>Date Entered</th>
        </tr>

        @foreach($results as $ss)

                <tr class="item-row">
                    <td >{{$ss->CreditorID}}</td>
                    <td >{{$ss->DebtorID}}</td>
                    <td >{{$ss->DebtorName}}</td>
                    <td>${{$ss->AmountPlaced}}</td>
                    <td>{{$ss->StatusID}}</td>
                    <td>{{$ss->DateEntered}}</td>
                </tr>

        @endforeach



    </table>



</div>

</body>

</html>


