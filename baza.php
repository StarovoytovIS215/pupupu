<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Стили остаются без изменений */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column; /* Вертикальное расположение элементов */
        }

        table {
            width: 100%;
            max-width: 600px;
            margin: 20px;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        /* Адаптивность таблицы */
        @media (max-width: 600px) {
            th, td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            th {
                text-align: center;
            }
        }

        /* Стили для кнопки выйти */
        #logoutButton {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #logoutButton:hover {
            background-color: #d32f2f;
        }

        /* Стили для кнопки удаления */
        .deleteButton {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .deleteButton:hover {
            background-color: #d32f2f;
        }
    </style>
    <title>Адаптивная таблица с PHP и MySQLi</title>
</head>
<body>

<?php
// Подключение к базе данных (замените параметры на ваши)
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "User";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Удаление пользователя
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM `Danila` WHERE `id` = $delete_id";
    $conn->query($delete_sql);
}

// SQL-запрос для получения данных
$sql = "SELECT `login`, `password`, `id`, `role` FROM `Danila`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Вывод данных в таблицу
    echo '<table>';
echo '<thead><tr><th>ID</th><th>Роль</th><th>Логин</th><th>Пароль</th><th>Действия</th><th>Изменить роль</th></tr></thead>';
echo '<tbody>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['role'] . '</td>';
    echo '<td>' . $row['login'] . '</td>';
    echo '<td>' . $row['password'] . '</td>';
    echo '<td><button class="deleteButton" onclick="confirmDelete(' . $row['id'] . ')">Удалить</button></td>';
    echo '<td>
        <select id="roleSelect' . $row['id'] . '">
            <option value="User">User</option>
            <option value="men">men</option>
            <option value="admin">admin</option>
        </select>
        <button class="editButton" onclick="changeRole(' . $row['id'] . ')">Изменить</button>
    </td>';
    echo '</tr>';
}

echo '</tbody></table>';
}
?>

<!-- Кнопка выхода -->
<button id="logoutButton" onclick="location.href='login.php'">Выйти</button>

<script>
function confirmDelete(id) {
    const confirmation = confirm("Вы уверены, что хотите удалить этого пользователя?");
    if (confirmation) {
        window.location.href = "?delete_id=" + id; // Перенаправление на текущую страницу с параметром delete_id
    }
}
function changeRole(id) {
    const roleSelect = document.getElementById('roleSelect' + id);
    const newRole = roleSelect.value;
    
    // You can implement the logic here to update the role for the user with the given ID to the newRole
    
    alert("Change role functionality for user id: " + id + ", new role: " + newRole);
}
</script>

</body>
</html>
