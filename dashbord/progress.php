<?php

session_start();
include("../config/database.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.html");
    exit();
}

$user = $_SESSION['user'];
/* =========================================
   GET LATEST ROADMAP
========================================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, goal, progress
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
   GET ROADMAP STEPS
========================================= */

$steps = [];

if ($roadmap) {

    $progressStmt = mysqli_prepare(
        $conn,
        "SELECT *
         FROM roadmap_progress
         WHERE roadmap_id = ?
         ORDER BY step_number ASC"
    );

    mysqli_stmt_bind_param(
        $progressStmt,
        "i",
        $roadmap['id']
    );

    mysqli_stmt_execute($progressStmt);

    $progressResult = mysqli_stmt_get_result(
        $progressStmt
    );

    while ($row = mysqli_fetch_assoc($progressResult)) {

        $steps[] = $row;

    }

    mysqli_stmt_close($progressStmt);

}


/* =========================================
   CALCULATE PROGRESS
========================================= */

$totalSteps = count($steps);

$completedSteps = 0;

foreach ($steps as $step) {

    if ($step['status'] === 'Completed') {

        $completedSteps++;

    }

}

$overallProgress = 0;

if ($totalSteps > 0) {

    $overallProgress = round(
        ($completedSteps / $totalSteps) * 100
    );

}

/* =========================================
   GET RECENT ACTIVITIES
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

$activityResult = mysqli_stmt_get_result($activityStmt);

while ($activityRow = mysqli_fetch_assoc($activityResult)) {

    $activities[] = $activityRow;

}

mysqli_stmt_close($activityStmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Progress | AI Learn</title>

    <link rel="stylesheet" href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=2">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<div class="dashboard-container">

    <!-- ================= HEADER ================= -->

    <header class="dashboard-header">

        <div class="header-left">

            <div>

                <h1>My Progress</h1>

                <p>
                    Keep track of your learning journey 📈
                </p>

            </div>

        </div>


        <div class="header-right">

            <div
                class="profile-icon"
                onclick="window.location.href='/AI-Learning-Path-Generator/dashbord/profile.php'"
                title="My Profile">

                <i class="fa-solid fa-user"></i>

            </div>

            <button class="menu-button" id="menuButton">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>

        </div>

    </header>


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

            <a href="dashboard.php">

                <i class="fa-solid fa-house"></i>

                <span>Dashboard</span>

            </a>


            <a href="roadmap.php">

                <i class="fa-solid fa-road"></i>

                <span>My Roadmap</span>

            </a>


            <a href="progress.php" class="active">

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


        <!-- ================= PROGRESS OVERVIEW ================= -->

        <section class="dashboard-stats">


            <div class="dashboard-card">

                <div class="card-icon">

                    <i class="fa-solid fa-chart-line"></i>

                </div>

                <div>

                    <h3><?php echo $overallProgress; ?>%</h3>
                    <p>Overall Progress</p>

                </div>

            </div>


            <div class="dashboard-card">

                <div class="card-icon">

                    <i class="fa-solid fa-book-open"></i>

                </div>

                <div>

                    <h3><?php echo $completedSteps; ?></h3>
                    <p>Steps Completed</p>
                </div>

            </div>


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

                    <i class="fa-solid fa-clock"></i>

                </div>

                <div>

                    <h3>42 Hours</h3>

                    <p>Total Study Time</p>

                </div>

            </div>


        </section>


        <!-- ================= COURSE PROGRESS ================= -->

        <section class="recent-section">

            <div class="section-heading">

                <h2>Course Progress</h2>

            </div>


            <div class="activity-list">


                <!-- WEB DEVELOPMENT -->

<!-- ================= DYNAMIC COURSE PROGRESS ================= -->

<section class="recent-section">

    <div class="section-heading">

        <h2>Course Progress</h2>

    </div>


    <div class="activity-list">

        <?php if ($roadmap): ?>

            <?php

            $courseProgress = $overallProgress;

            $goalName = $roadmap['goal'];

            ?>

            <div class="activity-item course-progress-item">

                <div class="activity-icon">

                    <i class="fa-solid fa-road"></i>

                </div>


                <div class="course-progress-content">

                    <div class="course-title">

                        <div>

                            <h4>
                                <?php
                                echo htmlspecialchars($goalName);
                                ?>
                            </h4>

                            <p>
                                Your personalized learning roadmap
                            </p>

                        </div>


                        <span>
                            <?php
                            echo $courseProgress;
                            ?>%
                        </span>

                    </div>


                    <div class="course-progress-bar">

                        <div
                            class="course-progress-fill"
                            style="width: <?php echo $courseProgress; ?>%;">
                        </div>

                    </div>


                    <p style="margin-top: 8px;">

                        <?php
                        echo $completedSteps;
                        ?>

                        of

                        <?php
                        echo $totalSteps;
                        ?>

                        steps completed

                    </p>

                </div>

            </div>


        <?php else: ?>

            <div class="activity-item">

                <div class="activity-icon">

                    <i class="fa-solid fa-road"></i>

                </div>


                <div>

                    <h4>
                        No Learning Roadmap
                    </h4>

                    <p>
                        Create a roadmap to start tracking your progress.
                    </p>

                </div>

            </div>

        <?php endif; ?>

    </div>

</section>


                <!-- AI -->

                <div class="activity-item course-progress-item">

    <div class="activity-icon">
        <i class="fa-solid fa-brain"></i>
    </div>

    <div class="course-progress-content">

        <div class="course-title">

            <div>
                <h4>Artificial Intelligence</h4>

                <p>
                    Python, Machine Learning and AI fundamentals
                </p>
            </div>

            <span>70%</span>

        </div>

        <div class="course-progress-bar">

            <div class="course-progress-fill"
                 style="width:70%;">
            </div>

        </div>

    </div>

</div>


                <!-- DATABASE -->

                <div class="activity-item course-progress-item">

    <div class="activity-icon">
        <i class="fa-solid fa-database"></i>
    </div>

    <div class="course-progress-content">

        <div class="course-title">

            <div>
                <h4>Database Management</h4>

                <p>
                    SQL, MySQL and database concepts
                </p>
            </div>

            <span>65%</span>

        </div>

        <div class="course-progress-bar">

            <div class="course-progress-fill"
                 style="width:65%;">
            </div>

        </div>

    </div>

</div>


                <!-- CYBER SECURITY -->

                <div class="activity-item course-progress-item">

    <div class="activity-icon">
        <i class="fa-solid fa-shield-halved"></i>
    </div>

    <div class="course-progress-content">

        <div class="course-title">

            <div>
                <h4>Cyber Security</h4>

                <p>
                    Networking, Linux and security fundamentals
                </p>
            </div>

            <span>45%</span>

        </div>

        <div class="course-progress-bar">

            <div class="course-progress-fill"
                 style="width:45%;">
            </div>

        </div>

    </div>

</div>


            </div>

        </section>
<section class="recent-section">

    <div class="section-heading">

        <h2>My Learning Progress</h2>

        <span>
            <?php echo $overallProgress; ?>% Completed
        </span>

    </div>


    <div class="activity-list">

        <?php if (count($steps) > 0): ?>

            <?php foreach ($steps as $step): ?>

                <div class="activity-item">

                    <div class="activity-icon">

                        <?php if ($step['status'] === 'Completed'): ?>

                            <i class="fa-solid fa-check"></i>

                        <?php else: ?>

                            <i class="fa-solid fa-book-open"></i>

                        <?php endif; ?>

                    </div>


                    <div>

                        <h4>
                            <?php
                            echo htmlspecialchars(
                                $step['step_title']
                            );
                            ?>
                        </h4>

                        <p>
                            Step
                            <?php
                            echo (int)$step['step_number'];
                            ?>
                        </p>

                    </div>


                    <div class="progress-step-action">

                    <?php if ($step['status'] === 'Completed'): ?>

                        <span class="completed-badge">
                            <i class="fa-solid fa-circle-check"></i>
                            Completed
                        </span>

                    <?php elseif ($step['status'] === 'In Progress'): ?>

                <span class="status-progress">

                    <i class="fa-solid fa-spinner"></i>

                    In Progress

                </span>

                <form
                    action="../php/update_progress.php"
                    method="POST">

                    <input
                        type="hidden"
                        name="progress_id"
                        value="<?php echo (int)$step['id']; ?>">

                    <input
                        type="hidden"
                        name="action"
                        value="complete">

                    <button
                        type="submit"
                        class="complete-step-btn">

                        <i class="fa-solid fa-check"></i>

                        Mark as Complete

                    </button>

                </form>


            <?php else: ?>

                <form
                    action="../php/update_progress.php"
                    method="POST">

                    <input
                        type="hidden"
                        name="progress_id"
                        value="<?php echo (int)$step['id']; ?>">

                    <input
                        type="hidden"
                        name="action"
                        value="start">

                    <button
                        type="submit"
                        class="start-step-btn">

                        <i class="fa-solid fa-play"></i>

                        Start Learning

                    </button>

                </form>

            <?php endif; ?>
                </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="activity-item">

                <div class="activity-icon">

                    <i class="fa-solid fa-road"></i>

                </div>

                <div>

                    <h4>No roadmap found</h4>

                    <p>
                        Create a learning roadmap to start
                        tracking your progress.
                    </p>

                </div>

            </div>

        <?php endif; ?>

    </div>

</section>

<!-- ================= RECENT ACTIVITY ================= -->

<section class="recent-section">

    <div class="section-heading">

        <h2>Recent Activity</h2>

        <span>Latest Updates</span>

    </div>


    <div class="activity-list">

        <?php if (count($activities) > 0): ?>

            <?php foreach ($activities as $activity): ?>

                <div class="activity-item">


                    <!-- ACTIVITY ICON -->

                    <div class="activity-icon">

                        <?php if ($activity['activity_type'] === 'roadmap'): ?>

                            <i class="fa-solid fa-road"></i>

                        <?php elseif ($activity['activity_type'] === 'completed'): ?>

                            <i class="fa-solid fa-circle-check"></i>

                        <?php elseif ($activity['activity_type'] === 'learning'): ?>

                            <i class="fa-solid fa-book-open"></i>

                        <?php else: ?>

                            <i class="fa-solid fa-bell"></i>

                        <?php endif; ?>

                    </div>


                    <!-- ACTIVITY CONTENT -->

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


                    <!-- ACTIVITY TIME -->

                    <span>

                        <?php
                        echo date(
                            "d M, h:i A",
                            strtotime(
                                $activity['created_at']
                            )
                        );
                        ?>

                    </span>


                </div>

            <?php endforeach; ?>


        <?php else: ?>

            <div class="activity-item">

                <div class="activity-icon">

                    <i class="fa-solid fa-clock-rotate-left"></i>

                </div>


                <div>

                    <h4>
                        No Recent Activity
                    </h4>

                    <p>
                        Your learning activities will appear here.
                    </p>

                </div>

            </div>

        <?php endif; ?>

    </div>

</section>

        <!-- ================= LEARNING GOAL ================= -->

        <section class="welcome-card">

            <div>

                <span class="small-title">
                    KEEP GOING
                </span>


                <h2>
                    You're Making Great Progress 🚀
                </h2>


                <p>

                    Stay consistent with your daily learning goals.
                    Complete your roadmap and build real-world projects
                    to improve your career skills.

                </p>


                <a href="roadmap.php" class="dashboard-btn">

                    Continue Learning

                </a>

            </div>

        </section>


    </main>

</div>


<script src="/AI-Learning-Path-Generator/assets/js/dashboard.js?v=2"></script>

</body>

</html>