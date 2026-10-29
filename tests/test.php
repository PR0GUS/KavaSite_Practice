<?php
// Прості тести без додаткових бібліотек
function check($name, $ok) {
    echo ($ok ? "OK " : "ERROR ") . $name . "\n";
    if (!$ok) exit(1);
}
$folder = sys_get_temp_dir() . "/kava_test_" . uniqid();
mkdir($folder);
$db = new PDO("sqlite:" . $folder . "/test.sqlite");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE messages (id INTEGER PRIMARY KEY, name TEXT, email TEXT, message TEXT)");
$db->prepare("INSERT INTO messages (name,email,message) VALUES (?,?,?)")->execute(["Тест", "test@example.com", "Привіт"]);
check("1. Збереження повідомлення", $db->query("SELECT COUNT(*) FROM messages")->fetchColumn() == 1);
check("2. Отримання повідомлення", $db->query("SELECT name FROM messages")->fetchColumn() == "Тест");
$db->exec("DELETE FROM messages WHERE id=1");
check("3. Видалення повідомлення", $db->query("SELECT COUNT(*) FROM messages")->fetchColumn() == 0);
$db = null;
unlink($folder . "/test.sqlite");
rmdir($folder);
