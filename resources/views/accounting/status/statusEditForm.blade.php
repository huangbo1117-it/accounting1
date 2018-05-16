
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Update Status Information</h1>

        <form name="form" method="post">
            {{ csrf_field() }}
            <input type="hidden" value="{{$status->StatusID}}" name="updateStatusID">

            <div class="form-group">
                <label for="statusDesc">Payment Type Description:</label>
                <input type="text" class="form-control" name="statusDesc" required value="{{$status->StatusDesc}}">
            </div>


            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Update Status">
            </div>
        </form>
    </div>
@endsection