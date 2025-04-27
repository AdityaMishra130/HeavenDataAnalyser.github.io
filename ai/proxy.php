<?php
// proxy.php for OpenRouter.ai
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$apiKey = "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"; // Replace this with your actual OpenRouter key

$input = json_decode(file_get_contents("php://input"), true);
$prompt = $input["prompt"] ?? "";

$ch = curl_init("https://openrouter.ai/api/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer $apiKey"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
  "model" => "mistralai/mistral-7b-instruct", // Free model
  "messages" => [
    ["role" => "system", "content" => "You are a helpful data analyst. Give clear insights from CSV-style tabular data."],
    ["role" => "user", "content" => $prompt]
  ]
]));

$response = curl_exec($ch);
curl_close($ch);
echo $response;
?>
