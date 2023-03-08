<?php 
    class Workflow {
        private $conn;
        private $table = "workflow";

        public $workflow_name;
        public $workflow_description;

        // constructor to connect with databse
        public function __construct($db) {
            $this->conn = $db;
        }

        // get workflow
        public function get_workflow() {
            $sql = "
                SELECT * FROM ".$this->table."
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }

        // create workflow
        public function create_workflow() {
            $sql = "
                INSERT INTO ".$this->table." SET workflow_name = :workflow_name, workflow_description = :workflow_description
            ";

            $stmt = $this->conn->prepare($sql);

            // clean data
            $this->workflow_name = htmlspecialchars(strip_tags($this->workflow_name));
            $this->workflow_description = htmlspecialchars(strip_tags($this->workflow_description));

            // bind data
            $stmt->bindParam("workflow_name", $this->workflow_name);
            $stmt->bindParam("workflow_description", $this->workflow_description);

            if($stmt->execute()) {
                return true;
            }
            printf("Error: %s", $stmt->error);
            return false;
        }
    }
?>