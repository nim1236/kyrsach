<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>История обращений к серверу</title>
</head>
<body>
  <h1>История обращений к серверу</h1>
  
  <?php
  // Открываем лог-файл для чтения
  $log_file = 'server_logs.txt';
  if (file_exists($log_file)) {
      // Читаем содержимое лог-файла
      $log_content = file($log_file, FILE_IGNORE_NEW_LINES);
      // Переворачиваем массив строк, чтобы новые записи были сверху
      $log_content = array_reverse($log_content);
      
      // Выводим каждую запись в обратном порядке
      echo "<ul>";
      foreach ($log_content as $line) {
          echo "<li>$line</li>";
      }
      echo "</ul>";
  } else {
      echo "<p>Лог-файл отсутствует или пуст</p>";
  }
  ?>

  <a href="sait.php">Вернуться на главную</a>
</body>
</html>
