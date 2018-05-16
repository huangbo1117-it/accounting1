@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtors</a></li>
            <li class="breadcrumb-item active"><a href="/Debtor?searchCreditor={{$selected[0]->DebtorID}}">{{$selected[0]->DebtorID }} -- {{$selected[0]->DebtorName}}</a></li>
        </ol>
        <div class="row vertical-align">
            <div class="col-md-8">
                <h1>Manage Trust : </h1>
            </div>
            <div class="col-md-2 ">
                <a href="../AddTrustActivity/{{$selected[0]->DebtorID}}" class="btn btn-info align pull-right" role="button">Add Trust Activity</a>
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
                <th>Check No.</th>
                <th>Release Date</th>
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
                            <div>{{ $cd->CheckNumb }}</div>
                        </td>

                        <td class="table-text flex" >
                            <div>{{ Carbon\Carbon::parse($cd->RelDate)->format('Y/m/d') }}</div>
                        </td>
                        <td class="pull-right">

                            <form action="/EditTrustActivity/{{$cd->TPaymentID}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                {{ csrf_field() }}
                            </form>
                            <form action="/DelTrustActivity/{{$cd->TPaymentID}}" method="post" class="inline">
                                <input type="hidden" name="DebtorID" value="{{$selected[0]->DebtorID }}">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
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
                Currently no Trust Account available !
            </div>
        @endif

    </div>
@endsection