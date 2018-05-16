@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="Creditor">Creditor</a></li>
            <li class="breadcrumb-item active">{{ Session::get('creditorID')}}</li>
        </ol>


        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Contacts</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddContact" class="btn btn-info align pull-right" role="button">Add Contact</a>
            </div>
        </div>

        <hr>

        @if (count($contacts) > 0 || Request::input('searchContact') != "")
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="searchContact" value="{{Request::input('searchContact')}}" placeholder="Search Contacts" >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @if (count($contacts) > 0)

            <table class="table table-striped task-table">
                <thead>
                <th>Client Name</th>
                <th>Person Name</th>
                <th>Address</th>
                <th></th>
                </thead>
                <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td class="table-text" >
                            <div>{{ $contact->ClientName }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $contact->Saltnt }} {{ $contact->CFirstName }} {{ $contact->CLastName }}</div>
                        </td>
                        <td class="table-text flex" >
                            <div>{{ $contact->Street }}, {{$contact->City}}, {{$contact->State}} ({{$contact->Zip}})</div>
                        </td>
                        <td class="pull-right">
                           <form action="/EditContact/{{$contact->ContactID}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                               {{ csrf_field() }}
                           </form>
                           <form action="/DelContact/{{$contact->ContactID}}" method="post" class="inline">
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
                Currently no contacts available !
            </div>
        @endif

    </div>
@endsection