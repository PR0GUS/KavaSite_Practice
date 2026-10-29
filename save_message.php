<?php

header("Content-Type: application/json; charset=UTF-8");
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Дозволено тільки POST"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(["error" => "Неправильні дані"]);
    exit;
}

$name = trim($data["name"] ?? "");
$email = trim($data["email"] ?? "");
$message = trim($data["message"] ?? "");

if ($name == "" || $email == "" || $message == "") {
    http_response_code(400);
    echo json_encode(["error" => "Заповни всі поля"]);
    exit;
}

if (strlen($name) > 100 || strlen($email) > 254 || strlen($message) > 5000) {
    http_response_code(400);
    echo json_encode(["error" => "Занадто довгі дані"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["error" => "Неправильний email"]);
    exit;
}

require "db.php";

$sql = "INSERT INTO messages (name, email, message)
        VALUES (:name, :email, :message)";

$stmt = $db->prepare($sql);

$stmt->execute([
    ":name" => $name,
    ":email" => $email,
    ":message" => $message
]);

echo json_encode([
    "success" => true,
    "message" => "Повідомлення збережено!"
]);

?>
