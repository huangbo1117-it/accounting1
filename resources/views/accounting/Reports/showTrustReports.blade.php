<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

   <title>All Trust Activity</title>

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

   <div id="header">All Trust Activity</div>


   <div style="clear:both"></div>



   <table id="items">

      <tr>
         <th>Dt Rec</th>
         <th>Check#</th>
         <th>Debtor Name</th>
         <th>Cred ID</th>
         <th>Gross Col.</th>
         <th>Net Fees</th>
         <th>Rel Date</th>
      </tr>
       @php ($i =0)
      @foreach($results as $ss)
         <tr class="item-row">
             @php ($i += $ss->NetClient)
            <td class="item-name"><div class="delete-wpr">{{date('d-m-Y', strtotime($ss->DateRcvd))}}</div></td>
            <td >{{$ss->CheckNumb}}</td>
            <td>{{$ss->DebtorName}}</td>
            <td>{{$ss->CreditorID}}</td>
            <td>${{$ss->NetClient}}</td>
            <td>${{$ss->AgencyNet}}</td>
            <td>{{date('d-m-Y', strtotime($ss->RelDate))}}</td>
         </tr>
      @endforeach
<tfoot>
<!--<tr class="item-row">

    <td ></td>
    <td ></td>
    <td ></td>
    <td ></td>
    <td> </td>
    <td>${{$i}}</td>
    <td ></td>
</tr>-->
</tfoot>


   </table>



</div>

</body>

</html>


<!--
SELECT tblDebtors.DebtorName, tblCreditor.CreditorID, tblTrust.PaymentReceived,
tblCreditor.SalesID,
((CASE PaymentReceived WHEN null THEN 0 ELSE PaymentReceived END )-
(CASE MiscFees WHEN null THEN 0 ELSE MiscFees END )+
(CASE CostRef WHEN null THEN 0 ELSE CostRef END )-
(CASE agencygross WHEN null THEN 0 ELSE agencygross END )+
(CASE attyfees WHEN null THEN 0 ELSE attyfees END )) AS NetClient,
tblDebtors.ClientAcntNumber, tblTrust.ColID, tblTrust.DebtorID,
tblTrust.TPaymentID, tblTrust.TPaymentType, tblTrust.DateRcvd, tblTrust.CheckNumb, tblTrust.RelDate, tblTrust.ColID,
ClastName , CFirstName ,

((CASE AgencyGross WHEN null THEN 0 ELSE AgencyGross END )-
(CASE AttyFees WHEN null THEN 0 ELSE AttyFees END )+
(CASE Intrest WHEN null THEN 0 ELSE Intrest END )+
(CASE MiscFees WHEN null THEN 0 ELSE MiscFees END )) AS AgencyNet,

Month(DateRcvd) AS MonthOfPmnt,
Year(DateRcvd) AS ThisYear,
((CASE PaymentReceived WHEN null THEN 0 ELSE PaymentReceived END )-
(CASE AttyFees WHEN null THEN 0 ELSE AttyFees END )) AS GrossClient
FROM tblCreditor LEFT JOIN ((tblTrust RIGHT JOIN tblDebtors ON tblTrust.DebtorID=tblDebtors.DebtorID)
LEFT JOIN tblCollectors ON tblTrust.ColID=tblCollectors.ColID) ON tblCreditor.CreditorID=tblDebtors.CreditorID
WHERE (tblCreditor.CreditorID=Forms!frmTrustReports!Creditor_Combo Or Forms!frmTrustReports!Creditor_Combo=" Any") And tblTrust.TPaymentType="T" And (tblTrust.DateRcvd)>=Forms!frmTrustReports!start_date And (tblTrust.DateRcvd)<=Forms!frmTrustReports!end_date
ORDER BY tblDebtors.DebtorName, tblTrust.DateRcvd DESC;
-->