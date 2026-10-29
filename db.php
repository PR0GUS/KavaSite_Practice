<?php

$folder = dirname(__DIR__) . "/KavaSite_data";
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$db = new PDO("sqlite:" . $folder . "/messages.sqlite");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("
    CREATE TABLE IF NOT EXISTS messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        message TEXT NOT NULL,
        created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
    )
");
?>
