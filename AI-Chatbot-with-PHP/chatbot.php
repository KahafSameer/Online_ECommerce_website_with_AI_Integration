<?php
// chatbot.php — Gemini AI API integration for MOMAL Chatbot

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Gemini API key (store in .env in production)
$api_key = "AIzaSyCZOrtazGRxU1nuSh6mqTxEgPTW6v0Y9NE";
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$api_key";

// Read user input
$input = json_decode(file_get_contents("php://input"), true);
if (!$input || !isset($input['message']) || trim($input['message']) === "") {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}
$user_message = trim($input['message']);

// DB connection for product lookup
require_once __DIR__ . '/../components/connect.php';

// --- PRODUCT DB LOOKUP LOGIC ---
$product_answer = null;
$product_name = null;
$words = preg_split('/\s+/', $user_message);
// 1. Try direct product name match for 1-4 word queries
if (count($words) >= 1 && count($words) <= 4) {
    $product_name = trim($user_message);
    if ($product_name && strlen($product_name) > 1) {
        $stmt = $conn->prepare("SELECT name, price, details FROM products WHERE name LIKE ? LIMIT 1");
        $stmt->execute(['%' . $product_name . '%']);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Prepare product info for user and AI
            $product_info = "<b>{$row['name']}</b>\nPrice: Rs. {$row['price']}\nDetails: {$row['details']}";
            // Ask Gemini for a short comment about this product
            $ai_comment = '';
            $ai_prompt = "Give a 1-line honest comment or review about this product for a customer, based on the following details (do not repeat the price):\nProduct: {$row['name']}\nDetails: {$row['details']}";
            $ai_data = [
                "contents" => [
                    ["parts" => [["text" => $ai_prompt]]]
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ai_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            $ai_response = curl_exec($ch);
            $ai_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($ai_http_code === 200) {
                $ai_response_data = json_decode($ai_response, true);
                $ai_comment = $ai_response_data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            }
            $product_answer = $product_info . ($ai_comment ? "\nAI Comment: $ai_comment" : "");
        }
    }
}
// 2. If not found, try keyword-based extraction (for longer queries)
if (!$product_answer && preg_match('/\b(product|price|detail|details|info|information|about|describe|features|feature|cost|rate|kitna|ka|ki|hai|kia|kya|bataye|batao|show|display)\b/i', $user_message)) {
    if (preg_match('/(?:of|about|for)\s+([\w\s\-]+)/i', $user_message, $m)) {
        $product_name = trim($m[1]);
    } else {
        if (count($words) >= 2) {
            $product_name = trim($words[count($words)-2] . ' ' . $words[count($words)-1]);
        } else {
            $product_name = end($words);
        }
    }
    if ($product_name && strlen($product_name) > 1) {
        $stmt = $conn->prepare("SELECT name, price, details FROM products WHERE name LIKE ? LIMIT 1");
        $stmt->execute(['%' . $product_name . '%']);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product_info = "<b>{$row['name']}</b>\nPrice: Rs. {$row['price']}\nDetails: {$row['details']}";
            $ai_comment = '';
            $ai_prompt = "Give a 1-line honest comment or review about this product for a customer, based on the following details (do not repeat the price):\nProduct: {$row['name']}\nDetails: {$row['details']}";
            $ai_data = [
                "contents" => [
                    ["parts" => [["text" => $ai_prompt]]]
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ai_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            $ai_response = curl_exec($ch);
            $ai_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($ai_http_code === 200) {
                $ai_response_data = json_decode($ai_response, true);
                $ai_comment = $ai_response_data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            }
            $product_answer = $product_info . ($ai_comment ? "\nAI Comment: $ai_comment" : "");
        }
    }
}
if ($product_answer) {
    // Convert markdown bold **text** to <b>text</b> for chat UI
    $product_answer = preg_replace('/\*\*(.*?)\*\*/s', '<b>$1</b>', $product_answer);
    echo json_encode(['response' => $product_answer]);
    exit;
}

// Check for eCommerce-related content (make less strict)
$ecommerce_keywords = ['product', 'store', 'vendor', 'sku', 'offer', 'review', 'customer', 'order', 'refund', 'checkout', 'cart', 'inventory', 'browsing'];
$is_ecommerce_question = false;

foreach ($ecommerce_keywords as $keyword) {
    if (stripos($user_message, $keyword) !== false) {
        $is_ecommerce_question = true;
        break;
    }
}

// Only block if message is extremely short and not eCommerce-related
if (!$is_ecommerce_question && strlen($user_message) < 3) {
    echo json_encode(['response' => "⚠️ Please ask a little more detail so I can help you! (e.g., 'order status', 'mobile price', 'return policy')"]);
    exit;
}

// Gemini prompt: force short reply (1–2 lines max)
$prompt = "You are a helpful eCommerce website assistant chatbot.\n" . $user_message;

// Prepare Gemini API payload
$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => $prompt]
            ]
        ]
    ]
];

// Call Gemini API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo json_encode(['error' => 'Server error: ' . $http_code]);
    exit;
}

$response_data = json_decode($response, true);
$ai_reply = $response_data['candidates'][0]['content']['parts'][0]['text'] ?? null;

if (!$ai_reply) {
    echo json_encode(['error' => 'Unexpected Server response format']);
    exit;
}

// Clean response: remove HTML tags, trim whitespace, allow markdown
$clean_reply = trim(strip_tags($ai_reply));
// Convert markdown bold **text** to <b>text</b> for chat UI
$clean_reply = preg_replace('/\*\*(.*?)\*\*/s', '<b>$1</b>', $clean_reply);
echo json_encode(['response' => $clean_reply]);
exit;
