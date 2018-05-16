
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Update Payment Type Information</h1>

        <form name="form" method="post">
            {{ csrf_field() }}
            <input type="hidden" value="{{$paymenttype->PmntID}}" name="updatePaymentTypeID">

            <div class="form-group">
                <label for="paymentTypeDescription">Payment Type Description:</label>
                <input type="text" class="form-control" name="paymentTypeDescription" required value="{{$paymenttype->PmntDesc}}">
            </div>


            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Update Payment Type">
            </div>
        </form>
    </div>
@endsection