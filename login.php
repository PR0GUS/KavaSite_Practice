<?php

session_start();
if (isset($_SESSION["admin"])) {
    header("Location: messages.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"] ?? "";
    $adminPassword = getenv("ADMIN_PASSWORD");

    if ($adminPassword !== false && hash_equals($adminPassword, $password)) {
        session_regenerate_id(true);
        $_SESSION["admin"] = true;

        header("Location: messages.php");
        exit;
    } else {
        $error = "Неправильний пароль!";
    }
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід адміністратора</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Вхід адміністратора</h1>
<form method="post">
    <label for="password">Пароль:</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Увійти</button>
</form>

<p><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>

</body>
</html>
