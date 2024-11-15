<?php
    require_once '../ConnDB/connDB.php';
    require_once '../Controller/studentsController.php';
    $studentsController = new StudentsController($connectionDB);
    if (isset($_GET['ID'])) {
        $id_lop = $_GET['ID'];
        $students = $studentsController->getAllStudentInClass($id_lop);
    } else {
        echo "Không tìm thấy ID lớp.";
    }
    if (!empty($students)) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học cùng Nihongo | Điểm danh</title>
    <link href="image/logoFaceWeb.png" rel="icon">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>

    <section class="home">
        <section class="user-list">
            <?php require_once 'includes/adminView.php'; ?>

            <div class="checkcam">
                <div class="list-button">
                    <button class="btnCam">Camera</button>
                    <button class="btnCheck">Điểm danh</button>
                </div>
                <div class="containerVideo" style="display: none">
                    <video id="webcam" width="960" height="720" autoplay></video>
                </div>
                <div class="studentCards" style="display: none">
                    <?php
                        $stt = 0;
                        foreach ($students as $row) {
                            echo '<div class="studentCard">';
                                echo '<img src="image/logostudent.png" alt="">';
                                echo '<div class="info">';
                                    echo '<p>ID: ' . htmlspecialchars($row["ID"]) .'</p>';
                                    echo '<h5>' . htmlspecialchars($row["Ten"]) . '</h5>';
                                echo '</div>';
                                echo ' <button class="tick"><i class="las la-check"></i></button>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            
        </section>
    </section>

    <script>
        const btnCam = document.querySelector(".btnCam"),
            btnCheck = document.querySelector(".btnCheck"),
            studentCards =document.querySelector(".studentCards"),
            videoElement = document.getElementById('webcam');
            containerVideo =document.querySelector(".containerVideo");

            btnCam.addEventListener("click", function() {
                studentCards.style.display = "none";
                containerVideo.style.display = "block";
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true })
                        .then(function(stream) {
                            const videoElement = document.getElementById('webcam');
                            videoElement.srcObject = stream;
                        })
                        .catch(function(error) {
                            console.log('Error accessing webcam: ', error);
                        });
                } else {
                    console.log('Webcam access is not supported by your browser.');
                }
            });
            
            btnCheck.addEventListener("click", function(){
                containerVideo.style.display = "none";
                studentCards.style.display = "flex";
                if (videoElement.srcObject) {
                    const stream = videoElement.srcObject;
                    const tracks = stream.getTracks();

                    tracks.forEach(track => track.stop());
                    videoElement.srcObject = null;
                }
            })
    </script>
    <script>
        
    </script>

    <script src="javascript/toggle.js"></script>
</body>
</html>
<?php
    } else {
        echo "Không có sinh viên nào trong lớp hoặc có lỗi trong truy vấn.";
    }
?>