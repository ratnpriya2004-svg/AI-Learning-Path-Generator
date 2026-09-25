<?php

header("Content-Type: application/json; charset=UTF-8");

include("../config/gemini.php");


// =========================================
// ONLY POST REQUEST
// =========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);

    exit();
}


// =========================================
// GET DEMO INPUTS
// =========================================

$goal = trim($_POST['goal'] ?? '');
$skill = trim($_POST['skill'] ?? '');
$study = trim($_POST['study'] ?? '');
$duration = trim($_POST['duration'] ?? '');


// =========================================
// VALIDATION
// =========================================

if (
    $goal === '' ||
    $skill === '' ||
    $study === '' ||
    $duration === ''
) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Please fill all demo fields."
    ]);

    exit();
}


// Prevent unnecessarily large public requests
if (strlen($goal) > 120) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Learning goal is too long."
    ]);

    exit();
}


// =========================================
// GEMINI PROMPT
// =========================================

$prompt = <<<PROMPT
Create a concise personalized learning roadmap.

Learning Goal: {$goal}
Current Skill Level: {$skill}
Daily Study Time: {$study}
Learning Duration: {$duration}

Rules:
1. Match the roadmap to the learner's level.
2. Respect the available study time.
3. Keep it practical and beginner-friendly when appropriate.
4. Include projects or hands-on practice.
5. Create exactly 4 to 6 steps.
6. Return ONLY valid JSON.
7. Do not use markdown.
8. Do not use code fences.
9. Do not add explanation outside JSON.

Return exactly:

[
    {
        "title": "Step title",
        "description": "Short practical description",
        "duration": "Estimated duration"
    }
]
PROMPT;


// =========================================
// REQUEST
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
// GEMINI REQUEST + RETRY
// =========================================

$maxAttempts = 3;

$response = false;
$httpCode = 0;
$curlError = "";


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

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Unable to connect to AI service.",
        "error" => $curlError
    ]);

    exit();
}


// =========================================
// API ERROR
// =========================================

if ($httpCode !== 200) {

    $errorData = json_decode(
        $response,
        true
    );

    $message =
        $errorData['error']['message']
        ?? 'AI service is temporarily unavailable.';

    http_response_code($httpCode);

    echo json_encode([
        "success" => false,
        "message" => $message
    ]);

    exit();
}


// =========================================
// READ GEMINI RESPONSE
// =========================================

$geminiResponse = json_decode(
    $response,
    true
);


$roadmapText =
    $geminiResponse['candidates'][0]['content']['parts'][0]['text']
    ?? '';


if ($roadmapText === '') {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "AI returned an empty response."
    ]);

    exit();
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

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "AI returned an invalid roadmap."
    ]);

    exit();
}


// =========================================
// CLEAN ROADMAP
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

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "No valid roadmap steps were generated."
    ]);

    exit();
}


// =========================================
// RETURN DEMO RESULT
// =========================================

echo json_encode([

    "success" => true,

    "roadmap" => $cleanRoadmap

], JSON_UNESCAPED_UNICODE);

?>