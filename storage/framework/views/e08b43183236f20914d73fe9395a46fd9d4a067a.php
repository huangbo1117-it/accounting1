<?php $__env->startSection('content'); ?>
    <link href="<?php echo e(asset('kendo/css/kendo.common-material.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('kendo/css/kendo.material.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('kendo/css/kendo.material.mobile.min.css')); ?>" rel="stylesheet">

    <div class="container">
        <div class="row">
            <div class="col-md-10">


        <form name="form" method="post" action="/TrustReports" target="_blank">
            <?php echo e(csrf_field()); ?>

            <div id="YearDiv" >
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="colID">Month:</label>

                        <select class="form-control" name="Month" id="Month" required>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="colID">Year:</label>
                        <input type="text" class="form-control" id="Maskphone"  name="Year" required>
                    </div>
                </div>
            </div>
            <div id="DateDiv" hidden>


            <div class="col-md-3"  >
                <div class="form-group">
                    <label for="sDate">Start Date:</label>
                    <input type="Date" name="sDate" id="sDate" class="form-control">

                </div>
            </div>
            <div class="col-md-3"  >
                <div class="form-group">
                    <label for="eDate">End Date:</label>
                    <input type="Date" name="eDate" id="eDate" class="form-control">
                </div>
            </div>
            </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="colID">Report Type:</label>

                        <select class="form-control" name="ReportType" id="ReportType" required onchange="onSelection(this);">

                            <option value="1">All Payment Activity</option>
                            <option value="2">by Collector</option>
                            <option value="3">By Salesman</option>
                            <option value="4">By Creditor</option>
                            <option value="5">By Debtor</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3" id="CollectorDiv" hidden>
                    <div class="form-group">
                        <label for="colID">Collector:</label>

                        <select class="form-control" name="ColID" id="ColID" >
                            <option value="">Select Collector</option>
                            <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->ColID); ?>"><?php echo e($s->CLastName); ?>  <?php echo e($s->CFirstName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3" id="SalesManDiv" hidden>
                    <div class="form-group">
                        <label for="colID">Sales Man:</label>

                        <select class="form-control" name="SalesID" id="SalesID" >
                            <option value="">Select Saleman</option>
                            <?php $__currentLoopData = $saleman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ss->SalesID); ?>"><?php echo e($ss->SLastName); ?>  <?php echo e($ss->SFirstName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3" id="debtorIDDiv" hidden>
                    <div class="form-group">
                        <label for="colID">Debtor ID:</label>
                        <input type="text" class="form-control"   name="DebtorID" id="DebtorID" >
                    </div>
                </div>
                <div class="col-md-3" id="creditorIDDiv" hidden>
                    <div class="form-group">
                        <label for="colID">Creditor ID:</label>

                        <input type="text" class="form-control"  name="CreditorID"  id="CreditorID"  >
                    </div>
                </div>
       <!--     <div class="col-md-6">
                <div class="form-group">
                    <input type="submit" name="view" class="form-control btn btn-primary" value="View Report">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="submit" name="view" class="form-control btn btn-primary" value="Export">
                </div>
            </div>-->
        </form>
            </div>
            <div class="col-md-2 pull-right">
                <br>
                <button class="form-control btn btn-primary" id="Exports" value="Export">Show Data</button>
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
            if (rpt==2){
                $('#CollectorDiv').show();
                $('#ColID').attr('required','required')
            }else{
                $('#ColID').removeAttr('required')
                $('#CollectorDiv').hide();
            }
            if (rpt  == 3 ){
                $('#SalesManDiv').show();
                $('#SalesID').attr('required','required')
            }else{
                $('#SalesID').removeAttr('required')
                $('#SalesManDiv').hide();
            }
            if (rpt  == 5 ){

                $('#debtorIDDiv').show();
                $('#DebtorID').attr('required','required')
            }else{
                $('#DebtorID').removeAttr('required')
                $('#debtorIDDiv').hide();


            }
            if (rpt  == 4 ){

                $('#creditorIDDiv').show();
                $('#CreditorID').attr('required','required')
            }else{
                $('#CreditorID').removeAttr('required')
                $('#creditorIDDiv').hide();
                $('#DateDiv').hide();
            }
            if (rpt  == 4 || rpt  == 5 ){
                $('#DateDiv').show();
                $('#YearDiv').hide();

            }else{
                $('#DateDiv').hide();
                $('#YearDiv').show();
            }
        }
        $(function(){$("#Maskphone").mask("9999");});
    </script>
    <script type="x/kendo-template" id="page-template">
        <div class="page-template">
            <div class="header">
                Multi-page grid with automatic page breaking
            </div>
            <div class="watermark">CRS</div>
            <div class="footer">
                Page #: pageNum # of #: totalPages #
            </div>
        </div>
    </script>
    <script type="text/javascript">
        function convertDoller(amount) {
            if(amount >= 0){
                return '$'+amount.toFixed(2);
            }
            if(amount < 0){
                return '($'+ Math.abs(amount).toFixed(2) +')';
            }
        }
        $(document).ready(function () {
            $('#loader').hide()
            $('#Exports').click(function(){
                var headerName='Trust Report';
                var rpt=$('#ReportType').val();
                if (rpt  == 4 || rpt  == 5 ){
                    if($('#sDate').val() == ''){
                        alert('Enter Start Date');
                        return;
                    }
                    if($('#eDate').val() == ''){
                        alert('Enter End Date');
                        return;
                    }
                }else{
                    if($('#Maskphone').val() == ''){
                        alert('Enter Year');
                        return;
                    }
                }


                if (rpt==2){
                    if($('#ColID').val() == ''){
                        alert('Select Collecter');
                        return;
                    }else{
                        headerName +=' '+$('#ColID option:selected').text().trim();
                    }
                }
                if (rpt  == 3 ){
                    if($('#SalesID').val() == ''){
                        alert('Select Collecter');
                        return;
                    }else{
                        headerName +=' '+$('#SalesID option:selected').text().trim();
                    }
                }
                if (rpt  == 4 ){
                    if($('#CreditorID').val() == ''){
                        alert('Enter Creditor ID');
                        return;
                    }else{
                        headerName +=' '+$('#CreditorID option:selected').text().trim();
                    }
                }
                if (rpt  == 5 ){
                    if($('#DebtorID').val() == ''){
                        alert('Enter Debtor ID');
                        return;
                    }else{
                        headerName +=' '+$('#DebtorID option:selected').text().trim();
                    }
                }
                $('#loader').show()
                var token=$('input[name=_token]').val();
                $.ajax({
                    type: 'POST',
                    data: {
                        ReportType:rpt,
                        Month:$('#Month').val(),
                        Year:$('#Maskphone').val(),
                        ColID:$('#ColID').val(),
                        SalesID:$('#SalesID').val(),
                        CreditorID:$('#CreditorID').val(),
                        DebtorID:$('#DebtorID').val(),
                        sDate:$('#sDate').val(),
                        eDate:$('#eDate').val(),
                        _token:token,
                    },
                    success: function(data) {

                            var dbFields=[
                                { field: "DateRcvd", title: "Dt Rec" },
                                { field: "CheckNumb", title: "Check #" },
                                { field: "DebtorName", title: "Debtor Name"},
                                { field: "ClientAcntNumber", title: "Account#"},
                                { field: "NetClient", title: "Gross Rec" },
                                { field: "AgencyNet", title: "Agency Net" },
                                { field: "RelDate", title: "Rel Date" },
                            ];
                            var dsFields={
                                DateRcvd: { type: "string" },
                                CheckNumb: { type: "string" },
                                DebtorName: { type: "string" },
                                ClientAcntNumber: { type: "string" },
                                NetClient: { type: "string" },
                                AgencyNet: { type: "string" },
                                RelDate: { type: "string" },
                            };
                        var NetClient=0;
                        var AgencyNet=0;
                        data.forEach(function(e){
                            NetClient+= e.NetClient;
                            AgencyNet+= e.AgencyNet;                            
                            
                            var tmp1 = e.DateRcvd;
                            var dd = tmp1.substring(8,10);
                            var mm = tmp1.substring(5,7);
                            var yyyy = tmp1.substring(0,4);
                            var OpenDate1 = mm+'/'+dd+'/'+yyyy;
                            e.DateRcvd=OpenDate1;

                                var tmp1 = e.RelDate;
                                dd = tmp1.substring(8,10);
                                mm = tmp1.substring(5,7);
                                yyyy = tmp1.substring(0,4);
                                var OpenDate1 = mm+'/'+dd+'/'+yyyy;
                                e.RelDate=OpenDate1;

                            e.AgencyNet=CurrencyFormat(e.AgencyNet);
                            e.NetClient=CurrencyFormat(e.NetClient);
                        });
                        var obj={
                            DateRcvd:'',
                            CheckNumb:'',
                            DebtorName:'Count : '+data.length,
                            CreditorID:'',
                            NetClient:CurrencyFormat(NetClient),
                            AgencyNet:CurrencyFormat(AgencyNet),
                            RelDate:''
                        };
                        data.push(obj);
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
                paging: {
                    pageSize: 20,
                    pageLinksCount: 10
                },
                sorting:{
                    multiple: false,
                    allowUnsort: false
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
                        fileName: "Creditor-Report",
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
                        fileName: "Creditor-Report",
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
                    fileName: "TrustReport.xlsx",
                    proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                    filterable: true,
                    allPages: true
                },
                pdf: {
                    fileName: "TrustReport.pdf",
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
                columns: dbFields
            });
        }
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>