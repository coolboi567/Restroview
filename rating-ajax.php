<?php
session_start();
require_once("database.php");

if(isset($_SESSION['success']) && isset($_SESSION['user'])) {
	$uid = $_SESSION['user']; // User id
	$rid = $_POST['rid'];
	$rating = $_POST['rating'];

// Check entry within table
	$query = "SELECT COUNT(*) AS count FROM ratings WHERE rid=$rid and uid=$uid";
	$result = mysqli_query($db,$query);
	$fetchdata = mysqli_fetch_array($result);
	$count = $fetchdata['count'];

	if($count == 0){
		$insertquery = "INSERT INTO ratings(uid,rid,rating) values($uid,$rid,$rating)";
		mysqli_query($db,$insertquery);
	}
	else {
		$updatequery = "UPDATE ratings SET rating=$rating WHERE uid=$uid and rid=$rid";
		mysqli_query($db,$updatequery);
	}

// get average
	$query = "SELECT ROUND(AVG(rating),1) as averageRating, count(*) as count FROM ratings WHERE rid=$rid";
	$result = mysqli_query($db,$query);
	$fetchAverage = mysqli_fetch_array($result);
	$averageRating = $fetchAverage['averageRating'];
	$countRating = $fetchAverage['count'];

	$return_arr = array("averageRating"=>$averageRating, "countRating"=>$countRating);
}
else
	$return_arr = array("error"=>"Invalid Request! No Session !!");

echo json_encode($return_arr);

?>