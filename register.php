<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "admin"; // измените на ваше имя пользователя
$password = "admin"; // измените на ваш пароль
$dbname = "User";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Проверяем, существует ли пользователь
    $stmt = $conn->prepare("SELECT * FROM Danila WHERE login = ?");
    $stmt->bind_param("s", $login); // Исправлено с $name на $login
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='error'>Пользователь уже существует!</div>";
    } else {
        // Регистрация нового пользователя
        $role = "User";
        $stmt = $conn->prepare("INSERT INTO Danila (login, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $login, $password, $role);
        
        if ($stmt->execute()) {
            // Успешная регистрация, перенаправляем на страницу входа
            header("Location: Users.html");
            exit(); // Обязательно вызываем exit после header
        } else {
            echo "<div class='error'>Ошибка: " . $stmt->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('/img/1710888149_bogatyr-club-k6y6-p-fon-dlya-prezentatsii-stroitelstvo-16.jpg') no-repeat center center fixed; /* Замените 'your-image.jpg' на ваш путь к изображению */
            background-size: cover; /* Подгонка изображения под размер экрана */
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 350px; /* Увеличено для большей удобочитаемости */
            margin: 100px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9); /* Полупрозрачный белый фон */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #007BFF; /* Синий цвет, подходящий для строительной компании */
            margin-bottom: 20px;
        }
        input[type=text], input[type=password] {
            width: calc(100% - 20px); /* Рассчитываем ширину с учетом отступов */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Включаем отступы в расчёт ширины */
        }
        input[type=submit] {
            width: 100%;
            padding: 10px;
            background: #007BFF; /* Синий цвет кнопки */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type=submit]:hover {
            background: #0056b3; /* Тёмно-синий при наведении */
        }
        .error {
            color: red;
            text-align: center;
            margin: 10px 0;
        }
        .info {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9); /* Полупрозрачный белый фон для информации */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .info h3 {
            color: #007BFF;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Регистрация</h2>
    <form method="post" action="">
        Логин: <input type="text" name="login" required><br>
        Пароль: <input type="password" name="password" required><br>
        <input type="submit" value="Зарегистрироваться">
    </form>
</div>

<div class="info">
    <h3>О нашей строительной компании</h3>
    <p>Мы — надежная строительная компания с многолетним опытом работы в сфере строительства и реконструкции. Наша команда состоит из высококвалифицированных специалистов, которые готовы воплотить в жизнь любые ваши идеи.</p>
    <p>Мы предлагаем широкий спектр услуг, включая:</p>
    <ul>
        <li>Строительство жилых и коммерческих объектов</li>
        <li>Реконструкция зданий</li>
        <li>Проектирование и архитектурные услуги</li>
        <li>Ландшафтный дизайн и благоустройство территорий</li>
    </ul>
    <p>Наша цель — предоставить клиентам высококачественные услуги и гарантировать полное удовлетворение их потребностей. Мы ценим каждого клиента и стремимся к долгосрочному сотрудничеству.</p>
</div>

</body>
</html>