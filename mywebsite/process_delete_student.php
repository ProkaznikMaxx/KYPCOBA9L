<!-- process_delete_student.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $studentId = $_POST["student"];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Запрос для удаления студента
    $deleteQuery = "DELETE FROM students WHERE student_id = $studentId";
    $deleteResult = $conn->query($deleteQuery);

    if ($deleteResult === TRUE) {
        echo "Студент успешно удален.";
    } else {
        echo "Ошибка при удалении студента: " . $conn->error;
    }

    // Закрываем соединение
    $conn->close();
}
?>
