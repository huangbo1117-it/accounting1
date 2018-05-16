@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row vertical-align">
            <div class="col-md-10">
                <h1>Manage Users</h1>
            </div>
            <div class="col-md-2 ">
                <a href="./AddUser" class="btn btn-info align pull-right" role="button">Add User</a>
            </div>

        </div>

        <hr>
        <div class="row">
            <div class="col-md-12" id="mainDiv">
        @if (count($user) > 0 || Request::input('searchUser') != "")

                <div class="col-md-12 pull-right">
                    <form name="form" method="get">
                        <div class="row">
                            <div class="col-md-7"></div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="searchUser" value="{{Request::input('searchUser')}}" placeholder="Search User By ID " >
                            </div>
                            <div class="col-md-1">
                                <input type="submit" class="btn btn-primary" value="Search" >
                            </div>
                        </div>
                    </form>
                </div>

        @endif


        @if (count($user) > 0)

            <table class="table table-striped task-table">
                <thead>
                <th>User Name</th>
                <th>User ID</th>
                <th>User Group</th>

                <th></th>
                </thead>
                <tbody>
                @foreach ($user as $cd)
                    <tr>

                        <td class="table-text" >
                            <div>{{ $cd->name }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->email }}</div>
                        </td>
                        <td class="table-text" >
                            <div>{{ $cd->groupName }}</div>
                        </td>
                        <td class="pull-right">
                            @if($cd->groupName == 'client')
                                <button class="btn btn-primary" onclick="getUserCreditor('{{$cd->id}}','{{$cd->email}}')">Creditors</button>
                            @endif
                            <form action="/editUser/{{$cd->id}}" class="inline">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                {{ csrf_field() }}
                            </form>

                            <a href="{{ url('deleteUser',$cd->id) }}" class="btn btn-danger"
                               data-tr="tr_{{$cd->id}}"
                               data-toggle="confirmation"
                               data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
                               data-btn-ok-class="btn btn-sm btn-danger"
                               data-btn-cancel-label="Cancel"
                               data-btn-cancel-icon="fa fa-chevron-circle-left"
                               data-btn-cancel-class="btn btn-sm btn-default"
                               data-title="Are you sure you want to delete ?"
                               data-placement="left" data-singleton="true">
                                Delete
                            </a>


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $user->links() }}
        @else
            <br>
            <div class = "alert alert-danger">
                Currently no user available !
            </div>
        @endif
            </div>
            <div class="col-md-4" id="CreditorDiv" style="display: none">
                <div class="row">


                <div class="col-md-12">
                    <form id="CreditorForm">
                        <div class="form-group">
                            <label for="name" class="col-md-12 control-label">Creditor ID</label>
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <input  type="hidden" id="userid" class="form-control" name="userid" value=""  >
                                <input  type="text"  id="CreditorID" class="form-control" name="CreditorID" value=""  >
                            <br>
                                <input id="name" type="button" onclick="setUserCreditor(this)" class="btn btn-primary" name="name" value="Save"  >

                            </div>
                        </div>
                    </form>
                </div>
                </div>

                <br>
                <div class="row">


                    <div class="col-md-12">
                <ul class="list-group" id="abc">
                    <li class="list-group-item">inam</li>
                </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>

    <script>
        $(document).ready(function () {
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                onConfirm: function (event, element) {
                    element.trigger('confirm');
                }
            });
            $(document).on('confirm', function (e) {
                var ele = e.target;
                e.preventDefault();


                $.ajax({
                    url: ele.href,
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        if (data['success']) {
                            $("#" + data['tr']).slideUp("slow");
                            alert(data['success']);
                        } else if (data['error']) {
                            alert(data['error']);
                        } else {
                            alert('Whoops Something went wrong!!');
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });


                return false;
            });
        });
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
        function getUserCreditor(id,email){
            console.log(email);
            $('#CreditorForm div label').text('Creditor ID  : ' + email)
            $('#mainDiv').addClass("col-md-8").removeClass('col-md-12');
            $('#CreditorDiv').fadeIn('slow');

            $('#userid').val(id);
            $.ajax({
                url: './GetUserCreditor/',
                type: 'GET',
                data: { id: id },
                success: function(response)
                {
                    console.log(response);
                    $('#abc').empty();
                    for(var i =0; i< response.length; i++){
                    //<li class="list-group-item">inam</li>
                        $('#abc').append('<li class="list-group-item">'+ response[i].CreditorID+'</li>');
                    }
                }
            });
        }

        function setUserCreditor(e){
            var data = $('#CreditorForm').serializeArray();
            $.ajax({
                type: 'POST',
                url:'/AddUserCreditor',
                data: data,
                success: function(data) {

                    location.reload();
                },
                error: function(data) {
                    console.log("Signup was unsuccessful");
                }
            });
        }
    </script>

@endsection