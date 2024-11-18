<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentsPresent = json_decode($_POST['studentsPresent'], true);
    $studentsAbsent = json_decode($_POST['studentsAbsent'], true);
    if (!empty($studentsPresent)) {
        echo "<h3>Sinh viên đi học:</h3>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Thời gian</th>
                </tr>";

        foreach ($studentsPresent as $student) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($student['id']) . "</td>";
            echo "<td>" . htmlspecialchars($student['time']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Không có sinh viên đi học.</p>";
    }

    if (!empty($studentsAbsent)) {
        echo "<h3>Sinh viên vắng học:</h3>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Thời gian</th>
                </tr>";

        foreach ($studentsAbsent as $student) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($student['id']) . "</td>";
            echo "<td>" . htmlspecialchars($student['time']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Không có sinh viên vắng học.</p>";
    }

    // Bạn có thể thêm logic để lưu vào Discord tại đây
}
?>
