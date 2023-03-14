<?php
// important header
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// include external script
include_once "../../../config/Database.php";
include_once "../../../model/WorkflowStep.php";

$database = new Database();
$db = $database->connect();

$workflowSteps = new WorkflowStep($db);
$workflowSteps->step_id = isset($_GET['id']) ? $_GET['id'] : die();
$result = $workflowSteps->delete_single_step();
if($result) {
    echo json_encode(
        array("message" => "Step is deleted")
    );
}
else {
    echo json_encode(
        array("message" => "Failed to delete")
    );
}
?>