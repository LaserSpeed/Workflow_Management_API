<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../../config/Database.php';
include_once '../../../model/WorkflowStep.php';

$database = new Database();
$db = $database->connect();

$workflow = new WorkflowStep($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// assign the values to the public data member which are present in the workflow class
$workflow->workflow_id = $data->workflow_id;
$workflow->step_name = $data->step_name;
$workflow->step_order = $data->step_order;
$workflow->step_type = $data->step_type;
$workflow->step_handleby = $data->step_handleby;

if ($workflow->create_workflow_step()) {
    echo json_encode(
        array("Message" => "Workflow steps created")
    );
} else {
    echo json_encode(
        array("Error" => "Workflow steps not created")
    );
}
