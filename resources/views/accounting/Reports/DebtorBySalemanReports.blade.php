@extends('layouts.app')

@section('content')
    <link href="{{ asset('kendo/css/kendo.common-material.min.css') }}" rel="stylesheet">
    <link href="{{ asset('kendo/css/kendo.material.min.css') }}" rel="stylesheet">
    <link href="{{ asset('kendo/css/kendo.material.mobile.min.css') }}" rel="stylesheet">

    <div class="container">
        <div class="row">
            <div class="col-md-10">
        <form name="form" >
            {{ csrf_field() }}


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="colID">Report Type:</label>
                        <select class="form-control" name="ReportType" id="ReportType" required onchange="onSelection(this);">
                            <option value="1">All Debtors</option>
                            <option value="2">All Debtors By Date Entered</option>
                            <option value="3">All Debtors By Date Entered < $30,000.00</option>
                            <option value="4">All Debtors By Date Closed</option>
                            <option value="5">All Debtors By Date Closed < $30,000.00</option>
                            <option value="6">All Closed Debtors</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="colID">Start Date:</label>
                        <input type="Date" name="sDate" id="sDate" class="form-control">

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="colID">End Date:</label>
                        <input type="Date" name="eDate" id="eDate" class="form-control">
                    </div>
                </div>



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
@endsection


@section('scripts')
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
    <script src="{{ asset('kendo/js/jszip.min.js') }}"></script>
    <script src="{{ asset('kendo/js/kendo.all.min.js') }}"></script>
    <script>
        /*
            This demo renders the grid in "DejaVu Sans" font family, which is
            declared in kendo.common.css. It also declares the paths to the
            fonts below using <tt>kendo.pdf.defineFont</tt>, because the
            stylesheet is hosted on a different domain.
        */
        kendo.pdf.defineFont({
            "DejaVu Sans"             : "{{ asset('kendo/fonts/DejaVuSans.ttf') }}",
            "DejaVu Sans|Bold"        : "{{ asset('kendo/fonts/DejaVuSans-Bold.ttf') }}",
            "DejaVu Sans|Bold|Italic" : "{{ asset('kendo/fonts/DejaVuSans-Oblique.ttf') }}",
            "DejaVu Sans|Italic"      : "{{ asset('kendo/fonts/DejaVuSans-Oblique.ttf') }}",
            "WebComponentsIcons"      : "{{ asset('kendo/fonts/WebComponentsIcons.ttf') }}"
        });
    </script>
    <script src="{{ asset('kendo/js/pako_deflate.min.js') }}"></script>

    <script>
        function onSelection(e){
            console.log($('#ReportType').val());
            var rpt=$('#ReportType').val();
            if (parseInt(rpt) !==1 && parseInt(rpt) !==6){
                $('#sDate').attr('required','required')
                $('#eDate').attr('required','required')
            }else{
                $('#sDate').removeAttr('required')
                $('#eDate').removeAttr('required')
            }

        }
    </script>



    <script type="text/javascript">
        $(document).ready(function () {
            $('#loader').hide()
            $('#Exports').click(function(){
                var headerName='Debtor By Saleman';

                var rpt=$('#ReportType').val();
                if (parseInt(rpt) !==1 && parseInt(rpt) !==6){
                    if($('#sDate').val() == ''){
                        alert('Enter Start Date');
                        return;
                    }
                    if($('#eDate').val() == ''){
                        alert('Enter End Date');
                        return;
                    }

                }

                $('#loader').show()
                var token=$('input[name=_token]').val();
                $.ajax({
                    type: 'POST',
                    url:'/DebtorBySalemanReports',
                    data: {
                        ReportType:rpt,
                        sDate:$('#sDate').val(),
                        eDate:$('#eDate').val(),
                        _token:token,
                    },
                    success: function(data) {
                        showGrid(data,headerName);


                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });

        });
        function showGrid(gridData,headerName){
            $('#loader').hide()
            $("#grid").empty();
            var dbFields=[

                { field: "DebtorID", title: "Debtor ID" },
                { field: "DebtorName", title: "Debtor Name", },
                { field: "AmountPlaced", title: "Amount Placed", },
                { field: "DateEntered", title: "Date Entered" },
                { field: "StatusDesc", title: "Status Desc" }
            ];
            var dsFields={
                DebtorID: { type: "string" },
                DebtorName: { type: "string" },
                AmountPlaced: { type: "string" },
                DateEntered: { type: "string" },
                StatusDesc: { type: "string" },
            };
            var AmountPlaced =0;

            gridData.forEach(function(e){
                AmountPlaced+= e.AmountPlaced;
               
                e.AmountPlaced=CurrencyFormat( e.AmountPlaced);
                
                var tmp1 = e.DateEntered;
                var dd = tmp1.substring(8,10);
                var mm = tmp1.substring(5,7);
                var yyyy = tmp1.substring(0,4);
                var OpenDate1 = mm+'/'+dd+'/'+yyyy;
                e.DateEntered= OpenDate1;

            });
            var obj={
                CreditorID:'',
                DebtorID:'Total Debtors : '+gridData.length,
                DebtorName:'',
                AmountPlaced:CurrencyFormat(AmountPlaced),
                DateEntered:'',
                StatusDesc:'',
            };
            gridData.push(obj);
          /*  $("#grid").shieldGrid({
                dataSource: {
                    data: gridData,
                    group: [
                        { field: "CreditorID", order: "desc" }
                    ]
                },
                sorting:{
                    multiple: false,
                    allowUnsort: false
                },
                paging: {
                    pageSize: 20,
                    pageLinksCount: 10
                },
                grouping: {
                    showGroupHeader: true,
                    allowDragToGroup: true,
                    message: "Drag a column header here to group by a column"
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
                        fileName: "Debtor-By-Saleman-Report",
                        author: "Inam ul haq",
                        size: "a4",
                        orientation: "landscape",
                        dataSource: {
                            data: gridData
                        },
                        readDataSource: true,
                        header: {
                            cells: [
                                { field: "CreditorID", title: "Creditor ID",width: 60 },
                                { field: "DebtorID", title: "Debtor ID" ,width: 60},
                                { field: "DebtorName", title: "Debtor Name",width: 200 },
                                { field: "AmountPlaced", title: "Amount Placed",width: 80 },
                                { field: "DateEntered", title: "Date Entered" ,width: 80},
                                { field: "StatusDesc", title: "Status Desc" ,width: 200}
                            ]
                        }
                    },
                    csv: {
                        fileName: "Debtor-By-Saleman-Report",
                        dataSource: {
                            data: gridData
                        },
                        readDataSource: true
                    }
                }
            });*/
            kendoGrid(gridData,headerName,dbFields,dsFields);
        }
        function kendoGrid(data,headerName,dbFields,dsFields) {
            $('#loader').hide()
            $("#grid").empty();
            $("#grid").kendoGrid({
                toolbar: ["pdf","excel"],
                excel: {
                    fileName: "DebtorBySalemanReport.xlsx",
                    proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                    filterable: true,
                    allPages: true
                },
                pdf: {
                    fileName: "DebtorBySalemanReport.pdf",
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
@endsection