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
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width-sevice-width, initial-scale-1.0">
        <title>Регистрация</title>
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
                    <h2>Регистрация</h2>
                    <p>Пожалуйста,заполните форму для создания аккаунта.</p>
                    <form action="regist.php" method="post" onsubmit="return validatePassword()">
                        <div class="form-group">
                            <label>Имя</label>
                            <input type="text" name="name" class="form-control" ><!--required говорит нам что поле должно быть обязательно заполнено перед отправкой формы иначе выдаст ошибку -->
                        </div>    
                        <div class="form-group">
                            <label>Почта</label>
                            <input type="email" name="email" class="form-control" />
                        </div>    
                        <div class="form-group">
                        <label>Пароль</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" >
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">Показать</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Повтор пароля</label>
                        <div class="input-group">
                            <input type="password" id="confirmPassword" name="confirm_password" class="form-control" >
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">Показать</button>
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <input type="submit" name="Зарегистрироваться" class="btn btn-primary" value="Submit" onclick="return validatePassword()">
                        </div>
                        <p>Уже был тут? <a href="login.php">Входи</a>.</p>
                    </form>
                </div>
            </div>
        </div> 
<script>
    function validatePassword() {
    var name = document.getElementsByName("name")[0].value;
    var email = document.getElementsByName("email")[0].value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var uppercaseRegex = /[A-ZА-Я]/;
    var lowercaseRegex = /[a-zа-я]/;
    var symbolRegex = /[^\w\s]/;
    var lengthRegex = /.{8,}/;

    if (name.trim() === "") {
        alert("Please enter your Full Name.");
        return false;
    }

    if (email.trim() === "") {
        alert("Please enter your Email Address.");
        return false;
    }

    if (!uppercaseRegex.test(password) && !lowercaseRegex.test(password) && !symbolRegex.test(password) && !lengthRegex.test(password)) {
        alert("Пароль должен содержать хотя бы одну заглавную, одну строчную букву (русскую или английскую), один символ и иметь не менее 8 символов.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Пароль и его подтверждение не совпадают.");
        return false;
    }

    return true;
}
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
    document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
        var confirmPasswordInput = document.getElementById("confirmPassword");
        if (confirmPasswordInput.type === "password") {
            confirmPasswordInput.type = "text";
            this.textContent = "Спрятать";
        } else {
            confirmPasswordInput.type = "password";
            this.textContent = "Показать";
        }
    });
</script>   
    </body>
</html>