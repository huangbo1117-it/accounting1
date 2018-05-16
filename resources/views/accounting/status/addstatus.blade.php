@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Status</h1>

        <form name="form" method="post">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="statusID">Status ID:</label>
                <input type="text" class="form-control" name="statusID" required>
            </div>

            <div class="form-group">
                <label for="statusDesc">Status Description:</label>
                <input type="text" class="form-control" name="statusDesc" required>
            </div>

            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Create New Status">
            </div>
        </form>
    </div>
@endsection