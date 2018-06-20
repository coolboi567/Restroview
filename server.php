<?php
session_start();

require_once 'database.php';

$errors = [];
$success = [];

function getRandomString() {
	$length = 20;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if(isset($_GET['user-profile']))
	header("Location: user-profile.php");
if(isset($_GET['res-profile']))
	header("Location: res-profile.php");

if(isset($_POST['login'])) {
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password = mysqli_real_escape_string($db, $_POST['pwd']);
	$email = test_input($email);
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Invalid Email Format");
	}
	else if (mysqli_num_rows(mysqli_query($db, "SELECT * FROM users WHERE email='$email'")) == 0) {
		array_push($errors,"User does not exist. <a href=\"register.php\">Sign up</a>");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}
	if (count($errors)==0) {
		$res=mysqli_query($db, "SELECT saltstring,email,id FROM users WHERE email='$email'");
		$first = mysqli_fetch_assoc($res);
		$randstr = $first["saltstring"];
		$salt = sha1(md5($password)).$randstr;
		$password = md5($password.$salt);


		$res=mysqli_query($db, "SELECT id, email FROM users WHERE email='$email' AND password='$password'");
		if(mysqli_num_rows($res)>0) {
			$first = mysqli_fetch_assoc($res);
			$_SESSION['success'] = "You are now logged in.";
			$_SESSION['email'] = $first["email"];
			$_SESSION['user'] = $first["id"];
			header('location: index.php');
			exit();
		}
		else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}
else if(isset($_POST['register'])) {
	$name = mysqli_real_escape_string($db, $_POST['name']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = mysqli_real_escape_string($db, $_POST['pwd']);
	$password_2 = mysqli_real_escape_string($db, $_POST['pwd_2']);
	$email = test_input($email);
	if (empty($name)) {
		array_push($errors, "Name is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Invalid Email Format");
	}
	else if (mysqli_num_rows(mysqli_query($db, "SELECT * FROM users WHERE email='$email'")) >= 1) {
		array_push($errors,"User already exists. <a href=\"login.php\">Sign in</a>");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	else if (empty($password_2)) {
		array_push($errors, "Confirm Password is required");
	}
	else if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        //your site secret key
		$secret = '6Lc5fV8UAAAAAFStlhnp_yWNnNfAE0DlNsoDHVjA';
        //get verify response data
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		$responseData = json_decode($verifyResponse);
		if($responseData->success) {
			// array_push($success,"Your contact request have submitted successfully.");
		}
		else {
			array_push($errors, "Robot verification failed, please try again.");
		}
	}
	else {
		array_push($errors,"Please click on the reCAPTCHA box.");
	}
	if (count($errors)==0) {
		$password = $password_1;
		$randstr = getRandomString();
		$salt = sha1(md5($password)).$randstr;
		$password = md5($password.$salt);

		$query = "INSERT INTO users (name, email, password, saltstring) VALUES('$name','$email', '$password','$randstr')";
		$res=mysqli_query($db, $query);

		if($res) {
			$query = "SELECT email,id FROM restaurants where email='$email'";
			$first = mysqli_fetch_assoc(mysqli_query($db, $query));

			$_SESSION['success'] = "Successfully registered user and now logged in.";
			$_SESSION['email'] = $first["email"];
			$_SESSION['user'] = $first["id"];
			header('location: index.php');
			exit();
		}
		else {
			array_push($errors,"Failed to register the user");
		}
	}
}

if(isset($_POST['res-login'])) {
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password = mysqli_real_escape_string($db, $_POST['pwd']);
	$email = test_input($email);
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Invalid Email Format");
	}
	else if (mysqli_num_rows(mysqli_query($db, "SELECT * FROM restaurants WHERE email='$email'")) == 0) {
		array_push($errors,"Restaurant email does not exist. <a href=\"restaurant-register.php\">Sign up</a>");
	}

	if (empty($password)) {
		array_push($errors, "Password is required");
	}
	if (count($errors)==0) {
		$res=mysqli_query($db, "SELECT saltstring,email,id FROM restaurants WHERE email='$email'");
		$first = mysqli_fetch_assoc($res);
		$randstr = $first["saltstring"];
		$salt = sha1(md5($password)).$randstr;
		$password = md5($password.$salt);


		$res=mysqli_query($db, "SELECT id, email FROM restaurants WHERE email='$email' AND password='$password'");
		if(mysqli_num_rows($res)>0) {
			$_SESSION['success'] = "You are now logged in.";
			$_SESSION['email'] = $first["email"];
			$_SESSION['restaurant'] = $first["id"];
			header('location: index.php');
			exit();
		}
		else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}
else if(isset($_POST['res-register'])) {
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password_1= mysqli_real_escape_string($db, $_POST['pwd']);
	$password_2 = mysqli_real_escape_string($db, $_POST['pwd_2']);
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

	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	else if (empty($password_2)) {
		array_push($errors, "Confirm Password is required");
	}
	else if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
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
	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        //your site secret key
		$secret = '6Lc5fV8UAAAAAFStlhnp_yWNnNfAE0DlNsoDHVjA';
        //get verify response data
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		$responseData = json_decode($verifyResponse);
		if($responseData->success) {
			// array_push($success,"Your contact request have submitted successfully.");
		}
		else {
			array_push($errors, "Robot verification failed, please try again.");
		}
	}
	else {
		array_push($errors,"Please click on the reCAPTCHA box.");
	}
	if (count($errors)==0) {
		$password = $password_1;
		$randstr = getRandomString();
		$salt = sha1(md5($password)).$randstr;
		$password = md5($password.$salt);

		$query = "INSERT INTO restaurants (email , password, phone, place, body, name, lat, lon, saltstring) 
		VALUES('$email', '$password', '$phone', '$place', '$desc', '$name', '$lat', '$lon','$randstr')";
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
			array_push($errors,"Failed to register the restaurant");
		}
	}
}

if(isset($_GET['logout'])) {
	unset($_SESSION["success"]);
	unset($_SESSION["email"]);
	unset($_SESSION['user']);
	unset($_SESSION['restaurant']);
	session_destroy();
	header('location: index.php');
	exit();
}
?>