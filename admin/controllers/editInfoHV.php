<?php
   require_once '../php/database/connDB.php';

    if (isset($_GET['id'])) {
        $id = $conn->real_escape_string($_GET['id']);
        $query = "SELECT * FROM hocvien WHERE ID = '$id';";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row); 
        } else {
            echo json_encode([]);
        }
    } else {
        echo json_encode([]);
    }

