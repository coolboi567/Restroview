<?php
require_once 'server.php';
require_once 'header.php';
?>
<body>
	<img src="Triangles-2.1s-200px.svg" class="loader">
	<div class="container text-info">
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
							<a class="active nav-link" href="login.php"><i class="fas fa-users fa-lg"></i> User Portal</a>
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
					<h2 class="text-white bg-info text-center">User Login</h2>
				</div>
				<form action="" method="POST">
					<div class="form-group">
						<label for="email">Email address:</label>
						<input type="email" class="form-control" id="email" name="email">
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" id="pwd" name="pwd">
					</div>
					<input type="submit" name="login" value="LOGIN" class="btn btn-info" />
					<a class="pl-3" href="register.php">New User? Register!</a>
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
</body>
</html>