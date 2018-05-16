
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Update Collector Information</h1>

        <form name="form" method="post">
            {{ csrf_field() }}
            <input type="hidden" value="{{$collector->ColID}}" name="updateCollectorID">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="collectorFirstName">Collector First Name:</label>
                        <input type="text" class="form-control" name="collectorFirstName" required value="{{$collector->CFirstName}}">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="collectorLastName">Collector Last Name:</label>
                        <input type="text" class="form-control" name="collectorLastName" required value="{{$collector->CLastName}}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="closing">Closing:</label>
                <input type="text" class="form-control" name="closing" value="{{$collector->Closing}}">
            </div>

            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Update Collector">
            </div>
        </form>
    </div>
@endsection