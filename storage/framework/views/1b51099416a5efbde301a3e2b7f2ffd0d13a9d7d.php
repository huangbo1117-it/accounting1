<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>

                    <div class="panel-body">
                        <form class="form-horizontal" name="form" method="post">
                            <?php echo e(csrf_field()); ?>

                            <input id="name" type="hidden" class="form-control" name="updateUserID" value="<?php echo e($user->id); ?>" required autofocus>
                            <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="<?php echo e($user->name); ?>" required autofocus>

                                    <?php if($errors->has('name')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" disabled name="email" value="<?php echo e($user->email); ?>" required>

                                    <?php if($errors->has('email')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group<?php echo e($errors->has('is_permission') ? ' has-error' : ''); ?>">
                                <label for="email" class="col-md-4 control-label">User Group</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="is_permission" name="is_permission" required>
                                        <option value=""> </option>
                                        <?php $__currentLoopData = $Role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($s->id); ?>" <?php if($s->id == $user->is_permission): ?> selected <?php endif; ?>><?php echo e($s->name); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('is_permission')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('is_permission')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>