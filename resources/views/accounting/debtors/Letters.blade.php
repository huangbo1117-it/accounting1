@extends('layouts.app')

@section('content')
    <div class="container">
        @if(count($selected)>0)
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtor</a></li>
            <li class="breadcrumb-item active">{{$selected[0]->DebtorID }} -- {{$selected[0]->DebtorName}}</li>
        </ol>
        <h1>Selection</h1>
        <form name="form" method="post"  target="_blank">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="colID">Letter Type:</label>

                        <select class="form-control" name="LetterType" required>

                            @foreach($temp as $s)
                                <option value="{{$s->TemplateID}}">{{$s->Name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2" >
                    <div class="form-group">
                        <label for="colID">Export Report:</label>

                        <select class="form-control" name="Export" id="Export" >
                            <option value="PDF">PDF</option>
                            <option value="DOC">MS Word</option>
                        </select>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="submit" name="view" class="form-control btn btn-primary" value="Export">
                </div>
            </div>
            <div class="col-md-6" hidden>
                <div class="form-group">
                    <input type="submit" name="view" class="form-control btn btn-primary" value="Export">
                </div>
            </div>
        </form>
            @else
            <br>
            <div class = "alert alert-danger">
                Debtor Information Not Found
            </div>
        @endif
    </div>
@endsection


<!--
  select `td`.`DebtorID` AS `Debtors_DebtorID`,`td`.`CreditorID` AS `Debtors_CreditorID`,`td`.`ColID` AS `Debtors_ColID`,
`td`.`ContactID` AS `Debtors_ContactID`,`td`.`DateEntered` AS `Debtors_DateEntered`,
`td`.`Salutation` AS `Debtors_Salutation`,`td`.`DebtorName` AS `Debtors_DebtorName`,
`td`.`DFirstName` AS `Debtors_DFirstName`,`td`.`DLastName` AS `Debtors_DLastName`,
`td`.`Street` AS `Debtors_Street`,`td`.`City` AS `Debtors_City`,`td`.`State` AS `Debtors_State`,
`td`.`Zip` AS `Debtors_Zip`,`td`.`Phone` AS `Debtors_Phone`,`td`.`ClientAcntNumber` AS `Debtors_ClientAcntNumber`,`td`.`StatusID` AS `Debtors_StatusID`,
`td`.`LastDate` AS `Debtors_LastDate`,`td`.`AmountPlaced` AS `Debtors_AmountPlaced`,`td`.`FormDate` AS `Debtors_FormDate`,`td`.`CostAdv` AS `Debtors_CostAdv`,
`td`.`CostRec` AS `Debtors_CostRec`,`td`.`SuitFee` AS `Debtors_SuitFee`,`td`.`Fees` AS `Debtors_Fees`,`td`.`Email` AS `Debtors_Email`,`td`.`attorneyID` AS `Debtors_attorneyID`,
`td`.`CID` AS `Debtors_CID`,
`tsc`.`CreditorID` AS `Contacts_CreditorID`,`tsc`.`ContactID` AS `Contacts_ContactID`,`tsc`.`ClientName` AS `Contacts_ClientName`,
`tsc`.`Saltnt` AS `Contacts_Saltnt`,`tsc`.`CFirstName` AS `Contacts_CFirstName`,`tsc`.`CLastName` AS `Contacts_CLastName`,`tsc`.`MainManager` AS `Contacts_MainManager`,
`tsc`.`Street` AS `Contacts_Street`,`tsc`.`City` AS `Contacts_City`,`tsc`.`State` AS `Contacts_State`,`tsc`.`Zip` AS `Contacts_Zip`,`tsc`.`Phone` AS `Contacts_Phone`,
`tsc`.`Fax` AS `Contacts_Fax`,`tsc`.`Ext` AS `Contacts_Ext`,
`ts`.`SalesID` AS `sales_SalesID`,`ts`.`SLastName` AS `sales_SLastName`,`ts`.`SFirstName` AS `sales_SFirstName`,
`tss`.`DebtorID` AS `trusts_DebtorID`,`tss`.`TPaymentID` AS `trusts_TPaymentID`,`tss`.`TPaymentType` AS `trusts_TPaymentType`,`tss`.`DateRcvd` AS `trusts_DateRcvd`,
`tss`.`PaymentReceived` AS `trusts_PaymentReceived`,`tss`.`PaymentType` AS `trusts_PaymentType`,`tss`.`Intrest` AS `trusts_Intrest`,`tss`.`AttyFees` AS `trusts_AttyFees`,
`tss`.`MiscFees` AS `trusts_MiscFees`,`tss`.`CostRef` AS `trusts_CostRef`,`tss`.`AgencyGross` AS `trusts_AgencyGross`,`tss`.`CheckNumb` AS `trusts_CheckNumb`,
`tss`.`RelDate` AS `trusts_RelDate`,`tss`.`ColID` AS `trusts_ColID`,`tss`.`BilledFor` AS `trusts_BilledFor`,`tss`.`Paid` AS `trusts_Paid`
from ((((`tblcreditors` `tc`
left join `tblsales` `ts` on((`tc`.`SaleID` = `ts`.`SalesID`)))
left join `tblcontacts` `tsc` on((`tc`.`CreditorID` = `tsc`.`CreditorID`)))
left join `tbldebtors` `td` on((`tc`.`CreditorID` = `td`.`CreditorID`)))
left join `tbltrusts` `tss` on((`td`.`DebtorID` = `tss`.`DebtorID`)))
group by `td`.`DebtorID` ;
-->

