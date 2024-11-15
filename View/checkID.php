<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idnv = $_POST['idnv'];
        $link = mysqli_connect('localhost', 'root', "") or die ("Khong the ket noi");
        mysqli_select_db($link, "dbstudents");
        $query = "SELECT * FROM tbstudent WHERE id='$idnv'";
        $result = mysqli_query($link, $query);
        if ($result->num_rows > 0) {
            echo 'tontai'; 
        } else {
            echo 'chuatontai'; 
        }
    }
?>
