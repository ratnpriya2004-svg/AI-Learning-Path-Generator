<?php

session_start();

include("../config/database.php");


/* =========================================
   CHECK LOGIN
========================================= */

if (!isset($_SESSION['user'])) {

    header("Location: ../login.html");
    exit();

}


$user = $_SESSION['user'];


/* =========================================
   CHECK REQUEST
========================================= */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../dashbord/roadmap.php");
    exit();

}


/* =========================================
   GET DATA
========================================= */

$progressId = intval($_POST['progress_id'] ?? 0);
$action = $_POST['action'] ?? '';


/* =========================================
   VALIDATION
========================================= */

if ($progressId <= 0 || $action === '') {

    header("Location: ../dashbord/roadmap.php");
    exit();

}


/* =========================================
   ALLOWED ACTIONS
========================================= */

if ($action !== 'start' && $action !== 'complete') {

    header("Location: ../dashbord/roadmap.php");
    exit();

}


/* =========================================
   FIND USER'S PROGRESS STEP
========================================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM roadmap_progress
     WHERE id = ?
     AND username = ?
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stmt,
    "is",
    $progressId,
    $user
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);


if (mysqli_num_rows($result) === 0) {

    mysqli_stmt_close($stmt);

    header("Location: ../dashbord/roadmap.php");
    exit();

}


$step = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* =========================================
   DETERMINE NEW STATUS
========================================= */

if ($action === 'start') {

    $newStatus = "In Progress";

} else {

    $newStatus = "Completed";

}


/* =========================================
   UPDATE STEP STATUS
========================================= */

$updateStmt = mysqli_prepare(
    $conn,
    "UPDATE roadmap_progress
     SET status = ?
     WHERE id = ?
     AND username = ?"
);

mysqli_stmt_bind_param(
    $updateStmt,
    "sis",
    $newStatus,
    $progressId,
    $user
);

mysqli_stmt_execute($updateStmt);

mysqli_stmt_close($updateStmt);


/* =========================================
   GET ROADMAP ID
========================================= */

$roadmapId = $step['roadmap_id'];


/* =========================================
   CALCULATE PROGRESS
========================================= */

$countStmt = mysqli_prepare(
    $conn,
    "SELECT
        COUNT(*) AS total,
        SUM(status = 'Completed') AS completed
     FROM roadmap_progress
     WHERE roadmap_id = ?
     AND username = ?"
);

mysqli_stmt_bind_param(
    $countStmt,
    "is",
    $roadmapId,
    $user
);

mysqli_stmt_execute($countStmt);

$countResult = mysqli_stmt_get_result($countStmt);

$countData = mysqli_fetch_assoc($countResult);

mysqli_stmt_close($countStmt);


$totalSteps = (int)$countData['total'];
$completedSteps = (int)$countData['completed'];


if ($totalSteps > 0) {

    $progress = round(
        ($completedSteps / $totalSteps) * 100
    );

} else {

    $progress = 0;

}


/* =========================================
   UPDATE ROADMAP PROGRESS
========================================= */

$roadmapStmt = mysqli_prepare(
    $conn,
    "UPDATE learning_roadmaps
     SET progress = ?
     WHERE id = ?
     AND username = ?"
);

mysqli_stmt_bind_param(
    $roadmapStmt,
    "iis",
    $progress,
    $roadmapId,
    $user
);

mysqli_stmt_execute($roadmapStmt);

mysqli_stmt_close($roadmapStmt);


/* =========================================
   SAVE ACTIVITY
========================================= */

if ($action === 'start') {

    $activityTitle = "Started Learning";

    $activityDescription =
        "Started learning: " . $step['step_title'];

} else {

    $activityTitle = "Step Completed";

    $activityDescription =
        "Completed learning step: " . $step['step_title'];

}


$activityType = "progress";


$activityStmt = mysqli_prepare(
    $conn,
    "INSERT INTO user_activity
    (
        username,
        activity_type,
        title,
        description
    )
    VALUES (?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $activityStmt,
    "ssss",
    $user,
    $activityType,
    $activityTitle,
    $activityDescription
);

mysqli_stmt_execute($activityStmt);

mysqli_stmt_close($activityStmt);


/* =========================================
   GO BACK TO ROADMAP
========================================= */

header("Location: ../dashbord/roadmap.php");
exit();

?>