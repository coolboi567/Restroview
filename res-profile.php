<?php
require_once 'server.php';
/*
if(isset($_POST['res-update']))
{
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$name = mysqli_real_escape_string($db, $_POST['name']);
	$phone = mysqli_real_escape_string($db, $_POST['phone']);
	$place = mysqli_real_escape_string($db, $_POST['place']);
	$desc = mysqli_real_escape_string($db, $_POST['desc']);
	$lat = mysqli_real_escape_string($db, $_POST['lat']);
	$lon = mysqli_real_escape_string($db, $_POST['lon']);
	$email = test_input($email);
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Invalid Email Format");
	}
	elseif (mysqli_num_rows(mysqli_query($db, "SELECT * FROM restaurants WHERE email='$email'")) >= 1) {
		array_push($errors,"Restaurant email already exists. <a href=\"login.php\">Sign in</a>");
	}
	if (empty($place)) {
		array_push($errors, "Place is required");
	}
	if (empty($phone)) {
		array_push($errors, "Phone is required");
	}
	if (empty($desc)) {
		array_push($errors, "Description is required");
	}

	if (count($errors)==0) {

		$query = "UPDATE FROM restaurants SET email='$email', phone='$phone',  place='$place', body='$desc', name='$name', lat='$lat', lon='$lon'";
		$res = mysqli_query($db, $query);

		if($res) {
			$query = "SELECT email,id FROM restaurants where email='$email'";
			$first = mysqli_fetch_assoc(mysqli_query($db, $query));

			$_SESSION['success'] = "Successfully registered restaurant and now logged in.";
			$_SESSION['email'] = $first['email'];
			$_SESSION['restaurant'] = $first['id'];
			header('location: index.php');
			exit();
		}
		else {
			array_push($errors,"Failed to update  the restaurant");
		}
	}
}
*/
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
					if(!isset($_SESSION['success']) || empty($_SESSION['success']))
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
					<h2 class="text-white bg-info text-center">Restaurant Profile</h2>
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
</body>
</html>