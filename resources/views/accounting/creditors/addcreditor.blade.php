@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Creditor">Creditor</a></li>
        </ol>
        <h1>Add New Creditor</h1>

        <form name="form" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="creditorID">Creditor ID:</label>
                        <input type="text" class="form-control" name="creditorID" id="creditorID" required>
                    </div>
                </div>
                 <div class="col-md-3">
                     <div class="form-group">
                         <label for="clientName">Client Name:</label>
                         <input type="text" class="form-control" name="clientName" required>
                     </div>
                 </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="opendate">Open Date:</label>
                        <input type="date" class="form-control" name="opendate" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lastdate">Last Date:</label>
                        <input type="date" class="form-control" name="lastdate" required>
                    </div>
                </div>
                <input type="checkbox" name="compreport" value="1"> Comp Report
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" class="form-control" name="street" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Country:</label>
                        <input type="text" class="form-control" name="country" value="" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" name="city" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="state">State:</label>
                        <input type="text" class="form-control" name="state" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="zip">Zip:</label>
                        <input type="text" class="form-control" name="zip" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="sltn">Sltn:</label>
                        <select name="sltn" class="form-control">
                            <option value="Mr.">Mr.</option>
                            <option value="Ms.">Ms.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mFirstName">Manager First Name:</label>
                        <input type="text" class="form-control" name="mFirstName" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mLastName">Manager Last Name:</label>
                        <input type="text" class="form-control" name="mLastName" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="mainmanager">Main Manager:</label><br>
                        <input type="checkbox" class="form-control" name="mainmanager" id="mainmanager" value="1" checked disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="mainmanager">Contact ID (auto):</label><br>
                        <span hidden><input type="text" class="form-control" name="ContactID" value="" ></span>
                        <input type="text" class="form-control" name="ContactID2" value="{{$ContactID}}" disabled>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="Maskphone" class="form-control txtboxToFilter" name="phone" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="ext">Ext:</label>
                        <input type="text"  id="MaskExt" class="form-control txtboxToFilter" name="ext" >
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fax">Fax:</label>
                        <input type="text"  id="MaskFax" class="form-control txtboxToFilter" name="fax" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="email" class="form-control" name="Email" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="salesman">Sales ID:</label>
                        <select class="form-control" name="salesman" required>
                            @foreach($sm as $s)
                                <option value="{{$s->SalesID}}">{{$s->SFirstName}} {{$s->SLastName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="compreport">Comments:</label>
                        <textarea class="form-control" name="comments"></textarea>
                    </div>
                </div>

            </div>
            <br><br>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Create New Creditor">
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function getContactName(e){
            $('#creditorContactName').empty();
            $.ajax({
                url: './GetContact',
                type: 'GET',
                data: { id: e.value },
                success: function(response)
                {
                    console.log(response);
                    for(var i=0;i<response.length;i++){
                        $('#creditorContactName').append('<option value="'+ response[i].CreditorID +'">'+ response[i].CFirstName +'  '+ response[i].CLastName +' </option>')
                    }
                }
            });
        }
        $(document).ready(function() {
            $('#creditorID').blur(function (e) {
                $.ajax({
                    url: './GetCreditorID',
                    type: 'GET',
                    data: { id: $('#creditorID').val() },
                    success: function(response)
                    {
                        console.log(response);
                        if(response != ''){
                            alert('Creditor ID Already exist');
                            $('#creditorID').val('');
                        }
                    }
                });
            });
            $(".txtboxToFilter").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
            $("#Maskphone").mask("(999) 999-9999");
            $("#MaskFax").mask("(999) 999-9999");
            $("#MaskExt").mask("99999");
            $('#mainmanager').attr('readOnly','True')
        });
    </script>

@endsection