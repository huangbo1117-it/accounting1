<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Editable Invoice</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">



</head>

<body>

<div id="page-wrap">

    <textarea id="header">INVOICE</textarea>


    <div style="clear:both"></div>



    <table id="items">

        <tr>
            <th>DT Reported</th>
            <th>Amount Collected</th>
            <th>Rate</th>
            <th>Commission Due</th>
        </tr>

        @foreach($results as $ss)
            {{$ss->CreditorID}}
        @endforeach



    </table>

    <div id="terms">
        <h5>Terms</h5>
        <div>NO STATEMENT ISSUED - -  PLEASE PAY FROM INVOICE
            PLEASE INDICATE INVOICE NUMBER ON  YOUR REMITTANCE. THANK YOU</div>
    </div>

</div>

</body>

</html>