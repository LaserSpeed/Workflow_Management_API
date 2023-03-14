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
$result = $workflowSteps->delete_all_steps();
$total_deleted_row = $result->rowCount();
if($result) {
    if($total_deleted_row > 0) {
        echo json_encode(
            array("Message" => "".$total_deleted_row." step(s) are deleted")
        );
    } else {
        echo json_encode(
            array("Message" => "No steps to be deleted")
        );
    }
}
else {
    echo json_encode(
        array("message" => "Failed to delete")
    );
}
?>