<?php
// important header
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// include external script
include_once "../../../config/Database.php";
include_once "../../../model/WorkflowStep.php";

$database = new Database();
$db = $database->connect();

$workflowSteps = new WorkflowStep($db);
$stmt = $workflowSteps->get_workflow_step();
$no_of_records = $stmt->rowCount();
if($no_of_records > 0) {
    $step_array = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = array(
            "step_id" => $step_id,
            "workflow_name" => $workflow_name,
            "step_order" => $step_order,
            "step_name" => $step_name,
            "step_type" => $step_type,
            "step_handleby" => $step_handleby,
        );

        array_push($step_array, $item);
    }

    echo json_encode($step_array);
} else {
    echo json_encode(
        array("Message" => "No steps found")
    );
}