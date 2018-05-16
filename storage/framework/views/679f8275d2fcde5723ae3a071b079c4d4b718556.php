<?php $__env->startSection('content'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtor</a></li>

        </ol>
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Invoice : </h1>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-2">
                <span><b>Totel Collected :</b> <?php echo e(number_format($sumOfCollected,2)); ?></span>
            </div>
            <div class="col-md-2">
                <span><b>Totel Due : </b><?php echo e(number_format($sumOfDueInv,2)); ?></span>
            </div>
        </div>

        <?php if(count($data) > 0): ?>

            <table class="table table-striped task-table">
                <thead>
                <th>Inv#</th>
                <th>Inv Date</th>
                <th>Debtor ID</th>
                <th>Collected</th>
                <th>Agency Net</th>
                <th>AttyFee</th>
                <th>Paid Date</th>
                <th>Paid$</th>
                </thead>
                <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="table-text" >
                            <div><?php echo e($cd->InvoiceNumb); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($cd->InvDate); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($cd->DebtorID); ?></div>
                        </td>
                        <td class="table-text" >
                            <div>$<?php echo e(number_format($cd->Collected,2)); ?></div>
                        </td>
                        <td class="table-text" >
                            <div>$<?php echo e(number_format($cd->Fee1,2)); ?></div>
                        </td>
                        <td class="table-text" >
                            <div>$<?php echo e($cd->AttyFees); ?></div>
                        </td>
                        <td class="table-text" >
                            <div></div>
                        </td>
                        <td class="table-text" >
                            <div>$ 0.0</div>
                        </td>
                        <td class="pull-right">

                            <form action="/UnpaidInvoices/<?php echo e($cd->InvoiceNumb); ?>" method="post" class="inline">
                                <input type="hidden" name="DueInv" value="<?php echo e($cd->DueInv); ?>">
                                <button type="submit" name="edit" class="btn btn-primary">Mark As Paid</button>
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
                Currently no Unpaid invoice available !
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>