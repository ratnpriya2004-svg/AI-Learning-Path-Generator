<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.html");
    exit();
}

include("../config/database.php");

$user = $_SESSION['user'];


/* =========================================
   GET STEP ID
========================================= */

if (!isset($_POST['step_id'])) {
    header("Location: ../dashbord/progress.php");
    exit();
}

$stepId = (int) $_POST['step_id'];
/* =========================================
   GET STEP DETAILS
========================================= */

$stepTitle = "Learning Step";

$stepInfoStmt = mysqli_prepare(
    $conn,
    "SELECT step_title
     FROM roadmap_progress
     WHERE id = ?
     AND username = ?
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stepInfoStmt,
    "is",
    $stepId,
    $user
);

mysqli_stmt_execute($stepInfoStmt);

$stepInfoResult = mysqli_stmt_get_result(
    $stepInfoStmt
);

$stepInfo = mysqli_fetch_assoc(
    $stepInfoResult
);

mysqli_stmt_close($stepInfoStmt);

if ($stepInfo) {
    $stepTitle = $stepInfo['step_title'];
}

/* =========================================
   VERIFY STEP BELONGS TO CURRENT USER
========================================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, roadmap_id
     FROM roadmap_progress
     WHERE id = ?
     AND username = ?
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stmt,
    "is",
    $stepId,
    $user
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$step = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* =========================================
   STEP NOT FOUND
========================================= */

if (!$step) {

    header("Location: ../dashbord/progress.php");
    exit();

}


/* =========================================
   MARK STEP AS COMPLETED
========================================= */

$updateStmt = mysqli_prepare(
    $conn,
    "UPDATE roadmap_progress
     SET status = 'Completed',
         completed_at = NOW()
     WHERE id = ?
     AND username = ?"
);

mysqli_stmt_bind_param(
    $updateStmt,
    "is",
    $stepId,
    $user
);

mysqli_stmt_execute($updateStmt);

mysqli_stmt_close($updateStmt);


/* =========================================
   CALCULATE NEW PROGRESS
========================================= */

$roadmapId = $step['roadmap_id'];


/* Total steps */

$totalStmt = mysqli_prepare(
    $conn,
    "SELECT COUNT(*) AS total
     FROM roadmap_progress
     WHERE roadmap_id = ?
     AND username = ?"
);

mysqli_stmt_bind_param(
    $totalStmt,
    "is",
    $roadmapId,
    $user
);

mysqli_stmt_execute($totalStmt);

$totalResult = mysqli_stmt_get_result($totalStmt);

$totalData = mysqli_fetch_assoc($totalResult);

mysqli_stmt_close($totalStmt);

$totalSteps = (int) $totalData['total'];


/* Completed steps */

$completedStmt = mysqli_prepare(
    $conn,
    "SELECT COUNT(*) AS completed
     FROM roadmap_progress
     WHERE roadmap_id = ?
     AND username = ?
     AND status = 'Completed'"
);

mysqli_stmt_bind_param(
    $completedStmt,
    "is",
    $roadmapId,
    $user
);

mysqli_stmt_execute($completedStmt);

$completedResult = mysqli_stmt_get_result(
    $completedStmt
);

$completedData = mysqli_fetch_assoc(
    $completedResult
);

mysqli_stmt_close($completedStmt);

$completedSteps = (int) $completedData['completed'];


/* =========================================
   CALCULATE PERCENTAGE
========================================= */

$progress = 0;

if ($totalSteps > 0) {

    $progress = round(
        ($completedSteps / $totalSteps) * 100
    );

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
   SAVE USER ACTIVITY
========================================= */

$activityTitle = "Step Completed";
$activityDescription =
    $stepTitle . " has been completed successfully.";

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

$activityType = "completed";

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
   RETURN TO PROGRESS PAGE
========================================= */

header("Location: ../dashbord/progress.php");

exit();

?>