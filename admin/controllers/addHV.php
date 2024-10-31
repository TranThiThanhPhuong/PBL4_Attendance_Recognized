<?php
    require_once '../php/database/connDB.php'; 

    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    if (
        isset($data['id']) && isset($data['name']) && isset($data['gender']) &&
        isset($data['dateOfBirth']) && isset($data['email']) &&
        isset($data['address']) && isset($data['capdo']) && isset($data['lop'])
    ) {
        // Lấy dữ liệu và escape để tránh SQL Injection
        $id = $conn->real_escape_string($data['id']);
        $name = $conn->real_escape_string($data['name']);
        $gender = $conn->real_escape_string($data['gender']);
        $dateOfBirth = $conn->real_escape_string($data['dateOfBirth']);
        $email = $conn->real_escape_string($data['email']);
        $address = $conn->real_escape_string($data['address']);
        $capdo = $conn->real_escape_string($data['capdo']);
        $lop = $conn->real_escape_string($data['lop']);
        
        $query = "INSERT INTO hocvien (ID, Ten, GioiTinh, NgaySinh, Email, DiaChi, ID_CapDo, ID_Lop) 
                VALUES ('$id', '$name', '$gender', '$dateOfBirth', '$email', '$address', '$capdo', '$lop')";

        if ($conn->query($query) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Dữ liệu không đầy đủ']);
    }

    $conn->close();
?>
