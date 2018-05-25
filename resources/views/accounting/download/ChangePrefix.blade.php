@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>

                    <div class="panel-body">
                        
                        <form class="form-horizontal" name="form" method="post">
                            {{ csrf_field() }}
                            <input id="name" type="hidden" class="form-control" name="updateUserID" value="1" required autofocus>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="preFix" value="{{$preFix}}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Change
                                    </button>
                                </div>
                            </div>
                        </form>
                        <table>
                            <tr>
                               <th width="20%">FileName</th>
                               <th >url</th>
                               <th >downloadName</th>
                               <th>Exist<th/>
                            </tr>
                            @foreach ($files as $cd)
                            <tr>
                                <td width="20%">{{$cd->FileName}}</td>
                                <td>
                                    @if ($cd->fileExist)
                                        <span style="color:black">
                                        {{$cd->url}}
                                        </span>
                                    @else
                                        <span style="color:red">
                                        <strong>{{$cd->url}}</strong>
                                        </span>
                                    @endif
                                <td>{{$cd->downloadName}}</td>
                                <td>
                                    @if ($cd->fileExist)
                                        <span >
                                        <strong>Yes</strong>
                                        </span>
                                    @else
                                        <span >
                                        <strong>No</strong>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">{{$cd->generatedPath}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">DebtorID &nbsp;&nbsp;&nbsp;&nbsp; {{$cd->DebtorID}}</td>
                                <td colspan="2">Filename &nbsp;&nbsp;&nbsp;&nbsp; {{$cd->FileName}}</td>
                            </tr>
                            <tr>
                                <td>
                                    @if (!$cd->fileExist)
                                        <a href="/EditDebtor/Delete/{{$cd->FileID}}?preFix=1" class="btn btn-large btn-danger"><i class="icon-download-alt"></i> Delete  </a>
                                    @endif
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
