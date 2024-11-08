<?php
    class ScheduledModel {
        private $connection;

        public function __construct($connentionDB) {
            $this->connection = $connentionDB;
        }
        
        public function getAllTime() {
            $query =  "SELECT * FROM giohoc";
            $result = $this->connection->query($query);
            if (!$result) {
                throw new Exception("Query failed: " . $this->connection->error);
            }
            return $result; 
        }

        public function getAllWeek() {
            $query =  "SELECT * FROM tuanhoc";
            $result = $this->connection->query($query);
            if (!$result) {
                throw new Exception("Query failed: " . $this->connection->error);
            }
            return $result; 
        }
    }
?>