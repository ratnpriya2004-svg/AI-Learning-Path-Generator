<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.html");
    exit();
}

include("../config/database.php");

$user = $_SESSION['user'];


/* =========================================
   GET LATEST ROADMAP
========================================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, goal, skill_level, study_time, duration, progress, roadmap_data
     FROM learning_roadmaps
     WHERE username = ?
     ORDER BY id DESC
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $user
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$roadmapInfo = null;
$roadmap = [];

if (mysqli_num_rows($result) > 0) {

    $roadmapInfo = mysqli_fetch_assoc($result);

    /*
     * roadmap_data database mein JSON format mein saved hai.
     * Isko ek hi baar decode karna hai.
     */

    $roadmap = json_decode(
        $roadmapInfo['roadmap_data'],
        true
    );

    if (!is_array($roadmap)) {
        $roadmap = [];
    }
}

mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Roadmap | AI Learn</title>

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=4">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>

        /* =========================================
           ROADMAP PAGE
        ========================================= */

        .roadmap-main {
            max-width: 1050px;
            margin: 0 auto;
        }


        .roadmap-intro {

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;

            padding: 40px;

            border-radius: 24px;

            margin-bottom: 30px;

            box-shadow:
                0 15px 35px rgba(79,70,229,.18);

        }


        .roadmap-intro .small-title {

            color: rgba(255,255,255,.85);

        }


        .roadmap-intro h2 {

            color: white;

            font-size: 30px;

            margin: 12px 0;

        }


        .roadmap-intro p {

            color: rgba(255,255,255,.88);

            line-height: 1.7;

            margin: 5px 0;

        }


        /* =========================================
           ROADMAP CARD
        ========================================= */

        .roadmap-card {

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 22px;

            padding: 35px;

            box-shadow:
                0 10px 30px rgba(0,0,0,.06);

        }


        .roadmap-heading {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 25px;

        }


        .roadmap-heading h2 {

            margin: 0;

            color: #111827;

        }


        .progress-badge {

            background: #eef2ff;

            color: #4F46E5;

            padding: 8px 14px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: 700;

        }


        /* =========================================
           ROADMAP STEP
        ========================================= */

        .roadmap-step {

            display: flex;

            gap: 20px;

            padding: 25px 0;

            border-bottom: 1px solid #e5e7eb;

        }


        .roadmap-step:last-child {

            border-bottom: none;

        }


        .step-number {

            width: 48px;

            height: 48px;

            min-width: 48px;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: 700;

            font-size: 16px;

        }


        .step-content {

            flex: 1;

        }


        .step-content h3 {

            margin: 0 0 8px;

            color: #111827;

        }


        .step-content p {

            margin: 0 0 12px;

            color: #64748b;

            line-height: 1.6;

        }


        .step-duration {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 6px 12px;

            border-radius: 20px;

            background: #f1f5f9;

            color: #475569;

            font-size: 13px;

            font-weight: 600;

        }


        /* =========================================
           EMPTY STATE
        ========================================= */

        .empty-roadmap {

            text-align: center;

            padding: 60px 25px;

        }


        .empty-roadmap i {

            font-size: 50px;

            color: #4F46E5;

            margin-bottom: 20px;

        }


        .empty-roadmap h2 {

            color: #111827;

            margin-bottom: 10px;

        }


        .empty-roadmap p {

            color: #64748b;

            margin-bottom: 25px;

        }


        .create-roadmap-btn {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 13px 22px;

            border-radius: 10px;

            text-decoration: none;

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;

            font-weight: 600;

        }


        /* =========================================
           ACTION BUTTONS
        ========================================= */

        .roadmap-actions {

            display: flex;

            gap: 12px;

            margin-top: 25px;

        }


        .roadmap-action {

            padding: 12px 20px;

            border-radius: 10px;

            text-decoration: none;

            font-weight: 600;

        }


        .new-roadmap {

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;

        }
        

        /* =========================================
           MOBILE
        ========================================= */

        @media(max-width: 700px) {

            .roadmap-intro,
            .roadmap-card {

                padding: 25px;

            }


            .roadmap-heading {

                flex-direction: column;

                align-items: flex-start;

            }


            .roadmap-step {

                gap: 14px;

            }


            .roadmap-actions {

                flex-direction: column;

            }

        }
        .top-menu {
            position: absolute;
            top: 75px;
            right: 25px;

            width: 190px;

            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 14px;

            padding: 8px;

            box-shadow: 0 10px 30px rgba(0,0,0,.12);

            display: none;

            z-index: 9999;
        }

        .top-menu.show {
            display: block;
        }

        .top-menu a {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 11px 12px;

            border-radius: 9px;

            color: #334155;
            text-decoration: none;

            font-weight: 500;
                }

            .top-menu a:hover {
                background: #f1f5f9;
            }

            .top-menu i {
                width: 18px;
            }

            .top-menu .logout-menu {
                color: #dc2626;
            }

            /* =========================================
   PROGRESS BUTTONS
========================================= */

.step-progress-area {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 16px;
}

.progress-form {
    display: inline-block;
    margin: 0;
}

.start-learning-btn,
.complete-learning-btn {
    border: none;
    border-radius: 9px;
    padding: 10px 16px;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    display: inline-flex;
    align-items: center;
    gap: 7px;

    transition: .2s;
}

.start-learning-btn {
    background: linear-gradient(135deg, #4F46E5, #06B6D4);
    color: white;
}

.start-learning-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(79,70,229,.20);
}

.complete-learning-btn {
    background: #16a34a;
    color: white;
}

.complete-learning-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(22,163,74,.20);
}

.status-progress {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 9px 13px;

    border-radius: 20px;

    background: #fff7ed;
    color: #ea580c;

    font-size: 13px;
    font-weight: 700;
}

.status-completed {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 9px 13px;

    border-radius: 20px;

    background: #dcfce7;
    color: #15803d;

    font-size: 13px;
    font-weight: 700;
}
    </style>

</head>


<body>

<div class="dashboard-container">


    <!-- =========================================
         HEADER
    ========================================= -->

    <header class="dashboard-header">

        <div class="header-left">

            <div>

                <h1>My Roadmap</h1>

                <p>
                    Your personalized learning journey 🚀
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

            <button
                class="menu-button"
                id="menuButton">

                <i class="fa-solid fa-ellipsis-vertical"></i>

            </button>
            <div class="top-menu" id="topMenu">

                <a href="dashboard.php">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>

                <a href="roadmap.php">
                    <i class="fa-solid fa-road"></i>
                    My Roadmap
                </a>

                <a href="profile.php">
                    <i class="fa-solid fa-user"></i>
                    Profile
                </a>
                <a href="about.php">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>About</span>
                </a>
                <a href="../php/logout.php" class="logout-menu">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>

            </div>

        </div>

    </header>


    <!-- =========================================
         SIDEBAR
    ========================================= -->

    <aside class="sidebar">


        <button
            class="close-menu"
            id="closeMenu">

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


            <a href="roadmap.php"
               class="active">

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


        </nav>


        <div class="sidebar-bottom">

            <a href="../php/logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                <span>Logout</span>

            </a>

        </div>


    </aside>


    <div
        class="menu-overlay"
        id="menuOverlay">
    </div>


    <!-- =========================================
         MAIN
    ========================================= -->

    <main class="dashboard-main">


        <div class="roadmap-main">


            <?php if ($roadmapInfo): ?>


                <!-- =================================
                     INTRO
                ================================= -->

                <section class="roadmap-intro">

                    <span class="small-title">
                        YOUR AI LEARNING PATH
                    </span>


                    <h2>

                        <?php
                        echo htmlspecialchars(
                            $roadmapInfo['goal']
                        );
                        ?>

                    </h2>


                    <p>

                        Skill Level:
                        <strong>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $roadmapInfo['skill_level']
                                )
                            );
                            ?>
                        </strong>

                    </p>


                    <p>

                        Daily Study:
                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $roadmapInfo['study_time']
                            );
                            ?>
                        </strong>

                    </p>


                </section>


                <!-- =================================
                     ROADMAP
                ================================= -->

                <section class="roadmap-card">


                    <div class="roadmap-heading">

                        <h2>
                            Learning Roadmap
                        </h2>


                        <span class="progress-badge">

                            <?php
                            echo (int)$roadmapInfo['progress'];
                            ?>%

                            Completed

                        </span>

                    </div>

                    <?php

/* Get progress status for current roadmap */

$progressStatuses = [];

if ($roadmapInfo) {

    $roadmapId = $roadmapInfo['id'];

    $progressStmt = mysqli_prepare(
        $conn,
        "SELECT id, step_number, status
         FROM roadmap_progress
         WHERE roadmap_id = ?
         AND username = ?
         ORDER BY step_number ASC"
    );

    mysqli_stmt_bind_param(
        $progressStmt,
        "is",
        $roadmapId,
        $user
    );

    mysqli_stmt_execute($progressStmt);

    $progressResult = mysqli_stmt_get_result($progressStmt);

    while ($progressRow = mysqli_fetch_assoc($progressResult)) {

       $progressStatuses[
                (int)$progressRow['step_number']
            ] = [
                'id' => $progressRow['id'],
                'status' => $progressRow['status']
            ];

    }

    mysqli_stmt_close($progressStmt);

}

?>
                    <?php

                    if (is_array($roadmap)):

                        $stepNumber = 1;

                        foreach ($roadmap as $step):

                    ?>


                        <div class="roadmap-step">


                            <div class="step-number">

                                <?php
                                echo $stepNumber;
                                ?>

                            </div>


<div class="step-content">

    <h3>
        <?php
        echo htmlspecialchars($step['title']);
        ?>
    </h3>

    <p>
        <?php
        echo htmlspecialchars($step['description']);
        ?>
    </p>

    <span class="step-duration">

        <i class="fa-solid fa-clock"></i>

        <?php
        echo htmlspecialchars($step['duration']);
        ?>

    </span>


    <?php

    $currentProgress =
        $progressStatuses[$stepNumber]
        ?? [
            'id' => 0,
            'status' => 'Not Started'
        ];

    $progressId =
        (int)$currentProgress['id'];

    $currentStatus =
        $currentProgress['status'];

    ?>


    <div class="step-progress-area">


        <?php if ($currentStatus === "Completed"): ?>

            <span class="status-completed">

                <i class="fa-solid fa-circle-check"></i>

                Completed

            </span>


        <?php elseif ($currentStatus === "In Progress"): ?>

            <span class="status-progress">

                <i class="fa-solid fa-spinner"></i>

                In Progress

            </span>


            <form
                action="../php/update_progress.php"
                method="POST"
                class="progress-form">

                <input
                    type="hidden"
                    name="progress_id"
                    value="<?php echo $progressId; ?>">

                <input
                    type="hidden"
                    name="action"
                    value="complete">

                <button
                    type="submit"
                    class="complete-learning-btn">

                    <i class="fa-solid fa-check"></i>

                    Mark as Complete

                </button>

            </form>


        <?php else: ?>


            <form
                action="../php/update_progress.php"
                method="POST"
                class="progress-form">

                <input
                    type="hidden"
                    name="progress_id"
                    value="<?php echo $progressId; ?>">

                <input
                    type="hidden"
                    name="action"
                    value="start">

                <button
                    type="submit"
                    class="start-learning-btn">

                    <i class="fa-solid fa-play"></i>

                    Start Learning

                </button>

            </form>


        <?php endif; ?>


    </div>

</div>


                        </div>


                    <?php

                            $stepNumber++;

                        endforeach;

                    endif;

                    ?>


                    <div class="roadmap-actions">

                        <a
                            href="../generator/generator.php"
                            class="roadmap-action new-roadmap">

                            <i class="fa-solid fa-wand-magic-sparkles"></i>

                            Create New Roadmap

                        </a>

                    </div>


                </section>


            <?php else: ?>


                <!-- =================================
                     EMPTY STATE
                ================================= -->

                <section class="roadmap-card">

                    <div class="empty-roadmap">

                        <i class="fa-solid fa-road"></i>


                        <h2>
                            No Learning Roadmap Yet
                        </h2>


                        <p>

                            Create your personalized learning
                            path and start your journey.

                        </p>


                        <a
                            href="../generator/generator.php"
                            class="create-roadmap-btn">

                            <i class="fa-solid fa-wand-magic-sparkles"></i>

                            Create My Learning Path

                        </a>

                    </div>

                </section>


            <?php endif; ?>


        </div>


    </main>


</div>


<script
    src="/AI-Learning-Path-Generator/assets/js/dashboard.js?v=4">
</script>

<script>

const menuButton = document.getElementById("menuButton");
const topMenu = document.getElementById("topMenu");

menuButton.addEventListener("click", function (event) {

    event.stopPropagation();

    topMenu.classList.toggle("show");

});

document.addEventListener("click", function (event) {

    if (
        !topMenu.contains(event.target) &&
        !menuButton.contains(event.target)
    ) {

        topMenu.classList.remove("show");

    }

});

</script>
</body>

</html>