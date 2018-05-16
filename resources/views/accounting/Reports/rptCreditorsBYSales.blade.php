<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Creditor By Sales</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">



</head>

<body>

<div id="page-wrap">

    <div id="header">CREDITOR BY SALES</div>


    <div style="clear:both"></div>



    <table id="items">

        <tr>
            <th>Salesman Name</th>
            <th>Creditor ID</th>
            <th>Creditor Name</th>
            <th>Phone</th>
        </tr>

    @foreach($results as $ss)
            <tr class="item-row">

                <td >{{$ss->SFirstName}} {{$ss->SLastName}}</td>
                <td>{{$ss->CreditorID}}</td>
                <td>{{$ss->ClientName}}</td>
                <td>{{$ss->Phone}}</td>
            </tr>
        @endforeach



    </table>


</div>

</body>

</html>