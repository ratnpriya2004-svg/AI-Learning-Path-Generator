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

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>About | AI Learn</title>

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=5">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>

        /* =========================================
           ABOUT PAGE
        ========================================= */

        .about-main {
            max-width: 1100px;
            margin: 0 auto;
        }


        .about-hero {

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;

            padding: 50px;

            border-radius: 25px;

            margin-bottom: 30px;

            box-shadow:
                0 15px 35px rgba(79,70,229,.18);

        }


        .about-hero .small-title {

            color: rgba(255,255,255,.85);

            font-size: 13px;

            font-weight: 700;

            letter-spacing: 1px;

        }


        .about-hero h2 {

            color: white;

            font-size: 34px;

            margin: 12px 0;

        }


        .about-hero p {

            max-width: 750px;

            color: rgba(255,255,255,.9);

            line-height: 1.8;

            margin: 0;

        }


        /* =========================================
           ABOUT CARDS
        ========================================= */

        .about-grid {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 25px;

            margin-bottom: 30px;

        }


        .about-card {

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 20px;

            padding: 30px;

            box-shadow:
                0 8px 25px rgba(0,0,0,.05);

        }


        .about-icon {

            width: 55px;

            height: 55px;

            border-radius: 15px;

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

            font-size: 22px;

            margin-bottom: 18px;

        }


        .about-card h3 {

            margin: 0 0 10px;

            color: #111827;

            font-size: 21px;

        }


        .about-card p {

            margin: 0;

            color: #64748b;

            line-height: 1.7;

        }


        /* =========================================
           HOW IT WORKS
        ========================================= */

        .how-section {

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 22px;

            padding: 35px;

            margin-bottom: 30px;

            box-shadow:
                0 8px 25px rgba(0,0,0,.05);

        }


        .section-title {

            margin-bottom: 25px;

        }


        .section-title h2 {

            margin: 0 0 8px;

            color: #111827;

        }


        .section-title p {

            margin: 0;

            color: #64748b;

        }


        .steps-grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;

        }


        .about-step {

            text-align: center;

            padding: 20px 10px;

        }


        .step-circle {

            width: 50px;

            height: 50px;

            margin: 0 auto 15px;

            border-radius: 50%;

            background: #eef2ff;

            color: #4F46E5;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: 700;

        }


        .about-step h4 {

            margin: 0 0 8px;

            color: #111827;

        }


        .about-step p {

            margin: 0;

            color: #64748b;

            font-size: 14px;

            line-height: 1.6;

        }


        /* =========================================
           FEATURES
        ========================================= */

        .features-section {

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 22px;

            padding: 35px;

            margin-bottom: 30px;

            box-shadow:
                0 8px 25px rgba(0,0,0,.05);

        }


        .features-grid {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;

        }


        .feature-item {

            display: flex;

            gap: 13px;

            padding: 18px;

            background: #f8fafc;

            border-radius: 14px;

        }


        .feature-item i {

            color: #4F46E5;

            font-size: 19px;

            margin-top: 3px;

        }


        .feature-item h4 {

            margin: 0 0 5px;

            color: #111827;

        }


        .feature-item p {

            margin: 0;

            color: #64748b;

            font-size: 13px;

            line-height: 1.5;

        }


        /* =========================================
           SUPPORT
        ========================================= */

        .support-card {

            background:
                linear-gradient(
                    135deg,
                    #eef2ff,
                    #ecfeff
                );

            border-radius: 22px;

            padding: 35px;

            text-align: center;

            margin-bottom: 30px;

        }


        .support-card h2 {

            margin: 0 0 10px;

            color: #111827;

        }


        .support-card p {

            color: #64748b;

            max-width: 650px;

            margin: 0 auto 22px;

            line-height: 1.7;

        }


        .about-btn {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 13px 22px;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;

            text-decoration: none;

            font-weight: 600;

        }


        /* =========================================
           MOBILE
        ========================================= */

        @media(max-width: 900px) {

            .steps-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

            .features-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }

        }


        @media(max-width: 700px) {

            .about-hero,
            .how-section,
            .features-section {

                padding: 25px;

            }


            .about-grid {

                grid-template-columns: 1fr;

            }


            .steps-grid,
            .features-grid {

                grid-template-columns: 1fr;

            }


            .about-hero h2 {

                font-size: 27px;

            }

        }
        /* =========================================
   MODERN ABOUT HERO
========================================= */

.about-hero-modern {
    display: grid;
    grid-template-columns: 1.2fr .8fr;
    align-items: center;
    gap: 40px;
    overflow: hidden;
}

.about-hero-content {
    position: relative;
    z-index: 2;
}

.about-hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 25px;
}

.about-primary-btn {
    box-shadow: 0 8px 20px rgba(79,70,229,.22);
}

.about-outline-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 22px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,.45);
    color: white;
    font-weight: 600;
    text-decoration: none;
    background: rgba(255,255,255,.08);
}

.about-outline-btn:hover {
    background: rgba(255,255,255,.16);
}

.about-hero-visual {
    min-height: 280px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ai-orb {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;

    background: rgba(255,255,255,.14);
    border: 1px solid rgba(255,255,255,.28);

    box-shadow:
        0 0 0 18px rgba(255,255,255,.04),
        0 25px 50px rgba(0,0,0,.15);

    font-size: 55px;
    color: white;
}

.floating-info {
    position: absolute;

    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 10px 14px;

    border-radius: 12px;

    background: rgba(255,255,255,.96);
    color: #1f2937;

    box-shadow: 0 12px 25px rgba(0,0,0,.12);

    font-size: 13px;
    font-weight: 700;

    white-space: nowrap;
}

.floating-info i {
    color: #4F46E5;
}

.info-one {
    top: 12%;
    right: 2%;
}

.info-two {
    bottom: 10%;
    left: 0;
}

.info-three {
    top: 48%;
    right: -3%;
}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 900px) {

    .about-hero-modern {
        grid-template-columns: 1fr;
    }

    .about-hero-visual {
        min-height: 220px;
        margin-top: 10px;
    }

}

@media (max-width: 600px) {

    .about-hero-actions {
        flex-direction: column;
    }

    .about-primary-btn,
    .about-outline-btn {
        width: 100%;
        justify-content: center;
    }

    .floating-info {
        font-size: 12px;
        padding: 8px 11px;
    }

    .info-one {
        right: 0;
    }

    .info-three {
        right: 0;
    }

}

/* =========================================
   PROJECT HIGHLIGHTS
========================================= */

.project-highlights {
    margin-bottom: 30px;
}


/* Highlight grid */

.highlight-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 25px;
}

.highlight-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;

    padding: 22px;

    box-shadow: 0 8px 22px rgba(0,0,0,.05);

    transition: .3s;
}

.highlight-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 28px rgba(79,70,229,.12);
}

.highlight-icon {
    width: 48px;
    height: 48px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 13px;

    background: #eef2ff;
    color: #4F46E5;

    font-size: 19px;

    margin-bottom: 15px;
}

.highlight-card strong {
    display: block;

    color: #111827;

    font-size: 16px;

    margin-bottom: 7px;
}

.highlight-card span {
    display: block;

    color: #64748b;

    font-size: 13px;

    line-height: 1.6;
}


/* =========================================
   TECH STACK
========================================= */

.tech-stack-card {
    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 22px;

    padding: 30px;

    box-shadow: 0 8px 25px rgba(0,0,0,.05);
}

.tech-stack-heading span {
    display: inline-block;

    color: #4F46E5;

    font-size: 12px;

    font-weight: 700;

    letter-spacing: 1px;

    margin-bottom: 7px;
}

.tech-stack-heading h3 {
    margin: 0 0 22px;

    color: #111827;

    font-size: 23px;
}

.tech-stack-list {
    display: flex;

    flex-wrap: wrap;

    gap: 12px;
}

.tech-item {
    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 10px 14px;

    border-radius: 10px;

    background: #f8fafc;

    border: 1px solid #e5e7eb;

    color: #334155;

    font-size: 13px;

    font-weight: 600;
}

.tech-item i {
    color: #4F46E5;

    font-size: 16px;
}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 1000px) {

    .highlight-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .highlight-grid {
        grid-template-columns: 1fr;
    }

    .tech-stack-card {
        padding: 24px;
    }

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

                <h1>About AI Learn</h1>

                <p>
                    Learn smarter. Build better. Grow faster. 🚀
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


            <a href="about.php" class="active">

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


    <div
        class="menu-overlay"
        id="menuOverlay">
    </div>


    <!-- =========================================
         MAIN CONTENT
    ========================================= -->

    <main class="dashboard-main">

        <div class="about-main">


            <!-- =================================
                 HERO
            ================================= -->

<section class="about-hero about-hero-modern">

    <div class="about-hero-content">

        <span class="small-title">
            ABOUT AI LEARN
        </span>

        <h2>
            Your Personalized Learning Companion 🧠
        </h2>

        <p>
            AI Learn helps students and learners turn a career goal
            into a clear, practical learning path with AI-powered
            roadmaps, resources and progress tracking.
        </p>

        <div class="about-hero-actions">

            <a
                href="dashboard.php"
                class="about-btn about-primary-btn">

                <i class="fa-solid fa-rocket"></i>

                Start Learning

            </a>

            <a
                href="#how-it-works"
                class="about-outline-btn">

                <i class="fa-solid fa-circle-play"></i>

                How It Works

            </a>

        </div>

    </div>


    <div class="about-hero-visual">

        <div class="ai-orb">
            <i class="fa-solid fa-brain"></i>
        </div>

        <div class="floating-info info-one">

            <i class="fa-solid fa-route"></i>

            <span>AI Roadmap</span>

        </div>

        <div class="floating-info info-two">

            <i class="fa-solid fa-chart-line"></i>

            <span>Track Progress</span>

        </div>

        <div class="floating-info info-three">

            <i class="fa-solid fa-graduation-cap"></i>

            <span>Learn & Grow</span>

        </div>

    </div>

</section>


            <!-- =================================
                 ABOUT CARDS
            ================================= -->

            <section class="about-grid">


                <div class="about-card">

                    <div class="about-icon">

                        <i class="fa-solid fa-bullseye"></i>

                    </div>


                    <h3>
                        Our Purpose
                    </h3>


                    <p>

                        Learning a new technology can feel confusing
                        when there are too many topics and resources.
                        AI Learn helps organize your learning journey
                        into simple and manageable steps.

                    </p>

                </div>


                <div class="about-card">

                    <div class="about-icon">

                        <i class="fa-solid fa-graduation-cap"></i>

                    </div>


                    <h3>
                        Built for Learners
                    </h3>


                    <p>

                        AI Learn is designed for students,
                        beginners and anyone who wants to develop
                        practical technology skills with a structured
                        learning plan.

                    </p>

                </div>


            </section>


            <!-- =================================
                 HOW IT WORKS
            ================================= -->

            <section class="how-section" id="how-it-works">


                <div class="section-title">

                    <h2>
                        How AI Learn Works
                    </h2>

                    <p>
                        Create a learning path in a few simple steps.
                    </p>

                </div>


                <div class="steps-grid">


                    <div class="about-step">

                        <div class="step-circle">
                            1
                        </div>

                        <h4>
                            Choose Your Goal
                        </h4>

                        <p>
                            Select the technology or career skill
                            you want to learn.
                        </p>

                    </div>


                    <div class="about-step">

                        <div class="step-circle">
                            2
                        </div>

                        <h4>
                            Tell Us About You
                        </h4>

                        <p>
                            Provide your skill level,
                            study time and experience.
                        </p>

                    </div>


                    <div class="about-step">

                        <div class="step-circle">
                            3
                        </div>

                        <h4>
                            Generate Your Path
                        </h4>

                        <p>
                            AI Learn creates a structured roadmap
                            based on your information.
                        </p>

                    </div>


                    <div class="about-step">

                        <div class="step-circle">
                            4
                        </div>

                        <h4>
                            Learn & Track
                        </h4>

                        <p>
                            Follow your roadmap and monitor
                            your learning progress.
                        </p>

                    </div>


                </div>

            </section>


            <!-- =================================
                 FEATURES
            ================================= -->

            <section class="features-section">


                <div class="section-title">

                    <h2>
                        What You Can Do
                    </h2>

                    <p>
                        Everything you need to organize your learning journey.
                    </p>

                </div>


                <div class="features-grid">


                    <div class="feature-item">

                        <i class="fa-solid fa-wand-magic-sparkles"></i>

                        <div>

                            <h4>
                                Personalized Roadmaps
                            </h4>

                            <p>
                                Generate learning paths based on
                                your individual goals and skill level.
                            </p>

                        </div>

                    </div>


                    <div class="feature-item">

                        <i class="fa-solid fa-chart-line"></i>

                        <div>

                            <h4>
                                Progress Tracking
                            </h4>

                            <p>
                                Track your completed learning steps
                                and see your progress.
                            </p>

                        </div>

                    </div>


                    <div class="feature-item">

                        <i class="fa-solid fa-book-open"></i>

                        <div>

                            <h4>
                                Learning Resources
                            </h4>

                            <p>
                                Keep useful learning materials
                                organized in one place.
                            </p>

                        </div>

                    </div>


                    <div class="feature-item">

                        <i class="fa-solid fa-user"></i>

                        <div>

                            <h4>
                                Personal Profile
                            </h4>

                            <p>
                                Manage your account and learning
                                information from your profile.
                            </p>

                        </div>

                    </div>


                    <div class="feature-item">

                        <i class="fa-solid fa-clock"></i>

                        <div>

                            <h4>
                                Study Planning
                            </h4>

                            <p>
                                Build your learning journey around
                                the time you can dedicate to studying.
                            </p>

                        </div>

                    </div>


                    <div class="feature-item">

                        <i class="fa-solid fa-mobile-screen-button"></i>

                        <div>

                            <h4>
                                Easy to Use
                            </h4>

                            <p>
                                A clean and simple interface designed
                                for a smooth learning experience.
                            </p>

                        </div>

                    </div>


                </div>

            </section>

            <!-- =========================================
     PROJECT HIGHLIGHTS
========================================= -->

<section class="project-highlights">

    <div class="section-title">

        <span>PROJECT HIGHLIGHTS</span>

        <h2>Built to Make Learning Simpler</h2>

        <p>
            AI Learn combines personalized planning, progress tracking
            and practical learning tools in one platform.
        </p>

    </div>


    <div class="highlight-grid">

        <div class="highlight-card">

            <div class="highlight-icon">
                <i class="fa-solid fa-robot"></i>
            </div>

            <strong>AI Powered</strong>

            <span>
                Personalized roadmaps generated according to learner input.
            </span>

        </div>


        <div class="highlight-card">

            <div class="highlight-icon">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <strong>Personalized</strong>

            <span>
                Learning paths adapt to skill level, study time and goals.
            </span>

        </div>


        <div class="highlight-card">

            <div class="highlight-icon">
                <i class="fa-solid fa-chart-line"></i>
            </div>

            <strong>Progress Focused</strong>

            <span>
                Track completed steps and monitor your learning journey.
            </span>

        </div>


        <div class="highlight-card">

            <div class="highlight-icon">
                <i class="fa-solid fa-laptop-code"></i>
            </div>

            <strong>Project Based</strong>

            <span>
                Encourages practical learning through real-world projects.
            </span>

        </div>

    </div>


    <!-- TECH STACK -->

    <div class="tech-stack-card">

        <div class="tech-stack-heading">

            <span>TECH STACK</span>

            <h3>Technologies Behind AI Learn</h3>

        </div>


        <div class="tech-stack-list">

            <div class="tech-item">
                <i class="fa-brands fa-html5"></i>
                <span>HTML5</span>
            </div>

            <div class="tech-item">
                <i class="fa-brands fa-css3-alt"></i>
                <span>CSS3</span>
            </div>

            <div class="tech-item">
                <i class="fa-brands fa-js"></i>
                <span>JavaScript</span>
            </div>

            <div class="tech-item">
                <i class="fa-brands fa-php"></i>
                <span>PHP</span>
            </div>

            <div class="tech-item">
                <i class="fa-solid fa-database"></i>
                <span>MySQL</span>
            </div>

            <div class="tech-item">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span>Gemini API</span>
            </div>

        </div>

    </div>

</section>

            <!-- =================================
                 SUPPORT
            ================================= -->

            <section class="support-card">

                <h2>
                    Need Help?
                </h2>


                <p>

                    If you have a question about your account,
                    learning roadmap, progress or any technical
                    issue, our support section is available to
                    help you.

                </p>


                <a href="../contact.php" class="about-btn">
                    <i class="fa-solid fa-headset"></i>
                    Contact Support
                </a>

            </section>


        </div>

    </main>

<?php include("../includes/footer.php"); ?>
</div>


<script
    src="/AI-Learning-Path-Generator/assets/js/dashboard.js?v=5">
</script>

</body>

</html>