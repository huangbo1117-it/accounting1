@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Collector</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddCollector" class="btn btn-info align pull-right" role="button">Add Collector</a>
            </div>
        </div>

        <hr>

        @if (count($collectors) > 0 || Request::input('searchCollector') != "")
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="searchCollector" value="{{Request::input('searchCollector')}}" placeholder="Search Collector" >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @if (count($collectors) > 0)

            <table class="table table-striped task-table">
                <thead>
                <th>Collector ID</th>
                <th>Collector Name</th>
                <th>Closing</th>
                <th></th>
                </thead>
                <tbody>
                @foreach ($collectors as $collector)
                    <tr>
                         <td class="table-text" >
                            <div>{{ $collector->ColID }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $collector->CFirstName }} {{ $collector->CLastName }}</div>
                        </td>
                        <td class="table-text flex" >
                            <div>{{ $collector->Closing }}</div>
                        </td>
                        <td class="pull-right">
                           <form action="/EditCollector/{{$collector->ColID}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                               {{ csrf_field() }}
                           </form>
                           <form action="/DelCollector/{{$collector->ColID}}" method="post" class="inline">
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
                Currently no collector available !
            </div>
        @endif

    </div>
@endsection