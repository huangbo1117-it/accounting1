<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Status</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddStatus" class="btn btn-info align pull-right" role="button">Add Status</a>
            </div>
        </div>

        <hr>

        <?php if(count($status) > 0 || Request::input('searchStatus') != ""): ?>
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="searchStatus" value="<?php echo e(Request::input('searchStatus')); ?>" placeholder="Search Status" >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <?php if(count($status) > 0): ?>

            <table class="table table-striped task-table">
                <thead>
                <th>Status ID</th>
                <th>Status Description</th>
                <th></th>
                </thead>
                <tbody>
                <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                         <td class="table-text" >
                            <div><?php echo e($st->StatusID); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($st->StatusDesc); ?></div>
                        </td>
                        <td class="pull-right">
                           <form action="/EditStatus/<?php echo e($st->StatusID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                               <?php echo e(csrf_field()); ?>

                           </form>
                           <form action="/DelStatus/<?php echo e($st->StatusID); ?>" method="post" class="inline">
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
                Currently no status available !
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>