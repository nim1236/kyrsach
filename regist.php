<?php
session_start();
require_once("db.php");

// Извлечение данных из формы и сохранение в сессию
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Сохранение данных в сессию
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
$_SESSION['confirm_password'] = $confirm_password;

$sql = "INSERT INTO `users` (name, email, passwod, too_password) VALUES ('$name', '$email', '$password', '$confirm_password')";

if ($conn->query($sql) === TRUE) {
    // Перенаправление на страницу site.php
    header("Location: sait.php");
    exit(); // Обязательно завершаем выполнение скрипта после перенаправления
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

