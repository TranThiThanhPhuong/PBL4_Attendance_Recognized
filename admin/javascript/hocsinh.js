const btninfo = document.querySelectorAll(".btninfo"),
            xemthongtin = document.querySelector(".xemthongtin"),
            suathongtin = document.querySelector(".suathongtin"),
            themhocvien =document.querySelector(".themhocvien"),
            mainCard = document.querySelector(".main-card"),
            attendanceList = document.querySelector(".attendance-list"),
            user = document.querySelector(".user"),

            btnedit = document.querySelectorAll(".btnedit"),
            btntrash = document.querySelectorAll(".btntrash"),
            btnClose = document.querySelector(".btnClose"),
            btnClose1 = document.querySelector(".btnClose1"),
            btnClose2 = document.querySelector(".btnClose2"),
            btnUpdate = document.querySelector(".btnUpdate"),
            btnSave = document.querySelector(".btnSave"),
            btnNew =document.querySelector(".btnNew"),
            btnView =document.querySelector(".btnView"),

            confirmBox = document.getElementById("confirmBox"),
            btnYes = document.getElementById("btnYes"),
            btnNo = document.getElementById("btnNo");

        btnView.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); 
                const capDoId = this.getAttribute('idcapdo');
                fetch('../controllers/getCapdo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ capDoId: capDoId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hiển thị danh sách học sinh
                        const studentList = document.querySelector('.student-list');
                        studentList.innerHTML = data.students.map(student => `
                            <div class="student-card">
                                <h4>${student.name}</h4>
                                <p>ID: ${student.id}</p>
                                <p>Email: ${student.email}</p>
                                <p>Địa chỉ: ${student.address}</p>
                            </div>
                        `).join('');
                    } else {
                        alert("Không có học sinh nào cho cấp độ này.");
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                });
            });
        });
        btnNew.addEventListener("click", function () {
            mainCard.classList.add("dimmed");
            attendanceList.classList.add("dimmed");
            user.classList.add("dimmed");
            themhocvien.style.display = "block";  
        })
        
        btninfo.forEach(function (button) {
            button.addEventListener("click", function () {
                mainCard.classList.add("dimmed");
                attendanceList.classList.add("dimmed");
                user.classList.add("dimmed");
                xemthongtin.style.display = "block";  

                const id = button.getAttribute("data-idxembtn");
                getStudentInfo(id);
            });
        });

        btnedit.forEach(function (button) {
            button.addEventListener("click", function () {
                mainCard.classList.add("dimmed");
                attendanceList.classList.add("dimmed");
                user.classList.add("dimmed");
                suathongtin.style.display = "block";  

                const id = button.getAttribute("data-idsuabtn");
                editStudentInfo(id);
            });
        });

        btnClose.addEventListener("click", function () {
            xemthongtin.style.display = "none";
            mainCard.classList.remove("dimmed");
            attendanceList.classList.remove("dimmed"); 
            user.classList.remove("dimmed"); 
        });

        btnClose1.addEventListener("click", function () {
            suathongtin.style.display = "none";
            mainCard.classList.remove("dimmed");
            attendanceList.classList.remove("dimmed"); 
            user.classList.remove("dimmed"); 
        });

        btnClose2.addEventListener("click", function () {
            themhocvien.style.display = "none";
            mainCard.classList.remove("dimmed");
            attendanceList.classList.remove("dimmed"); 
            user.classList.remove("dimmed"); 
        });

        btnUpdate.addEventListener("click", function () {
            suathongtin.style.display = "none";
            mainCard.classList.remove("dimmed");
            attendanceList.classList.remove("dimmed"); 
            user.classList.remove("dimmed"); 
        });

        btnSave.addEventListener("click", function (event) {
            themhocvien.style.display = "none";
            mainCard.classList.remove("dimmed");
            attendanceList.classList.remove("dimmed"); 
            user.classList.remove("dimmed"); 

            event.preventDefault(); 
            const id = document.getElementById('idthem').value;
            const name = document.getElementById('tenthem').value;
            const gender = document.querySelector('input[name="gender"]:checked') ? document.querySelector('input[name="gender"]:checked').value : '';
            const dateOfBirth = document.getElementById('datethem').value;
            const email = document.getElementById('emailthem').value;
            const address = document.getElementById('diachithem').value;
            const capdo = document.getElementById('capdo').value;
            const lop = document.getElementById('lop').value;

            if (!id || !name || !gender || !dateOfBirth || !email || !address || !capdo || !lop) {
                alert("Vui lòng nhập đầy đủ thông tin.");
                return;
            }
            fetch('../controllers/addHV.php.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    name: name,
                    gender: gender,
                    dateOfBirth: dateOfBirth,
                    email: email,
                    address: address,
                    capdo: capdo,
                    lop: lop
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Học viên đã được lưu thành công.");
                    // Cập nhật lại danh sách học viên hoặc reset form nếu cần
                    document.querySelector('.main-info').reset();
                } else {
                    alert("Có lỗi xảy ra khi lưu học viên.");
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
            });
        });

        btntrash.forEach(function (button) {
            button.addEventListener("click", function () {
                mainCard.classList.add("dimmed");
                attendanceList.classList.add("dimmed");
                user.classList.add("dimmed");
                confirmBox.classList.remove("hidden");

                const id = button.getAttribute("data-idxoabtn");
                btnYes.setAttribute("data-idHV", id);
            });
        });

        btnNo.addEventListener("click", function () {
            mainCard.classList.remove("dimmed");
            attendanceList.classList.remove("dimmed"); 
            user.classList.remove("dimmed"); 
            confirmBox.classList.add("hidden");
        });

        btnYes.addEventListener("click", function () {
            const id = btnYes.getAttribute("data-idHV");
            fetch('../controllers/deleteHV.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`tr[data-id="${id}"]`).remove();
                } else {
                    alert('Có lỗi xảy ra khi xóa học viên.');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
            });

            mainCard.classList.remove("dimmed");
            attendanceList.classList.remove("dimmed"); 
            user.classList.remove("dimmed"); 
            confirmBox.classList.add("hidden");
        });

function getCapdo(id) {
    fetch(`../controllers/getCapdo.php?id=${id}`)

        .then(response => response.json())
        .then(data => {
            document.getElementById('idxem').value = data.ID;
            document.getElementById('tenxem').value = data.Ten;
            document.getElementById('datexem').value = data.NgaySinh;
            document.getElementById('emailxem').value = data.Email;
            document.getElementById('diachixem').value = data.DiaChi;
            

            if (data.GioiTinh === 'Nam') {
                document.getElementById('genderxemnam').checked = true;
            } else {
                document.getElementById('genderxemnu').checked = true;
            }

            document.querySelector('.img-face img').src = data.HinhAnh || 'default-image.png'; 
        })
        .catch(error => console.error('Error fetching student info:', error));
}

function getStudentInfo(id) {
    fetch(`../controllers/getInfoHV.php?id=${id}`)

        .then(response => response.json())
        .then(data => {
            document.getElementById('idxem').value = data.ID;
            document.getElementById('tenxem').value = data.Ten;
            document.getElementById('datexem').value = data.NgaySinh;
            document.getElementById('emailxem').value = data.Email;
            document.getElementById('diachixem').value = data.DiaChi;
            

            if (data.GioiTinh === 'Nam') {
                document.getElementById('genderxemnam').checked = true;
            } else {
                document.getElementById('genderxemnu').checked = true;
            }

            document.querySelector('.img-face img').src = data.HinhAnh || 'default-image.png'; 
        })
        .catch(error => console.error('Error fetching student info:', error));
}

document.getElementById("editForm").addEventListener("submit", function () {
    document.getElementById("idsua").disabled = false;
});

function editStudentInfo(id) {
    fetch(`../controllers/editInfoHV.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('idsua').value = data.ID;
            document.getElementById('tensua').value = data.Ten;
            document.getElementById('datesua').value = data.NgaySinh;
            document.getElementById('emailsua').value = data.Email;
            document.getElementById('diachisua').value = data.DiaChi;

            if (data.GioiTinh === 'Nam') {
                document.getElementById('gendersuanam').checked = true;
            } else {
                document.getElementById('gendersuanu').checked = true;
            }

            document.querySelector('.img-face img').src = data.HinhAnh || 'default-image.png';
        })
        .catch(error => console.error('Error fetching student info:', error));
}

function selectLop() {

    const capdoSelect = document.getElementById("capdo");
    const selectedCapdoId = capdoSelect.options[capdoSelect.selectedIndex].getAttribute("data-idcapdo");

    fetch('../controllers/selectLop.php?capdo_id=' + selectedCapdoId)
        .then(response => response.json())
        .then(data => {
            const lopSelect = document.getElementById("lop");
            lopSelect.innerHTML = "";

            data.forEach(classOption => {
                const option = document.createElement("option");
                option.value = classOption.id;
                option.textContent = classOption.name;
                lopSelect.appendChild(option);
            });
        })
        .catch(error => console.error("Error fetching classes:", error));
}
