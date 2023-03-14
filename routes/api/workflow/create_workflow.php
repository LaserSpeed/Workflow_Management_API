<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../../config/Database.php';
include_once '../../../model/Workflow.php';

$database = new Database();
$db = $database->connect();

$workflow = new Workflow($db);
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// assign the values to the public data member which are present in the workflow class
$workflow->workflow_name = $data->workflow_name;
$workflow->workflow_description = $data->workflow_description;

if($workflow->create_workflow()) {
    echo json_encode(
        array("Message" => "Workflow created")
    );
}
else {
    echo json_encode(
        array("Error" => "Workflow not created")
    );
}

?>