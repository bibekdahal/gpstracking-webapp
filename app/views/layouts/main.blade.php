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
                padding-top: 40px;
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
            <div class="navbar-brand" ><span style="color:#292;">GPS Tracking System</span></div>
            </div>
            <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li @if($active=="Home")class="active"@endif><a href="index">Home</a></li>
            </ul>
            <ul class="nav nav-pills pull-right">
                @if(Auth::check())
                <li>
                    {{ Form::open(array('url'=>'home')) }}
                        <button class="btn btn-primary btn-block" style="padding: 15px 20px;" type="submit">Log Out</button>
                    {{ Form::close() }}
                </li>
                @endif
            </ul>
            </div>
        </div>
        </div>

        <br/><br/>
        {{ $content }}
        

        {{ HTML::script('js/jquery.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        @yield('footer')
    </body>
</html>