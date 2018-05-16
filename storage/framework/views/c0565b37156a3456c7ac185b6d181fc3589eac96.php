<?php $__env->startSection('content'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="Creditor">Creditor</a></li>
            <li class="breadcrumb-item active"><?php echo e(Session::get('creditorID')); ?></li>
        </ol>


        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Contacts</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddContact" class="btn btn-info align pull-right" role="button">Add Contact</a>
            </div>
        </div>

        <hr>

        <?php if(count($contacts) > 0 || Request::input('searchContact') != ""): ?>
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="searchContact" value="<?php echo e(Request::input('searchContact')); ?>" placeholder="Search Contacts" >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php if(count($contacts) > 0): ?>

            <table class="table table-striped task-table">
                <thead>
                <th>Client Name</th>
                <th>Person Name</th>
                <th>Address</th>
                <th></th>
                </thead>
                <tbody>
                <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="table-text" >
                            <div><?php echo e($contact->ClientName); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($contact->Saltnt); ?> <?php echo e($contact->CFirstName); ?> <?php echo e($contact->CLastName); ?></div>
                        </td>
                        <td class="table-text flex" >
                            <div><?php echo e($contact->Street); ?>, <?php echo e($contact->City); ?>, <?php echo e($contact->State); ?> (<?php echo e($contact->Zip); ?>)</div>
                        </td>
                        <td class="pull-right">
                           <form action="/EditContact/<?php echo e($contact->ContactID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                               <?php echo e(csrf_field()); ?>

                           </form>
                           <form action="/DelContact/<?php echo e($contact->ContactID); ?>" method="post" class="inline">
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
                Currently no contacts available !
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>