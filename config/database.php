<?php

$host="localhost";

$user="root";

$password="";

$database="ai_learning_path";

$conn=mysqli_connect($host,$user,$password,$database);

if(!$conn){

die("Database Connection Failed");

}

?>