@extends('layouts.app')
<style>

    #exTab3 .nav-pills > li > a {
        border-radius: 4px 4px 0 0 ;
    }

    #exTab3 .tab-content {
        color : white;
        background-color: #a9d8f3;
        padding : 5px 15px;
    }</style>
<link href="{{ asset('css/jquery-confirm.min.css') }}" rel="stylesheet">
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtor</a></li>
        </ol>
        @if($first != null)
            <span style="margin: 5px;"><a href="/EditDebtor/{{$first}}" class="btn btn-info align " role="button">First</a></span>
        @endif
        @if($previous != null)
            <span style="margin: 5px;"><a href="/EditDebtor/{{$previous}}" class="btn btn-info align " role="button">Previous</a></span>
        @endif
        @if($Next != null)
            <span style="margin: 5px;">     <a href="/EditDebtor/{{$Next}}" class="btn btn-info align " role="button">Next</a></span>
        @endif
        @if($last != null)
            <span style="margin: 5px;">     <a href="/EditDebtor/{{$last}}" class="btn btn-info align " role="button">Last</a></span>
        @endif
        <h4>Update Debtor</h4>
        <div id="exTab3" class="container">
            <ul  class="nav nav-pills">
                <li class="active">
                    <a  href="#1b" data-toggle="tab">Debtor Detail</a>
                </li>
                <li><a href="#2b" data-toggle="tab">Debtor Notes</a>
                </li>
                <li><a href="#3b" data-toggle="tab">Docx Upload</a>
                </li>
                <li><a href="#4b" data-toggle="tab">Letters</a>
                </li>
            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active" id="1b">

                         <form name="form" method="post">
            {{ csrf_field() }}
            <input type="hidden" value="{{$creditor->DebtorID}}" name="updateDebtorID">
            <div id="viewDetail">
            <div class="row">
                <div class="col-md-2" >
                    <div class="form-group">
                        <label for="creditorID">Debtor ID:</label>
                        <input type="text" class="form-control" name="debtorID" value="{{$creditor->DebtorID}}" disabled>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="creditorID">Debtor Name:</label>
                        <input type="text" class="form-control" name="debtorName" value="{{$creditor->DebtorName}}" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="creditorID">Date Entered:</label>
                        <input type="date" class="form-control" name="dateEntered" value="{{$creditor->DateEntered}}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="creditorID">Salutation:</label>

                        <select class="form-control" name="Salutation" required>
                            <option value="Mr.">Mr.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Dr.">Dr.</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">First Name:</label>
                        <input type="text" class="form-control" name="firstName" value="{{$creditor->DFirstName}}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Last Name:</label>
                        <input type="text" class="form-control" name="lastName" value="{{$creditor->DLastName}}" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="creditorID">Email:</label>
                        <input type="email" class="form-control" name="Email" value="{{$creditor->Email}}" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Street:</label>
                        <input type="text" class="form-control" name="street" value="{{$creditor->Street}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Country:</label>
                        <input type="text" class="form-control" name="country" value="{{$creditor->Country}}" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">City:</label>
                        <input type="text" class="form-control" name="city" value="{{$creditor->City}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">State:</label>
                        <input type="text" class="form-control" name="state" value="{{$creditor->State}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Zip:</label>
                        <input type="text" class="form-control" name="zip" value="{{$creditor->Zip}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Fax:</label>
                        <input type="text" class="form-control" name="Fax"  value="{{$creditor->Fax}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Phone:</label>
                        <input type="text" class="form-control" id="Maskphone" name="phone" value="{{$creditor->Phone}}" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Client Account:</label>
                        <input type="text" class="form-control" name="clientAccount" value="{{$creditor->ClientAcntNumber}}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Status ID:</label>

                        <select class="form-control" name="statusID" required>
                            @foreach($sm as $s)
                                <option value="{{$s->StatusID}}" @if($s->StatusID == $creditor->StatusID) selected @endif>{{$s->StatusDesc}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Attorney:</label>
                        <i class="fa fa-pencil" aria-hidden="true" data-toggle="modal"  data-target="#myModal"></i>
                        <input type="hidden" class="form-control" name="attorneyID" value="@if($attorney->attorneyID !=null) {{$attorney->attorneyID}} @endif  ">
                        <input type="text" class="form-control" name="AttorneyName" value="{{$attorney->AttorneyName}}" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Creditor ID:</label>

                        <select class="form-control" name="creditorID2" id="creditorID2" required onchange="getContactName(this)">
                            <option value="">Select Creditor ID</option>
                            @foreach($cd as $s)
                                <option value="{{$s->CreditorID}}" @if($s->CreditorID == $creditor->CreditorID) selected @endif >{{$s->CreditorID}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Creditor:</label>

                        <select class="form-control" name="creditorID" id="creditorID" required onchange="getContactName(this)">
                            <option value="">Select Creditor</option>
                            @foreach($cd as $s)
                                <option value="{{$s->CreditorID}}" @if($s->CreditorID == $creditor->CreditorID) selected @endif >{{$s->ClientName}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Creditor Contact Name:</label>

                        <select class="form-control" id="creditorContactName" name="creditorContactName" value="{{$creditor->CreditorID}}" required>
                            @foreach($contact as $s)
                                <option value="{{$s->ContactID}}" @if($s->ContactID == $creditor->ContactID) selected @endif >{{$s->CFirstName}} {{$s->CLastName}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Collector's Name:</label>

                        <select class="form-control" name="colID" required>
                            @foreach($col as $s)
                                <option value="{{$s->ColID}}" @if($s->ColID == $creditor->ColID) selected @endif>{{$s->CLastName}}  {{$s->CFirstName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Last Date:</label>
                        <input type="date" class="form-control" name="lastDate" value="{{$creditor->LastDate}}" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Form Date:</label>
                        <input type="date" class="form-control" name="formDate" value="{{$creditor->FormDate}}" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Amount Placed:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="amountPlaced" value="{{number_format ($creditor->AmountPlaced,2)}}" required>
                    </div></div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Balance Due:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>

                            <input type="text" class="form-control txtboxToFilter" name="balanceDue" value="{{floatval($creditor->AmountPlaced) -floatval($pending)}}" required>
                        </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Amount Paid:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>

                            <input type="text" class="form-control txtboxToFilter" name="AmountPaid" value="{{floatval($pending)}}" required>
                        </div></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Cost Advance:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="costAdvance" value="{{$creditor->CostAdv}}" >
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Suit Fee:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="suitFee" value="{{$creditor->SuitFee + $MISCFeeTrustVal}}" >
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Cost Recover:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="costRecover" value="{{$creditor->CostRec+$CostRecoveredVal}}" >
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Fees:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input type="text" class="form-control txtboxToFilter" name="fees" value="{{$creditor->Fees+$FeesVal}}" >
                    </div></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="compreport">Last Updated:</label>
                        <input class="form-control" type="date" name="LastUpdate" value="{{$creditor->LastUpdate}}"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="compreport">User Updated:</label>
                        <input class="form-control" name="LastUpdate" value="{{$creditor->UserUpdated}}"/>
                    </div>
                </div>
            </div>
            </div>
            <br><br>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Update Debtor">
            </div>
        </form>

                </div>
                <div class="tab-pane" id="2b">
                    <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ActivityCode">Activity Code:</label>
                            <i aria-hidden="true" onclick="activityCodeUpdate();" data-toggle="modal" data-target="#activityCodeModal" class="fa fa-pencil" title="Edit Activity Code"></i>
                            <i aria-hidden="true" onclick="activityCodeAdd();" data-toggle="modal" data-target="#activityCodeModal" class="fa fa-plus" title="Add Activity Code"></i>
                            <select class="form-control" name="ActivityCode" id="ActivityCode" required>
                                @foreach($activityCode as $s)
                                    <option value="{{$s->CodeID}}" >{{$s->Detail}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        <div class="col-md-1">
                            <button class="btn btn-default align" role="button" id="AddActivityCode">Add Activity Code</button>
                        </div>
                        <div class="col-md-6">

                        </div>
                    <div class="col-md-2 ">

                        <button class="btn btn-default align pull-right" role="button" data-toggle="modal"  data-target="#noteModal">Add Note</button>
                    </div>
                    </div>
                    <div class="row">


                    @if (count($notes) > 0)

                        <table class="table table-striped task-table">
                            <thead>
                            <th>Note</th>
                            <th>By</th>
                            <th>TimeStamp</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($notes as $cd)
                                <tr>
                                    <td class="table-text" >
                                        <div>{{ $cd->Detail }}</div>
                                    </td>
                                    <td class="table-text" >
                                        <div>{{ $cd->User }}</div>
                                    </td>
                                    <td class="table-text" >
                                        <div>{{ $cd->DateTime }}</div>
                                    </td>

                                    <td class="pull-right">


                                            {{ csrf_field() }}

                                        <button onclick="noteUpdate('{!! $cd->NoteID !!}','{!! $cd->Detail !!}');" data-toggle="modal"  data-target="#noteModal" name="edit" class="btn btn-primary">Edit</button>
                                            <button onclick="noteDelete('{!! $cd->NoteID !!}','{!! $creditor->DebtorID !!}');" name="delete" class="btn btn-danger noteDlete">Delete</button>


                                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getContactName({{$cd}})" data-target="#exampleModal">
                                View
                            </button>-->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <br>
                        <div class = "alert alert-danger">
                            Currently no notes available
                        </div>
                    @endif
                    </div>
                </div>
                <div class="tab-pane" id="3b">
                    <div class="row">

                            <form name="form" method="post" action="/UploadFile/{{$creditor->DebtorID}}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Upload File </label>
                                        <input type="file" name="importFile" class="form-control" accept=".xlsx, .xls, .csv">
                                    </div>
                                </div>

                                <br><br>
                                <div class="col-md-2 pull-right">
                                    <div class="form-group">
                                        <input type="submit" name="view" class="form-control btn btn-primary" value="Upload">
                                    </div>
                                </div>
                            </form>
                    </div>
                    <div class="row">


                        @if (count($files) > 0)

                            <table class="table table-striped task-table">
                                <thead>
                                <th>File Name</th>
                                <!--<th>Comments</th>-->
                                <th>File size</th>
                                <th>By</th>
                                <th>Upload Date</th>
                                <th>Download</th>
                                </thead>
                                <tbody>
                                @foreach ($files as $cd)
                                    <tr>
                                        <td class="table-text" >
                                            <div>{{ $cd->FileName	 }}</div>
                                        </td>
                                        <td class="table-text" >
                                            <div>{{ floatval($cd->Filesize)/1000 }} KB</div>
                                        </td>
                                        <td class="table-text" >
                                            <div>{{ $cd->User }}</div>
                                        </td>
                                        <td class="table-text" >
                                            <div>{{ $cd->created_at }}</div>
                                        </td>
                                        <td class="table-text">
                                            <a href="/Donwload/{{ $cd->FileID}}" class="btn btn-large" target="_blank"><i class="icon-download-alt"> </i> Download  </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <br>
                            <div class = "alert alert-danger">
                                Currently no file uploaded
                            </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane" id="4b">
                    <form name="form" method="post" action="/Letters/{{$creditor->DebtorID}}"  target="_blank">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="colID">Letter Type:</label>

                                    <select class="form-control" name="LetterType" required>

                                        @foreach($temp as $s)
                                            <option value="{{$s->TemplateID}}">{{$s->Name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2" >
                                <div class="form-group">
                                    <label for="colID">Export Report:</label>

                                    <select class="form-control" name="Export" id="Export" >
                                        <option value="PDF">PDF</option>
                                        <option value="DOC">MS Word</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="submit" name="view" class="form-control btn btn-primary" value="Export">
                            </div>
                        </div>
                        <div class="col-md-6" hidden>
                            <div class="form-group">
                                <input type="submit" name="view" class="form-control btn btn-primary" value="Export">
                            </div>
                        </div>
                    </form>
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
                    <h4 class="modal-title">Attorney Information</h4>
                </div>
                <div class="modal-body">
                    <form id="attorneyForm">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3" >
                                <div class="form-group">
                                    <label for="creditorID">Attorney Name:</label>
                                    <input type="hidden" class="form-control" name="AttorneyRequest" value="Yes" >
                                    <input type="hidden" class="form-control" name="updateAttorneyID" value="@if($attorney->attorneyID !=null) {{$attorney->attorneyID}} @endif  "  >
                                    <input type="text" class="form-control" name="AttorneyName" value="{{$attorney->AttorneyName}}"  required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Firm Name:</label>
                                    <input type="text" class="form-control" name="FirmName" value="{{$attorney->FirmName}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Street 1:</label>
                                    <input type="text" class="form-control" name="Street1"value="{{$attorney->Street1}}" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Street 2:</label>
                                    <input type="text" class="form-control" name="Street2"value="{{$attorney->Street2}}" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">City:</label>
                                    <input type="text" class="form-control" name="City" value="{{$attorney->City}}" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">State:</label>
                                    <input type="text" class="form-control" name="State" value="{{$attorney->State}}" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Zip:</label>
                                    <input type="text" class="form-control" name="Zip" value="{{$attorney->Zip}}" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="creditorID">Email:</label>
                                    <input type="email" class="form-control" name="Email" value="{{$attorney->Email}}" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Cell#:</label>
                                    <input type="text" class="form-control" name="Cell" value="{{$attorney->Cell}}" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Phone#:</label>
                                    <input type="text" class="form-control" name="Phone" value="{{$attorney->Phone}}" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Fax#:</label>
                                    <input type="text" class="form-control" name="Fax" value="{{$attorney->Fax}}" >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Website:</label>
                                    <input type="text" class="form-control" name="Website" value="{{$attorney->Website}}" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Bar Number:</label>
                                    <input type="text" class="form-control" name="BarNumber" value="{{$attorney->BarNumber}}" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="creditorID">Representation Capacity:</label>
                                    <input type="text" class="form-control" name="RepresentationCapacity" value="{{$attorney->RepresentationCapacity}}" >
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="attorneyFormSave"  class="btn btn-primary" >Save</button>
                    <form action="/DelAttorney/{{$creditor->DebtorID}}" method="post" class="inline">
                        <input type="hidden" class="form-control" name="ID" value="{{$attorney->attorneyID}}"  >
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        {{ csrf_field() }}
                    </form>

                    <button type="button" id="closeModal" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="noteModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Note Information</h4>
                </div>
                <div class="modal-body">
                    <form id="noteForm">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="creditorID">Note:</label>

                                    <input type="hidden" class="form-control" name="updateNoteID" value=""  >

                                    <textarea class="form-control" name="NoteDetail" required>

                                    </textarea>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="noteFormSave"  class="btn btn-primary" >Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div id="activityCodeModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Activity Code Information</h4>
                </div>
                <div class="modal-body">
                    <form id="ActivityCodeForm">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="creditorID">Activity Code:</label>

                                    <input type="hidden" class="form-control" name="updateCodeID" value=""  >

                                    <textarea class="form-control" name="CodeDetail" required>

                                    </textarea>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="ActivityCodeFormSave"  class="btn btn-primary" >Save</button>
                    <button type="button" id="ActivityCodeFormDelete"  class="btn btn-warning" >Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">
        function getContactName(e){
            // $.ajax({url: "./GetContact", success: function(result){
            //     console.log(result);
            // }});
            $('#creditorID2').val(e.value);
            $('#creditorID').val(e.value);
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
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
           // $('input[type=date]').val(today);
            $(".txtboxToFilter").change(function (e) {
                console.log();
                $(this).val(CurrencyFormat2(parseFloat($(this).val().replace(',','')).toFixed(2)));
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
            $("#attorneyFormSave").click(function(e) {
                e.preventDefault();
                var aa=$('#attorneyForm').serialize();
                console.log(aa);
                $.ajax({
                    type: 'POST',
                    data: $('#attorneyForm').serialize(),
                    success: function(data) {
                        var ii=data;
                        $('input[name=AttorneyName]').val(ii.AttorneyName);
                        $('input[name=attorneyID]').val(ii.id);
						alert('Data Saved Successfully..');
                        $('#closeModal').click();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });//here
            $("#attorneyFormDelete").click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url:'/DelAttorney',
                    data: {
                        ID:$('input[name=attorneyID]').val(),
                    },
                    success: function(data) {
                        $('input[name=AttorneyName]').val('');
                        $('input[name=attorneyID]').val('');
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });//here
            $("#noteFormSave").click(function(e) {
                e.preventDefault();
                var data = $('#noteForm').serializeArray();
                data.push({name: 'DebtorID', value: $('input[name=updateDebtorID]').val()});
                $.ajax({
                    type: 'POST',
                    url:'/AddNote',
                    data: data,
                    success: function(data) {

                        location.reload();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });//here
            $("#AddActivityCode").click(function(e) {
                e.preventDefault();
                var data = Array();
                var token=$('input[name=_token]').val();
                data.push({name: '_token', value: token});
                data.push({name: 'NoteDetail', value: $('#ActivityCode :selected').text()});
                data.push({name: 'DebtorID', value: $('input[name=updateDebtorID]').val()});
                $.ajax({
                    type: 'POST',
                    url:'/AddNote',
                    data: data,
                    success: function(data) {
                        alert('Note Added...');
                        location.reload();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });//here
            $("#ActivityCodeFormSave").click(function(e) {
                e.preventDefault();
                var data = $('#ActivityCodeForm').serializeArray();
                $.ajax({
                    type: 'POST',
                    url:'/AddActivityCode',
                    data: data,
                    success: function(data) {

                        location.reload();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            });
            var token=$('input[name=_token]').val();
            $.ajax({
                type: 'GET',
                url:'/calculationDebit/'+$('input[name=debtorID]').val(),
                data:{
                    _token:token
                },
                success: function(data) {
                    console.log(data);
                    var obj = data;
                    var placed = parseFloat($('input[name=amountPlaced]').val().replace(',',''));
                    var costRecover =parseFloat($('input[name=costRecover]').val().replace(',','')).toFixed(2);
                    var suitFee =parseFloat($('input[name=suitFee]').val().replace(',','')).toFixed(2);
                    var fees =parseFloat($('input[name=fees]').val().replace(',','')).toFixed(2);
                    placed-=parseFloat(obj.pending).toFixed(2);
                    costRecover = (parseFloat(costRecover) + parseFloat(obj.CostRecoveredVal)).toFixed(2);
                    suitFee+=parseFloat(obj.MISCFeeTrustVal).toFixed(2);
                    fees+=parseFloat(obj.FeesVal).toFixed(2);
                    $('input[name=AmountPaid]').val(parseFloat(obj.pending).toFixed(2));
                    $('input[name=balanceDue]').val(parseFloat(placed).toFixed(2));
                    $('input[name=costRecover]').val(parseFloat(costRecover).toFixed(2));
                    $('input[name=suitFee]').val(parseFloat(suitFee).toFixed(2));
                    $('input[name=fees]').val(parseFloat(fees).toFixed(2));
                },
                error: function(data) {
                    console.log("unsuccessful");
                }
            });

            $("#Maskphone").mask("(999) 999-9999");

        });
        function noteUpdate(id,DebtorID){

            $('input[name=updateNoteID]').val(id);
            $('textarea[name=NoteDetail]').val(DebtorID);
        }

        function activityCodeUpdate(){

            $('input[name=updateCodeID]').val($('#ActivityCode :selected').val());
            $('textarea[name=CodeDetail]').val($('#ActivityCode :selected').text());
            $('#ActivityCodeFormDelete').show();
        }
        function activityCodeAdd(){
            $('input[name=updateCodeID]').val('');
            $('textarea[name=CodeDetail]').val('');
            $('#ActivityCodeFormDelete').hide();
        }
        function noteDelete(id,DebtorID){
            if (confirm('Are you sure you want to delete')) {
                var token=$('input[name=_token]').val();
                $.ajax({
                    type: 'POST',
                    url:'/DelNote/'+DebtorID,
                    data: {
                        ID:id,
                        _token:token,
                    },
                    success: function(data) {
                        alert('Note Deleted..!!')
                        location.reload();
                    },
                    error: function(data) {
                        console.log("Signup was unsuccessful");
                    }
                });
            }
        }

        //aa.replace(/\B(?=(\d{3})+\b)/g, ",").replace(/-(.*)/, "($1)");
    </script>

@endsection

