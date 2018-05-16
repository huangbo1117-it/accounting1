<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Payment Type</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddPaymentType" class="btn btn-info align pull-right" role="button">Add Payment Type</a>
            </div>
        </div>

        <hr>

        <?php if(count($paymenttype) > 0 || Request::input('searchPaymentType') != ""): ?>
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="searchPaymentType" value="<?php echo e(Request::input('searchPaymentType')); ?>" placeholder="Search Payment Type" >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php if(count($paymenttype) > 0): ?>

            <table class="table table-striped task-table">
                <thead>
                <th>Payment Type ID</th>
                <th>Payment Type Description</th>
                <th></th>
                </thead>
                <tbody>
                <?php $__currentLoopData = $paymenttype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ptype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                         <td class="table-text" >
                            <div><?php echo e($ptype->PmntID); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($ptype->PmntDesc); ?></div>
                        </td>
                        <td class="pull-right">
                           <form action="/EditPaymentType/<?php echo e($ptype->PmntID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                               <?php echo e(csrf_field()); ?>

                           </form>
                           <form action="/DelPaymentType/<?php echo e($ptype->PmntID); ?>" method="post" class="inline">
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
                Currently no payment type available !
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>