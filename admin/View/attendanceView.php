<?php
    require_once '../ConnDB/connDB.php';
    require_once '../Controller/classController.php';
    $classController = new ClassController();
    $classes = $classController->getAllClass();
    $cardCounter = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học cùng Nihongo | Danh sách học viên</title>
    <link href="image/logoFaceWeb.png" rel="icon">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>

    <section class="home">
        <section class="user-list">
            <?php require_once 'includes/adminView.php'; ?>

            <div class="main-card">
                <?php
                    if ($classes) {
                        echo '<div class="main-skills">';
                        while ($row = $classes->fetch_assoc()) {
                            if ($cardCounter > 0 && $cardCounter % 4 == 0) {
                                echo '</div>
                                <div class="main-skills">';
                            }
                                    echo '<div class="card">
                                            <div class="detail">
                                                <h3>' . htmlspecialchars($row['TenLop']) . '</h3>
                                            </div>
                                            <button type="submit" class="btnView">View</button>
                                        </div>';
                            $cardCounter++;
                        }
                        echo '</div>';
                    }
                ?>
            </div>
        </section>
    </section>

    <script src="javascript/toggle.js"></script>
</body>
</html>
