<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моя веб-страница</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>

        .horizontal-scrollable {
            overflow-x: auto;
            white-space: nowrap;
        }

        .horizontal-scrollable table {
            display: inline-table;
            width: auto;
        }

    </style>
</head>
<body class="bg-light">

    <div class="d-flex justify-content-start mb-4" style="margin-left: 15px; margin-top: 15px;">
        <a href="index.php" class="btn btn-primary">Назад</a>
    </div>

    <h2 class='text-center mb-4'>Таблица успеваемости студентов</h2>
    <div class="container mt-3 horizontal-scrollable">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "111";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        $subjectsQuery = "SELECT DISTINCT SubjectName FROM subjects";
        $subjectsResult = $conn->query($subjectsQuery);

        $subjects = [];
        while ($subject = $subjectsResult->fetch_assoc()) {
            $subjects[] = $subject['SubjectName'];
        }

        $sql = "SELECT
            students.student_id AS Идентификатор_студента,
            students.Surname AS Фамилия,
            students.Name AS Имя,
            students.Middlename AS Отчество,
            students.Group AS Группа,
            AVG(grades.AverageGrade) AS Средний_балл_студента,
            " . implode(", ", array_map(function ($subject) {
                return "IFNULL(ROUND(AVG(CASE WHEN subjects.SubjectName = '$subject' THEN grades.AverageGrade END), 0), '') AS `$subject`";
            }, $subjects)) . ",
            COUNT(DISTINCT eventparticipation.participation_id) AS Количество_мероприятий
        FROM students
        LEFT JOIN grades ON students.student_id = grades.student_id
        LEFT JOIN eventparticipation ON students.student_id = eventparticipation.student_id
        LEFT JOIN subjects ON grades.subject_id = subjects.subject_id
        GROUP BY students.student_id
        ORDER BY Средний_балл_студента DESC, Количество_мероприятий DESC";

        $result = $conn->query($sql);

        if ($result === false) {
            echo "Ошибка выполнения запроса: " . $conn->error;
        } else {
            echo "<div class='container mt-3 horizontal-scrollable'>";
            echo "<table class='table table-striped table-bordered mt-4'>
                <thead>
                    <tr>
                        <th scope='col'>Позиция</th>
                        <th scope='col'>ID Cтудента</th>
                        <th scope='col'>Фамилия</th>
                        <th scope='col'>Имя</th>
                        <th scope='col'>Отчество</th>
                        <th scope='col'>Группа</th>";

            foreach ($subjects as $subject) {
                echo "<th scope='col'>$subject</th>";
            }

            echo "<th scope='col'>Средний балл студента</th>
                  <th scope='col'>Кол-во мероприятий</th>
                </tr>
            </thead>
            <tbody>";

            $rowNumber = 1;

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <th scope='row' class='text-center'>" . $rowNumber . "</th>
                    <td class='text-center'>" . $row["Идентификатор_студента"] . "</td>
                    <td class='text-center'>" . $row["Фамилия"] . "</td>
                    <td class='text-center'>" . $row["Имя"] . "</td>
                    <td class='text-center'>" . $row["Отчество"] . "</td>
                    <td class='text-center'>" . $row["Группа"] . "</td>";

                foreach ($subjects as $subject) {
                    echo "<td class='text-center'>" . ($row[$subject] === '' ? '' : rtrim($row[$subject], '0')) . "</td>";
                }

                echo "<td class='text-center'>" . ($row["Средний_балл_студента"] === '' ? '' : number_format($row["Средний_балл_студента"], 2, '.', '')) . "</td>
                      <td class='text-center'>" . $row["Количество_мероприятий"] . "</td>
                </tr>";

                $rowNumber++;
            }
            echo "</tbody></table>";
            echo "</div>";
        }
        ?>
    </div>

        <?php
        $sql2 = "SELECT
            students.student_id AS Идентификатор_студента,
            students.Surname AS Фамилия,
            students.Name AS Имя,
            students.Middlename AS Отчество,
            students.Group AS Группа,
            SUM(CASE WHEN events.EventName = 'Будущее IT' THEN 1 ELSE 0 END) AS `Будущее_IT`,
            SUM(CASE WHEN events.EventName = 'Молодой предприниматель' THEN 1 ELSE 0 END) AS `Молодой_предприниматель`,
            COUNT(DISTINCT eventparticipation.participation_id) AS Количество_посещений
        FROM students
        LEFT JOIN eventparticipation ON students.student_id = eventparticipation.student_id
        LEFT JOIN events ON eventparticipation.event_id = events.event_id
        GROUP BY students.student_id
        ORDER BY Количество_посещений DESC";

        $result2 = $conn->query($sql2);

        if ($result2 === false) {
            echo "Ошибка выполнения запроса: " . $conn->error;
        } else {
            echo "<h2 class='text-center mb-4'>Таблица посещаемости мероприятий</h2>";
            echo "<div class='container mt-3 horizontal-scrollable'>";
            echo "<table class='table table-striped table-bordered mt-4'>
                <thead>
                    <tr>
                        <th scope='col'>Позиция</th>
                        <th scope='col'>ID студента</th>
                        <th scope='col'>Фамилия</th>
                        <th scope='col'>Имя</th>
                        <th scope='col'>Отчество</th>
                        <th scope='col'>Группа</th>
                        <th scope='col'>Будущее IT</th>
                        <th scope='col'>Молодой предприниматель</th>
                        <th scope='col'>Количество посещений</th>
                    </tr>
                </thead>
                <tbody>";

            $rowNumber2 = 1;

            while ($row2 = $result2->fetch_assoc()) {
                echo "<tr>
                    <th scope='row' class='text-center'>" . $rowNumber2 . "</th>
                    <td class='text-center'>" . $row2["Идентификатор_студента"] . "</td>
                    <td class='text-center'>" . $row2["Фамилия"] . "</td>
                    <td class='text-center'>" . $row2["Имя"] . "</td>
                    <td class='text-center'>" . $row2["Отчество"] . "</td>
                    <td class='text-center'>" . $row2["Группа"] . "</td>
                    <td class='text-center'>" . ($row2["Будущее_IT"] > 0 ? '+' : '') . "</td>
                    <td class='text-center'>" . ($row2["Молодой_предприниматель"] > 0 ? '+' : '') . "</td>
                    <td class='text-center'>" . $row2["Количество_посещений"] . "</td>
                </tr>";

                $rowNumber2++;
            }
            echo "</tbody></table>";
            echo "</div>";
        }

        $conn->close();
        ?>
    </div>

</body>
</html>