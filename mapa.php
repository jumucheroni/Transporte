<?php include './inc/header.php';
include './inc/conexao.php';
?>
        <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
				<div id="map"></div>
			</div>
		</div>

<?php include './inc/footer.php'; ?>

<script type="text/javascript">
/*	var map;
    function initMap() {
        var myLatLng = {lat: -22.331980, lng: -49.029568};
            var pointA = {lat: -22.331980, lng: -49.029568};
    var pointB = {lat: -22.333560, lng: -49.025712};
    var pointC = {lat: -22.330232, lng: -49.032303};

        myOptions = {
      zoom: 7,
      center: myLatLng
    }

  	map = new google.maps.Map(document.getElementById('map'), myOptions),
    
    directionsService = new google.maps.DirectionsService,
    directionsDisplay = new google.maps.DirectionsRenderer({
      map: map
    }),

  		markerA = new google.maps.Marker({
      		position: {lat: -22.331980, lng: -49.029568},
      		title: "point A",
      		label: "A",
      		map: map
    	});

    	markerB = new google.maps.Marker({
      		position: {lat: -22.333560, lng: -49.025712},
      		title: "point B",
      		label: "B",
      		map: map
    	});

    	markerC = new google.maps.Marker({
      		position: {lat: -22.330232, lng: -49.032303},
      		title: "point C",
      		label: "C",
      		map: map
    	});

  // get route from A to B
  calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);

} */

function initMap() {
	var geocoder;
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var locations = [
  ['Manly Beach', -22.331980, -49.029568, 2],
  ['Bondi Beach', -22.333560, -49.025712, 4],
  ['Coogee Beach', -22.330232, -49.032303, 5]
];
  directionsDisplay = new google.maps.DirectionsRenderer();


  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: new google.maps.LatLng(-22.331980, -49.029568),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  directionsDisplay.setMap(map);
  var infowindow = new google.maps.InfoWindow();

  var marker, i;
  var request = {
    travelMode: google.maps.TravelMode.DRIVING
  };
  for (i = 0; i < locations.length; i++) {
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i][0]);
        infowindow.open(map, marker);
      }
    })(marker, i));

    if (i == 0) request.origin = marker.getPosition();
    else if (i == locations.length - 1) request.destination = marker.getPosition();
    else {
      if (!request.waypoints) request.waypoints = [];
      request.waypoints.push({
        location: marker.getPosition(),
        stopover: true
      });
    }

  }
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
    }
  });
}



function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
  directionsService.route({
    origin: pointA,
    destination: pointB,
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });

  /*var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Hello World!'
  });*/
    }
</script>


