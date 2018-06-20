<?php
require_once 'server.php';
require_once 'header.php';
?>

<body>
	<img src="Triangles-2.1s-200px.svg" class="loader">

	<div class="container text-info mb-5">
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
			<a href="#"><img src="images/favicon.png" alt="Logo" style="width:50px;"></a>
			&nbsp;&nbsp;
			<a class="navbar-brand" href="#">RESTROVIEW</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="active nav-link" href="#"><i class="fas fa-home fa-lg"></i> Home</a>
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
						<button class="btn btn-secondary my-2 my-sm-0" type="submit" name="<?php
						if(isset($_SESSION['restaurant']))
						echo "res-profile";
						else if(isset($_SESSION['user']))
						echo "user-profile";
						?>"><i class="fas fa-user fa-lg"></i> Profile</button>
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
				<div class="pb-2">
					<h3>Search Restaurants Reviews and Ratings</h3>
				</div>
				<form class="searchres">
					<select name="place" id="place" class="selection-2" required="required">
						<option selected="true" disabled="disabled" value="">Location</option>
						<?php
						$json  =  file_get_contents("cities.json");
						$data  =  json_decode($json);
						foreach($data as $cities) {
							$city=$cities->city;
							echo "<option value='".$city."'>".ucfirst($city)."</option>\n";
						}
						?>
					</select>
					<input type="text" name="search-name" id="search-name" placeholder="Restaurant's Name" required="required" />
					<input type="submit" value="Search" class="btn btn-danger" />
				</form>
				<hr/>
				<div id="results">
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
	<script type="text/javascript">
		$(document).ready(function(){
			$("form.searchres").on("submit",function(e){
				e.preventDefault();
				var name = $("#search-name").val();
				var place = $("#place").val();
				$.post("search-ajax.php",
				{
					name: name,
					place: place
				},
				function(data, status){
					/*
					Data: {"result":1,"results":[{"id":"1","name":"Brewsky Restaurant and Bar","body":null,"lat":"12.97962805","lon":"77.64082544"}]}
					Status: success
					*/
					var obj = jQuery.parseJSON(data);
					if(obj.error)
						$("#results").html('<h4 class="text-danger">Invalid Request !!</h4>');
					else if(status=="success") {
						if(obj.result>0) {
							$("#results").html(' ');	// Clearing the div before appending to avoid redundancy
							var rest, el,str;
							for(var i = 0; i < obj.results.length; i++) {
								rest = obj.results[i];
								str = '<div class="col-8"><h3>'+rest.sn+') <a href=restaurant.php?id='+rest.id+'>'+rest.name+'</a></h3></div><div class="col-4"><a href="https://www.google.com/maps/dir/?api=1&destination='+rest.lat+","+rest.lon+'"&dir_action=navigate" target="_blank">Navigate</a></div>';
								el = $("<div class='row'></div>").html(str);

								$("#results").append(el);
							}
						}
						else {
							$("#results").html('<h3 class="text-danger">No Results Found !</h3>');
						}
					}
				});
			});
		});
	</script>
</body>
</html>
