<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Invoice</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">

<style type="text/css">
    body
    {
        font-family: "Times New Roman", Times, serif;
    }
</style>

</head>

<body>
@if($trustActivity != null)
<div id="page-wrap">

    <textarea id="header">INVOICE</textarea>

    <div id="identity">
		
            <div id="address">
                {{$creditor->ClientName}}<br>
                Att : {{$contact->CFirstName}} {{$contact->CLastName}}<br>
                {{$creditor->Street}}<br>
                {{$creditor->City}}, {{$creditor->State}} {{$creditor->Zip}}
					


            </div>

    </div>

            <div style="clear:both"></div>

            <div id="customer">


                <table id="meta">
                    <tr>
                        <td class="meta-head">Debtor:</td>
                        <td>{{$debtor->DebtorName}}</td>
                    </tr>
                    <tr>

                        <td class="meta-head">Client Acc:</td>
                        <td>{{$debtor->ClientAcntNumber}}</td>
                    </tr>
                    <tr>
                        <td class="meta-head">Amount Due</td>
                        <td><div class="due">${{number_format ($total,2)}}</div></td>
                    </tr>
                    <tr>
                        <td class="meta-head">Invoice Number</td>
                        <td><div class="due">{{$trustActivity->InvoiceNumb}}</div></td>
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
                    <td class="item-name"><div class="delete-wpr">{{Carbon\Carbon::parse($trustActivity->InvDate)->format('m/d/Y')}}</div></td>
            <td class="description">${{number_format($trustActivity->Fee1Balance,2)}}</td>
            <td>{{$trustActivity->InvLbl}}</td>
            <td>${{number_format($trustActivity->Fee1,2)}}</td>
        </tr>


    </table>

    <div id="terms">
        <h5>Terms</h5>
        <div>NO STATEMENT ISSUED - -  PLEASE PAY FROM INVOICE
PLEASE INDICATE INVOICE NUMBER ON  YOUR REMITTANCE. THANK YOU <br>
        {{$trustActivity->InvText}}
        </div>
    </div>

</div>
    @else
    <div id="terms">

        <div>No Invoice Found</div>
    </div>
@endif
</body>

</html>