<?php
    require_once '../ConnDB/connDB.php';
    require_once '../Controller/studentsController.php';
    $studentsController = new StudentsController($connectionDB);
    if (isset($_GET['ID']) && isset($_GET['id_day'] )) {
        $id_lop = $_GET['ID'];
        $id_day = $_GET['id_day'];
        $students = $studentsController->getAllStudentInClass($id_lop);
        $id_qlbh = $studentsController->getIdQLBH($id_lop, $id_day);
    } else {
        echo "Không tìm thấy ID lớp và ID Ngày.";
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
                        $studentsPresent = [];
                        $studentsAbsent = []; 
                        foreach ($students as $row) {
                            $stt++;
                            echo '<div class="studentCard"  data-id="' . htmlspecialchars($row["ID"]) . '">';
                                echo '<img src="image/logostudent.png" alt="">';
                                echo '<div class="info">';
                                    echo '<small>STT: '.$stt.'</small>';
                                    echo '<p id="idStudent">ID: ' . htmlspecialchars($row["ID"]) .'</p>';
                                    echo '<h5>' . htmlspecialchars($row["Ten"]) . '</h5>';
                                echo '</div>';
                                echo ' <button id="check">
                                        <i id="icon" class="icon las la-times"></i>
                                        </button>';
                            echo '</div>';
                        }
                    ?>
                    <form action="sendMail.php" method="post" id="attendanceForm">
                        <input type="hidden" name="studentsPresent" id="studentsPresent">
                        <input type="hidden" name="studentsAbsent" id="studentsAbsent">
                        <div class="list-button">
                            <button type="submit" class="btnsave">Gửi Mail</button>
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
        const ws = new WebSocket("ws://192.168.4.48:8765"); // Đổi IP theo Raspberry Pi

        let students = <?php echo json_encode($students); ?>;
        let studentsPresent = []; 
        let studentsAbsent = [];  

        ws.onopen = () => {
            console.log("Kết nối WebSocket đã mở");
        };

        ws.onmessage = (event) => {
            if (typeof event.data === "string") {
                if (event.data === "stopped") {
                    alert("Đã dừng kết nối WebSocket");
                } else {
                    document.getElementById("detectedName").innerText = "ID: " + event.data;
                    checkStudentAttendance(event.data);
                }
            } else {
                // Nhận và hiển thị frame video
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
        
        function checkStudentAttendance(id) {
            let studentFound = false;
            students.forEach(student => {
                if (student.ID === id) {
                    studentFound = true;
                    if (!studentsPresent.includes(student)) {
                        studentsPresent.push(student); 
                        const studentCard = document.querySelector(`.studentCard[data-id="${id}"]`);
                        const checkButton = studentCard.querySelector("#check");
                        checkButton.classList.add("active");
                        const icon = checkButton.querySelector("i");
                        icon.classList.remove("las", "la-times");
                        icon.classList.add("las", "la-check"); 
                    }
                }
            });

            if (!studentFound) {
                let absentStudent = { ID: id, status: 'absent' };
                studentsAbsent.push(absentStudent);
            }
            console.log("Học sinh có mặt: ", studentsPresent);
            console.log("Học sinh vắng: ", studentsAbsent);
        }

        // document.getElementById("attendanceForm").onsubmit = function() {
        //     let presentList = JSON.stringify(studentsPresent);
        //     let absentList = JSON.stringify(studentsAbsent);
        // };
        document.getElementById("attendanceForm").onsubmit = function() {
            document.getElementById('studentsPresent').value = JSON.stringify(studentsPresent);
            document.getElementById('studentsAbsent').value = JSON.stringify(studentsAbsent);
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