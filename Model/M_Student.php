<?php
    require_once 'E_Student.php';

    class M_Student {
        public function __construct() {
        }

        public function getAllStudents() {
            $link = mysqli_connect('localhost', 'root', "") or die ("Khong the ket noi");
            mysqli_select_db($link, "dbstudents");
            $query = "SELECT * FROM tbstudent";
            $result = mysqli_query($link, $query);
            $i = 0;
            $studentList = [];
            while ($row = mysqli_fetch_array($result)){
                $id = $row['id'];
                $name=  $row['name'];
                $age = $row['age'];
                $university = $row['university'];
                while ($i != $id) $i++;
                $studentList[$i++] = new E_Student($id, $name, $age, $university);
            }
            return $studentList;
        }

        public function getStudentDetail($id) {
            $allStudents = $this->getAllStudents();
            return $allStudents[$id];
        }

        public function insertStudent($id, $name, $age, $university) {
            $link = mysqli_connect('localhost', 'root', "") or die ("Khong the ket noi");
            mysqli_select_db($link, "dbstudents");
            $query = "INSERT INTO tbstudent VALUES($id, '$name', $age, '$university')";
            $result = mysqli_query($link, $query);
            mysqli_close($link);
        }

        public function updateStudent($id, $name, $age, $university) {
            $link = mysqli_connect('localhost', 'root', "") or die ("Khong the ket noi");
            mysqli_select_db($link, "dbstudents");
            // $query = 
        }
    }
?>