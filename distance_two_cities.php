<!DOCTYPE html>
<html lang="en">
<head>
  <title>Auto Complete</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
<div class="container">
  <div class="row" style="margin-top:150px" id="draggable"s>

  	<div class="col-md-4 offset-md-4">

  		<div class="card" style="padding: 30px">
			  		<h4 class="text-center text-info">Auto Complete</h4>
			  	<form id="form">
			  		<div class="form-group">
			  			<input type="text"  name="name" id="map2" autocomplete="off" placeholder="Type something" class="map form-control"  required="">
			  		</div>
			  		<div class="form-group">
			  			<input type="text" id="map1"  name="name" autocomplete="off" placeholder="Type something" class="form-control"  required="">
			  		</div>
			  		<div class="form-group">
			  			<input type="submit" name="" class="form-control btn btn-info" >
			  		</div>
			  	</form>
			  	<div id="show" style="display: none;">
			  		<table>
			  			<tr>
			  				<td>From</td>
			  				<td id="from">:</td>
			  			</tr>

			  			<tr>
			  				<td>To:</td>
			  				<td id="to">:</td>
			  			</tr>

			  			<tr>
			  				<td>Distance(KM)</td>
			  				<td id="km">:</td>
			  			</tr>

			  			<tr>
			  				<td>Distance(Miles)</td>
			  				<td id="miles">:</td>
			  			</tr>

			  			<tr>
			  				<td>Time</td>
			  				<td id="time">:</td>
			  			</tr>
			  		</table>
			  	</div>
  		</div>

  	</form>
  		</div>
  		<div id="result"></div>
  		<p></p>
  	</div>

  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="//maps.googleapis.com/maps/api/js?key=YOUR API&sensor=false&libraries=places&language=en" type="text/javascript"></script>
       
    <script type="text/javascript">
    	       	 var darection = new google.maps.DirectionsRenderer;
        var directionsService = new google.maps.DirectionsService;
        google.maps.event.addDomListener(window, 'load', function () {
            new google.maps.places.SearchBox(document.getElementById('map1'));
        });
	
		
		 var darection = new google.maps.DirectionsRenderer;
        var directionsService = new google.maps.DirectionsService;
        google.maps.event.addDomListener(window, 'load', function () {
            new google.maps.places.SearchBox(document.getElementById('map2'));
        });
        // calculate distance
        $(document).on("submit","#form",function(e){
        	e.preventDefault()
        	calculateDistance()
        });
        function calculateDistance() {
        	var origin=$("#map1").val();
        	var destination=$("#map2").val();
  //      	alert(origin)
            var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix(
                {
                    origins: [origin],
                    destinations: [destination],
                    travelMode: google.maps.TravelMode.DRIVING,
                    unitSystem: google.maps.UnitSystem.IMPERIAL, // miles and feet.
                    // unitSystem: google.maps.UnitSystem.metric, // kilometers and meters.
                    avoidHighways: false,
                    avoidTolls: false
                }, callback);
        }
        // get distance results
        function callback(response, status) {
        	console.log(response);
            if (status != google.maps.DistanceMatrixStatus.OK) {
                $('#result').html(err);
            } else {
                var origin = response.originAddresses[0];
                var destination = response.destinationAddresses[0];
                if (response.rows[0].elements[0].status === "ZERO_RESULTS") {

                    $('#result').html("Better get on a plane. There are no roads between "  + origin + " and " + destination);
                } else {
                    var distance = response.rows[0].elements[0].distance;
                    var duration = response.rows[0].elements[0].duration;
//                    console.log(response.rows[0].elements[0].distance);
                    var distance_in_kilo = distance.value / 1000; // the kilom
                    var distance_in_mile = distance.value / 1609.34; // the mile
                    var duration_text = duration.text;
                    var duration_value = duration.value;
                    $("#show").show();
                    $("#from").text(origin);
                    $("#to").text(destination);
                    $("#km").text(distance_in_kilo);
                    $("#miles").text(distance_in_mile);
                    $("#time").text(duration_text)
                 }
            }
        }

    </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
</body>
</html>
