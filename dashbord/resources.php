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

    <title>Resources | AI Learn</title>

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=5">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>

        /* =========================================
           RESOURCES PAGE
        ========================================= */

        .resources-container {

            max-width: 1200px;
            margin: 0 auto;

        }


        /* =========================================
           INTRO
        ========================================= */

        .resources-intro {

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;

            padding: 35px;

            border-radius: 24px;

            margin-bottom: 25px;

            box-shadow:
                0 15px 35px rgba(79,70,229,.18);

        }


        .resources-intro .small-title {

            color: rgba(255,255,255,.85);

        }


        .resources-intro h2 {

            color: white;

            font-size: 30px;

            margin: 10px 0;

        }


        .resources-intro p {

            color: rgba(255,255,255,.9);

            margin: 0;

            line-height: 1.6;

        }


        /* =========================================
           SEARCH
        ========================================= */

        .resource-tools {

            display: flex;

            gap: 15px;

            margin-bottom: 22px;

            flex-wrap: wrap;

        }


        .resource-search {

            flex: 1;

            min-width: 240px;

            position: relative;

        }


        .resource-search i {

            position: absolute;

            left: 16px;

            top: 50%;

            transform: translateY(-50%);

            color: #64748b;

        }


        .resource-search input {

            width: 100%;

            box-sizing: border-box;

            padding: 14px 18px 14px 45px;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            outline: none;

            background: white;

            font-size: 14px;

        }


        .resource-search input:focus {

            border-color: #4F46E5;

            box-shadow:
                0 0 0 3px rgba(79,70,229,.1);

        }


        /* =========================================
           FILTER BUTTONS
        ========================================= */

        .resource-filters {

            display: flex;

            gap: 8px;

            flex-wrap: wrap;

            margin-bottom: 25px;

        }


        .filter-btn {

            border: 1px solid #e2e8f0;

            background: white;

            color: #475569;

            padding: 9px 15px;

            border-radius: 20px;

            cursor: pointer;

            font-size: 13px;

            font-weight: 600;

            transition: .2s;

        }


        .filter-btn:hover {

            border-color: #4F46E5;

            color: #4F46E5;

        }


        .filter-btn.active {

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;

            border-color: transparent;

        }


        /* =========================================
           RESOURCE GRID
        ========================================= */

        .resource-grid {

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 18px;

        }


        /* =========================================
           RESOURCE CARD
        ========================================= */

        .resource-card {

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 18px;

            padding: 22px;

            min-height: 235px;

            display: flex;

            flex-direction: column;

            box-shadow:
                0 5px 18px rgba(0,0,0,.04);

            transition:
                transform .25s,
                box-shadow .25s;

        }


        .resource-card:hover {

            transform: translateY(-5px);

            box-shadow:
                0 15px 30px rgba(0,0,0,.09);

        }


        .resource-icon {

            width: 52px;

            height: 52px;

            border-radius: 14px;

            background: #eef2ff;

            color: #4F46E5;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 25px;

            margin-bottom: 16px;

        }


        .resource-card h3 {

            margin: 0 0 8px;

            color: #111827;

            font-size: 18px;

        }


        .resource-card p {

            color: #64748b;

            line-height: 1.5;

            font-size: 14px;

            margin: 0 0 15px;

        }


        .resource-category {

            display: inline-block;

            align-self: flex-start;

            background: #eef2ff;

            color: #4F46E5;

            padding: 5px 9px;

            border-radius: 8px;

            font-size: 11px;

            font-weight: 700;

            margin-bottom: 16px;

        }


        .resource-open {

            margin-top: auto;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            padding: 10px 15px;

            border-radius: 9px;

            text-decoration: none;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            font-weight: 600;

            font-size: 13px;

            transition: .2s;

        }


        .resource-open:hover {

            transform: translateY(-2px);

        }


        /* =========================================
           NO RESULT
        ========================================= */

        .no-results {

            display: none;

            text-align: center;

            padding: 50px 20px;

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 18px;

        }


        .no-results i {

            font-size: 42px;

            color: #94a3b8;

            margin-bottom: 15px;

        }


        .no-results h3 {

            color: #111827;

            margin-bottom: 8px;

        }


        .no-results p {

            color: #64748b;

        }


        /* =========================================
           HELP / CONTACT
        ========================================= */

        .help-section {

            margin-top: 30px;

            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 20px;

            padding: 28px;

            box-shadow:
                0 5px 20px rgba(0,0,0,.04);

        }


        .help-header h2 {

            margin: 0 0 8px;

            color: #111827;

        }


        .help-header p {

            margin: 0 0 22px;

            color: #64748b;

        }


        .help-grid {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 15px;

        }


        .help-card {

            border: 1px solid #e5e7eb;

            border-radius: 14px;

            padding: 18px;

            display: flex;

            gap: 14px;

            align-items: flex-start;

        }


        .help-icon {

            width: 42px;

            height: 42px;

            min-width: 42px;

            border-radius: 11px;

            background: #eef2ff;

            color: #4F46E5;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .help-card h4 {

            margin: 0 0 5px;

            color: #111827;

        }


        .help-card p {

            margin: 0;

            color: #64748b;

            font-size: 13px;

            line-height: 1.5;

        }


        .help-card a {

            color: #4F46E5;

            text-decoration: none;

            font-weight: 600;

        }


        /* =========================================
           FOOTER
        ========================================= */

        .resource-footer {

            text-align: center;

            padding: 25px 10px;

            color: #64748b;

            font-size: 14px;

        }


        /* =========================================
           MOBILE
        ========================================= */

        @media(max-width: 1000px) {

            .resource-grid {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

            }

            .help-grid {

                grid-template-columns: 1fr;

            }

        }


        @media(max-width: 650px) {

            .resource-grid {

                grid-template-columns: 1fr;

            }


            .resources-intro {

                padding: 25px;

            }


            .resources-intro h2 {

                font-size: 25px;

            }


            .resource-card {

                min-height: 220px;

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

                <h1>Learning Resources</h1>

                <p>
                    Useful resources to improve your skills 📚
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


            <a
                href="resources.php"
                class="active">

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


    <div
        class="menu-overlay"
        id="menuOverlay">
    </div>


    <!-- =========================================
         MAIN
    ========================================= -->

    <main class="dashboard-main">

        <div class="resources-container">


            <!-- =====================================
                 INTRO
            ===================================== -->

            <section class="resources-intro">

                <span class="small-title">
                    LEARNING RESOURCES
                </span>

                <h2>
                    Learn. Practice. Build. 🚀
                </h2>

                <p>
                    Explore documentation, tutorials and tools
                    to improve your technical skills and build
                    real-world projects.
                </p>

            </section>


            <!-- =====================================
                 SEARCH
            ===================================== -->

            <div class="resource-tools">

                <div class="resource-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        id="resourceSearch"
                        placeholder="Search resources...">

                </div>

            </div>


            <!-- =====================================
                 FILTERS
            ===================================== -->

            <div class="resource-filters">

                <button
                    class="filter-btn active"
                    data-filter="all">

                    All

                </button>


                <button
                    class="filter-btn"
                    data-filter="web">

                    Web Development

                </button>


                <button
                    class="filter-btn"
                    data-filter="programming">

                    Programming

                </button>


                <button
                    class="filter-btn"
                    data-filter="ai">

                    AI / ML

                </button>


                <button
                    class="filter-btn"
                    data-filter="database">

                    Database

                </button>


                <button
                    class="filter-btn"
                    data-filter="security">

                    Cyber Security

                </button>


                <button
                    class="filter-btn"
                    data-filter="tools">

                    Tools

                </button>

            </div>


            <!-- =====================================
                 RESOURCE GRID
            ===================================== -->

            <div class="resource-grid"
                 id="resourceGrid">


                <!-- HTML & CSS -->

                <article
                    class="resource-card"
                    data-category="web"
                    data-search="html css web development responsive design">

                    <div class="resource-icon">

                        <i class="fa-brands fa-html5"></i>

                    </div>

                    <h3>HTML & CSS</h3>

                    <p>
                        Learn website structure, styling,
                        layouts and responsive design.
                    </p>

                    <span class="resource-category">
                        Web Development
                    </span>

                    <a
                        href="https://developer.mozilla.org/en-US/docs/Web/HTML"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- JAVASCRIPT -->

                <article
                    class="resource-card"
                    data-category="web"
                    data-search="javascript js dom programming web">

                    <div class="resource-icon">

                        <i class="fa-brands fa-js"></i>

                    </div>

                    <h3>JavaScript</h3>

                    <p>
                        Learn JavaScript fundamentals, DOM,
                        functions and modern JS.
                    </p>

                    <span class="resource-category">
                        Web Development
                    </span>

                    <a
                        href="https://developer.mozilla.org/en-US/docs/Web/JavaScript"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- REACT -->

                <article
                    class="resource-card"
                    data-category="web"
                    data-search="react reactjs frontend components javascript">

                    <div class="resource-icon">

                        <i class="fa-brands fa-react"></i>

                    </div>

                    <h3>React.js</h3>

                    <p>
                        Learn components, hooks, state,
                        props and modern React development.
                    </p>

                    <span class="resource-category">
                        Web Development
                    </span>

                    <a
                        href="https://react.dev/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- NODE -->

                <article
                    class="resource-card"
                    data-category="web"
                    data-search="node nodejs javascript backend server">

                    <div class="resource-icon">

                        <i class="fa-brands fa-node-js"></i>

                    </div>

                    <h3>Node.js</h3>

                    <p>
                        Learn server-side JavaScript,
                        APIs, modules and backend development.
                    </p>

                    <span class="resource-category">
                        Web Development
                    </span>

                    <a
                        href="https://nodejs.org/docs/latest/api/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- EXPRESS -->

                <article
                    class="resource-card"
                    data-category="web"
                    data-search="express expressjs node backend api">

                    <div class="resource-icon">

                        <i class="fa-solid fa-server"></i>

                    </div>

                    <h3>Express.js</h3>

                    <p>
                        Build fast web servers and REST APIs
                        with Node.js and Express.
                    </p>

                    <span class="resource-category">
                        Web Development
                    </span>

                    <a
                        href="https://expressjs.com/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- PYTHON -->

                <article
                    class="resource-card"
                    data-category="programming"
                    data-search="python programming coding">

                    <div class="resource-icon">

                        <i class="fa-brands fa-python"></i>

                    </div>

                    <h3>Python</h3>

                    <p>
                        Learn Python from programming basics
                        to advanced concepts.
                    </p>

                    <span class="resource-category">
                        Programming
                    </span>

                    <a
                        href="https://docs.python.org/3/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- JAVA -->

                <article
                    class="resource-card"
                    data-category="programming"
                    data-search="java programming oop">

                    <div class="resource-icon">

                        <i class="fa-brands fa-java"></i>

                    </div>

                    <h3>Java</h3>

                    <p>
                        Explore Java programming, OOP and
                        application development.
                    </p>

                    <span class="resource-category">
                        Programming
                    </span>

                    <a
                        href="https://dev.java/learn/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- C++ -->

                <article
                    class="resource-card"
                    data-category="programming"
                    data-search="c++ cpp programming">

                    <div class="resource-icon">

                        <i class="fa-solid fa-code"></i>

                    </div>

                    <h3>C++</h3>

                    <p>
                        Learn C++ programming, OOP,
                        STL and problem solving.
                    </p>

                    <span class="resource-category">
                        Programming
                    </span>

                    <a
                        href="https://cplusplus.com/doc/tutorial/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- AI -->

                <article
                    class="resource-card"
                    data-category="ai"
                    data-search="artificial intelligence ai machine learning">

                    <div class="resource-icon">

                        <i class="fa-solid fa-brain"></i>

                    </div>

                    <h3>Artificial Intelligence</h3>

                    <p>
                        Explore AI concepts, machine learning
                        and intelligent systems.
                    </p>

                    <span class="resource-category">
                        AI / ML
                    </span>

                    <a
                        href="https://developers.google.com/machine-learning"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- MACHINE LEARNING -->

                <article
                    class="resource-card"
                    data-category="ai"
                    data-search="machine learning ml ai models">

                    <div class="resource-icon">

                        <i class="fa-solid fa-robot"></i>

                    </div>

                    <h3>Machine Learning</h3>

                    <p>
                        Learn supervised learning,
                        unsupervised learning and ML models.
                    </p>

                    <span class="resource-category">
                        AI / ML
                    </span>

                    <a
                        href="https://scikit-learn.org/stable/user_guide.html"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- SQL -->

                <article
                    class="resource-card"
                    data-category="database"
                    data-search="sql database queries mysql">

                    <div class="resource-icon">

                        <i class="fa-solid fa-database"></i>

                    </div>

                    <h3>SQL</h3>

                    <p>
                        Learn database queries, tables,
                        joins and database concepts.
                    </p>

                    <span class="resource-category">
                        Database
                    </span>

                    <a
                        href="https://www.w3schools.com/sql/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- MYSQL -->

                <article
                    class="resource-card"
                    data-category="database"
                    data-search="mysql database sql">

                    <div class="resource-icon">

                        <i class="fa-solid fa-database"></i>

                    </div>

                    <h3>MySQL</h3>

                    <p>
                        Learn MySQL databases, queries,
                        relationships and administration.
                    </p>

                    <span class="resource-category">
                        Database
                    </span>

                    <a
                        href="https://dev.mysql.com/doc/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- MONGODB -->

                <article
                    class="resource-card"
                    data-category="database"
                    data-search="mongodb nosql database">

                    <div class="resource-icon">

                        <i class="fa-solid fa-leaf"></i>

                    </div>

                    <h3>MongoDB</h3>

                    <p>
                        Learn NoSQL databases, documents,
                        collections and MongoDB development.
                    </p>

                    <span class="resource-category">
                        Database
                    </span>

                    <a
                        href="https://www.mongodb.com/docs/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- CYBER SECURITY -->

                <article
                    class="resource-card"
                    data-category="security"
                    data-search="cyber security ethical hacking networking">

                    <div class="resource-icon">

                        <i class="fa-solid fa-shield-halved"></i>

                    </div>

                    <h3>Cyber Security</h3>

                    <p>
                        Learn security fundamentals,
                        networking and ethical security practices.
                    </p>

                    <span class="resource-category">
                        Cyber Security
                    </span>

                    <a
                        href="https://owasp.org/www-project-top-ten/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- LINUX -->

                <article
                    class="resource-card"
                    data-category="security"
                    data-search="linux operating system command line security">

                    <div class="resource-icon">

                        <i class="fa-brands fa-linux"></i>

                    </div>

                    <h3>Linux</h3>

                    <p>
                        Learn Linux commands, file systems,
                        permissions and administration.
                    </p>

                    <span class="resource-category">
                        Cyber Security
                    </span>

                    <a
                        href="https://www.linux.org/pages/download/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- GIT -->

                <article
                    class="resource-card"
                    data-category="tools"
                    data-search="git version control">

                    <div class="resource-icon">

                        <i class="fa-brands fa-git-alt"></i>

                    </div>

                    <h3>Git</h3>

                    <p>
                        Learn version control, branches,
                        commits and collaboration.
                    </p>

                    <span class="resource-category">
                        Tools
                    </span>

                    <a
                        href="https://git-scm.com/doc"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- GITHUB -->

                <article
                    class="resource-card"
                    data-category="tools"
                    data-search="github git repository portfolio">

                    <div class="resource-icon">

                        <i class="fa-brands fa-github"></i>

                    </div>

                    <h3>GitHub</h3>

                    <p>
                        Store projects, collaborate with others
                        and build your developer portfolio.
                    </p>

                    <span class="resource-category">
                        Tools
                    </span>

                    <a
                        href="https://github.com/"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


                <!-- VS CODE -->

                <article
                    class="resource-card"
                    data-category="tools"
                    data-search="visual studio code vscode editor coding">

                    <div class="resource-icon">

                        <i class="fa-solid fa-code"></i>

                    </div>

                    <h3>VS Code</h3>

                    <p>
                        Learn about extensions, debugging,
                        editing and developer workflows.
                    </p>

                    <span class="resource-category">
                        Tools
                    </span>

                    <a
                        href="https://code.visualstudio.com/docs"
                        target="_blank"
                        class="resource-open">

                        Open Resource
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>

                    </a>

                </article>


            </div>


            <!-- =====================================
                 NO RESULTS
            ===================================== -->

            <div
                class="no-results"
                id="noResults">

                <i class="fa-solid fa-magnifying-glass"></i>

                <h3>
                    No resources found
                </h3>

                <p>
                    Try searching for another skill or technology.
                </p>

            </div>


            <!-- =====================================
                 HELP / CONTACT
            ===================================== -->

            <section class="help-section">

                <div class="help-header">

                    <h2>
                        Need Help? 🤝
                    </h2>

                    <p>
                        Have a question, found an issue or want
                        to suggest a new learning resource?
                    </p>

                </div>


                <div class="help-grid">


                    <div class="help-card">

                        <div class="help-icon">

                            <i class="fa-solid fa-envelope"></i>

                        </div>

                        <div>

                            <h4>
                                Contact Admin
                            </h4>

                            <p>
                                For support and project-related
                                queries, contact the administrator.
                            </p>

                            <p style="margin-top:7px;">

                                <a href="contact.php">
                                    Contact Support →
                                </a>

                            </p>

                        </div>

                    </div>


                    <div class="help-card">

                        <div class="help-icon">

                            <i class="fa-solid fa-lightbulb"></i>

                        </div>

                        <div>

                            <h4>
                                Suggest a Resource
                            </h4>

                            <p>
                                Know a useful tutorial or learning
                                website? Suggest it to AI Learn.
                            </p>

                            <p style="margin-top:7px;">

                                <a href="contact.php">
                                    Suggest Resource →
                                </a>

                            </p>

                        </div>

                    </div>


                    <div class="help-card">

                        <div class="help-icon">

                            <i class="fa-solid fa-circle-question"></i>

                        </div>

                        <div>

                            <h4>
                                Help & Support
                            </h4>

                            <p>
                                Need assistance using AI Learn?
                                Our support section can help.
                            </p>

                            <p style="margin-top:7px;">

                                <a href="contact.php">
                                    Get Help →
                                </a>

                            </p>

                        </div>

                    </div>


                </div>

            </section>


            <!-- =====================================
                 FOOTER
            ===================================== -->

            <div class="resource-footer">

                Made with ❤️ for learners.
                Keep learning, keep building! 🚀

            </div>


        </div>

    </main>

</div>


<!-- =========================================
     JAVASCRIPT
========================================= -->

<script>

const searchInput =
    document.getElementById("resourceSearch");

const resourceCards =
    document.querySelectorAll(".resource-card");

const filterButtons =
    document.querySelectorAll(".filter-btn");

const noResults =
    document.getElementById("noResults");

let currentFilter = "all";


function filterResources() {

    const searchText =
        searchInput.value
        .toLowerCase()
        .trim();

    let visibleCount = 0;


    resourceCards.forEach(function(card) {

        const category =
            card.dataset.category;

        const searchData =
            card.dataset.search
            .toLowerCase();

        const title =
            card.querySelector("h3")
            .innerText
            .toLowerCase();


        const categoryMatch =
            currentFilter === "all" ||
            category === currentFilter;


        const searchMatch =
            searchText === "" ||
            searchData.includes(searchText) ||
            title.includes(searchText);


        if (categoryMatch && searchMatch) {

            card.style.display = "flex";

            visibleCount++;

        } else {

            card.style.display = "none";

        }

    });


    if (visibleCount === 0) {

        noResults.style.display = "block";

    } else {

        noResults.style.display = "none";

    }

}


searchInput.addEventListener(
    "input",
    filterResources
);


filterButtons.forEach(function(button) {

    button.addEventListener(
        "click",
        function() {

            filterButtons.forEach(function(btn) {

                btn.classList.remove("active");

            });


            button.classList.add("active");


            currentFilter =
                button.dataset.filter;


            filterResources();

        }
    );

});

</script>


<script
    src="/AI-Learning-Path-Generator/assets/js/dashboard.js?v=5">
</script>


</body>

</html>