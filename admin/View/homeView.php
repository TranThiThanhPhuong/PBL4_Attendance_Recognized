<?php
    require_once '../ConnDB/connDB.php';
    require_once '../Controller/studentsController.php';
    require_once '../Controller/classController.php';

    $classController = new ClassController();
    $classescount = $classController->countClasses();
    $studentsController = new StudentsController($connectionDB);
    $studentscount = $studentsController->countStudents();
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

            <div class="countCards">
                <div class="countCard">
                    <div class="card-main">
                        <h3>Số học viên</h3>
                        <h1>
                            <?php
                                if ($studentscount['success']) {
                                    echo $studentscount['student_count'];
                                } else {
                                    echo "Error retrieving count";
                                }
                            ?>
                        </h1>
                    </div>
                    <i class="la la-user"></i>
                </div>

                <div class="countCard">
                    <div class="card-main">
                        <h3>Số lớp học</h3>
                        <h1>
                            <?php
                                if ($classescount['success']) {
                                    echo $classescount['class_count'];
                                } else {
                                    echo "Error retrieving count";
                                }
                            ?>
                        </h1>
                    </div>
                    <i class="las la-chalkboard-teacher"></i>
                </div>
                
            </div>
        </section>
    </section>

    <script src="javascript/toggle.js"></script>

</body>
</html>
