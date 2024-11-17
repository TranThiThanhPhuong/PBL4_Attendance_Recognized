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

    <style>
        .studentCard #check {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        position: absolute;
        top: -15px;
        right: -10px;
        background-color: var(--primary--color);
        align-items: center;
        display: flex;
        justify-content: center;
        border: 1px solid #fff;
        }

        #check i {
        font-size: 18px;
        color: var(--primary--color-light);
        }

        #check.active {
            background-color: #ff5656;
            color: black;
        }
    </style>
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>

    <section class="home">
        <section class="user-list">
            <?php require_once 'includes/adminView.php'; ?>

            <div class="checkcam">
                <div class="containerVideo">
                    <img id="cameraFeed" alt="Camera Feed" style="max-width: 100%; height: auto;"/>
                    <h4 id="detectedName">ID: Unknown</h4>
                </div>
                <div class="list-button">
                    <button class="btnCheck">Điểm danh</button>
                </div>
                <div class="studentCards" style="display: none">
                    <?php
                        $stt = 0;
                        foreach ($students as $row) {
                            $stt++;
                            echo '<div class="studentCard">';
                                echo '<img src="image/logostudent.png" alt="">';
                                echo '<div class="info">';
                                    echo '<small>'.$stt.'</small>';
                                    echo '<p id="idStudent">ID: ' . htmlspecialchars($row["ID"]) .'</p>';
                                    echo '<h5>' . htmlspecialchars($row["Ten"]) . '</h5>';
                                echo '</div>';
                                echo ' <button id="check"><i class=" icon las la-check"></i></button>';
                            echo '</div>';
                        }
                    ?>
                </div>

            </div>
            
        </section>

    </section>

    <script>
        const detectedIDs = [],
            detectedNameElement = document.getElementById("detectedName"),
            containerVideo = document.querySelector(".containerVideo");
            icon =document.querySelector(".icon");

        const ws = new WebSocket("ws://192.168.4.48:8765"); // Đổi IP theo Raspberry Pi

        ws.onopen = () => {
            console.log("Kết nối WebSocket đã mở");
        };

        ws.onmessage = (event) => {
            if (typeof event.data === "string") {
                if (event.data === "stopped") {
                    alert("Đã dừng kết nối WebSocket");
                    containerVideo.style.display = "none";
                } else {
                    const detectedID = event.data.trim(); // Lấy ID từ dữ liệu nhận được
                    detectedNameElement.innerText = "ID: " + detectedID;

                    if (!detectedIDs.includes(detectedID)) {
                        detectedIDs.push(detectedID);
                        const studentCards = document.querySelectorAll(".studentCard");
                        studentCards.forEach(card => {
                            const idElement = card.querySelector("#idStudent");
                            const checkButton = card.querySelector("#check");

                            // Nếu ID khớp, đổi màu nút checkButton
                            if (!idElement.innerText.includes(detectedID)) {
                                checkButton.classList.add("active"); 
                                icon.classList.add("la-times");
                            }
                            else {
                                checkButton.classList.remove("active");
                                icon.classList.remove("la-times");
                            }
                        });
                    }
                }
            } else {
                // Xử lý dữ liệu dạng hình ảnh từ WebSocket
                const blob = new Blob([event.data], { type: "image/jpeg" });
                const url = URL.createObjectURL(blob);
                const imgElement = document.getElementById("cameraFeed");
                imgElement.src = url;
                imgElement.onload = () => {
                    console.log("Frame loaded");
                };
            }
        };

        ws.onclose = () => {
            console.log("Kết nối WebSocket đã đóng");
        };

        ws.onerror = (error) => {
            alert("Lỗi WebSocket: " + error.message);
        };

        document.getElementById("endButton").onclick = () => {
            ws.send("end");
        };
    </script> -->

    
    <script>
        const btnCheck = document.querySelector(".btnCheck");
        const  studentCards =document.querySelector(".studentCards");

        btnCheck.addEventListener("click", function(event){
            event.preventDefault();
            studentCards.style.display = "flex";
        })
    </script>

    <!-- <script>
        const btnCam = document.querySelector(".btnCam"),
            // btnCheck = document.querySelector(".btnCheck"),
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
            
            // btnCheck.addEventListener("click", function(){
            //     containerVideo.style.display = "none";
            //     studentCards.style.display = "flex";
            //     if (videoElement.srcObject) {
            //         const stream = videoElement.srcObject;
            //         const tracks = stream.getTracks();

            //         tracks.forEach(track => track.stop());
            //         videoElement.srcObject = null;
            //     }
            // })
    </script> -->

    <script src="javascript/toggle.js"></script>
</body>
</html>
<?php
    } else {
        echo "Không có sinh viên nào trong lớp hoặc có lỗi trong truy vấn.";
    }
?>