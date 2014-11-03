@section('header')
    @if($show_login) {{ HTML::style("css/sign-in.css") }} @endif
    @if($show_map)
        {{ HTML::style("css/lightbox.css") }}
        <style type="text/css">
            #map-parent {
                position: relative;
            }
            #map-canvas { 
                top: 20px;
                width: 100%;
                height: 400px;
            }
        </style>
        {{ HTML::script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDUn8hZ5V_pl0b2WYCx_c7tJJOjv-2Tpsk") }}

        <script type="text/javascript">
            var points = [
                <?php
                $i=0;
                foreach ($history as $data) {
                    echo 'new google.maps.LatLng(' . $data->latitude . ',' . $data->longitude . '),';
                    $images = $data->images()->get();
                    foreach ($images as $image) {
                        $imgsids[$image->id] = $i;
                    }
                    $i++;
                }
                ?>
            ];
            var images = [
                <?php
                    foreach ($history as $data) {
                        $images = $data->images()->get();
                        foreach ($images as $image) {
                            echo '"images/' . Auth::user()->email . '/' . $image->filepath . '",';
                        }
                        $i++;
                    }
                ?>
            ];
            var imgsizes = [
                <?php
                    foreach ($history as $data) {
                        $images = $data->images()->get();
                        foreach ($images as $image) {
                            $size = getimagesize('images/'.Auth::user()->email.'/'.$image->filepath);
                            echo ($size[0]/100000).','.($size[1]/100000).',';
                        }
                        $i++;
                    }
                ?>
            ];
            var imagePoints = [
                <?php
                    foreach ($history as $data) {
                        $images = $data->images()->get();
                        foreach ($images as $image) {
                            echo $imgsids[$image->id] . ',';
                        }
                        $i++;
                    }
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

    {{ Form::open(array('url'=>'login', 'class'=>'form-signin')) }}
    <h2 class="form-signin-heading">Please sign in</h2>
        @if(Session::has('message'))
            <p class="text-danger">{{ Session::get('message') }}</p>
        @endif
    <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
    <input type="password" name="password" class="form-control" placeholder="Password" required>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="remember" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    {{ Form::close() }}
@endif

@if($show_map)
    <h2>Your History</h2>
    <div id="map-parent">
        <div id="map-canvas"> </div>
        <a id="lightbox" href="#">
            <img id="map-img" />
            <!--div> At Location:... UNCOMMENT THIS TO PUT TEXT WITH IMAGE </div--> 
        </a>
    </div>

    <table class="table" style="margin-top:50px">
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
@endif