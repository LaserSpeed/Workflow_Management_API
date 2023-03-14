<?php
class WorkflowStep
{
    private $conn;
    private $table = "workflow_step";
    private $parent_table = "workflow";

    public $step_id;
    public $workflow_id;
    public $workflow_name;
    public $step_name;
    public $step_order;
    public $step_type;
    public $step_handleby;

    // constructor to connect with the database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // get all steps
    public function get_workflow_step()
    {
        $sql = "
        SELECT s.step_id, s.workflow_id, w.workflow_name, s.step_order, s.step_name, s.step_type, s.step_handleby FROM ".$this->table." s LEFT JOIN workflow w ON s.workflow_id = w.workflow_id ORDER BY s.workflow_id ASC, s.step_order ASC;
        ";

        // prepare the sql
        $stmt = $this->conn->prepare($sql);

        // execute and return the stmt
        $stmt->execute();
        return $stmt;
    }

    // get single step
    public function get_single_workflow_step() {
        $sql = "
        SELECT w.workflow_name, s.step_name, s.step_order, s.step_type, s.step_handleby FROM ".$this->table." s LEFT JOIN `workflow` w ON s.workflow_id = w.workflow_id WHERE s.step_id = :step_id;
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":step_id", $this->step_id);
        $stmt->execute();

        // get the row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->workflow_name = $row['workflow_name'];
            $this->step_name = $row['step_name'];
            $this->step_order = $row['step_order'];
            $this->step_type = $row['step_type'];
            $this->step_handleby = $row['step_handleby'];
        }
        return $stmt;
    }

    // create workflow
    public function create_workflow_step()
    {
        $sql = "
            INSERT INTO " . $this->table . " SET step_name = :step_name, workflow_id = :workflow_id, step_order = :step_order, step_type = :step_type, step_handleby = :step_handleby
        ";

        $stmt = $this->conn->prepare($sql);

        // clean data
        $this->workflow_id = htmlspecialchars(strip_tags($this->workflow_id));
        $this->step_name = htmlspecialchars(strip_tags($this->step_name));
        $this->step_order = htmlspecialchars(strip_tags($this->step_order));
        $this->step_type = htmlspecialchars(strip_tags($this->step_type));
        $this->step_handleby = htmlspecialchars(strip_tags($this->step_handleby));

        // bind data
        $stmt->bindParam("workflow_id", $this->workflow_id);
        $stmt->bindParam("step_name", $this->step_name);
        $stmt->bindParam("step_order", $this->step_order);
        $stmt->bindParam("step_type", $this->step_type);
        $stmt->bindParam("step_handleby", $this->step_handleby);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s", $stmt->error);
        return false;
    }

    // delete all steps as well as the workflow for the steps
    public function delete_step_and_workflow() {
        $sql = "
        DELETE ".$this->table.".*, ".$this->parent_table.".* FROM ".$this->table." JOIN ".$this->parent_table." ON ".$this->table.".workflow_id = ".$this->parent_table.".workflow_id;
        ";
        $result = $this->conn->prepare($sql);
        if($result->execute()) 
            return true;
        return false;
    }

    // delete the all steps from the table
    public function delete_all_steps() {
        $sql = "
        DELETE FROM ".$this->table." WHERE 1
        ";
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()) 
            return $stmt;
        return false;
    }

    // delete the all steps from the table
    public function delete_single_steps() {
        $sql = "
        DELETE FROM ".$this->table." WHERE step_id = :step_id
        ";
        $result = $this->conn->prepare($sql);
        $result->bindParam(":step_id", $this->step_id);
        if($result->execute()) 
            return true;
        return false;
    }

    // delete single step
    public function delete_single_step() {
        $select_sql = "
            SELECT * FROM ".$this->table." WHERE step_id = :step_id
        ";

        $select_stmt = $this->conn->prepare($select_sql);
        $select_stmt->bindParam("step_id", $this->step_id);
        if($select_stmt->execute()) {
            while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $this->workflow_id = $row['workflow_id'];
                $this->step_order = $row['step_order'];

                // delete the steps
                $delete_sql = "
                    DELETE FROM ".$this->table." WHERE workflow_id = :workflow_id AND step_id = :step_id;
                ";
                $delete_stmt = $this->conn->prepare($delete_sql);
                $delete_stmt->bindParam("workflow_id", $this->workflow_id);
                $delete_stmt->bindParam("step_id", $this->step_id);
                
                if($delete_stmt->execute()) {
                    // update the steps after deleted
                    $update_sql = "
                    UPDATE ".$this->table." SET `step_order` = `step_order` - 1 WHERE workflow_id = :workflow_id AND step_order > :step_order
                    ";
                    // UPDATE `workflow_step` SET `step_order`= 3 - 1 WHERE `step_id` = "19";
                    $update_stmt = $this->conn->prepare($update_sql);
                    $update_stmt->bindParam("workflow_id", $this->workflow_id);
                    $update_stmt->bindParam("step_order", $this->step_order);
                    if($update_stmt->execute()) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }
        else {
            return false;
        }
    }
}
