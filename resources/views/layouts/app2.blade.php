<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui-1.7.2.custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
</head>
<body>
<div id="app"  ng-app="myApp" ng-controller="myCtrl">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }} - Client Portal
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="dropdown ">
                                <select class="form-control" ng-model="user.CreditorID" id="CreditorDropDown">

                                    @foreach( $Creditors as $ss)
                                        <option value="{{$ss->CreditorID}}" >{{$ss->CreditorID}}  </option>
                                    @endforeach
                                </select>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Reports <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/ClientTrustReport">Trust Reports</a></li>
                                    <li><a href="/ClientInvoiceReport">Invoice Reports</a></li>
                                    <li><a href="/StatusReport">Status Reports</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>

                            @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        @if(app('request')->msg != "")
            <div class = "alert alert-success">
                <ul>
                    <li>{{app('request')->msg}}</li>
                </ul>
            </div>
        @endif
    </div>

    <div class="container">
        @if (count($errors) > 0)
            <div class = "alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    @yield('content')
</div>

<!-- Scripts -->

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{asset('js/maskedinput.js')}}"></script>
<script src="{{asset('js/shieldui-all.min.js')}}"></script>
<script>
    $(function () {
        $('input').attr('autocomplete','off')
    });
    function CurrencyFormat(val){
        if(val == null)
            val=0;
        var neg=false;
        if(val >= 0){
            val =val.toFixed(2);
            neg=false;
        }
        if(val < 0){
            val =Math.abs(val).toFixed(2);
            neg=true;
        }
        while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        if(!neg){
            return '$'+val;
        }else{
            return '($'+val+')';
        }
        return val;
    }
    function CurrencyFormat2(val){
        var neg=false;
        if(val >= 0){
            val =val.toFixed(2);
            neg=false;
        }
        if(val < 0){
            val =Math.abs(val).toFixed(2);
            neg=true;
        }
        while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        if(!neg){
            return ''+val;
        }else{
            return '('+val+')';
        }
        return val;
    }
</script>
@yield('scripts')
</body>
</html>
