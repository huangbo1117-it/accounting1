@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Collector</h1>

        <form name="form" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="collectorFirstName">Collector First Name:</label>
                        <input type="text" class="form-control" name="collectorFirstName" required>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="collectorLastName">Collector Last Name:</label>
                        <input type="text" class="form-control" name="collectorLastName" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="closing">Closing:</label>
                <input type="text" class="form-control" name="closing">
            </div>

            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Create New Collector">
            </div>
        </form>
    </div>
@endsection