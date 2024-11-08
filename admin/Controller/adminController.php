<?php
    require_once '../Model/AdminModel.php';
    require_once '../ConnDB/connDB.php';

    class AdminController {
        private $model;

        public function __construct($connectionDB) {
            $this->model = new AdminModel($connectionDB);
        }

        public function showAdmin() {
            try {
                return $this->model->showAdmin();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
                return null;
            }
        }
    }
?>
