<?php

session_start();

include("../config/database.php");


/* =====================================
   CHECK LOGIN
===================================== */

if (!isset($_SESSION['user'])) {

    header("Location: ../login.html");
    exit();

}


/* =====================================
   CHECK REQUEST
===================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: messages.php");
    exit();

}


/* =====================================
   GET DATA
===================================== */

$messageId = intval($_POST['message_id'] ?? 0);

$status = trim($_POST['status'] ?? '');


/* =====================================
   VALIDATION
===================================== */

$allowedStatuses = [
    'Pending',
    'In Progress',
    'Resolved'
];


if (
    $messageId <= 0 ||
    !in_array($status, $allowedStatuses, true)
) {

    header("Location: messages.php");
    exit();

}


/* =====================================
   UPDATE STATUS
===================================== */

$stmt = mysqli_prepare(
    $conn,
    "UPDATE support_messages
     SET status = ?
     WHERE id = ?
     LIMIT 1"
);


mysqli_stmt_bind_param(
    $stmt,
    "si",
    $status,
    $messageId
);


if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);

    header("Location: messages.php?updated=1");
    exit();

}


mysqli_stmt_close($stmt);

header("Location: messages.php?error=1");
exit();

?>