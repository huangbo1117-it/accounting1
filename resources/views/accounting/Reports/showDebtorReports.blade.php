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
            <th>Collector Name</th>
            <th>Debtor Name</th>
            <th>Debtor ID</th>
            <th>Phone </th>
            <th>Amount Placed</th>
            <th>Balance Due</th>
        </tr>

        @foreach($results as $ss)
            @if($ss->DebtorName !=null || $ss->DebtorName !='')
            <tr class="item-row">
                <td class="item-name"><div class="delete-wpr">{{$ss->CFirstName}} {{$ss->CLastName}}</div></td>
                <td >{{$ss->DebtorName}}</td>
                <td>{{$ss->DebtorID}}</td>
                <td>{{$ss->Phone}}</td>
                <td>${{$ss->AmountPlaced}}</td>
                <td>${{floatval($ss->AmountPlaced)-floatval($ss->SumOfAmountPaid)}}</td>

            </tr>
            @endif
        @endforeach



    </table>



</div>

</body>

</html>



<!--

SELECT qryDebtorsByCollector.StatusID,
qryDebtorsByCollector.DebtorID, qryDebtorsByCollector.DebtorName,
qryDebtorsByCollector.Phone, qryDebtorsByCollector.ColID,
qryDebtorsByCollector.CLastName, qryDebtorsByCollector.CFirstName,
IIf(IsNull([AmountPlaced]),0,[AmountPlaced]) AS Placed,
IIf(IsNull([SumOfAmountPaid]),0,[SumOfAmountPaid])
AS AmountPaid
FROM qryDebtorsByCollector;




SELECT tblDebtors.StatusID, tblDebtors.DebtorID, tblDebtors.DebtorName, tblDebtors.Phone,
tblCollectors.ColID, tblCollectors.CLastName, tblCollectors.CFirstName, tblDebtors.AmountPlaced,
qryTotalPaymentsLetters.SumOfAmountPaid, qryTotalTrustPerDateLetters.SumOfNetClient
FROM ((tblCollectors
RIGHT JOIN tblDebtors ON tblCollectors.[ColID] = tblDebtors.[ColID])
LEFT JOIN qryTotalPaymentsLetters ON tblDebtors.[DebtorID] = qryTotalPaymentsLetters.[DebtorID])
LEFT JOIN qryTotalTrustPerDateLetters ON tblDebtors.[DebtorID] = qryTotalTrustPerDateLetters.[DebtorID]
GROUP BY tblDebtors.StatusID, tblDebtors.DebtorID, tblDebtors.DebtorName,
tblDebtors.Phone, tblCollectors.ColID, tblCollectors.CLastName, tblCollectors.CFirstName,
tblDebtors.AmountPlaced, qryTotalPaymentsLetters.SumOfAmountPaid,
qryTotalTrustPerDateLetters.SumOfNetClient;

-->