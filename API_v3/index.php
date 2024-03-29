<?php 
 
 
// Для виведеня усіх помилок на екран
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


session_start();

// Підключення бази даних 
include_once 'config/database.php';

// Встановлення та перевірка з'єднання
include_once 'controllers/conect_mysql.php';

// Завантаження даних з навичками
include_once 'models/skills.php';

// Завантаження даних з проектами
include_once 'models/project.php';


// Відображення 
include_once 'views/view.php';

mysqli_close($conn);
?>

