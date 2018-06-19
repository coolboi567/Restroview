<?php
require_once 'server.php';
require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Restroview - Restaurant's Review and Rating</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, shrink-to-fit=no" />
	<link rel="icon" type="image/png" href="images/favicon.png"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<!--===============================================================================================-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<!--===============================================================================================-->
	<link rel="stylesheet" href="css/main.css?a=1">
	<!--===============================================================================================-->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
	<img src="Triangles-2.1s-200px.svg" class="loader">
	<div class="container text-info mb-5">
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
			<a href="index.php"><img src="images/favicon.png" alt="Logo" style="width:50px;"></a>
			&nbsp;&nbsp;
			<a class="navbar-brand" href="#">RESTROVIEW</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php"><i class="fas fa-home fa-lg"></i> Home</a>
					</li>
					<?php
					if(!isset($_SESSION['user']) || empty($_SESSION['user']))
					{
						?>
						<li class="nav-item">
							<a class="active nav-link" href="restaurant-login.php"><i class="fas fa-utensils fa-lg"></i> Restaurant Portal</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="login.php"><i class="fas fa-users fa-lg"></i> User Portal</a>
						</li>
						<?php
					}
					?>
					<li class="nav-item">
						<a class="nav-link" href="about-us.php"><i class="fas fa-map-marker-alt fa-lg"></i> About us</a>
					</li>
				</ul>
				<?php
				if(isset($_SESSION['success']) && !empty($_SESSION['success']))
				{
					?>
					<form class="form-inline my-2 my-lg-0">
						<button class="btn btn-secondary my-2 my-sm-0" type="submit" name="logout"><i class="fas fa-user fa-lg"></i> Profile</button>
					</form>
					&nbsp;&nbsp;&nbsp;
					<form class="form-inline my-2 my-lg-0">
						<button class="btn btn-secondary my-2 my-sm-0" type="submit" name="logout"><i class="fas fa-sign-out-alt fa-lg"></i> Logout</button>
					</form>
					<?php
				}
				?>
			</div>  
		</nav>

		<?php require_once 'errors-success.php'; ?>

		<div class="row pt-2">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div>
					<h2 class="text-white bg-info text-center">Restaurant Register</h2>
				</div>
				<form action="" method="POST">
					<div class="form-group">
						<label for="email">Email address:</label>
						<input type="email" class="form-control" id="email" required="required" name="email">
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" id="pwd" required="required" name="pwd">
					</div>
					<div class="form-group">
						<label for="pwd_2">Confirm Password:</label>
						<input type="password" class="form-control" id="pwd_2" required="required" name="pwd_2">
					</div>
					<div class="form-group">
						<label for="name">Restaurant Name:</label>
						<input type="text" class="form-control" id="name" required="required" name="name">
					</div>
					<div class="form-group">
						<label for="phone">Phone Number:</label>
						<input type="phonenumber" class="form-control" id="phone" required="required" name="phone">
					</div>
					<div class="form-group">
						<label for="name">Location:</label>
						<select name="place" id="place" class="form-control selection-2">
							<option selected="true" disabled="disabled" value="">Select location</option>
							<?php
							$json  =  file_get_contents("cities.json");
							$data  =  json_decode($json);
							foreach($data as $cities) {
								$city=$cities->city;
								echo "<option value='".$city."'>".ucfirst($city)."</option>\n";
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="desc">Description:</label>
						<textarea class="form-control" type="text" name="desc" value="Describe about the Restaurant. What is special about this restaurant. And Which category of food and drinks are available."></textarea> 
					</div>
					<div class="form-group">
						<label for="latlon">Location:</label>
						<input type="number" class="form-control" required="required" id="latbox" value="12.9715987" name="lat" hidden readonly>
						<input type="number" class="form-control" required="required" id="lngbox" value="77.5945627" name="lon" hidden readonly>
						<button type="button" class="form-control btn-info" onclick="getLocation();">Fetch Location</button>
						<span class="text-primary" id="demo">
							Allow permission for Geolocation after clicking the button below.
						</span>
						<div id="map">Google Map should display here.</div>
						<span class="text-primary">
							Adjust the marker to exact location of the restaurant
						</span>
					</div>
					<div class="g-recaptcha" data-sitekey="6Lc5fV8UAAAAAGtc-uAfyZUNMbWtLCagfCkAvM2U"></div>
					<input type="submit" name="res-register" value="REGISTER" class="btn btn-info" />
					<a class="pl-3" href="restaurant-login.php">Already Registered? Login!</a>
				</form>
			</div>
			<div class="col-sm-2"></div>
		</div>

		<div id="myBtn" class="btn-back-to-top bg0-hov">
			<span class="symbol-btn-back-to-top">
				<i class="fa fa-angle-double-up" aria-hidden="true"></i>
			</span>
		</div>
	</div>
	<!--===============================================================================================-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!--===============================================================================================-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<!--===============================================================================================-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<!--===============================================================================================-->
	<script type="text/javascript" src="js/main.js"></script>
	<!--===============================================================================================-->
	<!-- Loading Google API -->
	<script>
		var x = document.getElementById("demo");

		function getLocation() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition, showError);
			} else {
				x.innerHTML = "Geolocation is not supported by this browser.";
				loadLoc();
			}
		}
		function loadLoc() {
			var str = document.getElementById("place").value;
			var url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + str + "&key=AIzaSyAQFgFA-JX5_Xna8TsXVfGtvYn7XrFPuAQ";
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var myObj = JSON.parse(this.responseText);
					console.log(myObj.status);
					document.getElementById("latbox").value = myObj.results[0].geometry.location.lat;
					document.getElementById("lngbox").value = myObj.results[0].geometry.location.lng;
				}
			};
			xmlhttp.open("GET", url, true);
			xmlhttp.send();
			setTimeout(initMap, 1000);
		}

		function showPosition(position) {
			document.getElementById("latbox").value = position.coords.latitude;
			document.getElementById("lngbox").value = position.coords.longitude;
			initMap();
		}
	// Handling Errors
	function showError(error) {
		switch(error.code) {
			case error.PERMISSION_DENIED:
			x.innerHTML = "User denied the request for Geolocation."
			break;
			case error.POSITION_UNAVAILABLE:
			x.innerHTML = "Location information is unavailable."
			break;
			case error.TIMEOUT:
			x.innerHTML = "The request to get user location timed out."
			break;
			case error.UNKNOWN_ERROR:
			x.innerHTML = "An unknown error occurred."
			break;
		}
		loadLoc();
	}
</script>
<script>

	var map;
	function initMap() {
		var latlng = new google.maps.LatLng(document.getElementById("latbox").value, document.getElementById("lngbox").value);
		map = new google.maps.Map(document.getElementById('map'), {
			center: latlng,
			zoom: 13,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			clickableIcons: false,
			mapTypeControl: false,
			streetViewControl: false,
			overviewMapControl: true,
			rotateControl: true,
			panControl: true,
			zoomControl: true,
			scaleControl: true,
		});
		var marker = new google.maps.Marker({
			position: latlng,
			map: map,
			title: 'Drag this marker to your exact location',
			draggable: true,
		});
		google.maps.event.addListener(marker, 'dragend', function (event) {
			document.getElementById("latbox").value = this.getPosition().lat();
			document.getElementById("lngbox").value = this.getPosition().lng();
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmt9muKRq8oFoSiZQw-B0hcG-aBrvUNPo" async defer></script>
</body>
</html>