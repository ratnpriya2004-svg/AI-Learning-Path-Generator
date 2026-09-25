<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.html");
    exit();
}

$user = $_SESSION['user'];

include("../config/database.php");

/* =========================================
   GET RECENT USER ACTIVITIES
========================================= */

$activities = [];

$activityStmt = mysqli_prepare(
    $conn,
    "SELECT activity_type, title, description, created_at
     FROM user_activity
     WHERE username = ?
     ORDER BY id DESC
     LIMIT 5"
);

mysqli_stmt_bind_param(
    $activityStmt,
    "s",
    $user
);

mysqli_stmt_execute($activityStmt);

$activityResult = mysqli_stmt_get_result(
    $activityStmt
);

while ($activity = mysqli_fetch_assoc($activityResult)) {

    $activities[] = $activity;

}

mysqli_stmt_close($activityStmt);

/* =========================================
   GET LATEST ROADMAP PROGRESS
========================================= */

$overallProgress = 0;
$completedSteps = 0;
$totalSteps = 0;

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, progress
     FROM learning_roadmaps
     WHERE username = ?
     ORDER BY id DESC
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$roadmap = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* =========================================
   GET ACTUAL STEP PROGRESS
========================================= */

if ($roadmap) {

    $progressStmt = mysqli_prepare(
        $conn,
        "SELECT
            COUNT(*) AS total_steps,
            SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed_steps
         FROM roadmap_progress
         WHERE roadmap_id = ?
         AND username = ?"
    );

    mysqli_stmt_bind_param(
        $progressStmt,
        "is",
        $roadmap['id'],
        $user
    );

    mysqli_stmt_execute($progressStmt);

    $progressResult = mysqli_stmt_get_result($progressStmt);

    $progressData = mysqli_fetch_assoc($progressResult);

    mysqli_stmt_close($progressStmt);

    $totalSteps = (int) $progressData['total_steps'];

    $completedSteps = (int) $progressData['completed_steps'];


    if ($totalSteps > 0) {

        $overallProgress = round(
            ($completedSteps / $totalSteps) * 100
        );

    }
}
/* =========================================
   GET NEXT LEARNING STEP
========================================= */

$nextStep = null;

if ($roadmap) {

    $nextStepStmt = mysqli_prepare(
        $conn,
        "SELECT
            step_number,
            step_title,
            status
         FROM roadmap_progress
         WHERE roadmap_id = ?
         AND username = ?
         AND status = 'Not Started'
         ORDER BY step_number ASC
         LIMIT 1"
    );

    mysqli_stmt_bind_param(
        $nextStepStmt,
        "is",
        $roadmap['id'],
        $user
    );

    mysqli_stmt_execute($nextStepStmt);

    $nextStepResult =
        mysqli_stmt_get_result($nextStepStmt);

    $nextStep =
        mysqli_fetch_assoc($nextStepResult);

    mysqli_stmt_close($nextStepStmt);
}


/* =========================================
   GET ROADMAP BASIC INFO
========================================= */

$currentGoal =
    $roadmap['goal'] ?? 'No roadmap yet';

$currentStudyTime =
    $roadmap['study_time'] ?? 'Not set';
    
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | AI Learn</title>

<link rel="stylesheet" href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=2">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<div class="dashboard-container">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">
        <button class="close-menu" id="closeMenu">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="sidebar-logo">

            <i class="fa-solid fa-brain"></i>

            <span>AI Learn</span>

        </div>


        <nav class="sidebar-menu">

            <a href="dashboard.php" class="active">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

        <a href="roadmap.php">
            <i class="fa-solid fa-road"></i>
            <span>My Roadmap</span>
        </a>

            <a href="progress.php">
                <i class="fa-solid fa-chart-line"></i>
                <span>Progress</span>
            </a>

            <a href="resources.php">
                <i class="fa-solid fa-book"></i>
                <span>Resources</span>
            </a>

            <a href="profile.php">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>
            <a href="about.php">
                <i class="fa-solid fa-circle-info"></i>
                <span>About</span>
            </a>
        </nav>


        <div class="sidebar-bottom">

            <a href="../php/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>

        </div>

    </aside>
    <div class="menu-overlay" id="menuOverlay"></div>


    <!-- ================= MAIN CONTENT ================= -->

    <main class="dashboard-main">

        <!-- TOP BAR -->

        <header class="dashboard-header">

    <div class="header-left">

        <div>
            <h1>Dashboard</h1>

            <p>
                Welcome back, <?php echo htmlspecialchars($user); ?> 👋
            </p>
        </div>

    </div>

    <div class="header-right">
     

    <div
        class="profile-icon"
        onclick="window.location.href='profile.php'"
        title="My Profile">

        <i class="fa-solid fa-user"></i>

    </div>

    

    <button
        class="menu-button"
        id="menuButton"
        type="button">

        <i class="fa-solid fa-ellipsis-vertical"></i>

    </button>

</div>
</header>


        <!-- ================= STAT CARDS ================= -->

        <section class="dashboard-stats">

            <div class="dashboard-card">

                <div class="card-icon">
                    <i class="fa-solid fa-fire"></i>
                </div>

                <div>
                    <h3>12 Days</h3>
                    <p>Learning Streak</p>
                </div>

            </div>


            <div class="dashboard-card">

                <div class="card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div>
                    <h3><?php echo $completedSteps; ?></h3>
                    <p>Steps Completed</p>
                </div>

            </div>


            <div class="dashboard-card">

                <div class="card-icon">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>

                <div>
                    <h3><?php echo $overallProgress; ?>%</h3>
                    <p>Current Progress</p>
                </div>

            </div>


            <div class="dashboard-card">

                <div class="card-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div>
                   <h3>
                        <?php echo htmlspecialchars(
                            $roadmap['study_time'] ?? 'Not Set'
                        ); ?>
                    </h3>
                    <p>Today's Goal</p>
                </div>

            </div>

        </section>


        <!-- ================= WELCOME SECTION ================= -->

        <section class="welcome-card">

            <div>

                <span class="small-title">
                    AI LEARNING
                </span>

                <h2>
                    Build Your Personalized Learning Path 🚀
                </h2>

                <p>
                    Create a personalized roadmap based on your goals,
                    skills and learning level.
                </p>

                <a href="../generator/generator.php" class="dashboard-btn">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    Create Learning Path
                </a>

            </div>

        </section>

        <!-- ================= CONTINUE LEARNING ================= -->

<section class="continue-learning-card">

    <div class="continue-learning-content">

        <span class="small-title">
            CONTINUE LEARNING
        </span>

        <h2>
            <?php echo htmlspecialchars($currentGoal); ?>
        </h2>

        <?php if ($nextStep): ?>

            <p class="next-step-label">
                Your next step
            </p>

            <h3>
                <?php
                echo htmlspecialchars(
                    $nextStep['step_title']
                );
                ?>
            </h3>

            <p>
                Keep going with your personalized learning path.
            </p>

            <a
                href="roadmap.php"
                class="dashboard-btn">

                <i class="fa-solid fa-play"></i>

                Continue Learning

            </a>

        <?php else: ?>

            <p>
                🎉 You have completed all available steps
                in your current roadmap.
            </p>

            <a
                href="../generator/generator.php"
                class="dashboard-btn">

                <i class="fa-solid fa-wand-magic-sparkles"></i>

                Create New Roadmap

            </a>

        <?php endif; ?>

    </div>

</section>
-
        <!-- ================= RECENT ACTIVITY ================= -->

        <section class="recent-section">

    <div class="section-heading">

        <h2>Recent Activity</h2>

        <a href="progress.php">View Progress</a>

    </div>


    <div class="activity-list">

        <?php if (count($activities) > 0): ?>

            <?php foreach ($activities as $activity): ?>

                <div class="activity-item">

                    <div class="activity-icon">

                        <?php if ($activity['activity_type'] === 'completed'): ?>

                            <i class="fa-solid fa-circle-check"></i>

                        <?php elseif ($activity['activity_type'] === 'progress'): ?>

                            <i class="fa-solid fa-chart-line"></i>

                        <?php else: ?>

                            <i class="fa-solid fa-brain"></i>

                        <?php endif; ?>

                    </div>


                    <div>

                        <h4>
                            <?php
                            echo htmlspecialchars(
                                $activity['title']
                            );
                            ?>
                        </h4>

                        <p>
                            <?php
                            echo htmlspecialchars(
                                $activity['description']
                            );
                            ?>
                        </p>

                    </div>


                    <span>

                        <?php
                        echo date(
                            "d M",
                            strtotime($activity['created_at'])
                        );
                        ?>

                    </span>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="activity-item">

                <div class="activity-icon">

                    <i class="fa-solid fa-clock"></i>

                </div>

                <div>

                    <h4>No recent activity</h4>

                    <p>
                        Your learning activities will appear here.
                    </p>

                </div>

            </div>

        <?php endif; ?>

    </div>

</section>

    </main>

</div>


<script src="/AI-Learning-Path-Generator/assets/js/dashboard.js?v=2"></script>

</body>

</html>