<?php
require_once("db.php");

$login = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM `users` WHERE email='$login' AND passwod='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
         "Добро пожаловать " . $row['name'];
        // Перенаправление на страницу site.php
        header("Location: sait.php");
        exit(); // Обязательно завершаем выполнение скрипта после перенаправления
    }
} else {
     echo "Нет такого пользователя";
}
?>
