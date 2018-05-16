<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Letter</title>s

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">
    <script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='js/example.js'></script>
    <style >
        .coverLetter .item-row{
            height:25px;;
        }
        #terms{
            width: 50%;
            position: relative;
        }
        #terms h5 {
            width: 100%;
            height: 100px;
            display: inline-block;
        }
        table td, table th{
            border: 0px;;
        }
        #page-wrap {
            width: 700px;
            margin: 6px auto;
        }
        #meta td.meta-head {
            text-align: left;
            background: transparent;
        }
        #address {
            width: 250px;
            height: 94px;
            float: left;
        }
        #meta {
            margin-top: 1px;
            width: 169px;
            float: right;
        }
    </style>
</head>

<body>

<div id="page-wrap">




        <p id="" style=" height: 70px;" readonly>
{{$result->DebtorName}} <br>
{{$result->DAttn}} <br>
{{$result->Street}} <br>
{{$result->Address2}} <br>
{{$result->DebtorPhone}}</p>


        <br> <br>

        <p style="height: 70px;float: right;width: 170px;">
                    Amount Due: {{$result->AmountPlaced-$val}} <br>
                    ACCT #:{{$result->ClientAcntNumber}}</p>

        <br> <br> <br> <br>
            <p >

                Your account is now inexcusably PAST DUE. Creditors Recovery Systems, Inc. will be employed to take further action unless your payment is received before:  {{date('d-m-Y', strtotime($result->FormDate))}}
Your prompt attention to this notice will avoid further proceedings.
            </p>


        <br> <br>
        <p style="height: 70px;float: right;width: 170px;">
                    CREDITOR: {{$result->ClientName}} <br>
                    ADDRESS: {{$result->CreditorStreet}} <br> {{$result->CreditorCity}},{{$result->CreditorState}} , {{$result->CreditorZip}}
                    BY: {{$result->CFullName}} <br> Credit Manager</p>



        <br> <br> <br> <br> <br> <br>
            <p>
                CC:  CREDITORS RECOVERY SYSTEMS, INC.
            </p>



</div>

</body>

</html>

<!--
SELECT tblDebtors.DebtorID, tblDebtors.DebtorName,
Format(tblDebtors.FormDate,"mmm dd"", ""yyyy") AS FormDate,
Trim(tblCollectors.CFirstName) & " " & Trim(tblCollectors.CLastName) AS Collector,
"Attn: " & tblDebtors.Salutation & " " & tblDebtors.DFirstName & " " & Trim(tblDebtors.DLastName) AS DAttn,
tblDebtors.Street, Trim(tblDebtors.City) & ", " & tblDebtors.State & "  " & Trim(tblDebtors.Zip) AS Address2,
tblContacts.ClientName, tblDebtors.AmountPlaced, tblContacts.MainManager, tblContacts.Street AS CreditorStreet,
tblContacts.City AS CreditorCity, tblContacts.State AS CreditorState, tblContacts.Zip AS CreditorZip,
tblDebtors.Phone AS DebtorPhone, tblDebtors.ClientAcntNumber, qryGetContactID.CFullName
FROM (((tblCreditors tblCreditor
INNER JOIN qryGetContactID ON tblCreditor.CreditorID = qryGetContactID.CreditorID)
LEFT JOIN tblContacts ON tblCreditor.CreditorID = tblContacts.CreditorID)
LEFT JOIN (tblCollectors
RIGHT JOIN tblDebtors ON tblCollectors.ColID = tblDebtors.ColID) ON tblCreditor.CreditorID = tblDebtors.CreditorID)
LEFT JOIN tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
GROUP BY tblDebtors.DebtorID, tblDebtors.DebtorName, Format(tblDebtors.FormDate,"mmm dd"", ""yyyy"),
Trim(tblCollectors.CFirstName) & " " & Trim(tblCollectors.CLastName),
"Attn: " & tblDebtors.Salutation & " " & tblDebtors.DFirstName & " " & Trim(tblDebtors.DLastName),
tblDebtors.Street, Trim(tblDebtors.City) & ", " & tblDebtors.State & "  " & Trim(tblDebtors.Zip),
tblContacts.ClientName, tblDebtors.AmountPlaced, tblContacts.MainManager, tblContacts.Street,
tblContacts.City, tblContacts.State, tblContacts.Zip, tblDebtors.Phone, tblDebtors.ClientAcntNumber,
qryGetContactID.CFullName
HAVING (((tblDebtors.DebtorID)=CurrentDebtor()) AND ((tblContacts.MainManager)=True));











SELECT tblInvoice.InvoiceNumb, tblInvoice.InvoiceNumb, tblInvoice.IPaymentID,
tblInvoice.IPaymentType, tblInvoice.InvDate,
tblInvoice.DebtorID, tblInvoice.PaidDate,
tblInvoice.CAmountPaid,
tblInvoice.TotalBillFor, tblInvoice.AttyFees,
tblInvoice.Fee1Type, tblInvoice.Fee1Balance, tblInvoice.Fee1,
tblInvoice.Fee2Type, tblInvoice.Fee2Balance, tblInvoice.Fee2, tblInvoice.Fee3Type,
tblInvoice.Fee3Balance, tblInvoice.Fee3, tblInvoice.InvText, tblInvoice.InvLbl,
COALESCE(Fee1Balance,0)+
COALESCE(Fee2Balance,0)+
COALESCE(Fee3Balance,0) AS Collected,
IIf([Fee1Type]="%",([Fee1Balance]/100)*[Fee1],[Fee1])+
IIf(IsNull([Fee2Type]),0,IIf([Fee2Type]="%",([Fee2Balance]/100)*[Fee2],
IIf([Fee2Type]="$",[Fee2],0)))+IIf(IsNull([Fee3Type]),0,IIf([Fee3Type]="%",
([Fee3Balance]/100)*[Fee3],IIf([Fee3Type]="$",[Fee3],0)))-IIf(IsNull([AttyFees]),0,[AttyFees]) AS DueInv
FROM tblInvoice
WHERE (((tblInvoice.PaidDate) Is Null))
ORDER BY tblInvoice.InvoiceNumb DESC;

select tblDebtors.CreditorID,
COALESCE((case Fee1Type when \'%\'  then (Fee1Balance/100)*Fee1 ELSE Fee1 end) +
(case Fee2Type when Null  then 0 when \'%\' THEN (Fee2Balance/100)*Fee2 when \'$\' THEN Fee2  end) +
(case Fee3Type when Null  then 0 when \'%\' THEN (Fee3Balance/100)*Fee3 when \'$\' THEN Fee3   end) -
COALESCE(AttyFees,0),0)\'inv\' from tblDebtors
LEFT JOIN tblInvoices ON tblDebtors.DebtorID=tblInvoices.DebtorID  GROUP BY tblDebtors.CreditorID HAVING (((tblDebtors.CreditorID)=\'ADI-112\' ));');


SELECT tblInvoice.InvoiceNumb, tblInvoice.InvoiceNumb, tblInvoice.IPaymentID,
tblInvoice.IPaymentType, tblInvoice.InvDate,
tblInvoice.DebtorID, tblInvoice.PaidDate,
tblInvoice.CAmountPaid,
tblInvoice.TotalBillFor, tblInvoice.AttyFees,
tblInvoice.Fee1Type, tblInvoice.Fee1Balance, tblInvoice.Fee1,
tblInvoice.Fee2Type, tblInvoice.Fee2Balance, tblInvoice.Fee2, tblInvoice.Fee3Type,
tblInvoice.Fee3Balance, tblInvoice.Fee3, tblInvoice.InvText, tblInvoice.InvLbl,
COALESCE(Fee1Balance,0)+
COALESCE(Fee2Balance,0)+
COALESCE(Fee3Balance,0) AS Collected,
COALESCE((case Fee1Type when '%'  then (Fee1Balance/100)*Fee1 ELSE Fee1 end) +
(case Fee2Type when Null  then 0 when '%' THEN (Fee2Balance/100)*Fee2 when '$' THEN Fee2  end) +
(case Fee3Type when Null  then 0 when '%' THEN (Fee3Balance/100)*Fee3 when '$' THEN Fee3   end) -
COALESCE(AttyFees,0),0) AS DueInv
FROM tblInvoices tblInvoice
WHERE (((tblInvoice.PaidDate) Is Null))
ORDER BY tblInvoice.InvoiceNumb DESC

-->