<?php
    require_once '../Model/M_Student.php';

    class C_Student {
        public function Students() {
            if (isset($_GET['idhs'])){
                $model = new M_Student();
                $student = $model->getStudentDetail($_GET['idhs']);
                require_once '../View/StudentDetail.html';
            }
            else if (isset($_POST["insert"])){
                $id = $_REQUEST['id'];
                $name = $_REQUEST['name'];
                $age = $_REQUEST['age'];
                $university = $_REQUEST['university'];
                $modelStudent = new M_Student();
                $modelStudent->insertStudent($id, $name, $age, $university);
                header("Locaion: C_Student.php");
            }
            else if (isset($_GET["mod1"])){
                include_once '../View/InsertStudent.php';
            }
            else {
                $model = new M_Student();
                $studentList = $model->getAllStudents();
                require_once '../View/StudentList.php';
            }

            

            
        }
    }
    $C_Student = new C_Student();
    $C_Student->Students();
?>