@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Invoice</h1>
        @if($trustActivity->BilledFor == 1)
            <div class = "alert alert-danger">
                Invoice Already Billed !
            </div>
            @else
        <form name="form" method="post">
            {{ csrf_field() }}
            <input type="hidden" class="form-control" name="DebtorID"  id="DebtorID"  value="{{$trustActivity->DebtorID}}">
            <input type="hidden" class="form-control" name="IPaymentType"  id="IPaymentType"  value="{{$trustActivity->TPaymentType}}">
            <br>
            <div class="row">
                <div class="col-md-3" hidden>
                    <div class="form-group">
                        <label for="amountPaid">Invoice No:</label>
                        <input type="text" class="form-control" name="InvoiceNo"  id="InvoiceNo"   >
                    </div>
                </div>
                <div class="col-md-3" hidden>
                    <div class="form-group">
                        <label for="amountPaid">Invoice Date:</label>
                        <input type="date" class="form-control" name="InvoiceDate"  id="InvoiceDate"   >
                    </div>
                </div>
                <div class="col-md-3" hidden>
                    <div class="form-group">
                        <label for="amountPaid">Paid Date:</label>
                        <input type="date" class="form-control" name="PaidDate"  id="PaidDate"   >
                    </div>
                </div>
                <div class="col-md-3" hidden>
                    <div class="form-group">
                        <label for="amountPaid">Amount Paid:</label>
                        <input type="text" class="form-control" name="amountPaid"  id="amountPaid"   >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="amountPaid">Total Bill:</label>
                        <input type="text" class="form-control txtboxToFilter" name="TotalBill"  id="TotalBill"  value="{{$trustActivity->PaymentReceived}}"  required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dateReceived">Invoice Label:</label>
                        <input type="text" class="form-control" name="InvoiceLabel" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dateReceived">Atty Due:</label>
                        <input type="text" class="form-control" name="AttyDue" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="TOPID">Fee 1 Type:</label>
                        <select class="form-control" name="Fee1Type" id="Fee1Type" onchange="calculate()">
                                <option value="$">$ </option>
                            <option value="%">% </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Fee 1 Balance:</label>
                        <input type="text" class="form-control txtboxToFilter" name="Fee1Balance" id="Fee1Balance" value="{{$trustActivity->PaymentReceived}}" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Fee 1 :</label>
                        <input type="text" class="form-control txtboxToFilter" name="Fee1" id="Fee1" required onchange="calculate()" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Calculated Total Fee 1:</label>
                        <input type="text" class="form-control txtboxToFilter" name="CalculatedTotalFee1" id="CalculatedTotalFee1" required>
                    </div>
                </div>
                <div hidden>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="TOPID">Fee 2 Type:</label>
                        <select class="form-control" name="Fee2Type" id="Fee2Type">
                            <option value="$">$ </option>
                            <option value="%">% </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Fee 2 Balance:</label>
                        <input type="text" class="form-control"  name="Fee2Balance" id="Fee2Balance">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Fee 2 :</label>
                        <input type="text" class="form-control" name="Fee2" id="Fee2" onchange="calculate()">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Calculated Total Fee 2:</label>
                        <input type="text" class="form-control" name="CalculatedTotalFee2" id="CalculatedTotalFee2">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="TOPID">Fee 3 Type:</label>
                        <select class="form-control" name="Fee3Type" id="Fee3Type">
                            <option value="$">$ </option>
                            <option value="%">% </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Fee 3 Balance:</label>
                        <input type="text" class="form-control"  name="Fee3Balance" id="Fee3Balance">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Fee 3 :</label>
                        <input type="text" class="form-control" name="Fee3" id="Fee3" onchange="calculate()">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Calculated Total Fee 3:</label>
                        <input type="text" class="form-control" name="CalculatedTotalFee3" id="CalculatedTotalFee3">
                    </div>
                </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Invoice Total:</label>
                        <input type="text" class="form-control txtboxToFilter" name="InvoiceTotal" id="InvoiceTotal" required>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="dateReceived">Invoice Text:</label>
                        <textarea class="form-control" name="InvoiceText"></textarea>
                    </div>
                </div>
                <br><br>

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-primary" value="Save">
                    </div>
                </div>
                <div class="col-md-3" hidden>
                    <div class="form-group">
                        <input type="button" class="form-control btn btn-primary" value="Mark Invoice Paid">
                    </div>
                </div>
                <div class="col-md-3" hidden>
                    <div class="form-group">
                        <input type="button" class="form-control btn btn-primary" value="Preview Invoice">
                    </div>
                </div>
            </div>



        </form>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function calculate(){

            var Fee1Type =$("#Fee1Type").val();
            var Fee2Type =$("#Fee2Type").val();
            var Fee3Type =$("#Fee3Type").val();
            if (Fee1Type == "$"){
                var Fee1 =$("#Fee1").val();
                if(parseFloat(Fee1)>0){
                    $("#CalculatedTotalFee1").val(parseFloat(Fee1).toFixed(2));
                }
            }
            if (Fee1Type == "%"){
                var Fee1 =$("#Fee1").val();
                if(parseFloat(Fee1)>0){
                    var aa=parseFloat(Fee1)/100;
                    var Fee1Balance=$('#Fee1Balance').val();
                    var totalFee1=parseFloat(aa)*parseFloat(Fee1Balance);
                    $("#CalculatedTotalFee1").val(parseFloat(totalFee1).toFixed(2));
                }
            }
            //Me.txtTotalFee1 = Round((Me.Fee1 / 100) * Me.Fee1Balance, 2)
            if (Fee2Type == "$"){
                var Fee2 =$("#Fee2").val();
                if(parseFloat(Fee2)>0) {
                    $("#CalculatedTotalFee2").val(parseFloat(Fee2));
                }
            }
            if (Fee3Type == "$"){
                var Fee3 =$("#Fee3").val();
                if(parseFloat(Fee3)>0) {
                    $("#CalculatedTotalFee3").val(parseFloat(Fee3));
                }
            }
            var CalculatedTotalFee1 =$("#CalculatedTotalFee1").val();
            var CalculatedTotalFee2 =$("#CalculatedTotalFee2").val();
            var CalculatedTotalFee3 =$("#CalculatedTotalFee3").val();
            var invTotal=0;
            if(parseFloat(CalculatedTotalFee1)>0){
                invTotal+=parseFloat(CalculatedTotalFee1);
            }
            if(parseFloat(CalculatedTotalFee2)>0){
                invTotal+=parseFloat(CalculatedTotalFee2);
            }
            if(parseFloat(CalculatedTotalFee3)>0){
                invTotal+=parseFloat(CalculatedTotalFee3);
            }

            $('#InvoiceTotal').val(invTotal);

        }

        $(function(){

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
        });
    </script>

@endsection

