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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }

        .row {
            width: 100%;
            display: flex;
        }

        .col-md-12 {
            width: 100%;
            padding: 0 10px;
        }

        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }

        .input-group {
            width: 100%;
            display: flex;
        }

        .input-group-append {
            width: auto;
            flex-shrink: 0;
            margin-left: 10px;
        }

        .btn {
            width: 100%;
            padding: 10px 20px;
        }

        p {
            margin-top: 20px;
        }

        a {
            text-decoration: none;
            color: blue;
        }

        a:hover {
            color: darkblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Вход</h2>
                <p>Пожалуйста, укажите нужную информацию для входа.</p>
                <form action="process_login.php" method="post">
                    <div class="form-group">
                        <label>Почта</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">Показать</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Вход">
                    </div>
                </form>
                <p>Не регистрировался? <a href="index.php">С начала сюда</a>.</p>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.textContent = "Спрятать";
            } else {
                passwordInput.type = "password";
                this.textContent = "Показать";
            }
        });
    </script>
</body>
</html>