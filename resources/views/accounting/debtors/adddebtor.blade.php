@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Add New Debtor  @if($DID != null)<a href="/Letters/{{$DID}}" target="_blank" class=" btn btn-info">Print Letters For Last Debtor</a>@endif</h1>

        <form name="form" method="post">
            {{ csrf_field() }}
            <div class="row" >
                <div class="col-md-2" >
                    <div class="form-group">
                        <label for="creditorID">Debtor ID (auto):</label>
                        <input type="text" class="form-control" name="debtorID" value="{{$DebtorID}}" >
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="creditorID">Debtor Name:</label>
                        <input type="text" class="form-control" name="debtorName" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="creditorID">Date Entered:</label>
                        <input type="date" class="form-control" name="dateEntered" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="creditorID">Salutation:</label>

                        <select class="form-control" name="Salutation" required>
                            <option value="Mr.">Mr.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Dr.">Dr.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">First Name:</label>
                        <input type="text" class="form-control" name="firstName" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Last Name:</label>
                        <input type="text" class="form-control" name="lastName" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="creditorID">Email:</label>
                        <input type="email" class="form-control" name="Email" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Street:</label>
                            <input type="text" class="form-control" name="street" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Country:</label>
                        <input type="text" class="form-control" name="country" value="" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">City:</label>
                        <input type="text" class="form-control" name="city" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">State:</label>
                        <input type="text" class="form-control" name="state" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Zip:</label>
                        <input type="text" class="form-control" name="zip" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Fax:</label>
                        <input type="text" class="form-control" name="Fax" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Phone:</label>
                        <input type="text" class="form-control" id="Maskphone" name="phone" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Client Account:</label>
                        <input type="text" class="form-control" name="clientAccount" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Status ID:</label>

                        <select class="form-control" name="statusID" required>
                            @foreach($sm as $s)
                                <option value="{{$s->StatusID}}">{{$s->StatusDesc}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Creditor ID:</label>

                        <select class="form-control" name="creditorID2" id="creditorID2" required onchange="getContactName(this)">
                            <option value="">Select Creditor ID</option>
                            @foreach($cd as $s)
                                <option value="{{$s->CreditorID}}">{{$s->CreditorID}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Creditor Name:</label>

                        <select class="form-control" name="creditorID" id="creditorID" required onchange="getContactName(this)">
                            <option value="">Select Creditor</option>
                            @foreach($cd as $s)
                                <option value="{{$s->CreditorID}}">{{$s->ClientName}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Creditor Contact Name:</label>

                        <select class="form-control" id="creditorContactName" name="creditorContactName" required>

                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Collector's Name:</label>

                        <select class="form-control" name="colID" required>
                            @foreach($col as $s)
                                <option value="{{$s->ColID}}">{{$s->CLastName}}  {{$s->CFirstName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Last Date:</label>
                        <input type="date" class="form-control" name="lastDate" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Form Date:</label>
                        <input type="date" class="form-control" name="formDate" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Amount Placed:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="form-control" name="amountPlaced" id="amountPlaced" onchange="$('#balanceDue').val($('#amountPlaced').val())" required>
                        </div>


                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Balance Due:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                                <input type="text" class="form-control txtboxToFilter" name="balanceDue" id="balanceDue" value="0" disabled>
                            </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Cost Advance:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="costAdvance" value="0" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Suit Fee:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="suitFee" value="0" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Cost Recover:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="costRecover" value="0" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Fees:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="fees" value="0" required>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="submit" class="form-control btn btn-primary" value="Create New Debtor">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <a href="/Debtor" class="form-control btn btn-warning">Cancel</a>
                </div>
            </div>

        </form>
    </div>

@endsection

@section('scripts')
<script>
    function getContactName(e){
       // $.ajax({url: "./GetContact", success: function(result){
       //     console.log(result);
       // }});
        $('#creditorID2').val(e.value);
        $('#creditorID').val(e.value);
        $('#creditorContactName').empty();
        $.ajax({
            url: './GetContact',
            type: 'GET',
            data: { id: e.value },
            success: function(response)
            {
                console.log(response);
                for(var i=0;i<response.length;i++){
                    $('#creditorContactName').append('<option value="'+ response[i].CreditorID +'">'+ response[i].CFirstName +'  '+ response[i].CLastName +' </option>')
                }
            }
        });
    }
    $(document).ready(function($) {
        $('input[name="firstName"]').val('Accounts')
        $('input[name="lastName"]').val('Payable')
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
        $('input[type=date]').val(today);
            $(".txtboxToFilter").change(function (e) {
                if (this.id =='amountPlaced'){
                    $('#balanceDue').val(CurrencyFormat2(parseFloat($('#balanceDue').val())))
                }
            $(this).val(CurrencyFormat2(parseFloat($(this).val())));
        });
        $(".txtboxToFilter").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
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

    });
</script>

@endsection

