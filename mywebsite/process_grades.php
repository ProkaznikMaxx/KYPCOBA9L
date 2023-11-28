<!-- process_grades.php -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $studentId = $_POST["student"];
    $subjectId = $_POST["subject"];
    $gradeValue = $_POST["grade"];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Обновляем оценку
    $updateQuery = "UPDATE grades SET AverageGrade = ? WHERE student_id = ? AND subject_id = ?";
    $stmt = $conn->prepare($updateQuery);

    // Привязываем параметры
    $stmt->bind_param("dii", $gradeValue, $studentId, $subjectId);

    // Выполняем запрос
    $updateResult = $stmt->execute();

    $updateQuery = "UPDATE grades SET AverageGrade = $gradeValue WHERE student_id = $studentId AND subject_id = $subjectId";
    echo "Query: " . $updateQuery . "<br>"; // Вывод запроса в браузер
    $updateResult = $conn->query($updateQuery);

    if ($updateResult === TRUE) {
        echo "Оценка успешно обновлена.";
    } else {
        echo "Ошибка при обновлении оценки: " . $conn->error;
    }
        // Закрываем соединение
        $conn->close();
}
?>
