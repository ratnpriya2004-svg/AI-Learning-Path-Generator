<?php

session_start();

include("../config/database.php");
include("../config/gemini.php");


// =========================================
// CHECK LOGIN
// =========================================

if (!isset($_SESSION['user'])) {

    header("Location: ../login.html");
    exit();

}

$user = $_SESSION['user'];


// =========================================
// CHECK REQUEST
// =========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../generator/generator.php");
    exit();

}


// =========================================
// GET FORM DATA
// =========================================

$goal = trim($_POST['goal'] ?? '');
$skill = trim($_POST['skill'] ?? '');
$study = trim($_POST['study'] ?? '');
$duration = trim($_POST['duration'] ?? '');
$experience = trim($_POST['experience'] ?? '');
$interest = trim($_POST['interest'] ?? '');


// =========================================
// VALIDATION
// =========================================

if (
    $goal === '' ||
    $skill === '' ||
    $study === '' ||
    $duration === ''
) {

    die("Please fill all required fields.");

}


// =========================================
// BUILD GEMINI PROMPT
// =========================================

$prompt = <<<PROMPT
You are an expert learning-path designer.

Create a personalized learning roadmap using the learner information below.

LEARNER INFORMATION
-------------------
Goal: {$goal}
Skill Level: {$skill}
Daily Study Time: {$study}
Learning Duration: {$duration}
Current Experience: {$experience}
What They Want To Build: {$interest}

IMPORTANT RULES
---------------
1. Create a realistic roadmap for this learner.
2. Match the roadmap to their skill level.
3. Respect their available daily study time.
4. Respect the selected learning duration.
5. Include practical learning and projects.
6. Do not include unnecessary topics.
7. Keep descriptions clear and practical.
8. Return ONLY valid JSON.
9. Do NOT use markdown.
10. Do NOT use code fences.
11. Do NOT add any explanation outside the JSON.

Return exactly this structure:

[
    {
        "title": "Step title",
        "description": "Short practical description",
        "duration": "Estimated duration"
    }
]

Create between 5 and 10 roadmap steps.
PROMPT;


// =========================================
// GEMINI REQUEST
// =========================================

$requestData = [

    "contents" => [

        [
            "parts" => [

                [
                    "text" => $prompt
                ]

            ]
        ]

    ],

    "generationConfig" => [

        "responseMimeType" => "application/json",

        "temperature" => 0.4

    ]

];


$jsonData = json_encode(
    $requestData,
    JSON_UNESCAPED_UNICODE
);


// =========================================
// CALL GEMINI WITH RETRIES
// =========================================

$maxAttempts = 3;

$response = false;
$httpCode = 0;
$curlError = '';


for (
    $attempt = 1;
    $attempt <= $maxAttempts;
    $attempt++
) {

    $ch = curl_init($geminiEndpoint);


    curl_setopt_array($ch, [

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_POST => true,

        CURLOPT_HTTPHEADER => [

            "Content-Type: application/json",

            "x-goog-api-key: " . $geminiApiKey

        ],

        CURLOPT_POSTFIELDS => $jsonData,

        CURLOPT_TIMEOUT => 60

    ]);


    $response = curl_exec($ch);

    $httpCode = curl_getinfo(
        $ch,
        CURLINFO_HTTP_CODE
    );

    $curlError = curl_error($ch);


    curl_close($ch);


    if (
        $response !== false &&
        $httpCode === 200
    ) {

        break;

    }


    // Retry temporary errors

    if (
        $httpCode === 429 ||
        $httpCode === 500 ||
        $httpCode === 502 ||
        $httpCode === 503 ||
        $httpCode === 504
    ) {

        if ($attempt < $maxAttempts) {

            sleep($attempt * 2);

            continue;

        }

    }


    break;

}


// =========================================
// CURL ERROR
// =========================================

if ($response === false) {

    die(
        "Gemini request failed: " .
        htmlspecialchars($curlError)
    );

}


// =========================================
// API ERROR
// =========================================

if ($httpCode !== 200) {

    $errorData = json_decode(
        $response,
        true
    );

    $errorMessage =
        $errorData['error']['message']
        ?? 'Gemini API request failed.';

    die(
        "Gemini API Error: " .
        htmlspecialchars($errorMessage)
    );

}


// =========================================
// DECODE GEMINI RESPONSE
// =========================================

$geminiResponse = json_decode(
    $response,
    true
);


$roadmapText =
    $geminiResponse['candidates'][0]['content']['parts'][0]['text']
    ?? '';


if ($roadmapText === '') {

    die("Gemini returned an empty roadmap.");

}


// =========================================
// DECODE ROADMAP JSON
// =========================================

$roadmap = json_decode(
    $roadmapText,
    true
);


if (
    !is_array($roadmap) ||
    empty($roadmap)
) {

    die("Gemini returned invalid roadmap JSON.");

}


// =========================================
// VALIDATE ROADMAP
// =========================================

$cleanRoadmap = [];


foreach ($roadmap as $step) {

    if (
        !isset($step['title']) ||
        !isset($step['description']) ||
        !isset($step['duration'])
    ) {

        continue;

    }


    $title = trim(
        (string)$step['title']
    );

    $description = trim(
        (string)$step['description']
    );

    $stepDuration = trim(
        (string)$step['duration']
    );


    if (
        $title === '' ||
        $description === '' ||
        $stepDuration === ''
    ) {

        continue;

    }


    $cleanRoadmap[] = [

        "title" => $title,

        "description" => $description,

        "duration" => $stepDuration

    ];

}


if (empty($cleanRoadmap)) {

    die("No valid roadmap steps were generated.");

}


// Use validated roadmap
$roadmap = $cleanRoadmap;


// =========================================
// SAVE ROADMAP
// =========================================

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


if (!$stmt) {

    die(
        "Roadmap database error: " .
        mysqli_error($conn)
    );

}


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


if (!mysqli_stmt_execute($stmt)) {

    $error = mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);

    die(
        "Roadmap could not be saved: " .
        htmlspecialchars($error)
    );

}


// Get roadmap ID BEFORE closing statement
$roadmapId = mysqli_insert_id($conn);

mysqli_stmt_close($stmt);


// =========================================
// SAVE ROADMAP PROGRESS STEPS
// =========================================

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


if (!$progressStmt) {

    die(
        "Progress database error: " .
        mysqli_error($conn)
    );

}


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


    if (!mysqli_stmt_execute($progressStmt)) {

        mysqli_stmt_close($progressStmt);

        die("Could not save roadmap progress.");

    }


    $stepNumber++;

}


mysqli_stmt_close($progressStmt);


// =========================================
// SAVE ACTIVITY
// =========================================

$activityType = "roadmap";

$activityTitle = "AI Roadmap Created";

$activityDescription =
    "Your AI-generated "
    . $goal
    . " learning roadmap has been created successfully.";


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


if ($activityStmt) {

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

}


// =========================================
// SHOW RESULT
// =========================================

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Your AI Learning Path | AI Learn</title>

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
            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

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

            box-shadow:
                0 10px 30px
                rgba(0,0,0,.06);
        }

        .roadmap-step {
            display: flex;

            gap: 20px;

            padding: 25px 0;

            border-bottom:
                1px solid #e5e7eb;
        }

        .roadmap-step:last-child {
            border-bottom: none;
        }

        .step-number {
            width: 45px;
            height: 45px;

            min-width: 45px;

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
            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;
        }

        .secondary-result-btn {
            background: #f1f5f9;

            color: #334155;
        }

        .ai-badge {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 7px 13px;

            border-radius: 20px;

            background:
                rgba(255,255,255,.16);

            color: white;

            font-size: 13px;

            font-weight: 700;
        }

        .step-action {
            margin-top: 18px;
        }

        .start-step-btn {
            padding: 10px 18px;

            border: none;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #4F46E5,
                    #06B6D4
                );

            color: white;

            font-weight: 600;

            cursor: pointer;

            transition: .2s;
        }

        .start-step-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 6px 15px
                rgba(79,70,229,.25);
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

    </style>

</head>


<body>

<div class="dashboard-container">


    <main class="dashboard-main">

        <div class="result-main">


            <!-- HEADER -->

            <section class="result-header">

                <span class="ai-badge">

                    <i class="fa-solid fa-wand-magic-sparkles"></i>

                    AI GENERATED ROADMAP

                </span>


                <h1>
                    Your Learning Path 🚀
                </h1>


                <p>

                    A personalized AI roadmap has been created
                    for your goal:

                    <strong>
                        <?php
                        echo htmlspecialchars($goal);
                        ?>
                    </strong>

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

                            <?php
                            echo $stepNumber;
                            ?>

                        </div>


                        <div class="step-content">

                            <h3>

                                <?php
                                echo htmlspecialchars(
                                    $step['title']
                                );
                                ?>

                            </h3>


                            <p>

                                <?php
                                echo htmlspecialchars(
                                    $step['description']
                                );
                                ?>

                            </p>


                            <span class="step-duration">

                                <i class="fa-solid fa-clock"></i>

                                <?php
                                echo htmlspecialchars(
                                    $step['duration']
                                );
                                ?>

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

</body>

</html>