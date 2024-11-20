<?php
    require_once '../ConnDB/connDB.php';
    require_once '../Controller/studentsController.php';

    $studentsController = new StudentsController($connectionDB);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentsPresent = json_decode($_POST['studentsPresent'], true);
        $studentsAbsent = json_decode($_POST['studentsAbsent'], true);

        $dataToSend = [
            'present' => [],
            'absent' => []
        ];

        if (!empty($studentsPresent)) {
            foreach ($studentsPresent as $student) {
                $id = $student['id'];
                $studentInfo = $studentsController->getInfoStudent($id);
                if (!empty($studentInfo)) {
                    $email = $studentInfo['Email'];
                    $message = "📢 THÔNG BÁO
                                Kính gửi học viên,

                                Hôm nay, học viên đã có mặt trong buổi học.
                                Chúc bạn học tập hiệu quả và đạt nhiều thành tích tốt!

                                Trân trọng,
                                [Ban giám hiệu/ Giáo viên phụ trách]";

                    $dataToSend['present'][] = ['Email' => $email, 'message' => $message];
                }
            }
        }

        // Xử lý danh sách sinh viên vắng mặt
        if (!empty($studentsAbsent)) {
            foreach ($studentsAbsent as $student) {
                $id = $student['id'];
                $studentInfo = $studentsController->getInfoStudent($id);

                if (!empty($studentInfo)) {
                    $email = $studentInfo['Email'];
                    $message = "📢 THÔNG BÁO
                                Kính gửi học sinh,

                                Hôm nay, học viên đã vắng mặt trong buổi học.
                                Vui lòng đến lớp vào ngày học tiếp theo.
                                Nếu có lý do chính đáng, vui lòng liên hệ giáo viên phụ trách để được hỗ trợ.
                                Chúc bạn sức khỏe và học tập tốt!

                                Trân trọng,
                                [Ban giám hiệu/ Giáo viên phụ trách]";

                    $dataToSend['absent'][] = ['Email' => $email, 'message' => $message];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($dataToSend);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học cùng Nihongo | Trang chủ</title>
    <link href="image/logoFaceWeb.png" rel="icon">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>

    <section class="home">
        <section class="user-list">
            <?php require_once 'includes/adminView.php'; ?>

            <section class="wrapper">
                <div class="weeks">
                    <form action="sendMail.php" method="post">
                        <?php
                            if (!empty($studentsPresent)) {
                                echo "<h3>Sinh viên đi học:</h3>";
                                echo "<table class='table'
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
                                    echo "</tr>";
                                }

                                echo "</table>";
                            } else {
                                echo "<p>Không có sinh viên vắng học.</p>";
                            }
                        ?>
                        <input type="hidden" id="studentsPresent" name="studentsPresent" value='<?php echo json_encode($studentsPresent); ?>'>
                        <input type="hidden" id="studentsAbsent" name="studentsAbsent" value='<?php echo json_encode($studentsAbsent); ?>'>
                        <button type="submit">Gửi email</button>
                    </form>
                </div>

            </section>

        </section>

        
    </section>

    <script src="javascript/toggle.js"></script>

</body>
</html>

