<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
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

    <title>Contact Support | AI Learn</title>

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=5">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        .contact-main {
            max-width: 1050px;
            margin: 0 auto;
        }

        .contact-hero {
            background: linear-gradient(
                135deg,
                #4F46E5,
                #06B6D4
            );

            color: white;
            padding: 45px;
            border-radius: 24px;
            margin-bottom: 30px;
        }

        .contact-hero h2 {
            color: white;
            font-size: 32px;
            margin: 10px 0;
        }

        .contact-hero p {
            color: rgba(255,255,255,.9);
            line-height: 1.7;
            max-width: 700px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 25px;
        }

        .contact-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,.05);
        }

        .contact-card h2 {
            margin-top: 0;
            color: #111827;
        }

        .contact-card p {
            color: #64748b;
            line-height: 1.7;
        }

        .contact-info {
            display: flex;
            gap: 15px;
            margin: 22px 0;
        }

        .contact-icon {
            width: 45px;
            height: 45px;
            min-width: 45px;
            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #4F46E5,
                #06B6D4
            );

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-info h4 {
            margin: 0 0 5px;
            color: #111827;
        }

        .contact-info span {
            color: #64748b;
            font-size: 14px;
        }

        .contact-form-group {
            margin-bottom: 18px;
        }

        .contact-form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #374151;
        }

        .contact-input {
            width: 100%;
            box-sizing: border-box;
            padding: 13px 15px;

            border: 1px solid #e2e8f0;
            border-radius: 10px;

            background: #f8fafc;
            font-size: 15px;
            outline: none;
        }

        .contact-input:focus {
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79,70,229,.10);
        }

        textarea.contact-input {
            min-height: 140px;
            resize: vertical;
        }

        .contact-btn {
            border: none;
            padding: 13px 23px;
            border-radius: 10px;

            background: linear-gradient(
                135deg,
                #4F46E5,
                #06B6D4
            );

            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        @media(max-width: 800px) {

            .contact-grid {
                grid-template-columns: 1fr;
            }

            .contact-hero {
                padding: 30px 25px;
            }

        }

    </style>

</head>

<body>

<div class="dashboard-container">

    <!-- HEADER -->

    <header class="dashboard-header">

        <div class="header-left">

            <div>

                <h1>Contact Support</h1>

                <p>
                    We're here to help you 🤝
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


    <!-- SIDEBAR -->

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

            <a href="/AI-Learning-Path-Generator/dashbord/dashboard.php">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            <a href="/AI-Learning-Path-Generator/dashbord/roadmap.php">
                <i class="fa-solid fa-road"></i>
                <span>My Roadmap</span>
            </a>

            <a href="/AI-Learning-Path-Generator/dashbord/progress.php">
                <i class="fa-solid fa-chart-line"></i>
                <span>Progress</span>
            </a>

            <a href="/AI-Learning-Path-Generator/dashbord/resources.php">
                <i class="fa-solid fa-book"></i>
                <span>Resources</span>
            </a>

            <a href="/AI-Learning-Path-Generator/dashbord/profile.php">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>

            <a href="/AI-Learning-Path-Generator/dashbord/about.php">
                <i class="fa-solid fa-circle-info"></i>
                <span>About</span>
            </a>

        </nav>

        <div class="sidebar-bottom">

            <a href="/AI-Learning-Path-Generator/php/logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                <span>Logout</span>

            </a>

        </div>

    </aside>

    <div
        class="menu-overlay"
        id="menuOverlay">
    </div>


    <!-- MAIN -->

    <main class="dashboard-main">
        <?php if (isset($_GET['sent']) && $_GET['sent'] == '1'): ?>

    <div style="
        background:#dcfce7;
        color:#166534;
        border:1px solid #bbf7d0;
        padding:15px 18px;
        border-radius:12px;
        margin-bottom:20px;
        font-weight:600;
    ">

        <i class="fa-solid fa-circle-check"></i>

        Your message has been sent successfully! 🎉

                <a href="/AI-Learning-Path-Generator/dashbord/my_messages.php"
                    class="about-btn">
                        <i class="fa-solid fa-envelope"></i>
                        View My Messages
                </a>
                
    </div>

<?php endif; ?>

        <div class="contact-main">


            <!-- HERO -->

            <section class="contact-hero">

                <span class="small-title">
                    AI LEARN SUPPORT
                </span>

                <h2>
                    Need Help? We're Here for You 👋
                </h2>

                <p>
                    Have a question about your learning roadmap,
                    progress, resources or account? Send us a message
                    and we'll help you with your issue.
                </p>

            </section>


            <!-- CONTACT GRID -->

            <div class="contact-grid">


                <!-- ADMIN INFORMATION -->

                <section class="contact-card">

                    <h2>
                        Admin & Support
                    </h2>

                    <p>
                        If you need help with AI Learn, you can
                        contact the administrator using the information
                        below.
                    </p>


                    <div class="contact-info">

                        <div class="contact-icon">

                            <i class="fa-solid fa-user-shield"></i>

                        </div>

                        <div>

                            <h4>
                                Administrator
                            </h4>

                            <span>
                                AI Learn Support Team
                            </span>

                        </div>

                    </div>


                    <div class="contact-info">

                        <div class="contact-icon">

                            <i class="fa-solid fa-envelope"></i>

                        </div>

                        <div>

                            <h4>
                                Email
                            </h4>

                            <span>
                                support@ailearn.com
                            </span>

                        </div>

                    </div>


                    <div class="contact-info">

                        <div class="contact-icon">

                            <i class="fa-solid fa-headset"></i>

                        </div>

                        <div>

                            <h4>
                                Support
                            </h4>

                            <span>
                                Account & Technical Assistance
                            </span>

                        </div>

                    </div>

                </section>


                <!-- CONTACT FORM -->

                <section class="contact-card">

                    <h2>
                        Send Us a Message
                    </h2>

                    <p>
                        Describe your problem or question below.
                    </p>


                    <form
                        action="php/contact_submit.php"
                        method="POST">


                        <div class="contact-form-group">

                            <label>
                                Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="contact-input"
                                value="<?php echo htmlspecialchars($user); ?>"
                                required>

                        </div>


                        <div class="contact-form-group">

                            <label>
                                Subject
                            </label>

                            <input
                                type="text"
                                name="subject"
                                class="contact-input"
                                placeholder="What do you need help with?"
                                required>

                        </div>


                        <div class="contact-form-group">

                            <label>
                                Message
                            </label>

                            <textarea
                                name="message"
                                class="contact-input"
                                placeholder="Describe your issue..."
                                required></textarea>

                        </div>


                        <button
                            type="submit"
                            class="contact-btn">

                            <i class="fa-solid fa-paper-plane"></i>

                            Send Message

                        </button>

                    </form>

                </section>


            </div>

        </div>

    </main>

</div>


<script
    src="/AI-Learning-Path-Generator/assets/js/dashboard.js?v=5">
</script>

</body>

</html>