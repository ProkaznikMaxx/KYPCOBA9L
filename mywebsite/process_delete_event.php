<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $eventId = $_POST["event"];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Запрос для удаления мероприятия
    $deleteQuery = "DELETE FROM events WHERE EventId = $eventId";
    $deleteResult = $conn->query($deleteQuery);

    if ($deleteResult === TRUE) {
        echo "Мероприятие успешно удалено.";
    } else {
        echo "Ошибка при удалении мероприятия: " . $conn->error;
    }

    // Закрываем соединение
    $conn->close();
}
?>
