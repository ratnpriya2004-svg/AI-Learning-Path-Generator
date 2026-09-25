<?php

session_start();

// Destroy session
$_SESSION = array();
session_destroy();

// Logout ke baad Home page par
header("Location: ../index.html");
exit();

?>