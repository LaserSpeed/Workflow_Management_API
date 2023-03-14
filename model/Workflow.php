<?php 
    // User model
    class Workflow {
        private $conn;
        private $table = "workflow";

        public $workflow_id;
        public $workflow_name;
        public $workflow_description;
        public $created_at;

        // Controller 
        // constructor to connect with databse
        public function __construct($db) {
            $this->conn = $db;
        }

        // get all workflow
        public function get_workflow() {
            $sql = "
                SELECT * FROM ".$this->table."
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }

        // get single workflow
        public function get_single_workflow() {
            $sql = "
                SELECT * FROM ".$this->table." WHERE workflow_id = :workflow_id
            ";
            
            //prepare, bind the data and execute
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam('workflow_id', $this->workflow_id);
            $stmt->execute();

            // get the row and set the values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row) {
                $this->workflow_name = $row['workflow_name'];
                $this->workflow_description = $row['workflow_description'];
                $this->created_at = $row['created_at'];
            }

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

        // delete all workflow
        public function delete_workflow() {
            $sql = "
                DELETE FROM `workflow_step` WHERE 1
            ";
            $stmt = $this->conn->prepare($sql);
            // $stmt->bindParam("workflow_id", $this->workflow_id);
            if($stmt->execute()) {
                $sql1 = "
                DELETE FROM ".$this->table." WHERE 1
                ";
                $stmt1 = $this->conn->prepare($sql1);
                if($stmt1->execute())
                    return true;
                
                return false;
            }
            return false;
        } 
    }
?>