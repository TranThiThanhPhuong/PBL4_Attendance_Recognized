<?php
    class AdminModel {
        private $connection;

        public function __construct($connectionDB) {
            $this->connection = $connectionDB;
        }

        public function showAdmin() {
            $query = "SELECT username FROM admin";
            $result = $this->connection->query($query);
            if (!$result) {
                throw new Exception("Query failed: " . $this->connection->error);
            }
            return $result;
        }
    }
?>
