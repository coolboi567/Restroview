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
	<div class="container text-info">
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
			<a href="#"><img src="images/favicon.png" alt="Logo" style="width:50px;"></a>
			<a class="navbar-brand" href="#">RESTROVIEW</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="active nav-link" href="#">Restaurant Portal</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="register.php">Register</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="findus.php">Find us</a>
					</li>
				</ul>
			</div>  
		</nav>

		<div class="row pt-2">
			<div class="col-sm-5">
				<div>
					<h2 class="text-white bg-info text-center">Restroview - Login</h2>
				</div>
				<form action="" method="POST">

					<div class="form-group">
						<label for="email">Email address:</label>
						<input type="email" class="form-control" id="email">
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" id="pwd">
					</div>
					<input type="submit" name="login" value="LOGIN" class="btn btn-info" />
					<a class="pl-3" href="register.php">New User? Register!</a>
				</form>
			</div>
			<div class="col-sm-1 btn-info text-white pt-5"> OR </div>
			<div class="col-sm-6">
				<div>
					<h2 class="text-white bg-info text-center">Restroview - Register</h2>
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
					<!-- <textarea type="text" name="message" value=""></textarea> -->
					<div class="g-recaptcha" data-sitekey="6Lc5fV8UAAAAAGtc-uAfyZUNMbWtLCagfCkAvM2U"></div>
					<input type="submit" name="register" value="REGISTER" class="btn btn-info" />
					<a class="pl-3" href="login.php">Already Registered? Login!</a>
				</form>
			</div>
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
</body>
</html>