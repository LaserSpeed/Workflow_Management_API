<?php
class Database {
    private $server = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "workflow_management";
    private $conn;

    // create connection
    public function connect() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=".$this->server.";dbname=" .$this->dbname.";charset=UTF8";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error :" . $e->getMessage();
        }

        return $this->conn;
    }
}