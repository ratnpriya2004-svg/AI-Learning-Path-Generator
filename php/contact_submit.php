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

$user = $_SESSION['user'];


// =====================================
// CHECK REQUEST
// =====================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../contact.php");
    exit();

}


// =====================================
// GET FORM DATA
// =====================================

$name = trim($_POST['name'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');


// =====================================
// VALIDATION
// =====================================

if (
    empty($name) ||
    empty($subject) ||
    empty($message)
) {

    header("Location: ../contact.php?error=1");
    exit();

}


// =====================================
// GET USER EMAIL
// =====================================

$userStmt = mysqli_prepare(
    $conn,
    "SELECT email
     FROM users
     WHERE fullname = ?
     LIMIT 1"
);

if (!$userStmt) {

    die("User query failed: " . mysqli_error($conn));

}


mysqli_stmt_bind_param(
    $userStmt,
    "s",
    $user
);


mysqli_stmt_execute($userStmt);

$userResult = mysqli_stmt_get_result($userStmt);

$userData = mysqli_fetch_assoc($userResult);

mysqli_stmt_close($userStmt);


// =====================================
// GET EMAIL
// =====================================

$email = $userData['email'] ?? '';


// =====================================
// SAVE SUPPORT MESSAGE
// =====================================

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO support_messages
    (
        username,
        name,
        email,
        subject,
        message,
        status
    )
    VALUES (?, ?, ?, ?, ?, 'Pending')"
);


if (!$stmt) {

    die("Support message query failed: " . mysqli_error($conn));

}


mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $user,
    $name,
    $email,
    $subject,
    $message
);


// =====================================
// EXECUTE
// =====================================

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);

    header("Location: ../contact.php?sent=1");
    exit();

}


// =====================================
// ERROR
// =====================================

$error = mysqli_error($conn);

mysqli_stmt_close($stmt);

die("Message could not be sent: " . $error);

?>