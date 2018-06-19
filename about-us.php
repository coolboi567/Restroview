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
			<a class="navbar-brand" href="index.php">RESTROVIEW</a>
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
							<a class="nav-link" href="restaurant-login.php"><i class="fas fa-utensils fa-lg"></i> Restaurant Portal</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="login.php"><i class="fas fa-users fa-lg"></i> User Portal</a>
						</li>
						<?php
					}
					?>
					<li class="nav-item">
						<a class="nav-link active" href="#"><i class="fas fa-map-marker-alt fa-lg"></i> About us</a>
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
				<h2 class="text-white bg-info text-center">About us</h2>
				<h3 class="text-danger">Restroview - Rate and Review Restaurants</h3>
				<p  class="text-primary">Every customer has right to rate and give feedback about restaurant. We present a platform for the viewing authentic ratings and reviews about restaurants in the city. Also, you can give ratings and review of your own for any restaurants.</p>
				<blockquote class="blockquote border-left border-info pl-5 text-dark">
					<p>The fondest memories are made when gathered around the table.</p>
					<footer class="blockquote-footer">Fresh Farmhouse</footer>
				</blockquote>
				<div>
					<h5>
						Office Location:
					</h5>					
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4620.125291439671!2d77.63393588632809!3d13.159448297920383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xafcf83dbd629afcf!2sSri+Venkateshwara+College+of+Engineering!5e0!3m2!1sen!2sin!4v1529421337823" height="450" frameborder="0" style="border:0; width: 100%;" allowfullscreen></iframe>
				</div>
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
	<?php
		/*
		$first = mysqli_fetch_assoc(mysqli_query($db, "SELECT FROM restaurants WHERE email = {$_SESSION['email']}"));
		$lat = $first['lat'];
		$lon = $first['lon'];
		
		$lat = 13.159681;
		$lon = 77.636053;
	<script type="text/javascript">
		var map;
		function initMap() {
			var latlng = new google.maps.LatLng(<?php echo $lat . "," . $lon; ?>);
			map = new google.maps.Map(document.getElementById('map'), {
				center: latlng,
				zoom: 10,
				clickableIcons: false,
				disableDefaultUI: true,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var marker = new google.maps.Marker({
				position: latlng,
				map: map,
				title: 'Set lat/lon values for this property',
				draggable: false
			});
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmt9muKRq8oFoSiZQw-B0hcG-aBrvUNPo&callback=initMap"
	async defer></script>
	*/
	?>
</body>
</html>