@extends('layouts.app2')

@section('content')
<style>
[ng\:cloak], [ng-cloak], .ng-cloak {
  display: none !important;
}
</style>
    <div class="container ng-cloak" >
        <div class="row" ng-init="loadSearch()">

            <div >

                <div class="col-md-11">
                    <input type="text" class="form-control" my-enter="loadSearch()" name="searchCreditor" ng-model="searchCreditor"  placeholder="Global Search" >
                </div>
                <div class="col-md-1">
                    <input type="submit" ng-click="loadSearch()" class="btn btn-primary" value="Search" >
                </div>

            </div>

        </div>
        <br>
        <div class="row" ng-show='user.CreditorID !=null'>
            <div class="col-md-3" >
                <div class="single category">
                    <h3 class="side-title">Debtors</h3>
                    <ul class="list-unstyled">
                        <li ng-repeat="F in searchResult" ng-click="loadProfile(F)">
                            <div >[[F.DebtorName]]
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-9" ng-show="showProfile">
                <div class="col-md-12">


                <div class="portlet blue-hoki box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-user"></i>Debtor Information </div>

                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-md-6 value"> [[searchProfile.Debtor.DebtorName]]<br>
                                <small>[[searchProfile.Debtor.Street]]</small>
                            </div>
                            <div class="col-md-3 name"> Date Entered: </div>
                            <div class="col-md-3 value"> [[searchProfile.Debtor.DateEntered]] </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-2 name"> Account #:</div>
                            <div class="col-md-4 value"> [[searchProfile.Debtor.ClientAcntNumber]] </div>
                            <div class="col-md-3 name"> Amount Placed:</div>
                            <div class="col-md-3 value"> $[[searchProfile.Debtor.AmountPlaced | number : 2]] </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-2 name"> Current Status:</div>
                            <div class="col-md-4 value"> [[searchProfile.StatusID.StatusDesc]] </div>
                            <div class="col-md-3 name"> Balance Due:</div>
                            <div class="col-md-3 value"> $[[searchProfile.Debtor.AmountPlaced - searchProfile.pending | number : 2]] </div>
                        </div>

                    </div>
                </div>
                </div>
                <div class="col-md-6">

                    <div class="portlet grey-cascade box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>Trust Payment Detail
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th> Payment ID </th>
                                        <th> Date Received </th>
                                        <th> Payment Received</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="row in searchProfile.payment">

                                        <td> [[row.TPaymentID]] </td>
                                        <td> [[row.DateRcvd  | date:'MM/dd/yyyy']] </td>
                                        <td> $[[row.PaymentReceived | number : 2]] </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="portlet grey-cascade box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>Invoice Payment Detail </div>

                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th> Payment ID </th>
                                        <th> Date Received </th>
                                        <th> Payment Received</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="row in searchProfile.invoice">

                                        <td> [[row.TPaymentID]] </td>
                                        <td> [[row.DateRcvd  | date:'MM/dd/yyyy']] </td>
                                        <td> $[[row.PaymentReceived | number : 2]] </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="portlet grey-cascade box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>Notes Detail </div>

                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th> Note</th>
                                        <th> By </th>
                                        <th> TimeStamp</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="row in searchProfile.notes">

                                        <td> [[row.Detail]] </td>
                                        <td> [[row.User]] </td>
                                        <td> [[row.DateTime]] </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        .single {
            padding: 30px 15px;

            background: #fcfcfc;
            border: 1px solid #f0f0f0;
            height: 475px;
            max-height: 475px;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .single h3.side-title {
            margin: 0;
            margin-bottom: 10px;
            padding: 0;
            font-size: 20px;
            color: #333;
            text-transform: uppercase; }
        .single h3.side-title:after {
            content: '';
            width: 60px;
            height: 1px;
            background: #ff173c;
            display: block;
            margin-top: 6px; }

        .single ul {
            margin-bottom: 0; }
        .single li div {
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
            border-bottom: 1px solid #f0f0f0;
            line-height: 40px;
            display: block;
            text-decoration: none;
            cursor: pointer;
        }
        .single li div:hover {
            color: #ff173c; }
        .single li:last-child div {
            border-bottom: 0; }
    </style>
    <link href="http://keenthemes.com/preview/metronic/theme/assets/global/css/components.min.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/angular.min.js') }}"></script>

    <script>
        var app = angular.module('myApp', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });
        app.directive('myEnter', function () {
            return function (scope, element, attrs) {
                element.bind("keydown keypress", function (event) {
                    if(event.which === 13) {
                        scope.$apply(function (){
                            scope.$eval(attrs.myEnter);
                        });

                        event.preventDefault();
                    }
                });
            };
        });
        app.controller('myCtrl', function($scope, $http) {
            $scope.showProfile=false;
$scope.user={};
            $scope.loadSearch = function(){
				if($scope.user.CreditorID == undefined){
					alert('select CreditorID');
					return;
				}	
                var tokenValue = angular.element('input[name="_token"]').attr('value');
                // $scope.SaleInformation["__RequestVerificationToken"] = tokenValue;
                $http.get("globalSearch",{
                    params: {
                        '_token': tokenValue,
                        'searchCreditor': $scope.searchCreditor,
                        'CreditorID':$scope.user.CreditorID
                    }})
                    .then(function(response) {
                        //First function handles success
                        $scope.searchResult =response.data;
                    }, function(response) {
                        //Second function handles error
                        console.log(response.data)
                    });
            }

            $scope.loadProfile = function(obj){
                var tokenValue = angular.element('input[name="_token"]').attr('value');
                // $scope.SaleInformation["__RequestVerificationToken"] = tokenValue;
                $http.get("loadProfile",{
                    params: {
                        '_token': tokenValue,
                        'ID': obj.ID,
                        'DebtorID': obj.DebtorID
                    }})
                    .then(function(response) {
                        //First function handles success
                        $scope.searchProfile= response.data;
                        $scope.showProfile=true;
                    }, function(response) {
                        //Second function handles error
                        console.log(response.data)
                    });
            }


        });
    </script>

@endsection

