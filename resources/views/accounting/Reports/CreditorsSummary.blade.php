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


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="colID">Open Accounts Only:</label>
                            <input type="checkbox" name="chkActiveOnly" id="chkActiveOnly" class="form-control" checked >
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

                </form>
            </div>
            <div class="col-md-2 ">
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#loader').hide()
            $('#Exports').click(function(){
                var headerName='Creditor Summary Report';

                $('#loader').show()
                var token=$('input[name=_token]').val();
                var chkActiveOnly=0;
                var chk =$('#chkActiveOnly').is(":checked");
                if(chk){
                    chkActiveOnly=1;
                }else{
                    chkActiveOnly=0;
                }
                $.ajax({
                    type: 'POST',
                    data: {
                        chkActiveOnly:chkActiveOnly,
                        sDate:$('#sDate').val(),
                        eDate:$('#eDate').val(),
                        _token:token,
                    },
                    success: function(data) {

                        var cal=[];

                            var dbFields=[
                                { field: "DebtorID", title: "DebtorID" },
                                { field: "DebtorName", title: "Debtor Name" },
                                { field: "ClientAcntNumber", title: "Account#" },
                                { field: "StatusDesc", title: "Status" },
                                { field: "DateEntered", title: "Date Placed"},
                                { field: "LastDate", title: "Last Date"},
                                { field: "AmountPlaced", title: "Amount Placed" },
                                { field: "AmountPaid", title: "Amount Paid" },
                                { field: "BalanceDue", title: "BalanceDue" },
                                { field: "CostAdv", title: "Cost Adv" },
                                { field: "CostRec", title: "Cost Rec" },
                                { field: "SuitFee", title: "Suit Fee" },
                                { field: "SumOfTotalFees", title: "Total Fees" },
                            ];
                            var dsFields={
                                DebtorID: { type: "string" },
                                DebtorName: { type: "string" },
                                ClientAcntNumber: { type: "string" },
                                StatusDesc: { type: "string" },
                                DateEntered: { type: "string" },

                                LastDate: { type: "string" },
                                AmountPlaced: { type: "string" },
                                AmountPaid: { type: "string" },
                                BalanceDue: { type: "string" },
                                CostAdv: { type: "string" },

                                CostRec: { type: "string" },
                                SuitFee: { type: "string" },
                                SumOfTotalFees: { type: "string" },
                            };
                            cal=[
                                { field: "AmountPlaced", aggregate: "sum" },
                            ]
                           var AmountPlaced =0;
                            var AmountPaid =0;
                            var BalanceDue =0;
                            var CostRec=0;
                        var CostAdv =0;
                        var SuitFee =0;
                        var SumOfTotalFees =0;
                            data.forEach(function(e){
                                AmountPlaced+= e.AmountPlaced;
                                AmountPaid+= e.AmountPaid;
                                BalanceDue+= e.BalanceDue;
                                CostRec+= e.CostRec;
                                CostAdv+= e.CostAdv;
                                SumOfTotalFees+= e.SumOfTotalFees;
                                SuitFee+= e.SuitFee;

                                var OpenDate = new Date(e.DateEntered);var dd = OpenDate.getDate();var mm = OpenDate.getMonth()+1; //January is 0!
                                var yyyy = OpenDate.getFullYear();
                                if(dd<10){dd='0'+dd;}
                                if(mm<10){mm='0'+mm;}
                                var OpenDate1 = mm+'/'+dd+'/'+yyyy;
                                e.DateEntered= OpenDate1;
                                if(e.LastDate == null){e.LastDate= '';}else{
                                OpenDate = new Date(e.LastDate);var dd = OpenDate.getDate();var mm = OpenDate.getMonth()+1; //January is 0!
                                var yyyy = OpenDate.getFullYear();
                                if(dd<10){dd='0'+dd;}
                                if(mm<10){mm='0'+mm;}
                                var OpenDate1 = mm+'/'+dd+'/'+yyyy;
                                e.LastDate= OpenDate1;
                                }
                                e.AmountPlaced = CurrencyFormat( e.AmountPlaced);
                                e.AmountPaid = CurrencyFormat( e.AmountPaid);
                                e.BalanceDue = CurrencyFormat( e.BalanceDue);
                                e.CostAdv = CurrencyFormat( e.CostAdv);
                                e.CostRec = CurrencyFormat( e.CostRec);
                                e.SumOfTotalFees = CurrencyFormat( e.SumOfTotalFees);
                                e.SuitFee = CurrencyFormat( e.SuitFee);

                            });

                            var obj={
                                DebtorID:'',
                                DebtorName:'',
                                ClientAcntNumber:'',
                                StatusDesc:'',
                                DateEntered:'',
                                LastDate:'',
                                AmountPlaced:CurrencyFormat(AmountPlaced),
                                AmountPaid:CurrencyFormat(AmountPaid),
                                BalanceDue:CurrencyFormat(BalanceDue),
                                CostAdv:CurrencyFormat(CostAdv),
                                CostRec:CurrencyFormat(CostRec),
                                SuitFee:CurrencyFormat(SuitFee),
                                SumOfTotalFees:CurrencyFormat(SumOfTotalFees),

                            };
                            data.push(obj);



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
                        fileName: "Creditor-Summary",
                        orientation: "landscape",
                        size: "a4",
                        fontSize: 10,
                        author: "Inam ul haq",
                        dataSource: {
                            data: gridData,
                            aggregate: cal,
                        },
                        readDataSource: true,
                        header: {
                            cells: dbFields
                        },
                        margins: {
                            left: 10,
                            top: 50,
                            bottom: 50
                        }

                    },
                    csv: {
                        fileName: "Creditor-Summary",
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
                    fileName: "CreditorSummaryReport.xlsx",
                    proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                    filterable: true,
                    allPages: true
                },
                pdf: {
                    fileName: "CreditorSummaryReport.pdf",
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