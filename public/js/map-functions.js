    function clickImage() {
        document.getElementById("map-img").removeAttribute('src');
    }

    var map;
    function addImage(lat, lng, imgsrc) {
            var imgOverlay;
            var bnd = 0.025 * Math.pow(2,12) / Math.pow(2, map.getZoom());
            var imageBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(lat, lng),
                new google.maps.LatLng(lat+bnd, lng+bnd));
            imgOverlay = new google.maps.GroundOverlay(imgsrc, imageBounds);
            imgOverlay.setMap(map);
            google.maps.event.addListener(imgOverlay, 'click', function() {
                document.getElementById("map-img").src = imgsrc;
            });
            return imgOverlay;
    }

    function initialize() {
        var mapOptions = {
            center: new google.maps.LatLng(27, 85),
            zoom: 15
        };
        map = new google.maps.Map(document.getElementById("map-canvas"),
                mapOptions);
        var bounds = new google.maps.LatLngBounds();

        /*var points = [
            new google.maps.LatLng(27.0172323, 85.214897),
            new google.maps.LatLng(27.0191982, 85.121856),
            new google.maps.LatLng(26.9999, 84.99431),
            new google.maps.LatLng(26.998, 84.99027892)
        ];*/    
        var image = new google.maps.MarkerImage("images/marker.png",
            null, 
            new google.maps.Point(0,0),
            new google.maps.Point(3, 3)
        );
        for (i=0; i<points.length; ++i)
        {
            var marker = new google.maps.Marker({
                position: points[i],
                map: map,
                icon: image,
                title: times[i]
            });
            bounds.extend(points[i]);
        }
        map.fitBounds(bounds);

        var linePath = new google.maps.Polyline({
            path: points,
            geodesic: true,
            strokeColor: '#0000ff',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        linePath.setMap(map);


        var images = [
            /*'http://imgs.xkcd.com/comics/darkness.png',
            'http://assets.amuniversal.com/b5110bd0541f01315eb4001dd8b71c47'*/
        ];
        var imagePoints = [
            2, 0
        ];  // index for points
        var imgOverlays = [];
        google.maps.event.addListener(map, 'zoom_changed', function() {
            for (i=0; i<images.length; ++i)
            {
                if (typeof imgOverlays[i] != 'undefined') imgOverlays[i].setMap(null);
                imgOverlays[i] = addImage(points[imagePoints[i]].lat(), points[imagePoints[i]].lng(), images[i]);
            }
        });

        google.maps.event.addListener(map, 'click', function(){
            clickImage();
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
