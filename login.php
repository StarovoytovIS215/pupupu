<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Подключение к базе данных
$servername = "localhost"; // или ваш сервер БД
$username = "root"; // ваше имя пользователя БД
$password = ""; // ваш пароль БД
$dbname = "User"; // название вашей базы данных

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Защита от SQL-инъекций
    $name = $conn->real_escape_string($login);
    $pass = $conn->real_escape_string($password);

    // Запрос на выборку пользователя с использованием подготовленных выражений
    $stmt = $conn->prepare("SELECT Role FROM Danila WHERE login=? AND Password=?");
    $stmt->bind_param("ss", $login, $password); // 'ss' означает два параметра типа строка
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Пользователь найден, получаем роль
        $row = $result->fetch_assoc();
        $role = $row['Role'];

        // Сохранение роли в сессии (если необходимо)
        $_SESSION['role'] = $role;

        // Перенаправление в зависимости от роли
        switch ($role) {
            case 'admin':
                header("Location: admin.html");
                break;
            case 'men]':
                header("Location: men].html");
                break;
            case 'Users':
                header("Location: Users.html");
                break;
            case 'guets':
                header("Location: guets.html");
                break;
            default:
                echo "Неизвестная роль.";
                break;
        }
        exit();
    } else {
        echo "Неправильный логин или пароль.";
    }
    $stmt->close(); // Закрываем подготовленное выражение
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ЯМыОрда</title>
<link rel="stylesheet" href="styles.css"> <!-- Подключение внешнего CSS -->
</head>

<body>
<div class="login-container">
    <button class="close-btn" onclick="closeForm()">×</button>
    <a href="https://belovokyzgty.ru/" class="logo">
        <img src="/img/8c60b513dfe29396251f.png" alt="Логотип" width="290">
    </a>
    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="submit" value="Войти">
    </form>

    <!-- Кнопка для перехода на страницу регистрации -->
    <a href="register.php" class="register-button">Зарегистрироваться</a>


    <script>
    // Функция для скрытия формы (если необходимо)
    function closeForm() {
        document.querySelector('.login-container').style.display = 'none'; // Скрываем контейнер с формой
    }
    </script>
</body>
</html>