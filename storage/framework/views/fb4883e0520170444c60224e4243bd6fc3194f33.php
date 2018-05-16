<?php $__env->startSection('content'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtor</a></li>
            <li class="breadcrumb-item active"><a href="/Invoices/<?php echo e($invoice->DebtorID); ?>">Invoices</a> </li>
        </ol>
        <h3>Update Invoice</h3>
        <?php if($invoice->CAmountPaid == null): ?>
        <div class="row">
            <div class="col-md-3 pull-right">
                <div class="form-group">
                    <form method="post" action="/UpdatePaidInvoice/<?php echo e($invoice->IPaymentID); ?>" class="inline">
                        <input type="hidden" class="form-control" name="InvoiceTotal2" id="InvoiceTotal2" >
                        <button type="submit" name="edit" class="btn btn-primary">Mark Invoice Paid</button>
                        <?php echo e(csrf_field()); ?>

                    </form>
                </div>
            </div>
        </div>
<?php endif; ?>
            <form name="form" method="post">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" class="form-control" name="DebtorID"  id="DebtorID"  value="<?php echo e($invoice->DebtorID); ?>">
                <input type="hidden" class="form-control" name="updateInvoiceID"  id="IPaymentType"  value="<?php echo e($invoice->IPaymentID); ?>">
                <input type="hidden" class="form-control" name="IPaymentType"  id="IPaymentType"  value="<?php echo e($invoice->TPaymentType); ?>">
                <br>
                <div class="row">
                    <div class="col-md-3" >
                        <div class="form-group">
                            <label for="amountPaid">Invoice No:</label>
                            <input type="text" class="form-control" name="InvoiceNo"  id="InvoiceNo" value="<?php echo e($invoice->InvoiceNumb); ?>" readonly >
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="form-group">
                            <label for="amountPaid">Invoice Date:</label>
                            <input type="date" class="form-control" name="InvoiceDate"  id="InvoiceDate"  value="<?php echo e($invoice->InvDate); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="form-group">
                            <label for="amountPaid">Paid Date:</label>
                            <input type="date" class="form-control" name="PaidDate"  id="PaidDate"  value="<?php echo e($invoice->PaidDate); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="form-group">
                            <label for="amountPaid">Amount Paid:</label>
                            <input type="text" class="form-control" name="amountPaid"  id="amountPaid" value="<?php echo e($invoice->CAmountPaid); ?>"  readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amountPaid">Total Bill:</label>
                            <input type="text" class="form-control" name="TotalBill"  id="TotalBill"  value="<?php echo e($invoice->TotalBillFor); ?>"  required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dateReceived">Invoice Label:</label>
                            <input type="text" class="form-control" name="InvoiceLabel" value="<?php echo e($invoice->InvLbl); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dateReceived">Atty Due:</label>
                            <input type="text" class="form-control" name="AttyDue" value="<?php echo e($invoice->AttyFees); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="TOPID">Fee 1 Type:</label>
                            <select class="form-control" name="Fee1Type" id="Fee1Type" >
                                <option value="$">$ </option>
                                <option value="%">% </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dateReceived">Fee 1 Balance:</label>
                            <input type="text" class="form-control" name="Fee1Balance" id="Fee1Balance" value="<?php echo e($invoice->Fee1Balance); ?>" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dateReceived">Fee 1 :</label>
                            <input type="text" class="form-control" name="Fee1" id="Fee1" required value="<?php echo e($invoice->Fee1); ?>" onchange="calculate()" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dateReceived">Calculated Total Fee 1:</label>
                            <input type="text" class="form-control" name="CalculatedTotalFee1"  id="CalculatedTotalFee1" required>
                        </div>
                    </div>
                    <div class="col-md-3" hidden>
                        <div class="form-group">
                            <label for="TOPID">Fee 2 Type:</label>
                            <select class="form-control" name="Fee2Type" id="Fee2Type">
                                <option value="$">$ </option>
                                <option value="%">% </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" hidden>
                        <div class="form-group">
                            <label for="dateReceived">Fee 2 Balance:</label>
                            <input type="text" class="form-control"  name="Fee2Balance" value="<?php echo e($invoice->Fee2Balance); ?>" id="Fee2Balance">
                        </div>
                    </div>
                    <div class="col-md-3" hidden>
                        <div class="form-group">
                            <label for="dateReceived">Fee 2 :</label>
                            <input type="text" class="form-control" name="Fee2" id="Fee2" value="<?php echo e($invoice->Fee2); ?>" onchange="calculate()">
                        </div>
                    </div>
                    <div class="col-md-3" hidden>
                        <div class="form-group">
                            <label for="dateReceived">Calculated Total Fee 2:</label>
                            <input type="text" class="form-control" name="CalculatedTotalFee2" id="CalculatedTotalFee2">
                        </div>
                    </div>
                    <div class="col-md-3" hidden>
                        <div class="form-group">
                            <label for="TOPID">Fee 3 Type:</label>
                            <select class="form-control" name="Fee3Type" id="Fee3Type">
                                <option value="$">$ </option>
                                <option value="%">% </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" hidden>
                        <div class="form-group">
                            <label for="dateReceived">Fee 3 Balance:</label>
                            <input type="text" class="form-control"  name="Fee3Balance" value="<?php echo e($invoice->Fee3Balance); ?>" id="Fee3Balance">
                        </div>
                    </div>
                    <div class="col-md-3" hidden>
                        <div class="form-group">
                            <label for="dateReceived">Fee 3 :</label>
                            <input type="text" class="form-control" name="Fee3" id="Fee3" value="<?php echo e($invoice->Fee3); ?>" onchange="calculate()">
                        </div>
                    </div>
                    <div class="col-md-3" hidden>
                        <div class="form-group">
                            <label for="dateReceived">Calculated Total Fee 3:</label>
                            <input type="text" class="form-control" name="CalculatedTotalFee3" id="CalculatedTotalFee3">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dateReceived">Invoice Total:</label>
                            <input type="text" class="form-control" name="InvoiceTotal" value="<?php echo e($invoice->CAmountPaid); ?>" id="InvoiceTotal" required>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="dateReceived">Invoice Text:</label>
                            <textarea class="form-control" name="InvoiceText" > <?php echo e($invoice->InvText); ?></textarea>
                        </div>
                    </div>
                    <br><br>

                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-primary" value="Update">
                        </div>
                    </div>


                </div>



            </form>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function(){
            calculate();
        });
        function calculate(){

            var Fee1Type =$("#Fee1Type").val();
            var Fee2Type =$("#Fee2Type").val();
            var Fee3Type =$("#Fee3Type").val();
            if (Fee1Type == "$"){
                var Fee1 =$("#Fee1").val();
                if(parseFloat(Fee1)>0){
                    $("#CalculatedTotalFee1").val(parseFloat(Fee1));
                }
            }
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
            $('#InvoiceTotal2').val(invTotal);

        }
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>