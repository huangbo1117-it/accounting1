<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-8">
                <h1>Manage Debtor</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddDebtor" class="btn btn-info align pull-right" role="button">Add Debtor</a>
            </div>
            <div class="col-md-2 ">
                <form name="form" method="get" target="_blank">

                    <input type="submit" class="btn btn-primary" name="Export" value="Export Data" >
                </form>
            </div>
        </div>

        <hr>

        <?php if(count($debtor) > 0 || Request::input('searchCreditor') != ""): ?>
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-5"></div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="searchCreditor" value="<?php echo e(Request::input('searchCreditor')); ?>" placeholder="Search Debtor By DebtorName | F Name | L Name | Account No. | Adress" >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>


        <?php if(count($debtor) > 0): ?>

            <table class="table table-striped task-table">
                <thead>
                <th>Debtor ID</th>
                <th>Debtor Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th></th>
                </thead>
                <tbody>
                <?php $__currentLoopData = $debtor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="table-text" >
                            <div><a href="/EditDebtor/<?php echo e($cd->DebtorID); ?>" target="_blank"><?php echo e($cd->DebtorID); ?></a></div>
                        </td>
                        <td class="table-text" >
                            <div><a href="/EditDebtor/<?php echo e($cd->DebtorID); ?>" target="_blank"><?php echo e($cd->DebtorName); ?></a></div>
                        </td>

                        <td class="table-text" >
                            <div><?php echo e($cd->DFirstName); ?></div>
                        </td>
                        <td class="table-text" >
                            <div><?php echo e($cd->DLastName); ?></div>
                        </td>

                        <td class="pull-right">
                            <form action="/TrustAccount/<?php echo e($cd->DebtorID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Trust Account</button>
                                <?php echo e(csrf_field()); ?>

                            </form>
                            <form action="/Invoices/<?php echo e($cd->DebtorID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Invoices</button>
                                <?php echo e(csrf_field()); ?>

                            </form>
                        <!--   <form action="/Letters/<?php echo e($cd->DebtorID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary" hidden>Letters</button>
                                <?php echo e(csrf_field()); ?>

                            </form>-->
                            <form action="/EditDebtor/<?php echo e($cd->DebtorID); ?>" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                <?php echo e(csrf_field()); ?>

                            </form>
                            <form action="/DelDebtor/<?php echo e($cd->DebtorID); ?>" method="post" class="inline">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                <?php echo e(csrf_field()); ?>

                            </form>
                            <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getContactName(<?php echo e($cd->DebtorID); ?>)" data-target="#myModal">View</button>
                           <!-- <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getContactName(<?php echo e($cd); ?>)" data-target="#exampleModal">
                                View
                            </button>-->
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php echo e($debtor->links()); ?>

        <?php else: ?>
            <br>
            <div class = "alert alert-danger">
                Currently no Debtor available !
            </div>
        <?php endif; ?>

    </div>
    <div id="myModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Debtor Information</h4>
                </div>
                <div class="modal-body">
                    <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        function getContactName(e){
            console.log(e);
            // $.ajax({url: "./GetContact", success: function(result){
            //     console.log(result);
            // }});
           /* $('#creditorID2').val(e.value);
            $('#creditorID').val(e.value);
            $('#creditorContactName').empty();*/

            $.ajax({
                url: './/EditDebtor/'+e,
                type: 'GET',
                success: function(response)
                {
                    console.log(response);
                    var el =$(response);
                    var found =$('#viewDetail ',el);
                    console.log(found);
                    $('.modal-body').empty().append(found);
                    $( "select" ).attr('disabled','disabled')
                    $( ".modal-body input" ).attr('disabled','disabled')
                    var token=$('input[name=_token]').val();
                    $.ajax({
                        type: 'GET',
                        url:'/calculationDebit/'+$('input[name=debtorID]').val(),
                        data:{
                            _token:token
                        },
                        success: function(data) {
                            var obj = data;
                            var placed = parseFloat($('input[name=amountPlaced]').val().replace(',',''));
                            var costRecover =parseFloat($('input[name=costRecover]').val());
                            var suitFee =parseFloat($('input[name=suitFee]').val());
                            var fees =parseFloat($('input[name=fees]').val());
                            placed-=parseFloat(obj.pending);
                            costRecover+=parseFloat(obj.CostRecoveredVal);
                            suitFee+=parseFloat(obj.MISCFeeTrustVal);
                            fees+=parseFloat(obj.FeesVal);

                            $('input[name=balanceDue]').val(placed.toFixed(2));
                            $('input[name=costRecover]').val(costRecover.toFixed(2));
                            $('input[name=suitFee]').val(suitFee.toFixed(2));
                            $('input[name=fees]').val(fees.toFixed(2));
                        },
                        error: function(data) {
                            console.log("unsuccessful");
                        }
                    });
                }
            });
        }
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>