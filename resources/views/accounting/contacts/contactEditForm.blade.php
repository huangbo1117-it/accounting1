@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="../Creditor">Creditor</a></li>
            <li class="breadcrumb-item active"><a href="../Contact">{{ Session::get('creditorID')}}</a></li>
            <li class="breadcrumb-item active">Edit Contact Information</li>
        </ol>


        <h1>Edit Contact Information</h1>

        <form name="form" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="updateContactID" value="{{$contact->ContactID}}">
            <div class="form-group">
                <label for="clientName">Client Name:</label>
                <input type="text" class="form-control" name="clientName" required value="{{$contact->ClientName}}">
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sltn">Sltn:</label>
                        <select name="sltn" class="form-control">
                            <option value="Mr." @if($contact->Saltnt == 'Mr.') selected @endif>Mr.</option>
                            <option value="Ms." @if($contact->Saltnt == 'Ms.') selected @endif>Ms.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mFirstName">Manager First Name:</label>
                        <input type="text" class="form-control" name="mFirstName" value="{{$contact->CFirstName}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mLastName">Manager Last Name:</label>
                        <input type="text" class="form-control" name="mLastName" value="{{$contact->CLastName}}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="text" class="form-control" value="{{$contact->Email}}" name="Email" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" class="form-control" name="street" value="{{$contact->Street}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" name="city" value="{{$contact->City}}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="state">State:</label>
                        <input type="text" class="form-control" name="state" value="{{$contact->State}}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="zip">Zip:</label>
                        <input type="text" class="form-control" name="zip" value="{{$contact->Zip}}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" name="phone" value="{{$contact->Phone}}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ext">Ext:</label>
                        <input type="text" class="form-control" name="ext" value="{{$contact->Ext}}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fax">Fax:</label>
                        <input type="text" class="form-control" name="fax" value="{{$contact->Fax}}" required>
                    </div>
                </div>

            </div>


            <input type="checkbox" name="mainmanager" value="1" @if($contact->MainManager==true) checked @endif> Main Manager
            <br><br>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Update Contact">
            </div>
        </form>
    </div>
@endsection