<!-- add_delete_event.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление и удаление мероприятия</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="d-flex justify-content-start mb-4" style="margin-left: 15px; margin-top: 15px;">
        <a href="index.php" class="btn btn-primary">Назад</a>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Добавление и удаление мероприятия</h2>

        <!-- Форма для добавления мероприятия -->
        <form method="post" action="process_add_event.php">
            <h3 class="mb-3">Добавление мероприятия</h3>
            <div class="mb-3">
                <label for="eventname">Название мероприятия</label>
                <input type="text" class="form-control" id="eventname" name="eventname" required>
            </div>
            <div class="mb-3">
                <label for="eventdate">Дата мероприятия</label>
                <input type="date" class="form-control" id="eventdate" name="eventdate" required>
            </div>
            <button type="submit" class="btn btn-success">Добавить мероприятие</button>
        </form>

        <hr>

        <!-- Форма для удаления мероприятия -->
        <form method="post" action="process_delete_event.php">
            <h3 class="mb-3">Удаление мероприятия</h3>
            <div class="mb-3">
                <label for="event">Выберите мероприятие для удаления</label>
                <select class="form-select" id="event" name="event" required>
                    <?php
                    // Подключение к базе данных
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "111";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Ошибка подключения: " . $conn->connect_error);
                    }

                    // Запрос для получения списка мероприятий
                    $eventsQuery = "SELECT * FROM events";
                    $eventsResult = $conn->query($eventsQuery);

                    // Заполнение выпадающего списка мероприятий
                    while ($event = $eventsResult->fetch_assoc()) {
                        echo "<option value='" . $event['event_id'] . "'>" . $event['event_id'] . " - " . $event['EventName'] . " (" . $event['EventDate'] . ")</option>";
                    }

                    // Закрытие соединения
                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Удалить мероприятие</button>
        </form>

    </div>

</body>
</html>
