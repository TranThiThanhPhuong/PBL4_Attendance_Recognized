<?php
// Include database connection
require_once '../ConnDB/connDB.php';
    require_once '../Controller/classController.php';
    require_once '../Controller/studentsController.php';

// Initialize database connection (assuming you have a $connectionDB variable from your database configuration)
$controller = new StudentsController($conn);

// Get class ID (you may get it from a form or URL parameter)
$id_lop = 1;

// Retrieve student data
$students = $controller->getAllStudentInClass($id_lop);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách Học viên</title>
</head>
<body>
    <h1>Danh sách Học viên trong lớp</h1>
    <?php if (empty($students)): ?>
        <p>Không có học viên nào trong lớp này.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Ngày Sinh</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['ID']); ?></td>
                    <td><?php echo htmlspecialchars($student['Ten']); ?></td>
                    <td><?php echo htmlspecialchars($student['NgaySinh']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
