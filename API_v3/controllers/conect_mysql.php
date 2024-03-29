<?php

// Підключення до бази даних
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// перевірка з'єднання
if (!$conn) {
    die("Connection failed: " . $conn->connect_error());
}

// Встановлення кодування
$conn->set_charset("utf8mb4");

?>
