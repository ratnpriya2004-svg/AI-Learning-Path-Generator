<?php

$envFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';

if (!file_exists($envFile)) {
    die("ERROR: .env file not found at: " . $envFile);
}

$envLines = file(
    $envFile,
    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
);

$geminiApiKey = '';

foreach ($envLines as $line) {

    $line = trim($line);

    if ($line === '' || str_starts_with($line, '#')) {
        continue;
    }

    $parts = explode('=', $line, 2);

    if (count($parts) !== 2) {
        continue;
    }

    $key = trim($parts[0]);
    $value = trim($parts[1]);

    if ($key === 'GEMINI_API_KEY') {
        $geminiApiKey = $value;
        break;
    }
}

if ($geminiApiKey === '') {
    die("ERROR: GEMINI_API_KEY not found in .env");
}

$geminiModel = "gemini-3.6-flash";

$geminiEndpoint =
    "https://generativelanguage.googleapis.com/v1beta/models/"
    . $geminiModel
    . ":generateContent";

?>