<?php
class WorkflowStep
{
    private $conn;
    private $table = "workflow_step";

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
        SELECT s.step_id, w.workflow_name, s.step_order, s.step_name, s.step_type, s.step_handleby FROM ".$this->table." s LEFT JOIN workflow w ON s.workflow_id = w.workflow_id;
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
}
