<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Letter</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">
    <script type='text/javascript' src={{asset('js/jquery.min.js')}}></script>
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
        #identity,#customer{
            width:100%;
        }
        #identity  #address {
            width: 100%;
            display: block;
            float: left;
        }
        #meta {
            margin-top: 1px;
            width: 169px;
            float: right;
        }
        #customer{
            float: right;
        }
        #customer  #address {
            width: 170px;
            height: 70px;
            float: left;
        }
        #right-side{
            float: right;
        }
    </style>
</head>

<body>

<div id="page-wrap">





            <p id="" style=" height: 70px;" readonly>
{{$result->ClientName}}<br>
Attn:  {{$result->CFirstName}} {{$result->CLastName}}<br>
{{$result->Street}}<br>
{{$result->Address2}}</p>






    <p style="height: 70px;float: right;width: 100px;">
Re: {{$result->DebtorName}}<br>
# {{$result->ClientAcntNumber}}<br>
{{$result->AmountPlaced-$val}}<br>
</p>

<br>
    <br><br><br>

<p>

Dear {{$result->Saltnt}} {{$result->CLastName}}:<br>

This is sent to acknowledge the above captioned collection item which we have placed in the hands of our collection department.
Contact will be initiated immediately.  Many times the debtor may now contact you to arrange payment.  Should this occur, we ask that they be referred to this office to maintain a continuity of effort.  Please advance your file approximately 7 to 10 days for our initial report.
Thank you for this item of collection business."
</p>

    <br>

    <p style="height: 70px;float: right;width: 100px;">
        Your truly,<br>
        <br>
        {{$result->Salesman}}<br>
        Account Executive<br>
    </p>


</div>

</body>

</html>

<!--SELECT tblDebtors.DebtorID, tblDebtors.DebtorName, tblContacts.ContactID, tblDebtors.ClientAcntNumber,
tblContacts.ClientName, tblContacts.Saltnt, tblContacts.CFirstName, tblContacts.CLastName,
Trim(tblSales.SFirstName) & " " & Trim(tblSales.SLastName) AS Salesman, tblContacts.Street,
Trim(tblContacts.City) & ", " & tblContacts.State & "  " & Trim(tblContacts.Zip) AS Address2,
tblContacts.ClientName, tblDebtors.AmountPlaced, tblContacts.MainManager
FROM (((tblCreditors tblCreditor LEFT JOIN tblSales ON tblCreditor.SaleID = tblSales.SalesID)
LEFT JOIN tblContacts ON tblCreditor.CreditorID = tblContacts.CreditorID)
LEFT JOIN tblDebtors ON tblCreditor.CreditorID = tblDebtors.CreditorID)
LEFT JOIN tblTrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
GROUP BY tblDebtors.DebtorID, tblDebtors.DebtorName, tblContacts.ContactID,
tblDebtors.ClientAcntNumber, tblContacts.Saltnt, tblContacts.CFirstName,
tblContacts.CLastName, Trim(tblSales.SFirstName) & " " & Trim(tblSales.SLastName),
tblContacts.Street, Trim(tblContacts.City) & ", " & tblContacts.State & "  " & Trim(tblContacts.Zip),
tblContacts.ClientName, tblDebtors.AmountPlaced, tblContacts.MainManager, tblContacts.ClientName
HAVING (((tblDebtors.DebtorID)=4) AND ((tblContacts.ContactID)=(select ContactID from tblcontacts WHERE MainManager=1 AND CreditorID=(SELECT CreditorID FROM tbldebtors WHERE DebtorID=4))));-->
