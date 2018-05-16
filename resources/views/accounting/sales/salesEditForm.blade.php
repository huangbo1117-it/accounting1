
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Update Sales Man Information</h1>

        <form name="form" method="post">
            {{ csrf_field() }}
            <input type="hidden" value="{{$sales->SalesID}}" name="updateSaleID">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="salesFirstName">Sales Man First Name:</label>
                        <input type="text" class="form-control" name="salesFirstName" required value="{{$sales->SFirstName}}">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="salesLastName">Sales Man Last Name:</label>
                        <input type="text" class="form-control" name="salesLastName" required value="{{$sales->SLastName}}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Update Sales Man">
            </div>
        </form>
    </div>
@endsection