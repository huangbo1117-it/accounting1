@extends('layouts.app')

@section('content')
    <div class="container">

            <div class = "alert alert-success">
                <ul>
                    <li>Import One by one file </li>
                    <li>Creditor and Contacts file import at same  time </li>
                </ul>
            </div>

    </div>
    <div class="container">
        <h1>Import</h1>
        <form name="form" method="post"  enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-md-12">
                <div class="form-group">
                    <label>Upload Collector File </label>
                    <input type="file" name="Collector" class="form-control" accept=".xlsx, .xls, .csv">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Upload Creditor Contact File </label>
                    <input type="file" name="CreditorContact" class="form-control" accept=".xlsx, .xls, .csv">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Upload Creditor File </label>
                    <input type="file" name="Creditor" class="form-control" accept=".xlsx, .xls, .csv">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Upload Debtor File </label>
                    <input type="file" name="Debtor" class="form-control" accept=".xlsx, .xls, .csv">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Upload Payment File </label>
                    <input type="file" name="Payment" class="form-control" accept=".xlsx, .xls, .csv">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Upload Status File </label>
                    <input type="file" name="Status" class="form-control" accept=".xlsx, .xls, .csv">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Upload SaleMan File </label>
                    <input type="file" name="SaleMan" class="form-control" accept=".xlsx, .xls, .csv">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Upload Invoice File </label>
                    <input type="file" name="Invoice" class="form-control" accept=".xlsx, .xls, .csv">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Upload Notes File </label>
                    <input type="file" name="Notes" class="form-control" accept=".xlsx, .xls, .csv">
                </div>
            </div>
            <br><br>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="submit" name="view" class="form-control btn btn-primary" value="Import">
                </div>
            </div>
        </form>
    </div>
@endsection