<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$message = $data['message'] ?? '';

$apiKey = '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'; // Keep your actual key here (you already added it)

$apiUrl = 'https://api.openai.com/v1/chat/completions';

$postData = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
        ['role' => 'user', 'content' => $message]
    ],
    'temperature' => 0.7,
    'max_tokens' => 150
];

$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['response' => 'Curl error: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

$responseData = json_decode($response, true);
$answer = $responseData['choices'][0]['message']['content'] ?? "Sorry, I couldn't understand that.";

echo json_encode(['response' => trim($answer)]);
?>