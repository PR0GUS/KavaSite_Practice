<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION["admin"])) {
    http_response_code(401);
    echo json_encode(["error" => "Потрібно увійти"]);
    exit;
}

require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $stmt = $db->query(
        "SELECT id, name, email, message, created_at
         FROM messages ORDER BY id DESC"
    );

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = filter_var($data["id"] ?? null, FILTER_VALIDATE_INT);

    if (!$id || $id < 1) {
        http_response_code(400);
        echo json_encode(["error" => "Неправильний ID"]);
        exit;
    }

    $stmt = $db->prepare("DELETE FROM messages WHERE id = :id");
    $stmt->execute([":id" => $id]);

    echo json_encode(["success" => true]);
    exit;
}

header("Allow: GET, DELETE");
http_response_code(405);
echo json_encode(["error" => "Метод не підтримується"]);

?>
