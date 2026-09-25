<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.html");
    exit();
}

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Learning Path Generator | AI Learn</title>

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=3">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        /* =========================================
           GENERATOR PAGE
        ========================================= */

        .generator-main {
            max-width: 1000px;
            margin: 0 auto;
        }


        .generator-intro {
            background: linear-gradient(135deg, #4F46E5, #06B6D4);
            color: white;
            padding: 45px;
            border-radius: 24px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(79,70,229,.18);
        }

        .generator-intro .small-title {
            color: rgba(255,255,255,.85);
        }

        .generator-intro h2 {
            color: white;
            font-size: 32px;
            margin: 12px 0;
        }

        .generator-intro p {
            color: rgba(255,255,255,.88);
            line-height: 1.7;
            max-width: 700px;
        }


        /* FORM CARD */

        .generator-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 22px;
            padding: 40px;

            box-shadow: 0 10px 30px rgba(0,0,0,.06);
        }

        .generator-card h2 {
            color: #111827;
            margin-bottom: 8px;
        }

        .generator-card > p {
            color: #64748b;
            margin-bottom: 30px;
        }


        /* FORM */

        .generator-form {
            display: grid;
            gap: 22px;
        }

        .generator-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .generator-group {
            display: flex;
            flex-direction: column;
        }

        .generator-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .generator-group input,
        .generator-group select,
        .generator-group textarea {
            width: 100%;
            box-sizing: border-box;

            padding: 14px 16px;

            border: 1px solid #d1d5db;
            border-radius: 10px;

            background: #ffffff;
            color: #111827;

            font-family: inherit;
            font-size: 15px;

            outline: none;
            transition: .3s;
        }

        .generator-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .generator-group input:focus,
        .generator-group select:focus,
        .generator-group textarea:focus {
            border-color: #4F46E5;

            box-shadow:
                0 0 0 3px rgba(79,70,229,.10);
        }


        /* BUTTON */

        .generate-btn {
            width: 100%;
            padding: 16px 24px;

            border: none;
            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #4F46E5,
                #06B6D4
            );

            color: white;

            font-size: 16px;
            font-weight: 700;

            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            transition: .3s;
        }

        .generate-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 10px 25px rgba(79,70,229,.25);
        }


        /* INFO */

        .generator-note {
            margin-top: 20px;
            padding: 15px;

            background: #f8fafc;
            border-radius: 10px;

            color: #64748b;
            font-size: 14px;

            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .generator-note i {
            color: #4F46E5;
            margin-top: 2px;
        }


        /* MOBILE */

        @media(max-width: 768px) {

            .generator-intro {
                padding: 30px 25px;
            }

            .generator-intro h2 {
                font-size: 26px;
            }

            .generator-card {
                padding: 25px;
            }

            .generator-row {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>

<div class="dashboard-container">


    <!-- ================= HEADER ================= -->

    <header class="dashboard-header">

        <div class="header-left">

            <div>

                <h1>AI Learning Path</h1>

                <p>
                    Create your personalized learning roadmap 🤖
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


    <!-- ================= SIDEBAR ================= -->

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

            <a href="../dashbord/dashboard.php">

                <i class="fa-solid fa-house"></i>

                <span>Dashboard</span>

            </a>


            <a href="../dashbord/roadmap.php">

                <i class="fa-solid fa-road"></i>

                <span>My Roadmap</span>

            </a>


            <a href="../dashbord/progress.php">

                <i class="fa-solid fa-chart-line"></i>

                <span>Progress</span>

            </a>


            <a href="../dashbord/resources.php">

                <i class="fa-solid fa-book"></i>

                <span>Resources</span>

            </a>


            <a href="../dashbord/profile.php">

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


    <!-- ================= MAIN ================= -->

    <main class="dashboard-main">


        <div class="generator-main">


            <!-- INTRO -->

            <section class="generator-intro">

                <span class="small-title">
                    AI POWERED LEARNING
                </span>

                <h2>
                    Build Your Personalized Learning Path 🚀
                </h2>

                <p>
                    Tell us about your goals, current skills and
                    available study time. AI Learn will create a
                    structured learning roadmap for you.
                </p>

            </section>


            <!-- FORM -->

            <section class="generator-card">

                <h2>
                    Tell Us About Your Learning Goals
                </h2>

                <p>
                    Fill in the details below to create your roadmap.
                </p>


                <form
                    class="generator-form"
                    id="generatorForm"
                    action="../php/generate_ai.php"
                    method="POST">


                    <!-- GOAL -->

                    <div class="generator-group">

                        <label for="goal">

                            What do you want to learn?

                        </label>

                        <input
                            type="text"
                            id="goal"
                            name="goal"
                            placeholder="e.g. Web Development, AI, Cyber Security"
                            required>

                    </div>


                    <!-- SKILL + STUDY -->

                    <div class="generator-row">


                        <div class="generator-group">

                            <label for="skill">

                                Current Skill Level

                            </label>

                            <select
                                id="skill"
                                name="skill"
                                required>

                                <option value="">
                                    Select your level
                                </option>

                                <option value="beginner">
                                    Beginner
                                </option>

                                <option value="intermediate">
                                    Intermediate
                                </option>

                                <option value="advanced">
                                    Advanced
                                </option>

                            </select>

                        </div>


                        <div class="generator-group">

                            <label for="study">

                                Daily Study Time

                            </label>

                            <select
                                id="study"
                                name="study"
                                required>

                                <option value="">
                                    Select study time
                                </option>

                                <option value="30">
                                    30 Minutes
                                </option>

                                <option value="60">
                                    1 Hour
                                </option>

                                <option value="120">
                                    2 Hours
                                </option>

                                <option value="180">
                                    3+ Hours
                                </option>

                            </select>

                        </div>


                    </div>


                    <!-- DURATION -->

                    <div class="generator-group">

                        <label for="duration">

                            Learning Duration

                        </label>

                        <select
                            id="duration"
                            name="duration"
                            required>

                            <option value="">
                                Select duration
                            </option>

                            <option value="2">
                                2 Weeks
                            </option>

                            <option value="4">
                                1 Month
                            </option>

                            <option value="8">
                                2 Months
                            </option>

                            <option value="12">
                                3 Months
                            </option>

                            <option value="24">
                                6 Months
                            </option>

                        </select>

                    </div>


                    <!-- EXPERIENCE -->

                    <div class="generator-group">

                        <label for="experience">

                            What do you already know?

                        </label>

                        <textarea
                            id="experience"
                            name="experience"
                            placeholder="Example: I know basic HTML and CSS but I am new to JavaScript."></textarea>

                    </div>


                    <!-- INTEREST -->

                    <div class="generator-group">

                        <label for="interest">

                            What would you like to build?

                        </label>

                        <textarea
                            id="interest"
                            name="interest"
                            placeholder="Example: I want to build websites, AI projects and a portfolio."></textarea>

                    </div>


                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="generate-btn">

                        <i class="fa-solid fa-wand-magic-sparkles"></i>

                        Generate My Learning Path

                    </button>


                </form>


                <div class="generator-note">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>
                        Your answers will be used to create a
                        personalized learning roadmap based on your
                        goals and current skill level.
                    </span>

                </div>


            </section>


        </div>


    </main>

</div>


<script src="/AI-Learning-Path-Generator/assets/js/dashboard.js?v=3"></script>


</body>

</html>