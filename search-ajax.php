<?php
require_once 'database.php';

if(isset($_POST['name']) && isset($_POST['place']) && !empty($_POST['name']) && !empty($_POST['place'])) {
	$name = $_POST["name"];
	$place = $_POST["place"];

	mysqli_query($db,"SET @count:=0");
	$res = mysqli_query($db, "SELECT (@count:=@count+1) AS sn, id, name, lat, lon FROM `restaurants` WHERE `place` = '$place' and name LIKE '%{$name}%'");
	if(mysqli_num_rows($res)>0)
	{
		$return_arr = array("result"=>mysqli_num_rows($res));
		while($row = mysqli_fetch_array($res)) {
			$sn = $row['sn'];
			$id = $row['id'];
			$name = $row['name'];
			$lat = $row['lat'];
			$lon = $row['lon'];
			$return_arr['results'][] = array("sn"=>$sn, "id"=>$id,"name"=>$name,"lat"=>$lat,"lon"=>$lon);
		}
	}
	else
	{
		$return_arr = array("result"=>"0");
	}
}
else
{
	$return_arr = array("error"=>"1");
}

echo json_encode($return_arr);
?>