<?php

include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.html");
    exit();
}


// Get form data

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');


// Validate fields

if ($name === '' || $email === '' || $subject === '' || $message === '') {

    echo "<script>
            alert('Please fill all fields.');
            window.history.back();
          </script>";

    exit();
}


// Validate email

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo "<script>
            alert('Please enter a valid email address.');
            window.history.back();
          </script>";

    exit();
}


// Save message

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO contact_messages (name, email, subject, message)
     VALUES (?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $name,
    $email,
    $subject,
    $message
);


if (mysqli_stmt_execute($stmt)) {

    echo "<script>
            alert('Your message has been sent successfully! 🎉');
            window.location.href = '../index.html#contact';
          </script>";

} else {

    echo "<script>
            alert('Something went wrong. Please try again.');
            window.history.back();
          </script>";
}


mysqli_stmt_close($stmt);

?>