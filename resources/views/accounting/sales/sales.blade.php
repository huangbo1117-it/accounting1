@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Sales Man</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddSales" class="btn btn-info align pull-right" role="button">Add Sales Man</a>
            </div>
        </div>

        <hr>

        @if (count($sales) > 0 || Request::input('searchSales') != "")
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="searchSales" value="{{Request::input('searchSales')}}" placeholder="Search Sales Man" >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if (count($sales) > 0)

            <table class="table table-striped task-table">
                <thead>
                <th>Sales ID</th>
                <th>Sales Man Name</th>
                <th></th>
                </thead>
                <tbody>
                @foreach ($sales as $sale)
                    <tr>
                         <td class="table-text" >
                            <div>{{ $sale->SalesID }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $sale->SFirstName }} {{ $sale->SLastName }}</div>
                        </td>
                        <td class="pull-right">
                           <form action="/EditSales/{{$sale->SalesID}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                               {{ csrf_field() }}
                           </form>
                           <form action="/DelSales/{{$sale->SalesID}}" method="post" class="inline">
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
                Currently no sales man available !
            </div>
        @endif

    </div>
@endsection