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
$result = $workflowSteps->delete_step_and_workflow();
if($result) {
    echo json_encode(
        array("message" => "All steps and workflow are deleted")
    );
}
else {
    echo json_encode(
        array("message" => "Failed to delete")
    );
}
?>