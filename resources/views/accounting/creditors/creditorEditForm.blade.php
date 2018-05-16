
@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Creditor">Creditor</a></li>
        </ol>

            @if($first != null)
                  <span style="margin: 5px;"><a href="/EditCreditor/{{$first}}" class="btn btn-info align " role="button">First</a></span>
        @endif
        @if($previous != null)
            <span style="margin: 5px;"><a href="/EditCreditor/{{$previous}}" class="btn btn-info align " role="button">Previous</a></span>
        @endif
            @if($Next != null)
               <span style="margin: 5px;">     <a href="/EditCreditor/{{$Next}}" class="btn btn-info align " role="button">Next</a></span>
            @endif
        @if($last != null)
            <span style="margin: 5px;">     <a href="/EditCreditor/{{$last}}" class="btn btn-info align " role="button">Last</a></span>
        @endif

        <h1>Update Creditor Information</h1>

        <form name="form" method="post">
            {{ csrf_field() }}

<div id="viewDetail">
            <input type="hidden" value="{{$creditor->CreditorID}}" id="updateCreditorID" name="updateCreditorID">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="creditorID">Creditor ID:</label>
                        <input type="text" class="form-control" name="creditorID" value="{{$creditor->CreditorID}}" id="creditorID" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="clientName">Client Name:</label>
                        <input type="text" class="form-control" name="clientName" required value="{{$contact->ClientName}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="opendate">Open Date:</label>
                        <input type="date" class="form-control" name="opendate" value="{{$creditor->OpenDate}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lastdate">Last Date:</label>
                        <input type="date" class="form-control" name="lastdate" value="{{$creditor->LastDate}}" required>
                    </div>
                </div>
                <input type="checkbox" name="compreport" value="1" @if ($creditor->CompReport== true) checked @endif> Comp Report
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" class="form-control" name="street" value="{{$contact->Street}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Country:</label>
                        <input type="text" class="form-control" name="country" value="{{$contact->Country}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" name="city" value="{{$contact->City}}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="state">State:</label>
                        <input type="text" class="form-control" name="state" value="{{$contact->State}}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="zip">Zip:</label>
                        <input type="text" class="form-control" name="zip" value="{{$contact->Zip}}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="sltn">Sltn:</label>
                        <select name="sltn" class="form-control">
                            <option value="Mr." @if($contact->Saltnt == 'Mr.') selected @endif>Mr.</option>
                            <option value="Ms." @if($contact->Saltnt == 'Ms.') selected @endif>Ms.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mFirstName">Manager First Name:</label>
                        <input type="text" class="form-control" name="mFirstName" value="{{$contact->CFirstName}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mLastName">Manager Last Name:</label>
                        <input type="text" class="form-control" name="mLastName" value="{{$contact->CLastName}}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="mainmanager">Main Manager:</label><br>
                        <input type="checkbox" class="form-control" name="mainmanager" id="mainmanager" value="1" checked disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="mainmanager">Contact ID (auto):</label><br>
                        <span hidden><input type="text" class="form-control" name="ContactID" value="{{$contact->ContactID}}" ></span>
                        <input type="text" class="form-control" name="ContactID2" value="{{$contact->ContactID}}" disabled>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control txtboxToFilter" id="Maskphone" name="phone" value="{{$contact->Phone}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="ext">Ext:</label>
                        <input type="text" class="form-control txtboxToFilter" id="MaskExt" name="ext" value="{{$contact->Ext}}" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fax">Fax:</label>
                        <input type="text" class="form-control txtboxToFilter" id="MaskFax" name="fax" value="{{$contact->Fax}}" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="email" class="form-control" name="Email" required value="{{$creditor->Email}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="salesman">Sales Man:</label>
                        <select class="form-control" name="salesman" required>
                            @foreach($sm as $s)
                                <option value="{{$s->SalesID}}" @if($s->SalesID == $creditor->SaleID) selected @endif >{{$s->SFirstName}} {{$s->SLastName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="compreport">Comments:</label>
                        <textarea class="form-control" name="comments">{{$creditor->Comments}} </textarea>
                    </div>

                </div>
            </div>
            <div class="row">



                <div class="col-md-2">
            <div class="form-group">
                <label for="compreport">Total # Placed:</label>
                <input class="form-control" name="Placed" value="{{$NumbOfDebt}}" disabled/>
            </div></div>
                    <div class="col-md-2">
            <div class="form-group">
                <label for="compreport">Total $ Placed:</label>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                <input class="form-control" name="PlacedT" value="{{$SumOfAmountPlaced}}" disabled/>
                    </div>
            </div></div>
                        <div class="col-md-2">
            <div class="form-group">
                <label for="compreport">$ Collected:</label>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                <input class="form-control" name="Collected" disabled value="{{$totalCollectedValue}}"/>
                    </div>
            </div></div>
                            <div class="col-md-2">
            <div class="form-group">
                <label for="compreport">Balance Pending:</label>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input class="form-control" name="Pending"value="{{floatval($SumOfAmountPlaced)-floatval($totalCollectedValue)}}" disabled/>
                </div>

            </div></div>
                                <div class="col-md-2">
            <div class="form-group">
                <label for="compreport">Total Invoice:</label>
                <input class="form-control" name="Invoice" value="{{$InvDues}}" disabled/>
            </div></div>
                                    <div class="col-md-2">
            <div class="form-group">
                <label for="compreport">Total Trust:</label>
                <input class="form-control" name="Trust" value="{{$txtTotalRec}}" disabled />
            </div>
                                    </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="compreport">Last Updated:</label>
                        <input class="form-control" type="date" name="LastUpdate" value="{{$creditor->LastUpdate}}"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="compreport">User Updated:</label>
                        <input class="form-control" name="LastUpdate" value="{{$creditor->UserUpdated}}"/>
                    </div>
                </div>
            </div>
</div>
            <br><br>

                <div class="form-group">
                    <input type="submit" class="form-control btn btn-primary" value="Update Creditor">
                </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function getContactName(e){
            $('#creditorContactName').empty();
            $.ajax({
                url: './GetContact',
                type: 'GET',
                data: { id: e.value },
                success: function(response)
                {
                    console.log(response);
                    for(var i=0;i<response.length;i++){
                        $('#creditorContactName').append('<option value="'+ responsei.CreditorID +'">'+ responsei.CFirstName +'  '+ responsei.CLastName +' </option>')
                    }
                }
            });
        }
        $(document).ready(function() {
            $('#creditorID').blur(function (e) {
                var upID = $('#updateCreditorID').val();
                var ID = $('#creditorID').val();
                if(upID !== ID){
                $.ajax({
                    url: '/GetCreditorID',
                    type: 'GET',
                    data: { id: $('#creditorID').val() },
                    success: function(response)
                    {
                        console.log(response);
                        if(response != ''){
                            alert('Creditor ID Already exist');
                            $('#creditorID').val(upID);
                        }
                    }
                });
                }
            });
            $(".txtboxToFilter").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, 46, 8, 9, 27, 13, 110, 190) !== -1 ||
                            // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
            $("#Maskphone").mask("(999) 999-9999");
            $("#MaskFax").mask("(999) 999-9999");
            $("#MaskExt").mask("99999");

        });
    </script>

    @endsection

<!--SELECT tblDebtors.CreditorID,
Sum(IIf(Fee1Type="%",(Fee1Balance/100)*Fee1,Fee1)+
IIf(IsNull(Fee2Type),0,IIf(Fee2Type="%",(Fee2Balance/100)*Fee2,IIf(Fee2Type="$",Fee2,0)))+
IIf(IsNull(Fee3Type),0,IIf(Fee3Type="%",(Fee3Balance/100)*Fee3,IIf(Fee3Type="$",Fee3,0)))-
IIf(IsNull(AttyFees),0,AttyFees)) AS InvDue
FROM tblDebtors LEFT JOIN tblInvoice ON tblDebtors.DebtorID=tblInvoice.DebtorID
GROUP BY tblDebtors.CreditorID
HAVING (((tblDebtors.CreditorID)=Forms!frmCreditors!CreditorID));


SELECT tblDebtors.CreditorID,
tblTrust.DebtorID,
Sum(tblTrust.PaymentReceived-
IIf(IsNull(MiscFees),0,MiscFees)+
IIf(IsNull(CostRef),0,CostRef)-
IIf(IsNull(AttyFees),0,Attyfees)-
IIf(IsNull(AgencyGross),0,AgencyGross)) AS Pmnt
FROM tblDebtors LEFT JOIN tblTrust ON tblDebtors.DebtorID=tblTrusts.DebtorID
WHERE (((tblTrusts.TPaymentType)="T") )
GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID;



    SELECT DISTINCTROW tblDebtors.CreditorID,
    Sum(IIf(COALESCE(Intrest,0)-
    COALESCE(AttyFees,0)+
    COALESCE(MiscFees,0)+
    COALESCE(AgencyGross,0)) AS SumOfNetClient
    FROM tblDebtors LEFT JOIN tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID
    WHERE (((tblTrust.TPaymentType)="T") And ((tblTrust.DateRcvd)>'5/29/2000'))
    GROUP BY tblDebtors.CreditorID;



    SELECT DISTINCTROW tblDebtors.CreditorID, Sum(COALESCE(Intrest,0)- COALESCE(AttyFees,0)+ COALESCE(MiscFees,0)+ COALESCE(AgencyGross,0)) AS SumOfNetClient FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID WHERE (((tblTrust.TPaymentType)="T") And ((tblTrust.DateRcvd)>'5/29/2000')) GROUP BY tblDebtors.CreditorID
    SELECT DISTINCTROW tblDebtors.CreditorID, Sum(COALESCE(Intrest,0)- COALESCE(AttyFees,0))+(COALESCE(MiscFees,0)+COALESCE(AgencyGross,0)) AS SumOfNetClient FROM tblDebtors LEFT JOIN tblTrusts tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID WHERE (((tblTrust.TPaymentType)="T") And ((tblTrust.DateRcvd)>'5/29/2000')) GROUP BY tblDebtors.CreditorID;

            


    SELECT tblDebtors.DebtorID, ROUND(Sum(tblTrust.AgencyGross),2) AS SumOfAgencyGross FROM tblDebtors INNER JOIN tbltrusts tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID WHERE (((tblTrust.TPaymentType)="T")) GROUP BY tblDebtors.DebtorID HAVING (((tblDebtors.DebtorID)=8))


    SELECT tblDebtors.DebtorID,
    ROUND(Sum(
    case Fee1Type when "%" then (Fee1Balance/100)*Fee1 else Fee1 end +
    case Fee2Type when null then 0 when Fee2Type="%" then (Fee2Balance/100)*Fee2 when "$" then Fee2 end +
    case Fee3Type when null then 0 when Fee3Type='%' then (Fee3Balance/100)*Fee3 when "$" then Fee3 end
    ) ,2)AS DueInv
    FROM tblDebtors INNER JOIN tblinvoices tblInvoice ON tblDebtors.DebtorID=tblInvoice.DebtorID
    GROUP BY tblDebtors.DebtorID
    HAVING (((tblDebtors.DebtorID)=8));
        
            

    SELECT tblDebtors.DebtorID, Sum(tblTrust.MiscFees) AS SumOfMiscFees
    FROM tblDebtors INNER JOIN tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID
    WHERE (((tblTrust.TPaymentType)="T"))
    GROUP BY tblDebtors.DebtorID
    HAVING (((tblDebtors.DebtorID)=8));


    SELECT tblDebtors.DebtorID, Sum(tblTrust.CostRef) AS SumOfCostRef
    FROM tblDebtors INNER JOIN tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID
    WHERE (((tblTrust.TPaymentType)="T"))
    GROUP BY tblDebtors.DebtorID
    HAVING (((tblDebtors.DebtorID)=8));
    -->
