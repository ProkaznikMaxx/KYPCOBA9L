<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $eventName = $_POST["event_name"];
    $eventDate = $_POST["event_date"];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Запрос для добавления мероприятия
    $addQuery = "INSERT INTO events (EventName, EventDate) VALUES ('$eventName', '$eventDate')";
    $addResult = $conn->query($addQuery);

    if ($addResult === TRUE) {
        echo "Мероприятие успешно добавлено.";
    } else {
        echo "Ошибка при добавлении мероприятия: " . $conn->error;
    }

    // Закрываем соединение
    $conn->close();
}
?>
