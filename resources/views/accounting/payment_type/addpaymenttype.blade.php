@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Payment Type</h1>

        <form name="form" method="post">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="pTypeDesc">Payment Type Description:</label>
                <input type="text" class="form-control" name="pTypeDesc" required>
            </div>

            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Create New Payment Type">
            </div>
        </form>
    </div>
@endsection