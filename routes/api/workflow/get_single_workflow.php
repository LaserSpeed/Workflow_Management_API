<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "../../../config/Database.php";
include_once "../../../model/Workflow.php";

// instance of Database class
$database = new Database();
$db = $database->connect();

// instance of Workflow class
$workflow = new Workflow($db);

// get raw id to fetch single workflow
$workflow->workflow_id = isset($_GET['id']) ? $_GET['id'] : die();

$result = $workflow->get_single_workflow();
$num_of_rows = $result->rowCount();
if($num_of_rows == 0) {
    echo json_encode(
        array("Error" => "No workflow found")
    );
} 
else {
    $workflow_array = array(
        "workflow_id" => $workflow->workflow_id,
        "workflow_name" => $workflow->workflow_name,
        "workflow_description" => $workflow->workflow_description,
        "created_at" => $workflow->created_at
    );

    // make human readable json file
    print_r(json_encode($workflow_array));
}
?>