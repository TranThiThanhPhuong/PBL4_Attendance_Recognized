<?php
   require_once '../php/database/connDB.php'; // Kết nối cơ sở dữ liệu

    header("Content-Type: application/json");

    $capdoId = $_GET['capdo_id'];

    $query = "SELECT TenLop FROM lop WHERE ID_CapDo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $capdoId);
    $stmt->execute();
    $result = $stmt->get_result();

    $classes = [];
    while ($row = $result->fetch_assoc()) {
        $classes[] = ["name" => $row["TenLop"]];
    }

    echo json_encode($classes);
    $stmt->close();
    $conn->close();
?>
