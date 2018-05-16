@extends('layouts.app')

@section('content')

    <div class="container" ng-app="myApp" ng-controller="myCtrl">

        <div class="row">
            <div class="col-md-2">

                <ul class="list-group">

                    @foreach( $Role as $ss)
                        <li class="list-group-item" style="cursor: pointer;" ng-click="loadRight({{$ss}})">{{$ss->name}}</li>
                    @endforeach

                </ul>
                <form action="/Rights" name="form" method="post">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" name="GroupName" placeholder="New Group" required><br>
                    <input type="submit" class="btn btn-primary" value="New">
                </form>
                <form action="/RightsFieldsConfig" name="form" method="post" style="display: none;">
                    {{ csrf_field() }}

                    <select class="form-control" name="ScreenName" required>
                        <option value="Menu">Menu</option>
                        <option value="Invoice">Invoice</option>
                        <option value="Creditor">Creditor</option>
                        <option value="Debitor">Debitor</option>
                        <option value="TrustActivity">TrustActivity</option>
                    </select>
                    <input type="text" class="form-control" name="FieldName" placeholder="FieldName" required><br>
                    <input type="text" class="form-control" name="Alies" placeholder="Alies" required><br>
                    <input type="submit" class="btn btn-primary" value="New Field">
                </form>
            </div>
            <div class="col-md-10">
                <div class="col-md-5">
                    <label> Group : [[SelectedGroup]]</label>  <input type="button"  ng-disabled="checkChange()" ng-click="updateRights()" class="btn btn-primary" value="Update Rights">
                </div>
                <div class="col-md-7">
                    <div class="col-md-2"    ng-repeat="F in Fields | filter:{ ScreenName: 'Menu' }">[[F.Alies]]

                                            <input type="checkbox" ng-model="F.Set" ng-change="rightsChange(F)" ng-checked="F.Active">

                    </div>

                </div>
                <div class="col-md-12">


                    <div class="col-md-3">
                        <div class="single category">
                            <h3 class="side-title">Creditor</h3>
                            <ul class="list-unstyled">
                                <li ng-repeat="F in Fields | filter:{ ScreenName: 'Creditor' }">
                                    <div href="" title="">[[F.Alies]]
                                        <span class="pull-right">
                                            <input type="checkbox" ng-model="F.Set" ng-change="rightsChange(F)" ng-checked="F.Active"></span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="single category">
                            <h3 class="side-title">Debtors</h3>
                            <ul class="list-unstyled">
                                <li ng-repeat="F in Fields | filter:{ ScreenName: 'Debitor' }">
                                    <div href="" title="">[[F.Alies]]
                                        <span class="pull-right"><input type="checkbox" ng-model="F.Set" ng-change="rightsChange(F)" ng-checked="F.Active"></span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="single category">
                            <h3 class="side-title">Trust Activity</h3>
                            <ul class="list-unstyled">
                                <li ng-repeat="F in Fields | filter:{ ScreenName: 'Activity' }">
                                    <div href="" title="">[[F.Alies]]
                                        <span class="pull-right"><input type="checkbox" ng-model="F.Set" ng-change="rightsChange(F)" ng-checked="F.Active"></span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="single category">
                            <h3 class="side-title">Invoice</h3>
                            <ul class="list-unstyled">
                                <li ng-repeat="F in Fields | filter:{ ScreenName: 'Invoice' }">
                                    <div href="" title="">[[F.Alies]]
                                        <span class="pull-right"><input type="checkbox" ng-model="F.Set" ng-change="rightsChange(F)" ng-checked="F.Active"></span>
                                    </div>
                                </li>

                            </ul>
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
            margin-top: 40px;
            background: #fcfcfc;
            border: 1px solid #f0f0f0; }
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
            text-decoration: none; }
        .single li div:hover {
            color: #ff173c; }
        .single li:last-child div {
            border-bottom: 0; }
    </style>
    <script src="{{ asset('js/angular.min.js') }}"></script>

    <script>
        var app = angular.module('myApp', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });
        app.controller('myCtrl', function($scope, $http) {
            $scope.changedRights= new Array();

            $scope.loadRight = function(obj){
                $scope.SelectedGroup=obj.name;
                $scope.changedRights= new Array();
                var tokenValue = angular.element('input[name="_token"]').attr('value');
               // $scope.SaleInformation["__RequestVerificationToken"] = tokenValue;
                $http.get("RightsFields",{
                    params: {
                        '_token': tokenValue,
                        'RoleID': obj.id
                    }})
                    .then(function(response) {
                        //First function handles success
                        angular.forEach(response.data, function(value, key) {
                            console.log(value);
                            value.Set=value.Active == 1 ? true : false;
                        });
                        $scope.Fields=response.data;

                    }, function(response) {
                        //Second function handles error
                        console.log(response.data)
                    });
            }
            $scope.rightsChange = function(obj){
                var typ=false;
                angular.forEach($scope.changedRights, function(value, key) {
                    if(value.ID == obj.ID){
                        value.Set=obj.Set;
                        typ=true;
                    }
                });
                if (!typ) {
                    $scope.changedRights.push(obj);
                }
                console.log($scope.changedRights);
            }
            $scope.checkChange = function() {
                if ($scope.changedRights.length == 0) { // your question said "more than one element"
                    return true;
                }
                else {
                    return false;
                }
            };
            $scope.updateRights = function(){
                var tokenValue = angular.element('input[name="_token"]').attr('value');
                $scope.Information={};
                $scope.Information["_token"] = tokenValue;
                $scope.Information["RightsFields"] = $scope.changedRights;
                     $http({
                    method: 'POST',
                    url: '/RightsFields',
                    headers: {
                        'Content-Type' : 'application/x-www-form-urlencoded'
                    },
                    data: $.param($scope.Information)
                }).then(function(response) {
                         //First function handles success
                         if(response.data){
                             alert('Rights updated Successfully...')
                         }
                        console.log(response.data);
                         $scope.changedRights= new Array();
                     }, function(response) {
                         //Second function handles error
                         console.log(response.data)
                     });
            }
        });
    </script>

@endsection