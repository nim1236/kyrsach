<?php
// Открываем лог-файл для добавления записи
$log_file = 'server_logs.txt';
$log_message = date('Y-m-d H:i:s') . ' - ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL;
file_put_contents($log_file, $log_message, FILE_APPEND);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>История заказов</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }
    h1 {
      margin-bottom: 20px;
    }
    .order {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 10px;
    }
    .order-details {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h1>История заказов</h1>
  
  <?php
    // Подключение к базе данных
    require_once("db.php");

    // Запрос на получение всех заказов из таблицы zakaz
    $sql = "SELECT * FROM zakaz";
    $result = $conn->query($sql);

    // Если есть заказы, выводим их
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<div class='order'>";
        echo "<p><strong>Имя:</strong> " . $row["name"] . "</p>";
        echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
        echo "<p><strong>Количество товаров:</strong> " . $row["quantity"] . "</p>";
        echo "<p><strong>Общая сумма:</strong> " . $row["total_price"] . " руб</p>";
        echo "<p><strong>Комментарий:</strong> " . $row["Com"] . "</p>";
        echo "<p><strong>Дата заказа:</strong> " . $row["date"] . "</p>";
        echo "</div>";
      }
    } else {
      echo "Нет заказов.";
    }

    // Закрываем соединение с базой данных
    $conn->close();
  ?>
  
  <a href="sait.php">Вернуться на главную страницу</a>
</body>
</html>
