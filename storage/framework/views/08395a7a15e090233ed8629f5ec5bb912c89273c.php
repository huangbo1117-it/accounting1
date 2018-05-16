<?php $__env->startSection('content'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor?searchCreditor=<?php echo e($selected[0]->DebtorID); ?>">Debtor-- <?php echo e($selected[0]->DebtorID); ?></a></li>

        </ol>
        <div class="row vertical-align">
            <div class="col-md-8">
                <h1>Manage Invoice : <?php echo e($selected[0]->DebtorName); ?></h1>
            </div>
            <div class="col-md-2 ">
                <a href="../AddCredit/<?php echo e($selected[0]->DebtorID); ?>" class="btn btn-info align pull-right" role="button">Add Credit</a>
            </div>
            <div class="col-md-2 ">
                <form name="form" method="get" target="_blank">

                    <input type="submit" class="btn btn-primary" name="Export" value="Export Data" >
                </form>
            </div>
        </div>

        <hr>



        <?php if(count($debtor) > 0): ?>

            <table class="table table-striped task-table">
                <thead>
                <th>TPayment ID</th>
                <th>Date Received</th>
                <th>Payment Received</th>
                <th>Billed.</th>
                </thead>
                <tbody>
                <?php $__currentLoopData = $debtor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="table-text" >
                            <div><?php echo e($cd->TPaymentID); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($cd->DateRcvd); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($cd->PaymentReceived); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php if($cd->BilledFor == 1): ?> Yes <?php else: ?> NO <?php endif; ?></div>
                        </td>


                        <td class="pull-right">
                            <?php if($cd->BilledFor == 0): ?>
                                        <form action="/AddInvoice/<?php echo e($cd->TPaymentID); ?>" class="inline">
                                        <button type="submit" name="edit" class="btn btn-primary">Bill</button>
                                        <?php echo e(csrf_field()); ?>

                                        </form>
                                    <?php else: ?>
                                        <form action="/ShowInvoice/<?php echo e($cd->TPaymentID); ?>" target="_blank" class="inline">
                                            <button type="submit" name="edit" class="btn btn-primary">Preview</button>
                                            <?php echo e(csrf_field()); ?>

                                        </form>
                                <form action="/EditInvoice/<?php echo e($cd->TPaymentID); ?>" class="inline">
                                    <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                    <?php echo e(csrf_field()); ?>

                                </form>
                            <?php endif; ?>

                                <form action="/DeleteInvoice/<?php echo e($cd->ID); ?>" class="inline">
                                    <input type="hidden" name="IPaymentID" value="<?php echo e($cd->TPaymentID); ?>">
                                    <input type="hidden" name="DebtorID" value="<?php echo e($selected[0]->DebtorID); ?>">
                                    <button type="submit" name="edit" class="btn btn-danger">Delete</button>
                                    <?php echo e(csrf_field()); ?>

                                </form>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <br>
            <div class = "alert alert-danger">
                Currently no Debtor available !
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>