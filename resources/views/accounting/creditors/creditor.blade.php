@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-8">
                <h1>Manage Creditors</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddCreditor" class="btn btn-info align pull-right" role="button">Add Creditor</a>
            </div>
            <div class="col-md-2 ">
            <form name="form" method="get" target="_blank">

                        <input type="submit" class="btn btn-primary" name="Export" value="Export Data" >
            </form>
            </div>
        </div>

        <hr>

        @if (count($creditor) > 0 || Request::input('searchCreditor') != "")
            <div class="row">
                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-7"></div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="searchCreditor" value="{{Request::input('searchCreditor')}}" placeholder="Search Creditor By Creditor ID " >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif


        @if (count($creditor) > 0)

            <table class="table table-striped task-table">
                <thead>
                <th>Creditor ID</th>
                <th>Client Name</th>
                <th>Salesman Name</th>
                <th>Open Date</th>
                <th></th>
                </thead>
                <tbody>
                @foreach ($creditor as $cd)
                    <tr>
                         <td class="table-text" >
                            <div>{{ $cd->CreditorID }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->mainContact }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->saleman->SFirstName }} {{ $cd->saleman->SLastName }}</div>
                        </td>
                        <td class="table-text flex" >
                            <div>{{ Carbon\Carbon::parse($cd->OpenDate)->format('m/d/Y') }}</div>
                        </td>
                        <td class="pull-right">
                           <form action="/Contacts/{{$cd->CreditorID}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Other Contacts</button>
                                {{ csrf_field() }}
                           </form>
                           <form action="/EditCreditor/{{$cd->CreditorID}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                               {{ csrf_field() }}
                           </form>
                           <form action="/DelCreditor/{{$cd->CreditorID}}" method="post" class="inline">
                               <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                               {{ csrf_field() }}
                            </form>
                            <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getContactName('{{$cd->CreditorID}}')" data-target="#myModal">View</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $creditor->links() }}
        @else
            <br>
            <div class = "alert alert-danger">
                Currently no creditors available !
            </div>
        @endif

    </div>
    <div id="myModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Creditor Information</h4>
                </div>
                <div class="modal-body">

                </div>
                    <div class="modal-footer">
                    <form action="/EditCreditor/ddd" target="_blank" class="inline">
                        <button type="submit" name="edit" class="btn btn-primary">Summary Report</button>
                        {{ csrf_field() }}
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function getContactName(e){
            console.log(e);
            // $.ajax({url: "./GetContact", success: function(result){
            //     console.log(result);
            // }});
            /* $('#creditorID2').val(e.value);
             $('#creditorID').val(e.value);
             $('#creditorContactName').empty();*/
            $('.modal-body').empty();
            $.ajax({
                url: './EditCreditor/'+e,
                type: 'GET',
                success: function(response)
                {
                    console.log(response);
                    var el =$(response);
                    var found =$('#viewDetail ',el);
                    console.log(found);
                    $('.modal-body').empty().append(found);
                    $('.modal-footer form').attr('action','/CreditorsSummary/'+e);
                    $( "select" ).attr('disabled','disabled')
                    $( ".modal-body input" ).attr('disabled','disabled')
                }
            });
        }
    </script>

@endsection