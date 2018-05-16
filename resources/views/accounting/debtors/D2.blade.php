<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Letter</title>
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
{{$result->DebtorName}}<br>
{{$result->DAttn}}<br>
{{$result->Street}}<br>
{{$result->Address2}}</p>





    <p style="height: 70px;float: right;width: 100px;">
    Re: {{$result->ClientName}}<br>
        {{$result->AmountPlaced}}<br>
    </p>

    <br>
    <br><br><br>




<p>
    {{$result->DAttn}}:<br>

You have failed to respond to our demands for payment on this account.
Don't you realize that this is a collection matter and that your creditor has decided to take whatever action is necessary to collect this account?  If further action is to be halted we must have your payment by return mail.  Make you check payble to:{{$result->ClientName}}, but mail it to our office.  A business reply envelope is enclosed.
We will advance our files 7 days from the date of this letter with expectations of hearing from you.
</p>






    <p style="height: 70px;float: right;width: 100px;">
    Your Truly,<br>
    <br>
    {{$result->Collector}}<br>
    Collection Dept.
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
-->