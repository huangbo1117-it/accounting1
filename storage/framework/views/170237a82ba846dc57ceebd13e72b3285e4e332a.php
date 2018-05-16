<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Collector</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddCollector" class="btn btn-info align pull-right" role="button">Add Collector</a>
            </div>
        </div>

        <hr>

        <?php if(count($collectors) > 0 || Request::input('searchCollector') != ""): ?>
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="searchCollector" value="<?php echo e(Request::input('searchCollector')); ?>" placeholder="Search Collector" >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php if(count($collectors) > 0): ?>

            <table class="table table-striped task-table">
                <thead>
                <th>Collector ID</th>
                <th>Collector Name</th>
                <th>Closing</th>
                <th></th>
                </thead>
                <tbody>
                <?php $__currentLoopData = $collectors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                         <td class="table-text" >
                            <div><?php echo e($collector->ColID); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($collector->CFirstName); ?> <?php echo e($collector->CLastName); ?></div>
                        </td>
                        <td class="table-text flex" >
                            <div><?php echo e($collector->Closing); ?></div>
                        </td>
                        <td class="pull-right">
                           <form action="/EditCollector/<?php echo e($collector->ColID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                               <?php echo e(csrf_field()); ?>

                           </form>
                           <form action="/DelCollector/<?php echo e($collector->ColID); ?>" method="post" class="inline">
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
                Currently no collector available !
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>