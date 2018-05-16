<?php $__env->startSection('content'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="../Creditor">Creditor</a></li>
            <li class="breadcrumb-item active"><a href="../Contact"><?php echo e(Session::get('creditorID')); ?></a></li>
            <li class="breadcrumb-item active">Edit Contact Information</li>
        </ol>


        <h1>Edit Contact Information</h1>

        <form name="form" method="post">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="updateContactID" value="<?php echo e($contact->ContactID); ?>">
            <div class="form-group">
                <label for="clientName">Client Name:</label>
                <input type="text" class="form-control" name="clientName" required value="<?php echo e($contact->ClientName); ?>">
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sltn">Sltn:</label>
                        <select name="sltn" class="form-control">
                            <option value="Mr." <?php if($contact->Saltnt == 'Mr.'): ?> selected <?php endif; ?>>Mr.</option>
                            <option value="Ms." <?php if($contact->Saltnt == 'Ms.'): ?> selected <?php endif; ?>>Ms.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mFirstName">Manager First Name:</label>
                        <input type="text" class="form-control" name="mFirstName" value="<?php echo e($contact->CFirstName); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mLastName">Manager Last Name:</label>
                        <input type="text" class="form-control" name="mLastName" value="<?php echo e($contact->CLastName); ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="text" class="form-control" value="<?php echo e($contact->Email); ?>" name="Email" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" class="form-control" name="street" value="<?php echo e($contact->Street); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" name="city" value="<?php echo e($contact->City); ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="state">State:</label>
                        <input type="text" class="form-control" name="state" value="<?php echo e($contact->State); ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="zip">Zip:</label>
                        <input type="text" class="form-control" name="zip" value="<?php echo e($contact->Zip); ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo e($contact->Phone); ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ext">Ext:</label>
                        <input type="text" class="form-control" name="ext" value="<?php echo e($contact->Ext); ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fax">Fax:</label>
                        <input type="text" class="form-control" name="fax" value="<?php echo e($contact->Fax); ?>" required>
                    </div>
                </div>

            </div>


            <input type="checkbox" name="mainmanager" value="1" <?php if($contact->MainManager==true): ?> checked <?php endif; ?>> Main Manager
            <br><br>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Update Contact">
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>