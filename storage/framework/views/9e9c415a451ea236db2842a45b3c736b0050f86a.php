<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Template:</h1>
            </div>
            <div class="col-md-2 ">
                <a href="/AddTemplate" class="btn btn-info align pull-right" role="button">Add Template</a>
            </div>

        </div>

        <hr>



        <?php if(count($parms) > 0): ?>

            <table class="table table-striped task-table">
                <thead>
                <th>Template ID</th>
                <th>Template Name</th>
                <th>Date Time</th>
                </thead>
                <tbody>
                <?php $__currentLoopData = $parms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="table-text" >
                            <div><?php echo e($cd->TemplateID); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($cd->Name); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($cd->updated_at); ?></div>
                        </td>

                        <td class="pull-right">
                            <form action="/EditTemplate/<?php echo e($cd->TemplateID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                <?php echo e(csrf_field()); ?>

                            </form>
                            <form action="/DelTemplate/<?php echo e($cd->TemplateID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-warning">Del</button>
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