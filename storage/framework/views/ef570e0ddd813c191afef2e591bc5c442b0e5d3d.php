<?php $__env->startSection('content'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="Creditor">Creditor</a></li>
            <li class="breadcrumb-item active"><a href= "/Contacts/<?php echo e(Session::get('creditorID')); ?>"><?php echo e(Session::get('creditorID')); ?></a></li>

        </ol>
        <h1>Add New Contact</h1>

        <form name="form" method="post">
            <?php echo e(csrf_field()); ?>

            <div class="form-group">
                <label for="clientName">Client Name:</label>
                <input type="text" class="form-control" name="clientName" required>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sltn">Sltn:</label>
                        <select name="sltn" class="form-control">
                            <option value="Mr.">Mr.</option>
                            <option value="Ms.">Ms.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mFirstName">Manager First Name:</label>
                        <input type="text" class="form-control" name="mFirstName" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mLastName">Manager Last Name:</label>
                        <input type="text" class="form-control" name="mLastName" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="text" class="form-control" name="Email" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" class="form-control" name="street" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" name="city" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="state">State:</label>
                        <input type="text" class="form-control" name="state" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="zip">Zip:</label>
                        <input type="text" class="form-control" name="zip" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control txtboxToFilter" id="Maskphone" name="phone" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ext">Ext:</label>
                        <input type="text" class="form-control txtboxToFilter" id="MaskExt" name="ext" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fax">Fax:</label>
                        <input type="text" class="form-control txtboxToFilter" id="MaskFax" name="fax" >
                    </div>
                </div>

            </div>


            <input type="checkbox" name="mainmanager" value="1" hidden>
            <br><br>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Create New Contact">
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {

            $(".txtboxToFilter").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
            $("#Maskphone").mask("(999) 999-9999");
            $("#MaskFax").mask("(999) 999-9999");
            $("#MaskExt").mask("99999");

        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>