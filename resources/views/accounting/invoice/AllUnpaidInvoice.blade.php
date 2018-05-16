@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtor</a></li>

        </ol>
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Invoice : </h1>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-2">
                <span><b>Totel Collected :</b> {{number_format($sumOfCollected,2)}}</span>
            </div>
            <div class="col-md-2">
                <span><b>Totel Due : </b>{{number_format($sumOfDueInv,2)}}</span>
            </div>
        </div>

        @if (count($data) > 0)

            <table class="table table-striped task-table">
                <thead>
                <th>Inv#</th>
                <th>Inv Date</th>
                <th>Debtor ID</th>
                <th>Collected</th>
                <th>Agency Net</th>
                <th>AttyFee</th>
                <th>Paid Date</th>
                <th>Paid$</th>
                </thead>
                <tbody>
                @foreach ($data as $cd)
                    <tr>
                        <td class="table-text" >
                            <div>{{ $cd->InvoiceNumb }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->InvDate }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->DebtorID }}</div>
                        </td>
                        <td class="table-text" >
                            <div>${{number_format($cd->Collected,2)}}</div>
                        </td>
                        <td class="table-text" >
                            <div>${{number_format($cd->Fee1,2)}}</div>
                        </td>
                        <td class="table-text" >
                            <div>${{$cd->AttyFees}}</div>
                        </td>
                        <td class="table-text" >
                            <div></div>
                        </td>
                        <td class="table-text" >
                            <div>$ 0.0</div>
                        </td>
                        <td class="pull-right">

                            <form action="/UnpaidInvoices/{{$cd->InvoiceNumb}}" method="post" class="inline">
                                <input type="hidden" name="DueInv" value="{{$cd->DueInv}}">
                                <button type="submit" name="edit" class="btn btn-primary">Mark As Paid</button>
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
                Currently no Unpaid invoice available !
            </div>
        @endif

    </div>
@endsection