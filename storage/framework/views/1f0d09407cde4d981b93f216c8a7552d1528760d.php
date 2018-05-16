<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Invoice</title>

    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/print.css')); ?>" rel="stylesheet">

<style type="text/css">
    body
    {
        font-family: "Times New Roman", Times, serif;
    }
</style>

</head>

<body>
<?php if($trustActivity != null): ?>
<div id="page-wrap">

    <textarea id="header">INVOICE</textarea>

    <div id="identity">
		
            <div id="address">
                <?php echo e($creditor->ClientName); ?><br>
                Att : <?php echo e($contact->CFirstName); ?> <?php echo e($contact->CLastName); ?><br>
                <?php echo e($creditor->Street); ?><br>
                <?php echo e($creditor->City); ?>, <?php echo e($creditor->State); ?> <?php echo e($creditor->Zip); ?>

					


            </div>

    </div>

            <div style="clear:both"></div>

            <div id="customer">


                <table id="meta">
                    <tr>
                        <td class="meta-head">Debtor:</td>
                        <td><?php echo e($debtor->DebtorName); ?></td>
                    </tr>
                    <tr>

                        <td class="meta-head">Client Acc:</td>
                        <td><?php echo e($debtor->ClientAcntNumber); ?></td>
                    </tr>
                    <tr>
                        <td class="meta-head">Amount Due</td>
                        <td><div class="due">$<?php echo e(number_format ($total,2)); ?></div></td>
                    </tr>
                    <tr>
                        <td class="meta-head">Invoice Number</td>
                        <td><div class="due"><?php echo e($trustActivity->InvoiceNumb); ?></div></td>
                    </tr>
                </table>

            </div>

            <table id="items">

                <tr>
                    <th>DT Reported</th>
                    <th>Amount Collected</th>
                    <th>Rate</th>
                    <th>Commission Due</th>
                </tr>


                <tr class="item-row">
                    <td class="item-name"><div class="delete-wpr"><?php echo e(Carbon\Carbon::parse($trustActivity->InvDate)->format('m/d/Y')); ?></div></td>
            <td class="description">$<?php echo e(number_format($trustActivity->Fee1Balance,2)); ?></td>
            <td><?php echo e($trustActivity->InvLbl); ?></td>
            <td>$<?php echo e(number_format($trustActivity->Fee1,2)); ?></td>
        </tr>


    </table>

    <div id="terms">
        <h5>Terms</h5>
        <div>NO STATEMENT ISSUED - -  PLEASE PAY FROM INVOICE
PLEASE INDICATE INVOICE NUMBER ON  YOUR REMITTANCE. THANK YOU <br>
        <?php echo e($trustActivity->InvText); ?>

        </div>
    </div>

</div>
    <?php else: ?>
    <div id="terms">

        <div>No Invoice Found</div>
    </div>
<?php endif; ?>
</body>

</html>