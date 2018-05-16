@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor?searchCreditor={{$selected[0]->DebtorID}}">Debtor-- {{$selected[0]->DebtorID}}</a></li>

        </ol>
        <div class="row vertical-align">
            <div class="col-md-8">
                <h1>Manage Invoice : {{$selected[0]->DebtorName}}</h1>
            </div>
            <div class="col-md-2 ">
                <a href="../AddCredit/{{$selected[0]->DebtorID}}" class="btn btn-info align pull-right" role="button">Add Credit</a>
            </div>
            <div class="col-md-2 ">
                <form name="form" method="get" target="_blank">

                    <input type="submit" class="btn btn-primary" name="Export" value="Export Data" >
                </form>
            </div>
        </div>

        <hr>



        @if (count($debtor) > 0)

            <table class="table table-striped task-table">
                <thead>
                <th>TPayment ID</th>
                <th>Date Received</th>
                <th>Payment Received</th>
                <th>Billed.</th>
                </thead>
                <tbody>
                @foreach ($debtor as $cd)
                    <tr>
                        <td class="table-text" >
                            <div>{{ $cd->TPaymentID }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->DateRcvd }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->PaymentReceived }}</div>
                        </td>
                        <td class="table-text" >
                            <div>@if($cd->BilledFor == 1) Yes @else NO @endif</div>
                        </td>


                        <td class="pull-right">
                            @if($cd->BilledFor == 0)
                                        <form action="/AddInvoice/{{$cd->TPaymentID}}" class="inline">
                                        <button type="submit" name="edit" class="btn btn-primary">Bill</button>
                                        {{ csrf_field() }}
                                        </form>
                                    @else
                                        <form action="/ShowInvoice/{{$cd->TPaymentID}}" target="_blank" class="inline">
                                            <button type="submit" name="edit" class="btn btn-primary">Preview</button>
                                            {{ csrf_field() }}
                                        </form>
                                <form action="/EditInvoice/{{$cd->TPaymentID}}" class="inline">
                                    <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                    {{ csrf_field() }}
                                </form>
                            @endif

                                <form action="/DeleteInvoice/{{$cd->ID}}" class="inline">
                                    <input type="hidden" name="IPaymentID" value="{{$cd->TPaymentID}}">
                                    <input type="hidden" name="DebtorID" value="{{$selected[0]->DebtorID}}">
                                    <button type="submit" name="edit" class="btn btn-danger">Delete</button>
                                    {{ csrf_field() }}
                                </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <br>
            <div class = "alert alert-danger">
                Currently no Debtor available !
            </div>
        @endif

    </div>
@endsection