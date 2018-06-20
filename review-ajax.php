<?php
session_start();
require_once("database.php");

if(isset($_SESSION['success']) && isset($_SESSION['user'])) {
	$uid = $_SESSION['user']; // User id
	$rid = $_POST['rid'];
	$body = $_POST['review'];
	$heading = $_POST['heading'];

	$query = "SELECT id FROM ratings WHERE rid=$rid and uid=$uid";
	$res = mysqli_query($db,$query);
	if(mysqli_num_rows($res) == 1) {
		$fetchRatId = mysqli_fetch_array($res);
		$ratid = $fetchRatId['id'];

// Check entry within table
		$query = "SELECT COUNT(*) AS count FROM reviews as rev where ratingid=$ratid";
		$result = mysqli_query($db,$query);
		$fetchdata = mysqli_fetch_array($result);
		$count = $fetchdata['count'];

		if($count == 0){
			$insertquery = "INSERT INTO reviews(ratingid,heading,body) values($ratid,'$heading','$body')";
			mysqli_query($db,$insertquery);
		}
		else {
			$updatequery = "UPDATE reviews SET heading='$heading', body='$body' WHERE ratingid=$ratid";
			mysqli_query($db,$updatequery);
		}

// count total reviews
		$query = "SELECT count(*) as count FROM reviews WHERE ratingid=$ratid";
		$result = mysqli_query($db,$query);
		$fetchCount = mysqli_fetch_array($result);
		$count = $fetchCount['count'];

		$return_arr = array("countReview"=>$count);
	}
	else {
		$return_arr = array("error"=>"No Ratingid");
	}
}
else {
	$return_arr = array("error"=>"No Session");
}

echo json_encode($return_arr);
?>