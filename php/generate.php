<?php

session_start();

include("../config/database.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.html");
    exit();
}

$user = $_SESSION['user'];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../generator/generator.php");
    exit();
}


/* =========================
   GET FORM DATA
========================= */

$goal = trim($_POST['goal'] ?? '');
$skill = trim($_POST['skill'] ?? '');
$study = trim($_POST['study'] ?? '');
$duration = trim($_POST['duration'] ?? '');
$experience = trim($_POST['experience'] ?? '');
$interest = trim($_POST['interest'] ?? '');


/* =========================
   VALIDATION
========================= */

if ($goal === '' || $skill === '' || $study === '' || $duration === '') {

    echo "<script>
        alert('Please fill all required fields.');
        window.history.back();
    </script>";

    exit();
}


/* =========================
   CREATE ROADMAP
========================= */

$roadmap = [];


/* WEB DEVELOPMENT */

/* WEB DEVELOPMENT */

if (
    stripos($goal, 'web') !== false ||
    stripos($goal, 'website') !== false ||
    stripos($goal, 'frontend') !== false
) {

    /* =========================
       BEGINNER
    ========================= */

    if (
        stripos($skill, 'beginner') !== false ||
        stripos($skill, 'basic') !== false
    ) {

        $roadmap = [

            [
                "title" => "HTML Fundamentals",
                "description" => "Learn HTML structure, semantic elements, headings, links, images, forms and basic page structure.",
                "duration" => "1-2 Weeks"
            ],

            [
                "title" => "CSS Fundamentals",
                "description" => "Learn selectors, colors, typography, box model, Flexbox, Grid and responsive layouts.",
                "duration" => "1-2 Weeks"
            ],

            [
                "title" => "JavaScript Basics",
                "description" => "Learn variables, data types, conditions, loops, functions, arrays and objects.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "DOM & Interactive Websites",
                "description" => "Learn DOM manipulation, events, forms and how to create interactive web pages.",
                "duration" => "2 Weeks"
            ],

            [
                "title" => "Beginner Web Projects",
                "description" => "Build practical projects such as a portfolio, landing page, calculator and to-do application.",
                "duration" => "2-3 Weeks"
            ]

        ];

    }


    /* =========================
       INTERMEDIATE
    ========================= */

    elseif (
        stripos($skill, 'intermediate') !== false ||
        stripos($skill, 'medium') !== false
    ) {

        $roadmap = [

            [
                "title" => "Advanced JavaScript",
                "description" => "Strengthen JavaScript skills with ES6+, destructuring, modules, classes and advanced functions.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "APIs & Asynchronous JavaScript",
                "description" => "Learn REST APIs, fetch, promises, async/await and working with external data.",
                "duration" => "2 Weeks"
            ],

            [
                "title" => "React.js Fundamentals",
                "description" => "Learn components, JSX, props, state, events and the React component architecture.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "React Advanced Concepts",
                "description" => "Learn hooks, routing, API integration, state management and reusable components.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Full-Stack Web Project",
                "description" => "Build a complete practical web application and improve your portfolio with a real-world project.",
                "duration" => "3-4 Weeks"
            ]

        ];

    }


    /* =========================
       ADVANCED
    ========================= */

    else {

        $roadmap = [

            [
                "title" => "Advanced Frontend Architecture",
                "description" => "Learn scalable frontend architecture, reusable components and maintainable application structure.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Advanced React Development",
                "description" => "Work with advanced hooks, performance optimization, state management and complex React applications.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Backend & API Integration",
                "description" => "Learn backend communication, authentication, REST APIs and database integration.",
                "duration" => "3 Weeks"
            ],

            [
                "title" => "Performance & Production",
                "description" => "Learn performance optimization, security basics, deployment and production-ready development practices.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Advanced Full-Stack Project",
                "description" => "Build and deploy a complete production-style application to demonstrate your advanced development skills.",
                "duration" => "3-4 Weeks"
            ]

        ];

    }

}


/* AI / MACHINE LEARNING */

/* AI / MACHINE LEARNING */

elseif (
    stripos($goal, 'ai') !== false ||
    stripos($goal, 'artificial intelligence') !== false ||
    stripos($goal, 'machine learning') !== false
) {

    /* =========================
       BEGINNER
    ========================= */

    if (
        stripos($skill, 'beginner') !== false ||
        stripos($skill, 'basic') !== false
    ) {

        $roadmap = [

            [
                "title" => "Python Fundamentals",
                "description" => "Learn Python syntax, variables, data types, conditions, loops, functions, lists and dictionaries.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Mathematics for AI",
                "description" => "Learn basic statistics, probability and mathematical concepts commonly used in AI.",
                "duration" => "1-2 Weeks"
            ],

            [
                "title" => "Machine Learning Basics",
                "description" => "Understand supervised and unsupervised learning, datasets, features and basic ML algorithms.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Practical AI with Python",
                "description" => "Use Python libraries and datasets to build simple machine learning models and experiments.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Beginner AI Project",
                "description" => "Build a practical AI project and document your work for your portfolio.",
                "duration" => "2-3 Weeks"
            ]

        ];

    }


    /* =========================
       INTERMEDIATE
    ========================= */

    elseif (
        stripos($skill, 'intermediate') !== false ||
        stripos($skill, 'medium') !== false
    ) {

        $roadmap = [

            [
                "title" => "Advanced Python for AI",
                "description" => "Improve Python skills with object-oriented programming, modules, data processing and useful AI libraries.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Machine Learning Algorithms",
                "description" => "Work with regression, classification, clustering, decision trees and model evaluation techniques.",
                "duration" => "3 Weeks"
            ],

            [
                "title" => "Data Processing & Feature Engineering",
                "description" => "Learn data cleaning, preprocessing, feature selection and preparing datasets for machine learning.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Deep Learning Fundamentals",
                "description" => "Understand neural networks, training, loss functions and the fundamentals of deep learning.",
                "duration" => "3-4 Weeks"
            ],

            [
                "title" => "Intermediate AI Project",
                "description" => "Build an end-to-end machine learning or AI application and showcase it in your portfolio.",
                "duration" => "3-4 Weeks"
            ]

        ];

    }


    /* =========================
       ADVANCED
    ========================= */

    else {

        $roadmap = [

            [
                "title" => "Advanced Machine Learning",
                "description" => "Explore advanced algorithms, model optimization, ensemble methods and advanced evaluation techniques.",
                "duration" => "3 Weeks"
            ],

            [
                "title" => "Deep Learning & Neural Networks",
                "description" => "Work with advanced neural networks, training strategies and modern deep learning architectures.",
                "duration" => "3-4 Weeks"
            ],

            [
                "title" => "Natural Language Processing",
                "description" => "Learn text processing, embeddings, language models and practical NLP techniques.",
                "duration" => "3 Weeks"
            ],

            [
                "title" => "Computer Vision & AI Applications",
                "description" => "Explore image processing, computer vision concepts and practical AI application development.",
                "duration" => "3-4 Weeks"
            ],

            [
                "title" => "Advanced AI Project",
                "description" => "Design, build and deploy an advanced AI project that demonstrates real-world problem-solving skills.",
                "duration" => "4 Weeks"
            ]

        ];

    }

}

/* CYBER SECURITY */

/* CYBER SECURITY */

elseif (
    stripos($goal, 'cyber') !== false ||
    stripos($goal, 'security') !== false
) {

    /* =========================
       BEGINNER
    ========================= */

    if (
        stripos($skill, 'beginner') !== false ||
        stripos($skill, 'basic') !== false
    ) {

        $roadmap = [

            [
                "title" => "Networking Fundamentals",
                "description" => "Learn IP addresses, TCP/IP, DNS, HTTP, ports and basic networking concepts.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Linux Fundamentals",
                "description" => "Learn Linux commands, file permissions, processes and basic system administration.",
                "duration" => "2 Weeks"
            ],

            [
                "title" => "Cyber Security Fundamentals",
                "description" => "Understand common threats, vulnerabilities, authentication and basic security principles.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Security Tools & Safe Labs",
                "description" => "Learn the basics of security tools and practice only in authorized labs and learning environments.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Beginner Security Project",
                "description" => "Build a safe cybersecurity project such as a security checklist, log analyzer or network monitoring exercise.",
                "duration" => "2-3 Weeks"
            ]

        ];

    }


    /* =========================
       INTERMEDIATE
    ========================= */

    elseif (
        stripos($skill, 'intermediate') !== false ||
        stripos($skill, 'medium') !== false
    ) {

        $roadmap = [

            [
                "title" => "Advanced Networking",
                "description" => "Strengthen networking knowledge including routing, protocols, network services and traffic analysis.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Linux & System Security",
                "description" => "Learn Linux administration, permissions, processes, logs and basic system-hardening techniques.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Web Application Security",
                "description" => "Learn common web security risks, secure authentication and defensive security practices using authorized labs.",
                "duration" => "3 Weeks"
            ],

            [
                "title" => "Vulnerability Assessment",
                "description" => "Learn how vulnerabilities are identified, documented and prioritized in authorized environments.",
                "duration" => "2-3 Weeks"
            ],

            [
                "title" => "Intermediate Security Project",
                "description" => "Build a defensive security project and document your findings, methodology and security improvements.",
                "duration" => "3 Weeks"
            ]

        ];

    }


    /* =========================
       ADVANCED
    ========================= */

    else {

        $roadmap = [

            [
                "title" => "Advanced Network Security",
                "description" => "Explore advanced network security concepts, monitoring, segmentation and defensive architecture.",
                "duration" => "3 Weeks"
            ],

            [
                "title" => "Application Security",
                "description" => "Study secure application architecture, authentication, authorization and advanced defensive practices.",
                "duration" => "3 Weeks"
            ],

            [
                "title" => "Security Monitoring & Incident Response",
                "description" => "Learn security monitoring, log analysis, incident handling and defensive response techniques.",
                "duration" => "3-4 Weeks"
            ],

            [
                "title" => "Security Assessment & Ethical Hacking",
                "description" => "Practice authorized security assessment methodologies in controlled labs and approved environments.",
                "duration" => "3-4 Weeks"
            ],

            [
                "title" => "Advanced Cybersecurity Project",
                "description" => "Design a complete defensive security project and create a professional cybersecurity portfolio.",
                "duration" => "4 Weeks"
            ]

        ];

    }

}

/* GENERAL ROADMAP */

else {

    $roadmap = [

        [
            "title" => "Fundamentals",
            "description" => "Build a strong foundation in the concepts and tools related to your learning goal.",
            "duration" => "1-2 Weeks"
        ],

        [
            "title" => "Core Concepts",
            "description" => "Learn the most important concepts and practical techniques for your chosen field.",
            "duration" => "2-3 Weeks"
        ],

        [
            "title" => "Intermediate Skills",
            "description" => "Develop intermediate-level skills through guided practice and exercises.",
            "duration" => "2-3 Weeks"
        ],

        [
            "title" => "Advanced Topics",
            "description" => "Explore advanced concepts and modern tools related to your learning goal.",
            "duration" => "2-4 Weeks"
        ],

        [
            "title" => "Practical Projects",
            "description" => "Build real-world projects and create a portfolio demonstrating your skills.",
            "duration" => "2-3 Weeks"
        ]

    ];

}

/* =========================================
   PERSONALIZE ROADMAP BY STUDY TIME
========================================= */

$studyLower = strtolower($study);

$studyMinutes = 60;


/* 30 MINUTES */

if (
    stripos($studyLower, '30') !== false ||
    stripos($studyLower, 'half') !== false
) {

    $studyMinutes = 30;

}


/* 2 HOURS OR MORE */

elseif (
    stripos($studyLower, '2') !== false ||
    stripos($studyLower, 'more') !== false
) {

    $studyMinutes = 120;

}


/* 1 HOUR */

elseif (
    stripos($studyLower, '1') !== false
) {

    $studyMinutes = 60;

}


/* =========================================
   UPDATE LEARNING PACE
========================================= */

foreach ($roadmap as &$step) {

    if ($studyMinutes <= 30) {

        $step['duration'] =
            "Extended pace • " . $step['duration'];

    }

    elseif ($studyMinutes >= 120) {

        $step['duration'] =
            "Fast pace • " . $step['duration'];

    }

    else {

        $step['duration'] =
            "Recommended pace • " . $step['duration'];

    }

}

unset($step);
/* =========================================
   PERSONALIZE BY EXPERIENCE
========================================= */

$experienceLower = strtolower($experience);


/* BEGINNER / NO EXPERIENCE */

if (
    stripos($experienceLower, 'no experience') !== false ||
    stripos($experienceLower, 'beginner') !== false ||
    stripos($experienceLower, 'none') !== false
) {

    array_unshift(
        $roadmap,
        [
            "title" => "Getting Started",
            "description" => "Understand the basic tools, terminology and concepts you need before starting the main learning path.",
            "duration" => "1 Week"
        ]
    );

}


/* SOME EXPERIENCE */

elseif (
    stripos($experienceLower, 'some') !== false ||
    stripos($experienceLower, 'little') !== false
) {

    array_unshift(
        $roadmap,
        [
            "title" => "Skill Refresh & Assessment",
            "description" => "Review your existing knowledge and identify the key skills you need to strengthen before moving to advanced topics.",
            "duration" => "1 Week"
        ]
    );

}


/* EXPERIENCED */

elseif (
    stripos($experienceLower, 'experienced') !== false ||
    stripos($experienceLower, 'advanced') !== false
) {

    array_unshift(
        $roadmap,
        [
            "title" => "Advanced Skill Assessment",
            "description" => "Review your current skills and identify advanced areas where you can improve through practical challenges.",
            "duration" => "1 Week"
        ]
    );

}

/* =========================================
   PERSONALIZE BY INTEREST
========================================= */

$interestLower = strtolower($interest);


/* FRONTEND */

if (
    stripos($interestLower, 'frontend') !== false ||
    stripos($interestLower, 'front end') !== false ||
    stripos($interestLower, 'ui') !== false
) {

    $roadmap[] = [
        "title" => "Frontend Specialization",
        "description" => "Focus on modern user interfaces, responsive design, accessibility and interactive frontend experiences.",
        "duration" => "2-3 Weeks"
    ];

}


/* BACKEND */

elseif (
    stripos($interestLower, 'backend') !== false ||
    stripos($interestLower, 'back end') !== false ||
    stripos($interestLower, 'server') !== false
) {

    $roadmap[] = [
        "title" => "Backend Specialization",
        "description" => "Learn server-side development, APIs, authentication and database integration.",
        "duration" => "2-3 Weeks"
    ];

}


/* AI */

elseif (
    stripos($interestLower, 'ai') !== false ||
    stripos($interestLower, 'artificial intelligence') !== false ||
    stripos($interestLower, 'machine learning') !== false
) {

    $roadmap[] = [
        "title" => "AI Specialization",
        "description" => "Explore artificial intelligence, machine learning concepts and practical AI applications.",
        "duration" => "2-3 Weeks"
    ];

}


/* DATA */

elseif (
    stripos($interestLower, 'data') !== false ||
    stripos($interestLower, 'analytics') !== false
) {

    $roadmap[] = [
        "title" => "Data & Analytics Specialization",
        "description" => "Learn data analysis, visualization and practical techniques for extracting insights from datasets.",
        "duration" => "2-3 Weeks"
    ];

}


/* CYBER SECURITY */

elseif (
    stripos($interestLower, 'cyber') !== false ||
    stripos($interestLower, 'security') !== false
) {

    $roadmap[] = [
        "title" => "Cybersecurity Specialization",
        "description" => "Focus on defensive security, secure development and authorized security learning environments.",
        "duration" => "2-3 Weeks"
    ];

}
/* =========================================
   PERSONALIZE BY SELECTED DURATION
========================================= */

$durationLower = strtolower($duration);


/* =========================
   1 MONTH
========================= */

if (
    stripos($durationLower, '1 month') !== false ||
    stripos($durationLower, '1 month') !== false
) {

    foreach ($roadmap as &$step) {

        $step['duration'] = "3-5 Days";

    }

    unset($step);

}


/* =========================
   2 MONTHS
========================= */

elseif (
    stripos($durationLower, '2 month') !== false ||
    stripos($durationLower, '2 months') !== false
) {

    foreach ($roadmap as &$step) {

        $step['duration'] = "1-2 Weeks";

    }

    unset($step);

}


/* =========================
   3 MONTHS
========================= */

elseif (
    stripos($durationLower, '3 month') !== false ||
    stripos($durationLower, '3 months') !== false
) {

    foreach ($roadmap as &$step) {

        $step['duration'] = "2-3 Weeks";

    }

    unset($step);

}


/* =========================
   6 MONTHS
========================= */

elseif (
    stripos($durationLower, '6 month') !== false ||
    stripos($durationLower, '6 months') !== false
) {

    foreach ($roadmap as &$step) {

        $step['duration'] = "3-4 Weeks";

    }

    unset($step);

}
/* =========================
   SAVE ROADMAP TO DATABASE
========================= */

$roadmapData = json_encode(
    $roadmap,
    JSON_UNESCAPED_UNICODE
);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO learning_roadmaps
    (
        username,
        goal,
        skill_level,
        study_time,
        duration,
        experience,
        interest,
        roadmap_data,
        progress
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ssssssss",
    $user,
    $goal,
    $skill,
    $study,
    $duration,
    $experience,
    $interest,
    $roadmapData
);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

/* =========================================
   SAVE ROADMAP STEPS FOR PROGRESS TRACKING
========================================= */

$roadmapId = mysqli_insert_id($conn);

$progressStmt = mysqli_prepare(
    $conn,
    "INSERT INTO roadmap_progress
    (
        roadmap_id,
        username,
        step_number,
        step_title,
        status
    )
    VALUES (?, ?, ?, ?, 'Not Started')"
);

$stepNumber = 1;

foreach ($roadmap as $step) {

    $stepTitle = $step['title'];

    mysqli_stmt_bind_param(
        $progressStmt,
        "isis",
        $roadmapId,
        $user,
        $stepNumber,
        $stepTitle
    );

    mysqli_stmt_execute($progressStmt);

    $stepNumber++;
}

mysqli_stmt_close($progressStmt);


/* =========================================
   SAVE ROADMAP CREATED ACTIVITY
========================================= */

$activityType = "roadmap";

$activityTitle = "Roadmap Created";

$activityDescription =
    "Your personalized " . $goal . " learning roadmap has been created successfully.";

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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Your Learning Path | AI Learn</title>

    <link rel="stylesheet"
          href="/AI-Learning-Path-Generator/assets/css/dashboard.css?v=3">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>

        .result-main {
            max-width: 1000px;
            margin: 0 auto;
        }

        .result-header {
            background: linear-gradient(135deg,#4F46E5,#06B6D4);
            color: white;
            padding: 45px;
            border-radius: 24px;
            margin-bottom: 30px;
        }

        .result-header h1 {
            color: white;
            margin: 10px 0;
        }

        .result-header p {
            color: rgba(255,255,255,.88);
            line-height: 1.7;
        }

        .roadmap-result {
            background: white;
            padding: 35px;
            border-radius: 22px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 30px rgba(0,0,0,.06);
        }

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
            width: 45px;
            height: 45px;
            min-width: 45px;

            border-radius: 50%;

            background: linear-gradient(135deg,#4F46E5,#06B6D4);

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
        }

        .step-content {
            flex: 1;
        }

        .step-content h3 {
            margin: 0 0 8px;
            color: #111827;
        }

        .step-content p {
            margin: 0 0 10px;
            color: #64748b;
            line-height: 1.6;
        }

        .step-duration {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #eef2ff;
            color: #4F46E5;
            font-size: 13px;
            font-weight: 600;
        }

        .result-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .result-btn {
            padding: 13px 22px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .primary-result-btn {
            background: linear-gradient(135deg,#4F46E5,#06B6D4);
            color: white;
        }

        .secondary-result-btn {
            background: #f1f5f9;
            color: #334155;
        }

        @media(max-width:700px) {

            .result-header,
            .roadmap-result {
                padding: 25px;
            }

            .roadmap-step {
                gap: 14px;
            }

            .result-actions {
                flex-direction: column;
            }

        }
            .step-action {
    margin-top: 18px;
}

.start-step-btn {
    padding: 10px 18px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg,#4F46E5,#06B6D4);
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}

.start-step-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(79,70,229,.25);
}
    </style>

</head>


<body>

<div class="dashboard-container">

    <main class="dashboard-main">

        <div class="result-main">


            <!-- HEADER -->

            <section class="result-header">

                <span>
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    AI GENERATED ROADMAP
                </span>

                <h1>
                    Your Learning Path 🚀
                </h1>

                <p>
                    A personalized roadmap has been created
                    based on your goal:
                    <strong><?php echo htmlspecialchars($goal); ?></strong>
                </p>

            </section>


            <!-- ROADMAP -->

            <section class="roadmap-result">

                <?php

                $stepNumber = 1;

                foreach ($roadmap as $step):

                ?>

                    <div class="roadmap-step">

                        <div class="step-number">

                            <?php echo $stepNumber; ?>

                        </div>


                        <div class="step-content">

                        <h3>
                            <?php echo htmlspecialchars($step['title']); ?>
                        </h3>

                        <p>
                            <?php echo htmlspecialchars($step['description']); ?>
                        </p>

                        <span class="step-duration">

                            <i class="fa-solid fa-clock"></i>

                            <?php echo htmlspecialchars($step['duration']); ?>

                        </span>

                        <div class="step-action">

                            <button
                                type="button"
                                class="start-step-btn"
                                onclick="window.location.href='../learning/learn.php?step=<?php echo urlencode($step['title']); ?>'">

                                <i class="fa-solid fa-play"></i>

                                Start Learning

                            </button>
                        </div>

                    </div>
                </div>

                <?php

                    $stepNumber++;

                endforeach;

                ?>


                <div class="result-actions">

                    <a
                        href="../generator/generator.php"
                        class="result-btn secondary-result-btn">

                        <i class="fa-solid fa-arrow-left"></i>

                        Create Another Path

                    </a>


                    <a
                        href="../dashbord/roadmap.php"
                        class="result-btn primary-result-btn">

                        <i class="fa-solid fa-road"></i>

                        Go To My Roadmap

                    </a>

                </div>


            </section>

        </div>

    </main>

</div>
<script>

function startStep(stepTitle) {

    alert(
        "Starting: " + stepTitle +
        "\n\nLearning content will be added next."
    );

}

</script>
</body>

</html>