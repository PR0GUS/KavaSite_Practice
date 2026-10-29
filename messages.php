<?php

session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

require "db.php";

$stmt = $db->query("SELECT * FROM messages ORDER BY id DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Повідомлення кав'ярні</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Повідомлення від відвідувачів</h1>

<p><a href="logout.php">Вийти</a></p>

<?php foreach ($messages as $row): ?>

    <div class="menu-item">
        <h3>
            <?= htmlspecialchars($row["name"], ENT_QUOTES, "UTF-8") ?>
        </h3>

        <p>
            Email:
            <?= htmlspecialchars($row["email"], ENT_QUOTES, "UTF-8") ?>
        </p>

        <p>
            <?= nl2br(htmlspecialchars($row["message"], ENT_QUOTES, "UTF-8")) ?>
        </p>

        <p>
            Дата:
            <?= htmlspecialchars($row["created_at"], ENT_QUOTES, "UTF-8") ?>
        </p>

        <button onclick="deleteMessage(<?= (int)$row['id'] ?>)">
            Видалити
        </button>
    </div>

<?php endforeach; ?>

<script>
async function deleteMessage(id) {
    if (!confirm("Видалити це повідомлення?")) {
        return;
    }

    var response = await fetch("api.php", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({id: id})
    });

    var result = await response.json();

    if (response.ok && result.success) {
        location.reload();
    } else {
        alert(result.error || "Не вдалося видалити повідомлення");
    }
}
</script>

</body>
</html>
