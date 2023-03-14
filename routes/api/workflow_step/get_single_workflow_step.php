<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once "../../../config/Database.php";
include_once "../../../model/WorkflowStep.php";

$database = new Database();
$db = $database->connect();

$workflow_step = new WorkflowStep($db);
$workflow_step->step_id = isset($_GET['id']) ? $_GET['id'] : die();
$result = $workflow_step->get_single_workflow_step();
$num_of_row = $result->rowCount();
if($num_of_row == 0) {
    echo json_encode(
        array("Message" => "No workflow step found")
    );
}
else {
    $step_array = array (
        "step_id" => $workflow_step->step_id,
        "workflow_name" => $workflow_step->workflow_name,
        "step_name" => $workflow_step->step_name,
        "step_order" => $workflow_step->step_order,
        "step_type" => $workflow_step->step_type,
        "step_handleby" => $workflow_step->step_handleby
    );
    print_r(json_encode($step_array));
}