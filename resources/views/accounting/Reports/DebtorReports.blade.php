@extends('layouts.app')

@section('content')
    <link href="{{ asset('kendo/css/kendo.common-material.min.css') }}" rel="stylesheet">
    <link href="{{ asset('kendo/css/kendo.material.min.css') }}" rel="stylesheet">
    <link href="{{ asset('kendo/css/kendo.material.mobile.min.css') }}" rel="stylesheet">

    <div class="container">

        <div class="row">
            <div class="col-md-8">


        <form name="form" method="post"  target="_blank">
            {{ csrf_field() }}

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="colID">Open Accounts Only:</label>
                        <input type="checkbox" name="chkActiveOnly" id="chkActiveOnly" class="form-control"  >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="colID">Report Type:</label>

                        <select class="form-control" name="ReportType" id="ReportType" required>
                            <option value="1">Attorney</option>
                            <option value="2">Specific Collector</option>
                            <option value="3">All Collector</option>
                            <option value="4">All Collector < $30,000.00</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="colID">Collector:</label>

                        <select class="form-control" name="colID" id="colID" required>
                            @foreach($col as $s)
                                <option value="{{$s->ColID}}">{{$s->CLastName}}  {{$s->CFirstName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


          <!--  <br><br>
            <div class="col-md-6">
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
            <div class="col-md-4">
                <div class="col-md-6 ">
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
                var headerName='Debtors Report';
                var rpt=$('#ReportType').val();
                if(rpt == 4){
                    $('#chkActiveOnly').prop('checked', true);
                }
                if(rpt == 2){
                    headerName +=' '+$('#colID option:selected').text().trim();
                }
                $('#loader').show()
                var token=$('input[name=_token]').val();
                $.ajax({
                    type: 'POST',
                    data: {
                        ReportType:rpt,
                        chkActiveOnly:$('#chkActiveOnly').is(":checked"),
                        colID:$('#colID').val(),
                        _token:token,
                    },
                    success: function(data) {

                            var dbFields=[
                                { field: "CFirstName", title: "Collector First Name" },
                                { field: "CLastName", title: "Collector Last Name" },
                                { field: "DebtorName", title: "Debtor Name"},
                                { field: "DebtorID", title: "Debtor ID"},
                                { field: "Phone", title: "Phone" },
                                { field: "AmountPlaced", title: "Amount Placed", },
                                { field: "BalanceDue", title: "Balance Due",},
                            ];
                        var dsFields={
                            CFirstName: { type: "string" },
                            CLastName: { type: "string" },
                            DebtorName: { type: "string" },
                            DebtorID: { type: "string" },
                            Phone: { type: "string" },
                            AmountPlaced: { type: "string" },
                            BalanceDue: { type: "string" },
                        };
                        var AmountPlaced =0;
                        var BalanceDue =0;
                        data.forEach(function(e){
                            AmountPlaced+= e.AmountPlaced;
                            BalanceDue+= e.BalanceDue;
                            e.AmountPlaced=CurrencyFormat( e.AmountPlaced);
                            e.BalanceDue=CurrencyFormat( e.BalanceDue);
                        });
                        var obj={
                            CFirstName:'',
                            CLastName:'',
                            DebtorName:'Total Debtors : '+data.length,
                            DebtorID:'',
                            Phone:'',
                            AmountPlaced:CurrencyFormat(AmountPlaced),
                            BalanceDue:CurrencyFormat(BalanceDue),
                        };
                        data.push(obj);
                        kendoGrid(data,headerName,dbFields,dsFields);
                        //showGrid(data,dbFields);
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
                        size: "a4",
                        orientation: "landscape",
                        dataSource: {
                            data: gridData
                        },
                        readDataSource: true,
                        header: {
                            cells: dbFields
                        },

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
                    fileName: "DebtorReport.xlsx",
                    proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                    filterable: true,
                    allPages: true
                },
                pdf: {
                    fileName: "DebtorReport.pdf",
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