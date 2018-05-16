@extends('layouts.app')

@section('content')

    <script src="{{ asset('js/nicEdit.js') }}"></script>

    <script type="text/javascript">

        bkLib.onDomLoaded(function () {
            var myNicEditor = new nicEditor();
            myNicEditor.setPanel('myNicPanel');

            myNicEditor.addInstance('myInstance1');

        });

    </script>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Template">Template</a></li>
        </ol>
        {{ csrf_field() }}
                <!--  <div class="row">
            <form method="post" action="/PrintTemplate" target="_blank">
                {{ csrf_field() }}
                <input type="submit" class="btn btn-primary" value="print">
            </form>
        </div>-->
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="statusID">Template Name:</label>
                    <input type="text" class="form-control" name="TemplateName" value="{{$template->Name}}" id="TemplateName" required>
                </div>

            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="statusID">Parameter Name:</label>
                    <select class="form-control" id="dbParameters">
                        @foreach( $parms as $ss)
                            <option value="{{$ss->Name}}">{{$ss->Name}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <input type="button" class="btn btn-primary" name="addParameter" id="addParameter" value="Add Parms">
                </div>

            </div>
        </div>
        <div class="row">


            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <div id="myNicPanel" style="width:750px;">

                </div>
                <textarea id="test" hidden>{{$template->Detail}}</textarea>
                <div id="myInstance1" style="width:750px; min-height: 100px;background-color: white;">

                </div>
            </div>
            <div class="col-md-2">

            </div>

        </div>
        <input type="button" class="btn btn-primary pull-right" value="save Template" id="saveTemplate">
        <!--<input type="button" class="btn btn-primary" value="Export Template" id="ExportTemplate">-->
    </div>

    <br />
@endsection
@section('scripts')
    <script src="{{ asset('js/FileSaver.min.js') }}"></script>
    <script src="{{ asset('js/jquery.wordexport.js') }}"></script>
    <script>

        $(function() {
            $('#addParameter').click(function () {
                var txtParameter = $('#dbParameters option:selected').val();
                if (txtParameter != "") {
                    $('#myInstance1').append('[['+ txtParameter +']]');
                }

            });
            $('#saveTemplate').click(function(e){
                var templateName =$('#TemplateName').val();
                var htl=$('#myInstance1').html();
                if(templateName != '' && htl != '<br>'){
                    $.ajax({
                        type: "POST",
                        data: {
                            _token: $('input[name=_token]').val(),
                            Name: templateName,
                            TemplateData: $('#myInstance1').html(),
                        },
                        success: function (response) {
                            if(response){
                                alert('Template updated');
                            }else{
                                alert('Template Not updated');
                            }
                        },
                        error: function () {

                        }
                    });
                }else{
                    alert('Please fill all fields of template...')
                }
            });
            var aa =$('#test').text();
            $('#myInstance1').append(aa);
        });
    </script>
    @endsection


            <!--
SELECT tblDebtors.DebtorID, tblDebtors.DebtorName, tblContacts.ContactID, tblDebtors.ClientAcntNumber,
tblContacts.ClientName, tblContacts.Saltnt, tblContacts.CFirstName, tblContacts.CLastName,
CONCAT(Trim(tblSales.SFirstName),"  ", Trim(tblSales.SLastName)) AS Salesman, tblContacts.Street,
CONCAT(Trim(tblContacts.City) ,", " , tblContacts.State , "  " , Trim(tblContacts.Zip)) AS Address2,
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
HAVING (((tblDebtors.DebtorID)='.$request->DebtorID.') AND ((tblContacts.ContactID)=(select ContactID from tblcontacts WHERE MainManager=1 AND CreditorID=(SELECT CreditorID FROM tbldebtors WHERE DebtorID='.$request->DebtorID.'


select *
FROM (((tblCreditors TC LEFT JOIN   tblSales TS ON TC.SaleID = TS.SalesID)
LEFT JOIN tblContacts TSC ON TC.CreditorID = TSC.CreditorID)
LEFT JOIN tblDebtors TD ON TC.CreditorID = TD.CreditorID)
LEFT JOIN tblTrusts TSS ON TD.DebtorID = TSS.DebtorID


select TD.DebtorID'Debtors_DebtorID',TD.CreditorID'Debtors_CreditorID',TD.ColID'Debtors_ColID',TD.ContactID'Debtors_ContactID',TD.DateEntered'Debtors_DateEntered',TD.Salutation'Debtors_Salutation',TD.DebtorName'Debtors_DebtorName',TD.DFirstName'Debtors_DFirstName',TD.DLastName'Debtors_DLastName',TD.Street'Debtors_Street',TD.City'Debtors_City',TD.State'Debtors_State',TD.Zip'Debtors_Zip',TD.Phone'Debtors_Phone',TD.ClientAcntNumber'Debtors_ClientAcntNumber',TD.StatusID'Debtors_StatusID',TD.StatusID'Debtors_StatusID',TD.LastDate'Debtors_LastDate',TD.AmountPlaced'Debtors_AmountPlaced',TD.FormDate'Debtors_FormDate',TD.CostAdv'Debtors_CostAdv',TD.CostRec'Debtors_CostRec',TD.SuitFee'Debtors_SuitFee',TD.Fees'Debtors_Fees',TD.Email'Debtors_Email',TD.attorneyID'Debtors_attorneyID',TD.CID Debtors_CID,
TSC.CreditorID 'Contacts_CreditorID' ,TSC.ContactID `Contacts_ContactID`,TSC.ClientName `Contacts_ClientName`,TSC.Saltnt `Contacts_Saltnt`,TSC.CFirstName `Contacts_CFirstName`,TSC.CLastName`Contacts_CLastName`,TSC.MainManager`Contacts_MainManager`,TSC.Street`Contacts_Street`,TSC.City`Contacts_City`,TSC.State`Contacts_State`,TSC.Zip`Contacts_Zip`,TSC.Phone`Contacts_Phone`,TSC.Fax`Contacts_Fax`, TSC.Ext Contacts_Ext,
TS.SalesID 'sales_SalesID',TS.SLastName 'sales_SLastName',TS.SFirstName 'sales_SFirstName',
TSS.DebtorID 'trusts_DebtorID',TSS.TPaymentID 'trusts_TPaymentID',TSS.TPaymentType 'trusts_TPaymentType',TSS.DateRcvd 'trusts_DateRcvd',TSS.PaymentReceived 'trusts_PaymentReceived',TSS.PaymentType 'trusts_PaymentType',TSS.Intrest 'trusts_Intrest',TSS.AttyFees 'trusts_AttyFees',TSS.MiscFees 'trusts_MiscFees',TSS.CostRef 'trusts_CostRef',TSS.AgencyGross 'trusts_AgencyGross',TSS.CheckNumb 'trusts_CheckNumb',TSS.RelDate 'trusts_RelDate',TSS.ColID 'trusts_ColID',TSS.BilledFor 'trusts_BilledFor',TSS.Paid 'trusts_Paid'
FROM (((tblCreditors TC LEFT JOIN   tblSales TS ON TC.SaleID = TS.SalesID)
LEFT JOIN tblContacts TSC ON TC.CreditorID = TSC.CreditorID)
LEFT JOIN tblDebtors TD ON TC.CreditorID = TD.CreditorID)
LEFT JOIN tblTrusts TSS ON TD.DebtorID = TSS.DebtorID


TSC.CreditorID 'Contacts_CreditorID' ,TSC.ContactID `Contacts_ContactID`,TSC.ClientName `Contacts_ClientName`,TSC.Saltnt `Contacts_Saltnt`,TSC.CFirstName `Contacts_CFirstName`,TSC.CLastName`Contacts_CLastName`,TSC.MainManager`Contacts_MainManager`,TSC.Street`Contacts_Street`,TSC.City`Contacts_City`,TSC.State`Contacts_State`,TSC.Zip`Contacts_Zip`,TSC.Phone`Contacts_Phone`,TSC.Fax`Contacts_Fax`, TSC.Ext Contacts_Ext
TC.ID 'creditors_ID',TC.CreditorID'creditors_CreditorID',TC.SaleID'creditors_SaleID',TC.OpenDate'creditors_OpenDate',TC.Comments'creditors_Comments',TC.CompReport'creditors_CompReport',TC.LastDate'creditors_LastDate'
TS.SalesID 'sales_SalesID',TS.SLastName 'sales_SLastName',TS.SFirstName 'sales_SFirstName'
TSS.DebtorID 'trusts_DebtorID',TSS.TPaymentID 'trusts_TPaymentID',TSS.TPaymentType 'trusts_TPaymentType',TSS.DateRcvd 'trusts_DateRcvd',TSS.PaymentReceived 'trusts_PaymentReceived',TSS.PaymentType 'trusts_PaymentType',TSS.Intrest 'trusts_Intrest',TSS.AttyFees 'trusts_AttyFees',TSS.MiscFees 'trusts_MiscFees',TSS.CostRef 'trusts_CostRef',TSS.AgencyGross 'trusts_AgencyGross',TSS.CheckNumb 'trusts_CheckNumb',TSS.RelDate 'trusts_RelDate',TSS.ColID 'trusts_ColID',TSS.BilledFor 'trusts_BilledFor',TSS.Paid 'trusts_Paid'


TD.DebtorID'Debtors_DebtorID',TD.CreditorID'Debtors_CreditorID',TD.ColID'Debtors_ColID',TD.ContactID'Debtors_ContactID',TD.DateEntered'Debtors_DateEntered',TD.Salutation'Debtors_Salutation',TD.DebtorName'Debtors_DebtorName',TD.DFirstName'Debtors_DFirstName',TD.DLastName'Debtors_DLastName',
TD.Street'Debtors_Street',TD.City'Debtors_City',TD.State'Debtors_State',TD.Zip'Debtors_Zip',TD.Phone'Debtors_Phone',TD.ClientAcntNumber'Debtors_ClientAcntNumber',TD.StatusID'Debtors_StatusID',
TD.StatusID'Debtors_StatusID',TD.LastDate'Debtors_LastDate',TD.AmountPlaced'Debtors_AmountPlaced',TD.FormDate'Debtors_FormDate',TD.CostAdv'Debtors_CostAdv',TD.CostRec'Debtors_CostRec',
TD.SuitFee'Debtors_SuitFee',TD.Fees'Debtors_Fees',TD.Email'Debtors_Email',TD.attorneyID'Debtors_attorneyID',TD.CID`Debtors_CID'

->