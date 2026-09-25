<?php

include("../config/gemini.php");


// =====================================
// TEST INPUT
// =====================================

$goal = "Web Development";
$skill = "Beginner";
$studyTime = "2 Hours";
$duration = "1 Month";
$experience = "I know basic HTML and CSS.";
$interest = "I want to build responsive websites and projects.";


// =====================================
// PROMPT
// =====================================

$prompt = <<<PROMPT
Create a personalized learning roadmap.

Learning Goal: {$goal}
Current Skill Level: {$skill}
Daily Study Time: {$studyTime}
Learning Duration: {$duration}
Current Experience: {$experience}
What the learner wants to build: {$interest}

Return ONLY valid JSON.

Do not use markdown.
Do not use code fences.
Do not add explanations before or after the JSON.

Return exactly this structure:

[
  {
    "title": "Step title",
    "description": "Short practical description",
    "duration": "Estimated duration"
  }
]

Create 5 to 8 roadmap steps appropriate for the learner.
PROMPT;


// =====================================
// REQUEST DATA
// =====================================

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


// =====================================
// GEMINI REQUEST
// =====================================

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


// =====================================
// CURL ERROR
// =====================================

if ($response === false) {

    header(
        "Content-Type: text/plain; charset=UTF-8"
    );

    echo "cURL Error:\n\n";
    echo $curlError;

    exit();

}


// =====================================
// HTTP ERROR
// =====================================

if ($httpCode !== 200) {

    header(
        "Content-Type: application/json; charset=UTF-8"
    );

    echo $response;

    exit();

}


// =====================================
// DECODE GEMINI RESPONSE
// =====================================

$geminiResponse = json_decode(
    $response,
    true
);


if (!isset(
    $geminiResponse['candidates'][0]['content']['parts'][0]['text']
)) {

    header(
        "Content-Type: text/plain; charset=UTF-8"
    );

    echo "Gemini response format was unexpected.";

    exit();

}


$roadmapText =
    $geminiResponse['candidates'][0]
    ['content']['parts'][0]['text'];


// =====================================
// DECODE GENERATED JSON
// =====================================

$roadmap = json_decode(
    $roadmapText,
    true
);


if (
    !is_array($roadmap) ||
    empty($roadmap)
) {

    header(
        "Content-Type: text/plain; charset=UTF-8"
    );

    echo "Gemini returned invalid roadmap JSON.";

    echo "\n\nRaw response:\n";
    echo $roadmapText;

    exit();

}


// =====================================
// VALIDATE ROADMAP STRUCTURE
// =====================================

$cleanRoadmap = [];


foreach ($roadmap as $step) {

    if (
        !isset($step['title']) ||
        !isset($step['description']) ||
        !isset($step['duration'])
    ) {

        continue;

    }


    $cleanRoadmap[] = [

        "title" =>
            trim((string)$step['title']),

        "description" =>
            trim((string)$step['description']),

        "duration" =>
            trim((string)$step['duration'])

    ];

}


if (empty($cleanRoadmap)) {

    header(
        "Content-Type: text/plain; charset=UTF-8"
    );

    echo "No valid roadmap steps were returned.";

    exit();

}


// =====================================
// SHOW CLEAN JSON
// =====================================

header(
    "Content-Type: application/json; charset=UTF-8"
);


echo json_encode(
    $cleanRoadmap,
    JSON_PRETTY_PRINT |
    JSON_UNESCAPED_UNICODE
);

?>