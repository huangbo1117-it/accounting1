@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Status</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddStatus" class="btn btn-info align pull-right" role="button">Add Status</a>
            </div>
        </div>

        <hr>

        @if (count($status) > 0 || Request::input('searchStatus') != "")
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="searchStatus" value="{{Request::input('searchStatus')}}" placeholder="Search Status" >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if (count($status) > 0)

            <table class="table table-striped task-table">
                <thead>
                <th>Status ID</th>
                <th>Status Description</th>
                <th></th>
                </thead>
                <tbody>
                @foreach ($status as $st)
                    <tr>
                         <td class="table-text" >
                            <div>{{ $st->StatusID }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $st->StatusDesc }}</div>
                        </td>
                        <td class="pull-right">
                           <form action="/EditStatus/{{$st->StatusID}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                               {{ csrf_field() }}
                           </form>
                           <form action="/DelStatus/{{$st->StatusID}}" method="post" class="inline">
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
                Currently no status available !
            </div>
        @endif

    </div>
@endsection