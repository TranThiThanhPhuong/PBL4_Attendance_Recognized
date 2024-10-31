<?php

    require_once '../php/database/connDB.php'; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $conn->real_escape_string($_POST['id']);
        $ten = $conn->real_escape_string($_POST['ten']);
        $gender = $conn->real_escape_string($_POST['gender']);
        $date = $conn->real_escape_string($_POST['date']);
        $email = $conn->real_escape_string($_POST['email']);
        $address = $conn->real_escape_string($_POST['address']);

        $query = "UPDATE hocvien SET 
                    Ten = '$ten',
                    GioiTinh = '$gender',
                    NgaySinh = '$date',
                    Email = '$email',
                    DiaChi = '$address'
                WHERE ID = '$id'";
        if ($conn->query($query) === TRUE) {
            echo '<script>
                    window.location.href = "../php/hocsinh.php";
                    alert("Sửa thành công");
                </script>';

        } else {
            echo '<script>
                    window.location.href = "../php/hocsinh.php";
                    alert("Sửa không thành công");
                </script>';
        }

        $conn->close();
    }
?>
