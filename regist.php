<?php
require_once("db.php");
$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];
$confirm_password=$_POST['confirm_password'];

$sql="INSERT INTO `users` (name,email,passwod,too_password) VALUES ('$name','$email','$password','$confirm_password')";
if ($sql) {
    echo ("Добавление прошло успешно");
} else {
    echo ("Данные не были добавлены");
}
$conn -> query($sql);
