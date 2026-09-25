<?php

session_start();

include("../config/database.php");


// =====================================
// CHECK LOGIN
// =====================================

if (!isset($_SESSION['user'])) {

    header("Location: ../login.html");
    exit();

}


$currentUser = $_SESSION['user'];


// =====================================
// GET FORM DATA
// =====================================

$fullname = trim($_POST['fullname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$skill    = trim($_POST['skill_level'] ?? '');
$goal     = trim($_POST['goal'] ?? '');
$study    = trim($_POST['study_time'] ?? '');


// =====================================
// VALIDATION
// =====================================

if (
    $fullname === '' ||
    $email === '' ||
    $skill === '' ||
    $goal === '' ||
    $study === ''
) {

    die("Please fill all fields.");

}


// =====================================
// VALIDATE EMAIL
// =====================================

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    die("Please enter a valid email address.");

}


// =====================================
// UPDATE USER PROFILE
// =====================================

$stmt = mysqli_prepare(
    $conn,
    "UPDATE users
     SET fullname = ?,
         email = ?,
         skill_level = ?,
         goal = ?,
         study_time = ?
     WHERE fullname = ?
     LIMIT 1"
);


mysqli_stmt_bind_param(
    $stmt,
    "ssssss",
    $fullname,
    $email,
    $skill,
    $goal,
    $study,
    $currentUser
);


if (mysqli_stmt_execute($stmt)) {

    // Update session username
    $_SESSION['user'] = $fullname;

    mysqli_stmt_close($stmt);

    header(
        "Location: ../dashbord/profile.php?updated=1"
    );

    exit();

} else {

    $error = mysqli_error($conn);

    mysqli_stmt_close($stmt);

    die(
        "Profile update failed: " . $error
    );

}

?>