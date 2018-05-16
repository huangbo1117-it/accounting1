@extends('layouts.app')

@section('content')
    <link href="{{ asset('kendo/css/kendo.common-material.min.css') }}" rel="stylesheet">
    <link href="{{ asset('kendo/css/kendo.material.min.css') }}" rel="stylesheet">
    <link href="{{ asset('kendo/css/kendo.material.mobile.min.css') }}" rel="stylesheet">

    <div class="container">

        <div class="row">
            <div class="col-md-10">
        <form name="form" method="post"  target="_blank">
            {{ csrf_field() }}

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="colID">SaleMan:</label>

                        <select class="form-control" name="SalesID" id="SalesID">
                            <option value="">All Saleman</option>
                            @foreach( $saleman as $ss)
                                <option value="{{$ss->SalesID}}">{{$ss->SLastName}}  {{$ss->SFirstName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="colID">Report Type:</label>

                        <select class="form-control" name="ReportType" id="ReportType" required onchange="onSelection(this);">
                            <option value="1">All Creditors</option>
                            <option value="2">Creditors By Open Date</option>
                            <option value="3">Creditors By Last Date</option>
                            <option value="4">Creditors For All Salesman</option>
                            <option value="5">All Debtors</option>
                            <option value="6">All Debtors Date Entered</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="colID">Start Date:</label>
                        <input type="Date" name="sDate" id="sDate" class="form-control">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="colID">End Date:</label>
                        <input type="Date" name="eDate" id="eDate" class="form-control">
                    </div>
                </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="CreditorID">Creditor ID:</label>
                    <input type="text" name="CreditorID" id="CreditorID" class="form-control">
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
            if (rpt==2 || rpt==3 || rpt==6){
                $('#sDate').attr('required','required')
                $('#eDate').attr('required','required')
            }else{
                $('#sDate').removeAttr('required')
                $('#eDate').removeAttr('required')
            }
            if (rpt  != 4 ){
                $('#SalesID').attr('required','required')
            }else{
                $('#SalesID').removeAttr('required')
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#loader').hide()
            $('#Exports').click(function(){
                var headerName='Creditor Report';
                var rpt=$('#ReportType').val();
                if (rpt==2 || rpt==3 || rpt==6){
                    if($('#sDate').val() == ''){
                        alert('Enter Start Date');
                        return;
                    }
                    if($('#eDate').val() == ''){
                        alert('Enter End Date');
                        return;
                    }
                }else{
                    $('#sDate').removeAttr('required')
                    $('#eDate').removeAttr('required')
                }
                if (rpt  != 4 ){
                    if($('#SalesID').val() == ''){
                        alert('Select Sales ID');
                        return;
                    }else{
                        headerName +=' '+$('#SalesID option:selected').text().trim();
                    }
                }else{
                    $('#SalesID').removeAttr('required')
                }

                $('#loader').show()
                var token=$('input[name=_token]').val();
                $.ajax({
                    type: 'POST',
                    data: {
                        ReportType:rpt,
                        sDate:$('#sDate').val(),
                        eDate:$('#eDate').val(),
                        SalesID:$('#SalesID').val(),
                        _token:token,
                        CreditorID:$('#CreditorID').val(),
                    },
                    success: function(data) {

                        var cal=[];
                        if(rpt == 4){
                            var dbFields=[
                                { field: "SFirstName", title: "Saleman First Name" },
                                { field: "SLastName", title: "Saleman Last Name" },
                                { field: "CreditorID", title: "Creditor ID"},
                                { field: "ClientName", title: "Client Name"},
                                { field: "Phone", title: "Phone" },
                            ];
                            var dsFields={
                                SFirstName: { type: "string" },
                                SLastName: { type: "string" },
                                CreditorID: { type: "string" },
                                ClientName: { type: "string" },
                                Phone: { type: "string" },
                            };
                        }
                       else if(rpt == 5 || rpt == 6){
                            var dbFields=[
                                { field: "DebtorName", title: "Debtor Name" },
                                { field: "DateEntered", title: "Date PL" },
                                { field: "CreditorID", title: "Creditor"},
                                { field: "AmountPlaced", title: "Amount Pl"},
                                { field: "AmountPd", title: "Amount Pd" },
                                { field: "BalanceDue", title: "Balance Due" },
                                { field: "StatusID", title: "Status ID" },
                                { field: "ColID", title: "Col ID" },
                            ];
                            var dsFields={
                                DebtorName: { type: "string" },
                                DateEntered: { type: "string" },
                                CreditorID: { type: "string" },
                                AmountPlaced: { type: "string" },
                                AmountPd: { type: "string" },
                                BalanceDue: { type: "string" },
                                StatusID: { type: "string" },
                                ColID: { type: "string" },
                            };
                             cal=[
                                { field: "AmountPlaced", aggregate: "sum" },
                            ]
                            var AmountPlaced =0;
                            var AmountPd =0;
                            var BalanceDue =0;
                            data.forEach(function(e){
                                AmountPlaced+= e.AmountPlaced;
                                AmountPd+= e.AmountPd;
                                BalanceDue+= e.BalanceDue;

                                var OpenDate = new Date(e.DateEntered);var dd = OpenDate.getDate();var mm = OpenDate.getMonth()+1; //January is 0!
                                var yyyy = OpenDate.getFullYear();
                                if(dd<10){dd='0'+dd;}
                                if(mm<10){mm='0'+mm;}
                                var OpenDate1 = dd+'/'+mm+'/'+yyyy;

                                e.AmountPlaced=CurrencyFormat(e.AmountPlaced);
                                e.AmountPd=CurrencyFormat( e.AmountPd);
                                e.BalanceDue=CurrencyFormat( e.BalanceDue);
                                e.DateEntered= OpenDate1;
                            });

                            var obj={
                                DebtorName:'',
                                DateEntered:'Total Creditors:',
                                CreditorID:data.length,
                                AmountPlaced:CurrencyFormat(AmountPlaced),
                                AmountPd:CurrencyFormat(AmountPd),
                                BalanceDue:CurrencyFormat(BalanceDue),
                                StatusID:'',
                                ColID:'',

                            };
                            data.push(obj);
                        }
                        else{
                            var dbFields=[
                                { field: "ClientName", title: "Client Name" },
                                { field: "SaleID", title: "SL" },
                                { field: "OpenDate", title: "Open Date"},
                                { field: "CountOfDebtorID", title: "TTL PL"},
                                { field: "SumOfAmountPlaced", title: "DLRS PL" },
                                { field: "LastDate", title: "Last Date"},
                                { field: "DLRCOL", title: "DLR COL" },
                                { field: "FEES", title: "FEES" },
                            ];
                            var dsFields={
                                ClientName: { type: "string" },
                                SaleID: { type: "string" },
                                OpenDate: { type: "string" },
                                CountOfDebtorID: { type: "string" },
                                SumOfAmountPlaced: { type: "string" },
                                LastDate: { type: "string" },
                                DLRCOL: { type: "string" },
                                FEES: { type: "string" },
                            };
                            cal=[
                                { field: "SumOfAmountPlaced",aggregate: "sum" },
                            ]
                            var SumOfAmountPlaced =0;
                            var DLRCOL =0;
                            var FEES =0;
                            data.forEach(function(e){
                                SumOfAmountPlaced+= e.SumOfAmountPlaced;
                                DLRCOL+= e.DLRCOL;
                                FEES+= e.FEES;

                                var OpenDate = new Date(e.OpenDate);var dd = OpenDate.getDate();var mm = OpenDate.getMonth()+1; //January is 0!
                                var yyyy = OpenDate.getFullYear();
                                if(dd<10){dd='0'+dd;}
                                if(mm<10){mm='0'+mm;}
                                var OpenDate1 = mm+'/'+dd+'/'+yyyy;

                                var LastDate = new Date(e.LastDate);var dd = LastDate.getDate();var mm = LastDate.getMonth()+1; //January is 0!
                                var yyyy = LastDate.getFullYear();
                                if(dd<10){dd='0'+dd;}
                                if(mm<10){mm='0'+mm;}
                                var LastDate1 = mm+'/'+dd+'/'+yyyy;


                                e.SumOfAmountPlaced=CurrencyFormat(e.SumOfAmountPlaced);
                                e.DLRCOL=CurrencyFormat(e.DLRCOL)
                                e.FEES=CurrencyFormat(e.FEES);
                                e.OpenDate= OpenDate1;
                                e.LastDate= LastDate1;
                            });
                            var obj={
                                ClientName:'',
                                CreditorID:'',
                                SaleID:'Total Creditors:',
                                OpenDate:data.length,
                                LastDate:'',
                                CreditorID:'',
                                CreditorID:'',
                                DLRCOL:CurrencyFormat(DLRCOL),
                                FEES:CurrencyFormat(FEES),
                                CountOfDebtorID:'',
                                SumOfAmountPlaced:CurrencyFormat(SumOfAmountPlaced)
                            };
                            data.push(obj);
                        }

                       // showGrid(data,dbFields,cal);
                        kendoGrid(data,headerName,dbFields,dsFields);
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });

        });
        function showGrid(gridData,dbFields,cal){
            $('#loader').hide()
            $("#grid").empty();
            $("#grid").shieldGrid({
                dataSource: {
                    data: gridData,
                    aggregate: cal,
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
                events: {
                    dataBound: OnDataBound
                },
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
                            data: gridData,
                            aggregate: cal,
                        },
                        readDataSource: true,
                        header: {
                            cells: dbFields
                        },

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
        function OnDataBound(e) {
            var grid = e.target,
                headerTable = grid.headerTable,
                tHead = headerTable.find(">thead"),
                firstCell = tHead.find('tr th:first');
            $("#trid1").remove();
            firstCell.attr("rowspan", "2");
            var row = $('<tr id="trid1">')
                .addClass("sui-columnheader");
            tHead.prepend(row);
            firstCell.appendTo(row);
            var secondCell = $("<th>")
                .text("Personal Info")
                .attr("colspan", "2")
                .addClass("additional-cell");
            secondCell.appendTo(row);
            var thirdCell = $("<th>")
                .text("Company Info")
                .attr("colspan", "2")
                .addClass("additional-cell");
            thirdCell.appendTo(row);
            tHead.find("tr:eq(1)> th:first()").addClass("first-cell");
        }
        function kendoGrid(data,headerName,dbFields,dsFields) {
            $('#loader').hide()
            $("#grid").empty();
            $("#grid").kendoGrid({
                toolbar: ["pdf","excel"],
                excel: {
                    fileName: "CreditorReport.xlsx",
                    proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                    filterable: true,
                    allPages: true
                },
                pdf: {
                    fileName: "CreditorReport.pdf",
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