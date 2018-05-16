<?php $__env->startSection('content'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtors</a></li>
            <li class="breadcrumb-item active"><a href="/Debtor?searchCreditor=<?php echo e($selected[0]->DebtorID); ?>"><?php echo e($selected[0]->DebtorID); ?> -- <?php echo e($selected[0]->DebtorName); ?></a></li>
        </ol>
        <div class="row vertical-align">
            <div class="col-md-8">
                <h1>Manage Trust : </h1>
            </div>
            <div class="col-md-2 ">
                <a href="../AddTrustActivity/<?php echo e($selected[0]->DebtorID); ?>" class="btn btn-info align pull-right" role="button">Add Trust Activity</a>
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
                <th>Check No.</th>
                <th>Release Date</th>
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
                            <div><?php echo e($cd->CheckNumb); ?></div>
                        </td>

                        <td class="table-text flex" >
                            <div><?php echo e(Carbon\Carbon::parse($cd->RelDate)->format('Y/m/d')); ?></div>
                        </td>
                        <td class="pull-right">

                            <form action="/EditTrustActivity/<?php echo e($cd->TPaymentID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                <?php echo e(csrf_field()); ?>

                            </form>
                            <form action="/DelTrustActivity/<?php echo e($cd->TPaymentID); ?>" method="post" class="inline">
                                <input type="hidden" name="DebtorID" value="<?php echo e($selected[0]->DebtorID); ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
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
                Currently no Trust Account available !
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>