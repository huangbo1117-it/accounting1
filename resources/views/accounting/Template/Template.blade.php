@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Template:</h1>
            </div>
            <div class="col-md-2 ">
                <a href="/AddTemplate" class="btn btn-info align pull-right" role="button">Add Template</a>
            </div>

        </div>

        <hr>



        @if (count($parms) > 0)

            <table class="table table-striped task-table">
                <thead>
                <th>Template ID</th>
                <th>Template Name</th>
                <th>Date Time</th>
                </thead>
                <tbody>
                @foreach ($parms as $cd)
                    <tr>
                        <td class="table-text" >
                            <div>{{ $cd->TemplateID }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->Name }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->updated_at}}</div>
                        </td>

                        <td class="pull-right">
                            <form action="/EditTemplate/{{$cd->TemplateID}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                {{ csrf_field() }}
                            </form>
                            <form action="/DelTemplate/{{$cd->TemplateID}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-warning">Del</button>
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
                Currently no Debtor available !
            </div>
        @endif

    </div>
@endsection