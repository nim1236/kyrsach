<?php
session_start();
require_once("db.php");

// Извлечение данных из POST-запроса
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$total_items = $_POST['total_items'];
$total_price = $_POST['total_price'];
$comment = $_POST['comment'];

// Получение сегодняшней даты
$today_date = date("Y-m-d"); // Формат: ГГГГ-ММ-ДД

// Сохранение данных в сессию
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['total_items'] = $total_items;
$_SESSION['total_price'] = $total_price;
$_SESSION['comment'] = $comment;
$_SESSION['today_date'] = $today_date; // Сохраняем сегодняшнюю дату в сессии

// Вставка данных в таблицу zakaz
$sql = "INSERT INTO `zakaz` (name, email, quantity, total_price, Com, date) VALUES ('$name', '$email', '$total_items', '$total_price', '$comment', '$today_date')";

if ($conn->query($sql) === TRUE) {
    header("Location: sait.php");
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
