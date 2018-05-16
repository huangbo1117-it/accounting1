@extends('layouts.app')

@section('content')
<div class="container">

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

    <br>
    <div class="row">
        <div class="col-md-12">
            <div id="exTab3" class="container">
                <ul  class="nav nav-pills">

                    <li class="active"><a href="#2b" data-toggle="tab">Debtors Information  <span class="badge"> {{count($debtor)}}</span></a>
                    </li>
                    <li >
                        <a  href="#1b" data-toggle="tab">Client Information  <span class="badge"> {{count($contacts)}}</span></a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="2b">
                        @if (count($debtor) > 0)

                            <table class="table table-striped task-table">
                                <thead>
                                <th>Debtor ID</th>
                                <th>Debtor Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach ($debtor as $cd)
                                    <tr>
                                        <td class="table-text" >
                                            <div><a href="/EditDebtor/{{$cd->DebtorID}}" target="_blank">{{ $cd->DebtorID }}</a></div>
                                        </td>
                                        <td class="table-text" >
                                            <div><a href="/EditDebtor/{{$cd->DebtorID}}" target="_blank">{{ $cd->DebtorName }}</a></div>
                                        </td>
                                        <td class="table-text" >
                                            <div>{{ $cd->DFirstName }}</div>
                                        </td>
                                        <td class="table-text" >
                                            <div>{{ $cd->DLastName }}</div>
                                        </td>

                                        <td class="pull-right" >
                                            <form action="/TrustAccount/{{$cd->DebtorID}}" class="inline">
                                                {{ csrf_field() }}
                                                <button type="submit" name="edit" class="btn btn-primary">Trust Account</button>

                                            </form>
                                            <form action="/Invoices/{{$cd->DebtorID}}" class="inline">
                                                <button type="submit" name="edit" class="btn btn-primary">Invoices</button>
                                                {{ csrf_field() }}
                                            </form>



                                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getContactName({{$cd}})" data-target="#exampleModal">
                                View
                            </button>-->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $debtor->links() }}

                        @endif
                    </div>
                    <div class="tab-pane " id="1b">
                        @if (count($contacts) > 0)

                            <table class="table table-striped task-table">
                                <thead>

                                <th>CreditorID</th>
                                <th>Client Name</th>
                                <th>Person Name</th>
                                <th>Address</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach ($contacts as $contact)
                                    <tr>

                                        <td class="table-text" >
                                            <div><a href="/EditContact/{{$contact->ContactID}}/{{$contact->CreditorID}}" target="_blank">{{ $contact->CreditorID }}</a></div>
                                        </td>
                                        <td class="table-text" >
                                            <div><a href="/EditContact/{{$contact->ContactID}}/{{$contact->CreditorID}}" target="_blank">{{ $contact->ClientName }}</a></div>
                                        </td>
                                        <td class="table-text" >
                                            <div>{{ $contact->Saltnt }} {{ $contact->CFirstName }} {{ $contact->CLastName }}</div>
                                        </td>
                                        <td class="table-text flex" >
                                            <div>{{ $contact->Street }}, {{$contact->City}}, {{$contact->State}} ({{$contact->Zip}})</div>
                                        </td>
                                        <td class="pull-right">
                                            <form action="/Contacts/{{$cd->CreditorID}}" target="_blank" class="inline">
                                                <button type="submit" name="edit" class="btn btn-primary">Other Contacts</button>
                                                {{ csrf_field() }}
                                            </form>
                                            <form action="/EditCreditor/{{$cd->CreditorID}}" target="_blank" class="inline">
                                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                                {{ csrf_field() }}
                                            </form>

                                            <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getContactName('{{$cd->CreditorID}}')" data-target="#myModal">View</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
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