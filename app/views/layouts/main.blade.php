<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        {{ HTML::style('css/bootstrap.min.css') }}
        @if($styles!='') {{ HTML::style($styles) }} @endif

        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
                background-color: #eee;
            }
            li.active {
                font-weight: bold;
            }            
        </style>
        @yield('header')
    </head>
 
    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header" >
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand">GPS Tracking Application</div>
            </div>
            <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li @if($active=="Home")class="active"@endif><a href="index">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Faq</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                <li><a href="#">My Profile</a></li>
                <li><a href="home/logout" style="font-weight:bold;">Log Out</a></li>
                @endif
            </ul>
            </div>
        </div>
        </div>

        <div class="container">
        <div class="row">
        <div class="col-md-10 col-md-offset-1">

        {{ $content }}
        </div>
        </div>
        </div>
        

        {{ HTML::script('js/jquery.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        @yield('footer')
    </body>
</html>