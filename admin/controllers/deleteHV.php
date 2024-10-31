<?php
    require_once '../php/database/connDB.php'; 

    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $id = $conn->real_escape_string($data['id']);
        $query = "DELETE FROM hocvien WHERE ID = '$id'";
        if ($conn->query($query) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID không hợp lệ']);
    }

    $conn->close();
?>
