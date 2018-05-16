<style>

    #exTab3 .nav-pills > li > a {
        border-radius: 4px 4px 0 0 ;
    }

    #exTab3 .tab-content {
        color : white;
        background-color: #a9d8f3;
        padding : 5px 15px;
    }</style>
<link href="<?php echo e(asset('css/jquery-confirm.min.css')); ?>" rel="stylesheet">
<?php $__env->startSection('content'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtor</a></li>
        </ol>
        <?php if($first != null): ?>
            <span style="margin: 5px;"><a href="/EditDebtor/<?php echo e($first); ?>" class="btn btn-info align " role="button">First</a></span>
        <?php endif; ?>
        <?php if($previous != null): ?>
            <span style="margin: 5px;"><a href="/EditDebtor/<?php echo e($previous); ?>" class="btn btn-info align " role="button">Previous</a></span>
        <?php endif; ?>
        <?php if($Next != null): ?>
            <span style="margin: 5px;">     <a href="/EditDebtor/<?php echo e($Next); ?>" class="btn btn-info align " role="button">Next</a></span>
        <?php endif; ?>
        <?php if($last != null): ?>
            <span style="margin: 5px;">     <a href="/EditDebtor/<?php echo e($last); ?>" class="btn btn-info align " role="button">Last</a></span>
        <?php endif; ?>
        <h4>Update Debtor</h4>
        <div id="exTab3" class="container">
            <ul  class="nav nav-pills">
                <li class="active">
                    <a  href="#1b" data-toggle="tab">Debtor Detail</a>
                </li>
                <li><a href="#2b" data-toggle="tab">Debtor Notes</a>
                </li>
                <li><a href="#3b" data-toggle="tab">Docx Upload</a>
                </li>
                <li><a href="#4b" data-toggle="tab">Letters</a>
                </li>
            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active" id="1b">

                         <form name="form" method="post">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" value="<?php echo e($creditor->DebtorID); ?>" name="updateDebtorID">
            <div id="viewDetail">
            <div class="row">
                <div class="col-md-2" >
                    <div class="form-group">
                        <label for="creditorID">Debtor ID:</label>
                        <input type="text" class="form-control" name="debtorID" value="<?php echo e($creditor->DebtorID); ?>" disabled>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="creditorID">Debtor Name:</label>
                        <input type="text" class="form-control" name="debtorName" value="<?php echo e($creditor->DebtorName); ?>" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="creditorID">Date Entered:</label>
                        <input type="date" class="form-control" name="dateEntered" value="<?php echo e($creditor->DateEntered); ?>" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="creditorID">Salutation:</label>

                        <select class="form-control" name="Salutation" required>
                            <option value="Mr.">Mr.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Dr.">Dr.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">First Name:</label>
                        <input type="text" class="form-control" name="firstName" value="<?php echo e($creditor->DFirstName); ?>" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Last Name:</label>
                        <input type="text" class="form-control" name="lastName" value="<?php echo e($creditor->DLastName); ?>" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="creditorID">Email:</label>
                        <input type="email" class="form-control" name="Email" value="<?php echo e($creditor->Email); ?>" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Street:</label>
                        <input type="text" class="form-control" name="street" value="<?php echo e($creditor->Street); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Country:</label>
                        <input type="text" class="form-control" name="country" value="<?php echo e($creditor->Country); ?>" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">City:</label>
                        <input type="text" class="form-control" name="city" value="<?php echo e($creditor->City); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">State:</label>
                        <input type="text" class="form-control" name="state" value="<?php echo e($creditor->State); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Zip:</label>
                        <input type="text" class="form-control" name="zip" value="<?php echo e($creditor->Zip); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Fax:</label>
                        <input type="text" class="form-control" name="Fax"  value="<?php echo e($creditor->Fax); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Phone:</label>
                        <input type="text" class="form-control" id="Maskphone" name="phone" value="<?php echo e($creditor->Phone); ?>" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Client Account:</label>
                        <input type="text" class="form-control" name="clientAccount" value="<?php echo e($creditor->ClientAcntNumber); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Status ID:</label>

                        <select class="form-control" name="statusID" required>
                            <?php $__currentLoopData = $sm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->StatusID); ?>" <?php if($s->StatusID == $creditor->StatusID): ?> selected <?php endif; ?>><?php echo e($s->StatusDesc); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Attorney:</label>
                        <i class="fa fa-pencil" aria-hidden="true" data-toggle="modal"  data-target="#myModal"></i>
                        <input type="hidden" class="form-control" name="attorneyID" value="<?php if($attorney->attorneyID !=null): ?> <?php echo e($attorney->attorneyID); ?> <?php endif; ?>  ">
                        <input type="text" class="form-control" name="AttorneyName" value="<?php echo e($attorney->AttorneyName); ?>" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Creditor ID:</label>

                        <select class="form-control" name="creditorID2" id="creditorID2" required onchange="getContactName(this)">
                            <option value="">Select Creditor ID</option>
                            <?php $__currentLoopData = $cd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->CreditorID); ?>" <?php if($s->CreditorID == $creditor->CreditorID): ?> selected <?php endif; ?> ><?php echo e($s->CreditorID); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Creditor:</label>

                        <select class="form-control" name="creditorID" id="creditorID" required onchange="getContactName(this)">
                            <option value="">Select Creditor</option>
                            <?php $__currentLoopData = $cd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->CreditorID); ?>" <?php if($s->CreditorID == $creditor->CreditorID): ?> selected <?php endif; ?> ><?php echo e($s->ClientName); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Creditor Contact Name:</label>

                        <select class="form-control" id="creditorContactName" name="creditorContactName" value="<?php echo e($creditor->CreditorID); ?>" required>
                            <?php $__currentLoopData = $contact; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->ContactID); ?>" <?php if($s->ContactID == $creditor->ContactID): ?> selected <?php endif; ?> ><?php echo e($s->CFirstName); ?> <?php echo e($s->CLastName); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Collector's Name:</label>

                        <select class="form-control" name="colID" required>
                            <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->ColID); ?>" <?php if($s->ColID == $creditor->ColID): ?> selected <?php endif; ?>><?php echo e($s->CLastName); ?>  <?php echo e($s->CFirstName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Last Date:</label>
                        <input type="date" class="form-control" name="lastDate" value="<?php echo e($creditor->LastDate); ?>" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Form Date:</label>
                        <input type="date" class="form-control" name="formDate" value="<?php echo e($creditor->FormDate); ?>" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Amount Placed:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="amountPlaced" value="<?php echo e(number_format ($creditor->AmountPlaced,2)); ?>" required>
                    </div></div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Balance Due:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>

                            <input type="text" class="form-control txtboxToFilter" name="balanceDue" value="<?php echo e(floatval($creditor->AmountPlaced) -floatval($pending)); ?>" required>
                        </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Amount Paid:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>

                            <input type="text" class="form-control txtboxToFilter" name="AmountPaid" value="<?php echo e(floatval($pending)); ?>" required>
                        </div></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Cost Advance:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="costAdvance" value="<?php echo e($creditor->CostAdv); ?>" >
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Suit Fee:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="suitFee" value="<?php echo e($creditor->SuitFee + $MISCFeeTrustVal); ?>" >
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Cost Recover:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="costRecover" value="<?php echo e($creditor->CostRec+$CostRecoveredVal); ?>" >
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Fees:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="fees" value="<?php echo e($creditor->Fees+$FeesVal); ?>" >
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="compreport">Last Updated:</label>
                        <input class="form-control" type="date" name="LastUpdate" value="<?php echo e($creditor->LastUpdate); ?>"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="compreport">User Updated:</label>
                        <input class="form-control" name="LastUpdate" value="<?php echo e($creditor->UserUpdated); ?>"/>
                    </div>
                </div>
            </div>
            </div>
            <br><br>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Update Debtor">
            </div>
        </form>

                </div>
                <div class="tab-pane" id="2b">
                    <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ActivityCode">Activity Code:</label>
                            <i aria-hidden="true" onclick="activityCodeUpdate();" data-toggle="modal" data-target="#activityCodeModal" class="fa fa-pencil" title="Edit Activity Code"></i>
                            <i aria-hidden="true" onclick="activityCodeAdd();" data-toggle="modal" data-target="#activityCodeModal" class="fa fa-plus" title="Add Activity Code"></i>
                            <select class="form-control" name="ActivityCode" id="ActivityCode" required>
                                <?php $__currentLoopData = $activityCode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->CodeID); ?>" ><?php echo e($s->Detail); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                        <div class="col-md-1">
                            <button class="btn btn-default align" role="button" id="AddActivityCode">Add Activity Code</button>
                        </div>
                        <div class="col-md-6">

                        </div>
                    <div class="col-md-2 ">

                        <button class="btn btn-default align pull-right" role="button" data-toggle="modal"  data-target="#noteModal">Add Note</button>
                    </div>
                    </div>
                    <div class="row">


                    <?php if(count($notes) > 0): ?>

                        <table class="table table-striped task-table">
                            <thead>
                            <th>Note</th>
                            <th>By</th>
                            <th>TimeStamp</th>
                            <th></th>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="table-text" >
                                        <div><?php echo e($cd->Detail); ?></div>
                                    </td>
                                    <td class="table-text" >
                                        <div><?php echo e($cd->User); ?></div>
                                    </td>
                                    <td class="table-text" >
                                        <div><?php echo e($cd->DateTime); ?></div>
                                    </td>

                                    <td class="pull-right">


                                            <?php echo e(csrf_field()); ?>


                                        <button onclick="noteUpdate('<?php echo $cd->NoteID; ?>','<?php echo $cd->Detail; ?>');" data-toggle="modal"  data-target="#noteModal" name="edit" class="btn btn-primary">Edit</button>
                                            <button onclick="noteDelete('<?php echo $cd->NoteID; ?>','<?php echo $creditor->DebtorID; ?>');" name="delete" class="btn btn-danger noteDlete">Delete</button>


                                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getContactName(<?php echo e($cd); ?>)" data-target="#exampleModal">
                                View
                            </button>-->
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <br>
                        <div class = "alert alert-danger">
                            Currently no notes available
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="tab-pane" id="3b">
                    <div class="row">

                            <form name="form" method="post" action="/UploadFile/<?php echo e($creditor->DebtorID); ?>" enctype="multipart/form-data">
                                <?php echo e(csrf_field()); ?>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Upload File </label>
                                        <input type="file" name="importFile" class="form-control" accept=".xlsx, .xls, .csv">
                                    </div>
                                </div>

                                <br><br>
                                <div class="col-md-2 pull-right">
                                    <div class="form-group">
                                        <input type="submit" name="view" class="form-control btn btn-primary" value="Upload">
                                    </div>
                                </div>
                            </form>
                    </div>
                    <div class="row">


                        <?php if(count($files) > 0): ?>

                            <table class="table table-striped task-table">
                                <thead>
                                <th>File Name</th>
                                <!--<th>Comments</th>-->
                                <th>File size</th>
                                <th>By</th>
                                <th>Upload Date</th>
                                <th>Download</th>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="table-text" >
                                            <div><?php echo e($cd->FileName); ?></div>
                                        </td>
                                        <td class="table-text" >
                                            <div><?php echo e(floatval($cd->Filesize)/1000); ?> KB</div>
                                        </td>
                                        <td class="table-text" >
                                            <div><?php echo e($cd->User); ?></div>
                                        </td>
                                        <td class="table-text" >
                                            <div><?php echo e($cd->created_at); ?></div>
                                        </td>
                                        <td class="table-text">
                                            <a href="/Donwload/<?php echo e($cd->FileID); ?>" class="btn btn-large" target="_blank"><i class="icon-download-alt"> </i> Download  </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <br>
                            <div class = "alert alert-danger">
                                Currently no file uploaded
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="tab-pane" id="4b">
                    <form name="form" method="post" action="/Letters/<?php echo e($creditor->DebtorID); ?>"  target="_blank">
                        <?php echo e(csrf_field()); ?>


                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="colID">Letter Type:</label>

                                    <select class="form-control" name="LetterType" required>

                                        <?php $__currentLoopData = $temp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($s->TemplateID); ?>"><?php echo e($s->Name); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2" >
                                <div class="form-group">
                                    <label for="colID">Export Report:</label>

                                    <select class="form-control" name="Export" id="Export" >
                                        <option value="PDF">PDF</option>
                                        <option value="DOC">MS Word</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="submit" name="view" class="form-control btn btn-primary" value="Export">
                            </div>
                        </div>
                        <div class="col-md-6" hidden>
                            <div class="form-group">
                                <input type="submit" name="view" class="form-control btn btn-primary" value="Export">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Attorney Information</h4>
                </div>
                <div class="modal-body">
                    <form id="attorneyForm">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-3" >
                                <div class="form-group">
                                    <label for="creditorID">Attorney Name:</label>
                                    <input type="hidden" class="form-control" name="AttorneyRequest" value="Yes" >
                                    <input type="hidden" class="form-control" name="updateAttorneyID" value="<?php if($attorney->attorneyID !=null): ?> <?php echo e($attorney->attorneyID); ?> <?php endif; ?>  "  >
                                    <input type="text" class="form-control" name="AttorneyName" value="<?php echo e($attorney->AttorneyName); ?>"  required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Firm Name:</label>
                                    <input type="text" class="form-control" name="FirmName" value="<?php echo e($attorney->FirmName); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Street 1:</label>
                                    <input type="text" class="form-control" name="Street1"value="<?php echo e($attorney->Street1); ?>" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Street 2:</label>
                                    <input type="text" class="form-control" name="Street2"value="<?php echo e($attorney->Street2); ?>" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">City:</label>
                                    <input type="text" class="form-control" name="City" value="<?php echo e($attorney->City); ?>" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">State:</label>
                                    <input type="text" class="form-control" name="State" value="<?php echo e($attorney->State); ?>" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Zip:</label>
                                    <input type="text" class="form-control" name="Zip" value="<?php echo e($attorney->Zip); ?>" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Email:</label>
                                    <input type="email" class="form-control" name="Email" value="<?php echo e($attorney->Email); ?>" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Cell#:</label>
                                    <input type="text" class="form-control" name="Cell" value="<?php echo e($attorney->Cell); ?>" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Phone#:</label>
                                    <input type="text" class="form-control" name="Phone" value="<?php echo e($attorney->Phone); ?>" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Fax#:</label>
                                    <input type="text" class="form-control" name="Fax" value="<?php echo e($attorney->Fax); ?>" >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Website:</label>
                                    <input type="text" class="form-control" name="Website" value="<?php echo e($attorney->Website); ?>" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Bar Number:</label>
                                    <input type="text" class="form-control" name="BarNumber" value="<?php echo e($attorney->BarNumber); ?>" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Representation Capacity:</label>
                                    <input type="text" class="form-control" name="RepresentationCapacity" value="<?php echo e($attorney->RepresentationCapacity); ?>" >
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="attorneyFormSave"  class="btn btn-primary" >Save</button>
                    <form action="/DelAttorney/<?php echo e($creditor->DebtorID); ?>" method="post" class="inline">
                        <input type="hidden" class="form-control" name="ID" value="<?php echo e($attorney->attorneyID); ?>"  >
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        <?php echo e(csrf_field()); ?>

                    </form>

                    <button type="button" id="closeModal" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="noteModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Note Information</h4>
                </div>
                <div class="modal-body">
                    <form id="noteForm">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="creditorID">Note:</label>

                                    <input type="hidden" class="form-control" name="updateNoteID" value=""  >

                                    <textarea class="form-control" name="NoteDetail" required>

                                    </textarea>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="noteFormSave"  class="btn btn-primary" >Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="activityCodeModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Activity Code Information</h4>
                </div>
                <div class="modal-body">
                    <form id="ActivityCodeForm">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="creditorID">Activity Code:</label>

                                    <input type="hidden" class="form-control" name="updateCodeID" value=""  >

                                    <textarea class="form-control" name="CodeDetail" required>

                                    </textarea>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="ActivityCodeFormSave"  class="btn btn-primary" >Save</button>
                    <button type="button" id="ActivityCodeFormDelete"  class="btn btn-warning" >Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script type="text/javascript">
        function getContactName(e){
            // $.ajax({url: "./GetContact", success: function(result){
            //     console.log(result);
            // }});
            $('#creditorID2').val(e.value);
            $('#creditorID').val(e.value);
            $('#creditorContactName').empty();
            $.ajax({
                url: './GetContact',
                type: 'GET',
                data: { id: e.value },
                success: function(response)
                {
                    console.log(response);
                    for(var i=0;i<response.length;i++){
                        $('#creditorContactName').append('<option value="'+ response[i].CreditorID +'">'+ response[i].CFirstName +'  '+ response[i].CLastName +' </option>')
                    }
                }
            });
        }
        $(document).ready(function() {
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
           // $('input[type=date]').val(today);
            $(".txtboxToFilter").change(function (e) {
                console.log();
                $(this).val(CurrencyFormat2(parseFloat($(this).val().replace(',','')).toFixed(2)));
            });
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
            $("#attorneyFormSave").click(function(e) {
                e.preventDefault();
                var aa=$('#attorneyForm').serialize();
                console.log(aa);
                $.ajax({
                    type: 'POST',
                    data: $('#attorneyForm').serialize(),
                    success: function(data) {
                        var ii=data;
                        $('input[name=AttorneyName]').val(ii.AttorneyName);
                        $('input[name=attorneyID]').val(ii.id);
						alert('Data Saved Successfully..');
                        $('#closeModal').click();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });//here
            $("#attorneyFormDelete").click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url:'/DelAttorney',
                    data: {
                        ID:$('input[name=attorneyID]').val(),
                    },
                    success: function(data) {
                        $('input[name=AttorneyName]').val('');
                        $('input[name=attorneyID]').val('');
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });//here
            $("#noteFormSave").click(function(e) {
                e.preventDefault();
                var data = $('#noteForm').serializeArray();
                data.push({name: 'DebtorID', value: $('input[name=updateDebtorID]').val()});
                $.ajax({
                    type: 'POST',
                    url:'/AddNote',
                    data: data,
                    success: function(data) {

                        location.reload();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });//here
            $("#AddActivityCode").click(function(e) {
                e.preventDefault();
                var data = Array();
                var token=$('input[name=_token]').val();
                data.push({name: '_token', value: token});
                data.push({name: 'NoteDetail', value: $('#ActivityCode :selected').text()});
                data.push({name: 'DebtorID', value: $('input[name=updateDebtorID]').val()});
                $.ajax({
                    type: 'POST',
                    url:'/AddNote',
                    data: data,
                    success: function(data) {
                        alert('Note Added...');
                        location.reload();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });//here
            $("#ActivityCodeFormSave").click(function(e) {
                e.preventDefault();
                var data = $('#ActivityCodeForm').serializeArray();
                $.ajax({
                    type: 'POST',
                    url:'/AddActivityCode',
                    data: data,
                    success: function(data) {

                        location.reload();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });
            var token=$('input[name=_token]').val();
            $.ajax({
                type: 'GET',
                url:'/calculationDebit/'+$('input[name=debtorID]').val(),
                data:{
                    _token:token
                },
                success: function(data) {
                    console.log(data);
                    var obj = data;
                    var placed = parseFloat($('input[name=amountPlaced]').val().replace(',',''));
                    var costRecover =parseFloat($('input[name=costRecover]').val().replace(',','')).toFixed(2);
                    var suitFee =parseFloat($('input[name=suitFee]').val().replace(',','')).toFixed(2);
                    var fees =parseFloat($('input[name=fees]').val().replace(',','')).toFixed(2);
                    placed-=parseFloat(obj.pending).toFixed(2);
                    costRecover = parseFloat(costRecover) + parseFloat(obj.CostRecoveredVal).toFixed(2);
                    suitFee+=parseFloat(obj.MISCFeeTrustVal).toFixed(2);
                    fees+=parseFloat(obj.FeesVal).toFixed(2);
                    $('input[name=AmountPaid]').val(parseFloat(obj.pending).toFixed(2));
                    $('input[name=balanceDue]').val(parseFloat(placed).toFixed(2));
                    $('input[name=costRecover]').val(parseFloat(costRecover).toFixed(2));
                    $('input[name=suitFee]').val(parseFloat(suitFee).toFixed(2));
                    $('input[name=fees]').val(parseFloat(fees).toFixed(2));
                },
                error: function(data) {
                    console.log("unsuccessful");
                }
            });

            $("#Maskphone").mask("(999) 999-9999");

        });
        function noteUpdate(id,DebtorID){

            $('input[name=updateNoteID]').val(id);
            $('textarea[name=NoteDetail]').val(DebtorID);
        }

        function activityCodeUpdate(){

            $('input[name=updateCodeID]').val($('#ActivityCode :selected').val());
            $('textarea[name=CodeDetail]').val($('#ActivityCode :selected').text());
            $('#ActivityCodeFormDelete').show();
        }
        function activityCodeAdd(){
            $('input[name=updateCodeID]').val('');
            $('textarea[name=CodeDetail]').val('');
            $('#ActivityCodeFormDelete').hide();
        }
        function noteDelete(id,DebtorID){
            if (confirm('Are you sure you want to delete')) {
                var token=$('input[name=_token]').val();
                $.ajax({
                    type: 'POST',
                    url:'/DelNote/'+DebtorID,
                    data: {
                        ID:id,
                        _token:token,
                    },
                    success: function(data) {
                        alert('Note Deleted..!!')
                        location.reload();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            }
        }

        //aa.replace(/\B(?=(\d{3})+\b)/g, ",").replace(/-(.*)/, "($1)");
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>