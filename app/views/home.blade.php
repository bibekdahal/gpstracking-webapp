@section('header')
    @if($show_login) {{ HTML::style("css/sign-in.css") }} @endif
    @if($show_map)
        <style type="text/css">
            #map-parent {
                position: relative;
            }
            #map-canvas { 
                top: 20px;
                width: 100%;
                height: 400px;
            }
            #map-img {
                position: absolute;
                top: 80px;
                left: 20px;
                visibility: visible;
            }
        </style>
        {{ HTML::script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDUn8hZ5V_pl0b2WYCx_c7tJJOjv-2Tpsk") }}

        <script type="text/javascript">
            var points = [
                <?php
                foreach ($history as $data)
                    echo 'new google.maps.LatLng(' . $data->latitude . ',' . $data->longitude . '),';
                ?>
            ];
            var times = [
                <?php
                foreach ($history as $data)
                    echo '"'. $data->time . '",';
                ?>
            ];
            
        </script>
        {{ HTML::script("js/map-functions.js") }}
    @endif
@stop
@if ($show_login)
    <div class="container">
        @if(Session::has('message'))
            <p class="alert">{{ Session::get('message') }}</p>
        @endif
    </div>
    <div class="container">
        {{ Form::open(array('url'=>'login', 'class'=>'form-signin')) }}
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        {{ Form::close() }}
    </div>
@endif

@if($show_map)
    <div id="map-parent">
        <div id="map-canvas"> </div>    
        <img id="map-img" onclick="clickImage();" />
    </div>
    <div class="container" style="margin-top:50px">
        <table class="table">
            <thead>
                <tr>
                    <th>Phone Id</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Speed</th>
                    <th>Direction</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($history as $data)
                echo '<tr>
                        <td>'.$data->phone_id.'</td>
                        <td>'.$data->latitude.'</td>
                        <td>'.$data->longitude.'</td>
                        <td>'.$data->speed.'</td>
                        <td>'.$data->direction.'</td>
                        <td>'.$data->time.'</td>
                    </tr>'
                ?>
            </tbody>
        </table>     
    </div>                             
@endif