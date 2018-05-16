
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- title -->
    <title>TableExport Plugin</title>

    <!--stylesheets-->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tableexport.css') }}" rel="stylesheet">

    <!-- prettify -->
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?lang=css&skin=desert"></script>

    <!-- shortcut icon -->
    <link rel="shortcut icon" href="favicon.ico">
    <style>
        .bottom {
            caption-side: top;
        }
    </style>
</head>
<body>



<a href="#" onClick ="$('#Population-list-2').tableExport({type:'csv',escape:'false'});">CSV</a>
<main>
    <div class="container">
        <div class="row">
            <div class="col-md-12">



                <div class="row" hidden>
                    <div class="col-md-12">
                        <h3 id="demo-1">Demo 1</h3>
                        <br>
                        <h4>Countries By Population</h4>

                        <div class="table-responsive">
                            <table id="Population-list-1" class="table table-striped table-bordered"
                                   data-name="cool-table">
                                <thead>
                                <tr>

                                    <th>Client Name</th>
                                    <th>SL</th>
                                    <th>Open Date</th>
                                    <th>TTL PL</th>
                                    <th>DLRS PL</th>
                                    <th>Last Date</th>
                                    <th>DLR COL</th>
                                    <th>FEES</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <h3 id="demo-2">Demo 2</h3>
                        <br>
                        <h4>Countries By Population</h4>

                        <div class="table-responsive">
                            <table id="Population-list-2" class="table table-striped table-bordered"
                                   data-name="cool-table">
                                <thead>
                                <tr>

                                    <th>Client Name</th>
                                    <th>SL</th>
                                    <th>Open Date</th>
                                    <th>TTL PL</th>
                                    <th>DLRS PL</th>
                                    <th>Last Date</th>
                                    <th>DLR COL</th>
                                    <th>FEES</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($results as $ss)
                                    <tr>
                                        <td>{{$ss->ClientName}}</td>
                                        <td >{{$ss->SaleID}}</td>
                                        <td>{{$ss->OpenDate}}</td>
                                        <td>{{round($ss->CountOfDebtorID,2)}}</td>
                                        <td>{{round($ss->SumOfAmountPlaced,2)}}</td>
                                        <td>{{$ss->LastDate}}</td>
                                        <td>{{round(floatval($ss->Credits)+floatval($ss->SumOfNetClient),2)}}</td>
                                        <td>{{round(floatval($ss->DueInv)+floatval($ss->SumOfAgencyGross),2)}}</td>
                                    </tr>
                                @endforeach

                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</main>



<script type="text/javascript" src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.bootstrap-autohidingnavbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ZeroClipboard.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/xlsx.core.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/Blob.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/FileSaver.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/Export2Excel.js') }}"></script>
<!--<script type="text/javascript" src="{{ asset('js/jquery.tableexport.js') }}"></script>-->
<script type="text/javascript" src="{{ asset('js/jquery.tableexport.v2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sprintf.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jspdf.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/base64.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>


</body>
</html>


