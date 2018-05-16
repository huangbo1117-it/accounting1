<?php $__env->startSection('content'); ?>
    <link href="<?php echo e(asset('kendo/css/kendo.common-material.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('kendo/css/kendo.material.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('kendo/css/kendo.material.mobile.min.css')); ?>" rel="stylesheet">

    <div class="container">
        <h3>Invoice Report</h3>
        <div name="form" >
            <?php echo e(csrf_field()); ?>

            <div class="row">

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="colID">Report Type:</label>

                        <select class="form-control" name="ReportType" id="ReportType" onchange="onSelection(this);" required>
                            <option value="2">Invoices by Date</option>
                            <option value="6">Invoices by Account #</option>
                            <option value="7">Invoices by Debtor</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2" hidden>
                    <div class="form-group">
                        <label for="colID">Invoice Status:</label>

                        <select class="form-control" name="InvoiceStatus" id="InvoiceStatus" required>
                            <option value="1">All</option>
                            <option value="2">Paid</option>
                            <option value="3">Un-paid</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-2" id="CollectorDiv" hidden>
                    <div class="form-group">
                        <label for="colID">Collector:</label>

                        <select class="form-control" name="colID" id="colID" >
                            <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->ColID); ?>"><?php echo e($s->CLastName); ?>  <?php echo e($s->CFirstName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2" id="SalesDiv" hidden>
                    <div class="form-group">
                        <label for="colID">Sales:</label>
                        <select class="form-control" name="SaleID" id="SaleID" >

                            <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->SalesID); ?>"><?php echo e($s->SLastName); ?>  <?php echo e($s->SFirstName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="colID">Start Date:</label>
                        <input type="Date" name="sDate" id="sDate" class="form-control">

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="colID">End Date:</label>
                        <input type="Date" name="eDate" id="eDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-3" id="CreditorDiv" hidden>
                    <div class="form-group">
                        <label for="colID">Account #:</label>
                        <input type="text" name="CreditorID" id="CreditorID" class="form-control">
                    </div>
                </div>
                <div class="col-md-3" id="DebtorDiv" hidden>
                    <div class="form-group">
                        <label for="colID">Debtor ID:</label>
                        <input type="text" name="DebtorID" id="DebtorID" class="form-control">
                    </div>
                </div>
                <div class="col-md-2 pull-right">
                    <br>
                    <button class="form-control btn btn-primary" id="Exports" value="Export">Show Data</button>
                </div>
            </div>

        </div>

    </div>
    <div class="container">
        <i class="fa fa-spinner fa-spin" style="font-size:50px" id="loader"></i>
        <div id="grid" >

        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
    <style>
        /* Page Template for the exported PDF */
        .page-template {
            font-family: "DejaVu Sans", "Arial", sans-serif;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .page-template .header {
            position: absolute;
            top: 30px !important;
            left: 30px;
            right: 30px;
            border-bottom: 1px solid #888;
            color: #888;
        }
        .page-template .footer {
            position: absolute;
            bottom: 30px;
            left: 30px;
            right: 30px;
            border-top: 1px solid #888;
            text-align: center;
            color: #888;
        }
        .page-template .watermark {
            font-weight: bold;
            font-size: 400%;
            text-align: center;
            margin-top: 30%;
            color: #aaaaaa;
            opacity: 0.1;
            transform: rotate(-35deg) scale(1.7, 1.5);
        }

        /* Content styling */
        .customer-photo {
            display: inline-block;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-size: 32px 35px;
            background-position: center center;
            vertical-align: middle;
            line-height: 32px;
            box-shadow: inset 0 0 1px #999, inset 0 0 10px rgba(0,0,0,.2);
            margin-left: 5px;
        }
        kendo-pdf-document .customer-photo {
            border: 1px solid #dedede;
        }
        .customer-name {
            display: inline-block;
            vertical-align: middle;
            line-height: 32px;
            padding-left: 3px;
        }
    </style>
    <script src="<?php echo e(asset('kendo/js/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('kendo/js/kendo.all.min.js')); ?>"></script>
    <script>
        /*
            This demo renders the grid in "DejaVu Sans" font family, which is
            declared in kendo.common.css. It also declares the paths to the
            fonts below using <tt>kendo.pdf.defineFont</tt>, because the
            stylesheet is hosted on a different domain.
        */
        kendo.pdf.defineFont({
            "DejaVu Sans"             : "<?php echo e(asset('kendo/fonts/DejaVuSans.ttf')); ?>",
            "DejaVu Sans|Bold"        : "<?php echo e(asset('kendo/fonts/DejaVuSans-Bold.ttf')); ?>",
            "DejaVu Sans|Bold|Italic" : "<?php echo e(asset('kendo/fonts/DejaVuSans-Oblique.ttf')); ?>",
            "DejaVu Sans|Italic"      : "<?php echo e(asset('kendo/fonts/DejaVuSans-Oblique.ttf')); ?>",
            "WebComponentsIcons"      : "<?php echo e(asset('kendo/fonts/WebComponentsIcons.ttf')); ?>"
        });
    </script>
    <script src="<?php echo e(asset('kendo/js/pako_deflate.min.js')); ?>"></script>
    <script>
        function onSelection(e){
            console.log($('#ReportType').val());
            var rpt=$('#ReportType').val();
            if (parseInt(rpt) !==1){
                $('#sDate').attr('required','required')
                $('#eDate').attr('required','required')
            }else{
                $('#sDate').removeAttr('required')
                $('#eDate').removeAttr('required')
            }

            if (parseInt(rpt) ==6){
                $('#CreditorDiv').show();
                $('#CollectorDiv').hide();
                $('#SalesDiv').hide();
            }else{
                $('#CreditorDiv').hide();
                $('#CollectorDiv').hide();
                $('#SalesDiv').hide();
            }
            if (parseInt(rpt) ==7){
                $('#DebtorDiv').show();
                $('#CollectorDiv').hide();
                $('#SalesDiv').hide();
            }else{
                $('#DebtorDiv').hide();
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#loader').hide()
            $('#Exports').click(function(){
                var headerName='Invoice Report';
                var rpt=$('#ReportType').val();
                if (parseInt(rpt) !==1){
                    if($('#sDate').val() ==''){
                        alert('Enter Start Date');
                        return;
                    }
                    if($('#eDate').val() ==''){
                        alert('Enter End Date');
                        return;
                    }

                }

                if (parseInt(rpt) ==6){
                    if($('#CreditorID').val() ==''){
                        alert('Enter Account #');
                        return;
                    }else{
                        headerName +=' '+$('#CreditorID option:selected').text().trim();
                    }
                }
                $('#loader').show()
                var token=$('input[name=_token]').val();
                $.ajax({
                    type: 'POST',
                    data: {
                        ReportType:rpt,
                        sDate:$('#sDate').val(),
                        eDate:$('#eDate').val(),
                        colID:$('#colID').val(),
                        SaleID:$('#SaleID').val(),
                        DebtorID:$('#DebtorID').val(),
                        CreditorID:$('#CreditorID').val(),
                        InvoiceStatus:$('#InvoiceStatus').val(),
                        Creditor:$('#CreditorDropDown').val(),
                        _token:token,
                    },
                    success: function(data) {
                        if(rpt == 3){
                            var dbFields=[
                                { field: "SumOfCollected", title: "Sum Of Collected" },
                                { field: "SumOfDueInv", title: "Sum Of Due Inv" },
                                { field: "CountOfInvoiceNumb", title: "Count Of Invoice#"},
                                { field: "Paid", title: "Paid"},

                            ];
                            var dsFields={
                                SumOfCollected: { type: "string" },
                                SumOfDueInv: { type: "string" },
                                CountOfInvoiceNumb: { type: "string" },
                                Paid: { type: "string" },
                            };
                            data.forEach(function(e){

                                e.SumOfCollected=CurrencyFormat( e.SumOfCollected);
                                e.SumOfDueInv=CurrencyFormat( e.SumOfDueInv);
                            });
                        }else{
                            var dbFields=[
                                { field: "InvDate", title: "Inv Date" },
                                { field: "PaidDate", title: "Paid Date" },
                                { field: "CreditorID", title: "Client ID"},
                                { field: "DebtorID", title: "Debtor ID"},
                                { field: "DebtorName", title: "Debtor Name" },
                                { field: "InvoiceNumb", title: "Invoice#", },
                                { field: "Collected", title: "Collected",},
                                { field: "DueInv", title: "Net Fees",}
                            ];
                            var dsFields={
                                InvDate: { type: "string" },
                                PaidDate: { type: "string" },
                                CreditorID: { type: "string" },
                                DebtorID: { type: "string" },
                                DebtorName: { type: "string" },
                                InvoiceNumb: { type: "string" },
                                Collected: { type: "string" },
                                DueInv: { type: "string" },
                            };
                            var Collected =0;
                            var DueInv =0;
                            if(data.length>0){
                                data.forEach(function(e){
                                    Collected+= e.Collected;
                                    DueInv+= e.DueInv;
                                    var OpenDate = new Date(e.InvDate);var dd = OpenDate.getDate();var mm = OpenDate.getMonth()+1; //January is 0!
                                    var yyyy = OpenDate.getFullYear();
                                    if(dd<10){dd='0'+dd;}
                                    if(mm<10){mm='0'+mm;}
                                    var OpenDate1 = mm+'/'+dd+'/'+yyyy;
                                    e.InvDate=OpenDate1;
                                    if(e.PaidDate != null){
                                        var OpenDate = new Date(e.PaidDate);var dd = OpenDate.getDate();var mm = OpenDate.getMonth()+1; //January is 0!
                                        var yyyy = OpenDate.getFullYear();
                                        if(dd<10){dd='0'+dd;}
                                        if(mm<10){mm='0'+mm;}
                                        var OpenDate1 = mm+'/'+dd+'/'+yyyy;
                                        e.PaidDate=OpenDate1;
                                    }
                                    e.Collected=CurrencyFormat( e.Collected);
                                    e.DueInv=CurrencyFormat( e.DueInv);
                                });
                            }

                            var obj={
                                InvDate:'',
                                PaidDate:'',
                                CreditorID:'',
                                DebtorID:'',
                                DebtorName:'',
                                InvoiceNumb:'',
                                Collected:CurrencyFormat(Collected),
                                DueInv:CurrencyFormat(DueInv),
                            };
                            data.push(obj);
                        }
                        //showGrid(data,dbFields);
                        kendoGrid(data,headerName,dbFields,dsFields);
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });

        });
        function showGrid(gridData,dbFields){
            $('#loader').hide()
            $("#grid").empty();
            $("#grid").shieldGrid({
                dataSource: {
                    data: gridData
                },
                sorting:{
                    multiple: false,
                    allowUnsort: false
                },
                paging: {
                    pageSize: 20,
                    pageLinksCount: 10
                },
                columns: dbFields,
                toolbar: [
                    {
                        buttons: [
                            {
                                commandName: "pdf",
                                caption: '<span class="sui-sprite sui-grid-icon-export-pdf"></span> <span class="sui-grid-button-text">Export to PDF</span>'
                            },{
                                commandName: "csv",
                                caption: '<span class="sui-sprite sui-grid-icon-export-csv"></span> <span class="sui-grid-button-text">Export to CSV</span>'
                            }
                        ]
                    }
                ],
                exportOptions: {
                    proxy: "/filesaver/save",
                    pdf: {
                        fileName: "Debtor-Report",
                        author: "Inam ul haq",
                        dataSource: {
                            data: gridData
                        },
                        readDataSource: true,
                        header: {
                            cells: dbFields
                        }
                    },
                    csv: {
                        fileName: "Debtor-Report",
                        dataSource: {
                            data: gridData
                        },
                        readDataSource: true
                    }
                }
            });
        }
        function kendoGrid(data,headerName,dbFields,dsFields) {
            $('#loader').hide()
            $("#grid").empty();
            $("#grid").kendoGrid({
                toolbar: ["pdf","excel"],
                excel: {
                    fileName: "InvoiceReport.xlsx",
                    proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                    filterable: true,
                    allPages: true
                },
                pdf: {
                    fileName: "InvoiceReport.pdf",
                    allPages: true,
                    avoidLinks: true,
                    paperSize: "A4",
                    margin: { top: "2cm", left: "1cm", right: "1cm", bottom: "1cm" },
                    landscape: true,
                    repeatHeaders: true,
                    template:'<div class="page-template">\n' +
                    '            <div class="header">\n' + headerName +
                    '            </div>\n' +
                    '            <div class="watermark">CRS</div>\n' +
                    '            <div class="footer">\n' +
                    '                Page #: pageNum # of #: totalPages #\n' +
                    '            </div>\n' +
                    '        </div>',
                    scale: 0.8
                },
                dataSource: {
                    data: data,
                    schema: {
                        model: {
                            fields:dsFields
                        }
                    },
                    pageSize: 20
                },
                height: 550,
                sortable: true,
                pageable: {
                    refresh: true,
                    pageSizes: true,
                    buttonCount: 5
                },
                filterable: {
                    extra: false,
                    operators: {
                        string: {
                            startswith: "Starts with",
                            eq: "Is equal to",
                            neq: "Is not equal to"
                        }
                    }
                },
                columns: dbFields
            });
        }

    </script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>