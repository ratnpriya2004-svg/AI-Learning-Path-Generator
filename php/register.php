<?php

include("../config/database.php");

$fullname=$_POST['fullname'];

$email=$_POST['email'];

$password=password_hash($_POST['password'],PASSWORD_DEFAULT);

$skill=$_POST['skill_level'];

$goal=$_POST['goal'];

$study=$_POST['study_time'];

$sql="INSERT INTO users(fullname,email,password,skill_level,goal,study_time)

VALUES('$fullname','$email','$password','$skill','$goal','$study')";

if(mysqli_query($conn,$sql)){

header("Location: ../login.html");

}else{

echo "Registration Failed";

}

?>