<?php
require_once 'server.php';

if(isset($_SESSION['success']) && isset($_SESSION['user'])) {
	$uid = $_SESSION['user'];
}

if(isset($_GET['id'])) {
	$res = mysqli_query($db, "SELECT id, name, body, phone, email, place, lat, lon FROM `restaurants` WHERE `id` = {$_GET['id']}");
	if(mysqli_num_rows($res)>0) {
		while($row = mysqli_fetch_array($res)) {
			$rid = $row['id'];
			$name = $row['name'];
			$body = $row['body'];
			$email = $row['email'];
			$phone = $row['phone'];
			$place  = $row['place'];
			$lat = $row['lat'];
			$lon = $row['lon'];
		}
	}
	else {
		array_push($errors,"ID #{$_GET['id']} does not exist in Restaurant Database.");
	}
}
else {
	array_push($errors,"Invalid Request.");
}
require_once 'header.php';
?>

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

		<?php
		require_once 'errors-success.php';
		if(count($errors)) {
			echo '<h2 class="text-center pt-5">Error occured while processing your request.<br/><a href="index.php">Go to Homepage</a></h2>';
		}
		else {
			?>
			<div id="taberror" style="display: none;"></div>
			<div class="row pt-2">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="pb-2">
						<h2><?php echo $name; ?></h2>
					</div>
					<div class="row bg-light text-dark">
						<div class="col-sm-12 col-md-4">
							<h5><?php echo $place; ?></h5>
						</div>
						<div class="col-sm-12 col-md-4">
							<a href="tel:<?php echo $phone; ?>"><i class="fa fa-phone"></i><?php echo $phone; ?></a>
						</div>
						<div class="col-sm-12 col-md-4">
							<a href="mailto:<?php echo $email; ?>?Subject=Restroview%20Review%20and%20Rating" target="_top"><i class="fa fa-envelope"></i> <?php echo $email; ?></a>
						</div>
						<h4 class="pt-3"><?php echo $body; ?></h4>
					</div>
					<hr/>
					<div class="row text-dark">
						<h5>Location: <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $lat; ?>,<?php echo $lon; ?>&dir_action=navigate" target="_blank">Navigate</a></h5>
						<div id="map"></div>
					</div>
					<?php
					$averageRating = 0;
					$countRating = 0;
						// User rating
					$query = "SELECT * FROM ratings WHERE rid=$rid ";
					if(isset($_SESSION['user']) && !empty($_SESSION['user']))
						$query .= 'and uid='.$_SESSION['user'];

					$userresult = mysqli_query($db,$query);
					if(!$userresult)
						array_push($errors,mysqli_error($db));

					$fetchRating = mysqli_fetch_array($userresult);
					$rating = $fetchRating['rating'];

						// get average
					$query = "SELECT ROUND(AVG(rating),1) as averageRating,count(*) as countRating FROM ratings WHERE rid=$rid";
					$avgresult = mysqli_query($db,$query);
					if(!$avgresult)
						array_push($errors,mysqli_error());

					if(mysqli_num_rows($avgresult)>=1) {
						$fetchAverage = mysqli_fetch_array($avgresult);
						$averageRating = $fetchAverage['averageRating'];
						$countRating = $fetchAverage['countRating'];
					}
					if($averageRating <= 0) {
						$averageRating = "No ratings yet";
						$countRating = 0;
					}
					?>
					<?php
					if(isset($_SESSION['user'])) {
						?>
						<div class="row pt-3">
							<h5>Your Rating: </h5> &nbsp;&nbsp;
							<select class="rating" id='rating_<?php echo $rid; ?>' data-id='rating_<?php echo $rid; ?>' required="required">
								<option value="" ></option>
								<?php
								for($i=1;$i<=5;$i++) {
									echo '<option value="'.$i.'" ';
									if($i==$rating)
										echo 'selected';
									echo '>'.$i.'</option>';
								}
								?>
							</select>
						</div>
						<?php
						$query = "SELECT COUNT(*) AS count FROM reviews as rev where ratingid=(SELECT id FROM ratings WHERE rid=$rid and uid=$uid)";
						$result = mysqli_query($db,$query);
						$fetchdata = mysqli_fetch_array($result);
						$count = $fetchdata['count'];

						if($count == 0) {
							?>

							<h5 class="row">Your Review: </h5>
							<form class="submitreview">
								<div class="form-group">
									<input type="text" class="form-control" id="heading" required="required" name="heading" placeholder="Review Heading">
								</div>
								<div class="form-group">
									<textarea class="form-control" type="text" id="review" name="review" placeholder="Feedback"></textarea> 
								</div>
								<input type="text" id="rid" name="rid" hidden="hidden" readonly="readonly" value="<?php echo $rid; ?>">
								<input type="submit" value="Submit" class="btn btn-danger" />
							</form>

							<?php
						}
					}
					?>

					<div class="row pt-3">
						<h4 class="pr-2">Average Ratings (<span id="countrating_<?php echo $rid; ?>"><?php echo $countRating; ?></span>) : </h4>
						<div class="avgrating">
							<?php
							if(!is_numeric($averageRating))
								$averageRating = 0;
							for($x=1;$x<=5;$x++) {
								?>
								<i class="fas fa-star fa-2x star text-secondary <?php
								if($x<=floor($averageRating))
								echo "text-warning";?>"
								></i>
								<?php
							}
							?>
						</div>
						<h3 class="pl-2 ">(<span id='avgrating_<?php echo $rid; ?>'><?php echo $averageRating; ?></span>)</h3>
					</div>
					<div class="row pt-3 review">
						<?php
						$res = mysqli_query($db, "SELECT COUNT(*) as count from reviews as rev,ratings as rat where rev.ratingid=rat.id and rat.rid={$_GET['id']}");
						$fetchreview = mysqli_fetch_array($res);
						?>

						<h4>Reviews (<span id="countreview_<?php echo $rid; ?>"><?php echo $fetchreview['count'] ?></span>)</h4>
						<?php
						$res = mysqli_query($db, "SELECT (SELECT ROUND(AVG(rating),1) from ratings where rid={$_GET['id']}) as averageRating, u.name as uname,rat.rating,rev.heading,rev.body,rev.ts from restaurants as r, ratings as rat,users as u,reviews as rev where rat.rid=r.id and rat.uid=u.id and rat.id=rev.ratingid and r.id={$_GET['id']}");
						if(mysqli_num_rows($res)>0) {
							while($row = mysqli_fetch_array($res)) {
								$avgRevRating=$row['averageRating'];
								?>
								<div class="row border">
									<div class="col-sm-12 col-md-12">
										<?php
										for($x=1;$x<=5;$x++) {
											echo '<i class="fas fa-star star text-secondary ';
											if($x<=floor($avgRevRating))
												echo 'text-warning';
											echo '"></i>';
										}
										?>
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<h4 class="text-danger">
											<?php echo $row['heading']; ?>
										</h4>
									</div>
									<div class="col-sm-12 col-md-4 col-lg-6">
										<p class="text-secondary">
											<?php echo $row['uname']; ?>
										</p>
									</div>
									<div class="col-sm-12 col-md-8 col-lg-6">
										<p class="text-secondary">
											<?php 
											$date=date_create($row['ts']);
											echo date_format($date,"D jS M,Y h:i:s A");
											?>
										</p>
									</div>
									<div class="col-sm-12 col-md-12 text-dark">
										<?php echo $row['body']; ?>
									</div>
								</div>
								<?php 
							}
						}
						?>
					</div>
				</div>
				<div class="col-sm-2"></div>
			</div>
			<?php
		}
		?>

		<div id="myBtn" class="btn-back-to-top bg0-hov">
			<span class="symbol-btn-back-to-top">
				<i class="fa fa-angle-double-up" aria-hidden="true"></i>
			</span>
		</div>
	</div>
	<!--===============================================================================================-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!--===============================================================================================-->
	<script type="text/javascript" src="js/jAlert-v3.min.js"></script>
	<!--===============================================================================================-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<!--===============================================================================================-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<!--===============================================================================================-->
	<script type="text/javascript" src="js/main.js"></script>
	<!--===============================================================================================-->
	<script src="js/jquery.barrating.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$('.rating').barrating({
				theme: 'fontawesome-stars',
				onSelect: function(value, text, event) {
					// Get element id by data-id attribute
					var el = this;
					var el_id = el.$elem.data('id');

					// rating was selected by a user
					if (typeof(event) !== 'undefined') {
						var split_id = el_id.split("_");
						var rid = split_id[1]; // postid

						// AJAX Request
						$.ajax({
							url: 'rating-ajax.php',
							type: 'post',
							data: {rid:rid,rating:value},
							dataType: 'json',
							success: function(data) {
								// Update average
								var average = data['averageRating'];
								var count = data['countRating'];
								$('#avgrating_'+rid).text(average);
								$('#countrating_'+rid).text(count);
								$('.avgrating i').removeClass("text-warning");

								var rating = Math.floor(average);
								$(".avgrating i").each(function( index ) {
									if( index<rating )
										$(this).addClass("text-warning");
								});
							}
						});
					}
				}
			});
			$("form.submitreview").on("submit",function(e) {
				e.preventDefault();
				var heading = $("#heading").val();
				var review = $("#review").val();
				var rid = $("#rid").val();
				// AJAX Request
				$.ajax({
					url: 'review-ajax.php',
					type: 'post',
					data: { rid: rid, heading: heading, review: review },
					dataType: 'json',
					success: function(data) {
						// Update average
						if(data['error']) {
							if(data['error']=="No Ratingid"){
								psAlert("Warning","Please give ratings befor submiting review","yellow");
								$("taberror").html('<div class="alert failure"><span class="closebtn">&times;</span><strong>Error : Please give rating before submiting review.</strong></div>').show();
							}
							if(data['error']=="No Session") {
								psAlert("Error","Not Rating ID found","red");
								$("taberror").html('<div class="alert failure"><span class="closebtn">&times;</span><strong>Error : No session was found. Please, login first.</strong></div>').show();
							}
						}
						else {
							psAlert("Success","Review Successfully Added !!","green");
							var count = data['countReview'];
							$('form.submitreview').remove();
							window.location.reload(false); 
						}
					}
				})
				.fail(function() {
					psAlert("Error","Review Ajax Failed unexpectedly","red");
				});
			});
		});

		function psAlert(title,content,theme,image){
			$.jAlert({
				'title': title,
				'content': content,
				'theme': theme,
				'closeOnClick': true,
				'backgroundColor': 'black',
			});
		}
	</script>
	<!-- Loading Google API -->
	<script type="text/javascript">
		var map;
		function initMap() {
			var latlng = new google.maps.LatLng(<?php echo $lat . "," . $lon; ?>);
			map = new google.maps.Map(document.getElementById('map'), {
				center: latlng,
				zoom: 13,
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
</body>
</html>