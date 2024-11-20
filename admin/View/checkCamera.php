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
            background-color: var(---primary--color-light);
            align-items: center;
            display: flex;
            justify-content: center;
            border: 2px double var(--primary--color);
        }

        #check i {
            font-size: 18px;
            color: black;
        }

        #check.active {
            background-color: var(--primary--color) !important;
            border: 2px double white;
        }

        #check.active i {
            font-size: 18px;
            color: white;
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
                    <h4 id="detectedTime">Time: </h4>
                </div>
                <div class="list-button">
                    <button class="btnshowclasses">Điểm danh</button>
                </div>
                <div class="studentCards" style="display: none">
                    <?php
                        $stt = 0;
                        foreach ($students as $row) {
                            $stt++;
                            echo '<div class="studentCard">';
                                echo '<img src="image/logostudent.png" alt="">';
                                echo '<div class="info">';
                                    echo '<small>STT: '.$stt.'</small>';
                                    echo '<p id="idStudent">ID: ' . htmlspecialchars($row["ID"]) .'</p>';
                                    echo '<h5>' . htmlspecialchars($row["Ten"]) . '</h5>';
                                    // echo '<h5>' . htmlspecialchars($row["Email"]) . '</h5>';
                                echo '</div>';
                                echo ' <button id="check"><i id="icon" class="icon las la-times"></i></button>';
                            echo '</div>';
                        }
                    ?>
                    <form action="saveDiscord.php" method="post" id="attendanceForm">
                        <input type="hidden" name="studentsPresent" id="studentsPresent">
                        <input type="hidden" name="studentsAbsent" id="studentsAbsent">
                        <div class="list-button">
                            <button class="btnsave">Save Discord Attendance</button>
                        </div>
                    </form>
                </div>

            </div>
            
        </section>

    </section>

    <script>
        function getCurrentTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Tháng từ 0-11
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
        const detectedIDs = [],
            detectedNameElement = document.getElementById("detectedName"),
            detectedTimeElement = document.getElementById("detectedTime"),
            containerVideo = document.querySelector(".containerVideo");
            icon =document.getElementById("icon");

        const ws = new WebSocket("ws://192.168.4.48:8765"); // Đổi IP theo Raspberry Pi

        ws.onopen = () => {
            console.log("Kết nối WebSocket đã mở");
        };

        const studentsPresentIDs = [];
        const studentsAbsentIDs = [];
        ws.onmessage = (event) => {
            if (typeof event.data === "string") {
                if (event.data === "stopped") {
                    alert("Đã dừng kết nối WebSocket");
                    containerVideo.style.display = "none";
                } else {
                    const detectedTime = getCurrentTime();
                    const detectedID = event.data.trim(); // Lấy ID từ dữ liệu nhận được
                    
                    detectedNameElement.innerText = "ID: " + detectedID;
                    detectedTimeElement.innerText = "Time: " + detectedTime;

                    if (!detectedIDs.includes(detectedID)) {
                        detectedIDs.push(detectedID);
                        const studentCards = document.querySelectorAll(".studentCard");
                        studentCards.forEach(card => {
                            const idElement = card.querySelector("#idStudent");
                            const checkButton = card.querySelector("#check");

                            // Nếu ID khớp, đổi màu nút checkButton
                            const studentID = idElement.innerText.split(": ")[1];
                            if (studentID === detectedID) {
                                if (!studentsPresentIDs.some(student => student.id === studentID)) {
                                    studentsPresentIDs.push({ id: studentID, time: detectedTime });
                                    checkButton.classList.add("active"); 
                                    icon.classList.remove("la-times");
                                    icon.classList.add("la-check");
                                }
                            }
                            else {
                                if (!studentsAbsentIDs.some(student => student.id === studentID) && 
                                    !studentsPresentIDs.some(student => student.id === studentID)) {
                                    studentsAbsentIDs.push({ id: studentID });
                                }
                            }
                        });
                        const btnsave = document.querySelector(".btnsave");
                        btnsave.addEventListener("click", (event) => {
                            event.preventDefault();
                            document.getElementById("studentsPresent").value = JSON.stringify(studentsPresentIDs);
                            document.getElementById("studentsAbsent").value = JSON.stringify(studentsAbsentIDs);
                            document.getElementById("attendanceForm").submit();
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
    </script> 

    <script>
        const btnshowclasses = document.querySelector(".btnshowclasses");
        const  studentCards =document.querySelector(".studentCards");

        btnshowclasses.addEventListener("click", function(event){
            event.preventDefault();
            studentCards.style.display = "flex";
            studentCards.style.flexWrap = "wrap";
        })
    </script>

    <script src="javascript/toggle.js"></script>
</body>
</html>
<?php
    } else {
        echo "Không có sinh viên nào trong lớp hoặc có lỗi trong truy vấn.";
    }
?>