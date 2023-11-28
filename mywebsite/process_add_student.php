<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $middlename = $_POST["middlename"];
    $studentGroup = $_POST["group"];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Запрос для добавления студента без указания student_id
    $addQuery = "INSERT INTO students (Surname, Name, Middlename, `Group`) VALUES ('$surname', '$name', '$middlename', '$studentGroup')";
    $addResult = $conn->query($addQuery);

    if ($addResult === TRUE) {
        echo "Студент успешно добавлен.";
    } else {
        echo "Ошибка при добавлении студента: " . $conn->error;
    }

    // Закрываем соединение
    $conn->close();
}
?>
