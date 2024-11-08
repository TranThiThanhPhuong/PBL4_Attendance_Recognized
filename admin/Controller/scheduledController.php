<?php
    require_once '../Model/scheduledModel.php';
    require_once '../ConnDB/connDB.php';

    class ScheduledController {
        private $model ;

        public function __construct() {
            global $connectionDB;
            $this->model = new ScheduledModel($connectionDB);
        }
        public function getAllTime() {
            try {
                $scheduled = $this->model->getAllTime();
                return $scheduled;
            }
            catch(Exception $e) {
                echo "Error: ",  $e;
                return null;
            }
        }
    }

    
?>