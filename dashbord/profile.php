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


// =====================================
// CURRENT USER
// =====================================

$user = $_SESSION['user'];


// =====================================
// GET USER DATA FROM DATABASE
// =====================================

$sql = "SELECT * FROM users WHERE fullname='$user' LIMIT 1";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    $userData = mysqli_fetch_assoc($result);

} else {

    die("User data not found.");

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Profile | AI Learn</title>


    <!-- DASHBOARD CSS -->

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=3">


    <!-- FONT AWESOME -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>

        /* =====================================
           PROFILE PAGE
        ===================================== */

        .profile-page {

            display:grid;

            grid-template-columns:320px 1fr;

            gap:25px;

        }


        /* =====================================
           PROFILE CARD
        ===================================== */

        .profile-card {

            background:#ffffff;

            border:1px solid #e5e7eb;

            border-radius:20px;

            padding:35px;

            text-align:center;

            box-shadow:0 5px 20px rgba(0,0,0,.05);

        }


        .profile-avatar {

            width:100px;

            height:100px;

            margin:0 auto 20px;

            border-radius:50%;

            background:linear-gradient(
                135deg,
                #4F46E5,
                #06B6D4
            );

            color:white;

            display:flex;

            align-items:center;

            justify-content:center;

            font-size:38px;

        }


        .profile-card h2 {

            margin-bottom:8px;

            color:#111827;

        }


        .profile-card p {

            color:#64748b;

        }


        /* =====================================
           PROFILE INFORMATION
        ===================================== */

        .profile-info {

            background:#ffffff;

            border:1px solid #e5e7eb;

            border-radius:20px;

            padding:30px;

            box-shadow:0 5px 20px rgba(0,0,0,.05);

        }


        .profile-info h2 {

            margin-bottom:25px;

            color:#111827;

        }


        /* =====================================
           FORM GROUP
        ===================================== */

        .info-group {

            margin-bottom:20px;

        }


        .info-group label {

            display:block;

            font-size:14px;

            font-weight:600;

            color:#64748b;

            margin-bottom:8px;

        }


        /* =====================================
           INPUTS
        ===================================== */

        .edit-input {

            display:block;

            box-sizing:border-box;

            width:100%;

            padding:14px 16px;

            background:#f8fafc;

            border:1px solid #e2e8f0;

            border-radius:10px;

            color:#334155;

            font-size:15px;

            outline:none;

            transition:.3s;

        }


        .edit-input:focus {

            border-color:#4F46E5;

            box-shadow:
                0 0 0 3px
                rgba(79,70,229,.10);

        }


        select.edit-input {

            cursor:pointer;

        }


        /* =====================================
           BUTTONS
        ===================================== */

        .profile-actions {

            margin-top:25px;

            display:flex;

            gap:15px;

            flex-wrap:wrap;

        }


        .profile-btn {

            padding:12px 22px;

            border:none;

            border-radius:10px;

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color:white;

            font-weight:600;

            cursor:pointer;

            transition:.3s;

        }


        .profile-btn:hover {

            transform:translateY(-2px);

            box-shadow:
                0 8px 18px
                rgba(79,70,229,.25);

        }


        .cancel-btn {

            display:inline-flex;

            align-items:center;

            justify-content:center;

            padding:12px 22px;

            border-radius:10px;

            background:#e5e7eb;

            color:#374151 !important;

            font-weight:600;

            text-decoration:none;

        }


        .cancel-btn:hover {

            background:#d1d5db;

        }


        /* =====================================
           SUCCESS MESSAGE
        ===================================== */

        .success-message {

            background:#dcfce7;

            color:#166534;

            border:1px solid #bbf7d0;

            padding:14px 18px;

            border-radius:12px;

            margin-bottom:20px;

            font-weight:600;

            display:flex;

            align-items:center;

            gap:10px;

        }


        /* =====================================
           MOBILE
        ===================================== */

        @media(max-width:800px) {

            .profile-page {

                grid-template-columns:1fr;

            }

        }


        @media(max-width:576px) {

            .profile-info {

                padding:20px;

            }

            .profile-card {

                padding:25px;

            }

            .profile-actions {

                flex-direction:column;

            }

            .profile-btn,
            .cancel-btn {

                width:100%;

                box-sizing:border-box;

            }

        }

    </style>

</head>


<body>


<div class="dashboard-container">


    <!-- =====================================
         HEADER
    ===================================== -->

    <header class="dashboard-header">


        <div class="header-left">

            <div>

                <h1>My Profile</h1>

                <p>
                    Manage your AI Learn account 👤
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


        </div>


    </header>



    <!-- =====================================
         SIDEBAR
    ===================================== -->

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


            <a
                href="profile.php"
                class="active">

                <i class="fa-solid fa-user"></i>

                <span>Profile</span>

            </a>

            <a href="about.php">
                <i class="fa-solid fa-circle-info"></i>
                <span>About</span>
            </a>
        </nav>



        <!-- LOGOUT -->

        <div class="sidebar-bottom">

            <a href="../php/logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                <span>Logout</span>

            </a>

        </div>


    </aside>



    <!-- OVERLAY -->

    <div
        class="menu-overlay"
        id="menuOverlay">
    </div>



    <!-- =====================================
         MAIN CONTENT
    ===================================== -->

    <main class="dashboard-main">


        <!-- =====================================
             SUCCESS MESSAGE
        ===================================== -->

        <?php if (isset($_GET['updated']) && $_GET['updated'] == '1'): ?>

            <div class="success-message">

                <i class="fa-solid fa-circle-check"></i>

                Profile updated successfully! 🎉

            </div>

        <?php endif; ?>



        <!-- =====================================
             PROFILE PAGE
        ===================================== -->

        <div class="profile-page">



            <!-- =================================
                 PROFILE CARD
            ================================= -->

            <div class="profile-card">


                <div class="profile-avatar">

                    <i class="fa-solid fa-user"></i>

                </div>


                <h2>

                    <?php
                    echo htmlspecialchars(
                        $userData['fullname']
                    );
                    ?>

                </h2>


                <p>
                    AI Learn Student
                </p>


            </div>



            <!-- =================================
                 PROFILE INFORMATION
            ================================= -->

            <div class="profile-info">


                <h2>
                    Account Information
                </h2>


                <form
                    action="../php/update_profile.php"
                    method="POST">



                    <!-- FULL NAME -->

                    <div class="info-group">

                        <label>
                            Full Name
                        </label>


                        <input
                            type="text"
                            name="fullname"
                            class="edit-input"
                            value="<?php
                            echo htmlspecialchars(
                                $userData['fullname']
                            );
                            ?>"
                            required>

                    </div>



                    <!-- EMAIL -->

                    <div class="info-group">

                        <label>
                            Email
                        </label>


                        <input
                            type="email"
                            name="email"
                            class="edit-input"
                            value="<?php
                            echo htmlspecialchars(
                                $userData['email']
                            );
                            ?>"
                            required>

                    </div>



                    <!-- SKILL LEVEL -->

                    <div class="info-group">

                        <label>
                            Skill Level
                        </label>


                        <select
                            name="skill_level"
                            class="edit-input"
                            required>


                            <option value="">
                                Select Skill Level
                            </option>


                            <option
                                value="Beginner"
                                <?php
                                if (
                                    $userData['skill_level']
                                    == 'Beginner'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                Beginner

                            </option>


                            <option
                                value="Intermediate"
                                <?php
                                if (
                                    $userData['skill_level']
                                    == 'Intermediate'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                Intermediate

                            </option>


                            <option
                                value="Advanced"
                                <?php
                                if (
                                    $userData['skill_level']
                                    == 'Advanced'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                Advanced

                            </option>


                        </select>

                    </div>



                    <!-- LEARNING GOAL -->

                    <div class="info-group">

                        <label>
                            Learning Goal
                        </label>


                        <select
                            name="goal"
                            class="edit-input"
                            required>


                            <option value="">
                                Select Learning Goal
                            </option>


                            <option
                                value="Web Development"
                                <?php
                                if (
                                    $userData['goal']
                                    == 'Web Development'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                Web Development

                            </option>


                            <option
                                value="Artificial Intelligence"
                                <?php
                                if (
                                    $userData['goal']
                                    == 'Artificial Intelligence'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                Artificial Intelligence

                            </option>


                            <option
                                value="Data Science"
                                <?php
                                if (
                                    $userData['goal']
                                    == 'Data Science'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                Data Science

                            </option>


                            <option
                                value="Cyber Security"
                                <?php
                                if (
                                    $userData['goal']
                                    == 'Cyber Security'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                Cyber Security

                            </option>


                        </select>

                    </div>



                    <!-- STUDY TIME -->

                    <div class="info-group">

                        <label>
                            Daily Study Time
                        </label>


                        <select
                            name="study_time"
                            class="edit-input"
                            required>


                            <option value="">
                                Select Study Time
                            </option>


                            <option
                                value="1 Hour"
                                <?php
                                if (
                                    $userData['study_time']
                                    == '1 Hour'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                1 Hour

                            </option>


                            <option
                                value="2 Hours"
                                <?php
                                if (
                                    $userData['study_time']
                                    == '2 Hours'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                2 Hours

                            </option>


                            <option
                                value="3 Hours"
                                <?php
                                if (
                                    $userData['study_time']
                                    == '3 Hours'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                3 Hours

                            </option>


                            <option
                                value="4+ Hours"
                                <?php
                                if (
                                    $userData['study_time']
                                    == '4+ Hours'
                                ) {
                                    echo 'selected';
                                }
                                ?>>

                                4+ Hours

                            </option>


                        </select>

                    </div>



                    <!-- BUTTONS -->

                    <div class="profile-actions">


                        <button
                            type="submit"
                            class="profile-btn">

                            <i class="fa-solid fa-save"></i>

                            Save Changes

                        </button>


                        <a
                            href="profile.php"
                            class="cancel-btn">

                            Cancel

                        </a>


                    </div>


                </form>


            </div>


        </div>


    </main>


</div>



<!-- =====================================
     DASHBOARD JAVASCRIPT
===================================== -->

<script
    src="/AI-Learning-Path-Generator/assets/js/dashboard.js?v=3">
</script>


</body>

</html>