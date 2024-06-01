<?php
$log_file = 'server_logs.txt';
file_put_contents($log_file, ''); // Очищаем содержимое файла
header('Location: index.php'); // Перенаправляем пользователя на главную страницу
exit();
?>
