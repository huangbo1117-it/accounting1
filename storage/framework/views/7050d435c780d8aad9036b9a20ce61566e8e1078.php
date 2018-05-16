<?php $__env->startSection('content'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtor</a></li>
            <li class="breadcrumb-item active"><a href="/Invoices/<?php echo e($selected[0]->DebtorID); ?>">Invoices</a> </li>
        </ol>
        <h1>Add Credit</h1>
        <form name="form" method="post">
            <?php echo e(csrf_field()); ?>

            <div class="pull-right" hidden>
                <label for="paymentReceived">Billed For:</label>
                <input type="checkbox"  name="BilledFor"  id="BilledFor"  >
            </div>

            <input type="hidden" class="form-control" name="DebtorID"  id="DebtorID"  value="<?php echo e($selected[0]->DebtorID); ?>">
            <br>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="amountPaid">Amount Paid:</label>
                        <input type="text" class="form-control txtboxToFilter" name="amountPaid"  id="amountPaid"   required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateReceived">Date Received:</label>
                        <input type="date" class="form-control" name="dateReceived" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="TOPID">Type Of Payment:</label>
                        <select class="form-control" name="TOPID" required>
                            <?php $__currentLoopData = $debtors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($d->PmntID); ?>"><?php echo e($d->PmntDesc); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="colID">Collector's Name:</label>

                        <select class="form-control" name="colID" required>
                            <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->ColID); ?>" <?php if($s->ColID == $selected[0]->ColID): ?> selected <?php endif; ?>><?php echo e($s->CLastName); ?>  <?php echo e($s->CFirstName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

            </div>


            <br><br>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Save">
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function calculate(){
            var paymentReceived=$('#paymentReceived').val();
            var AgencyGross=$('#AgencyGross').val();
            var NetClient=parseFloat(paymentReceived)-parseFloat(AgencyGross);
            $('#NetClient').val(NetClient);
            $('#AgencyNet').val(AgencyGross);
            $('#Gross').val(paymentReceived+AgencyGross);
            //•	Payment Received – Agency Gross = Net Client
            //•	Agency Gross = Agency Net
            //•	Payment Received + Agency Gross = Gross
            //$('#a').val(0);
        }

        $(function(){
            var now = new Date();

            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

            $('input[type=date]').val(today);
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

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>