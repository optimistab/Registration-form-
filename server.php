<?php

session_start();

$username = "";
$email    = ""; 

$errors = array(); 

$db = mysqli_connect('localhost','root','','livedata') or die("can't reach to database");

//for user registration

$username = mysqli_real_escape_string($db,isset($_POST['username']));
$email = mysqli_real_escape_string($db,isset($_POST['email']));
//$contactnumber = mysqli_real_escape_string($db,isset($_POST['contact number']));
$password_1 = mysqli_real_escape_string($db,isset($_POST['password_1']));
$password_2 = mysqli_real_escape_string($db,isset($_POST['password_2']));
 
// handling errors

if(empty($username)) {array_push($errors,"username is required");}
if(empty($email)) {array_push($errors,"email is required");}
//if(empty($contactnumber)) {array_push($errors,"contactnumber is required");}
if(empty($password_1)) {array_push($errors,"password  is required");}
if($password_1 != $password_2){array_push($errors,"passwords do not match");}

$user_check_query = "SELECT * FROM userdata WHERE username='$username' or email='$email' LIMIT 1";

$results=mysqli_query($db,$user_check_query);
$user =mysqli_fetch_assoc($results);

if($user){
	if($user['username']=== $username){array_push($errors,"Username already exits");}
	if($user['email']=== $email){array_push($errors,"email already exits");}
}

// now we can register the user, as there are no errors now

if(count($errors) == 0){ 
	$password=md5($password_1);
	$query = "INSERT INTO userdata (username,email,password) VALUES ('$username''$email''$password_1')";

	mysqli_query($db,$query);
	$_SESSION['username']= $username;
	$_SESSION['success']= "you are now logged in";

	header('location : index.php'); 
}
?>







































