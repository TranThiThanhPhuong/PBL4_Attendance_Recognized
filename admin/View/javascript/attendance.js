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
                            checkButton.innerHTML = '<i id="icon" class="icon las la-check"></i>';
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