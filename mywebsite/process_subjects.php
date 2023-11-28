<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "111";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Обработка добавления предмета
if (isset($_POST['subjectNameAdd'])) {
    $subjectName = $_POST['subjectNameAdd'];

    // Проверка, есть ли такой предмет в базе данных
    $checkQuery = "SELECT * FROM subjects WHERE SubjectName = '$subjectName'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Предмет уже существует
        echo "Предмет с таким именем уже существует. Нельзя добавить повторно.";
    } else {
        // Добавление предмета
        $insertQuery = "INSERT INTO subjects (SubjectName) VALUES ('$subjectName')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Предмет успешно добавлен.";
        } else {
            echo "Ошибка добавления предмета: " . $conn->error;
        }
    }
}

// Обработка удаления предмета
if (isset($_POST['subjectIdDelete'])) {
    $subjectId = $_POST['subjectIdDelete'];

    // Удаление предмета
    $deleteQuery = "DELETE FROM subjects WHERE subject_id = '$subjectId'";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "Предмет успешно удален.";
    } else {
        echo "Ошибка удаления предмета: " . $conn->error;
    }
}

// Закрытие соединения
$conn->close();
?>
