<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once "../../../config/Database.php";
include_once "../../../model/Workflow.php";

// create instance of the Database class
$database = new Database();
$db = $database->connect();

// create instance of the Workflow class
$workflow = new Workflow($db);
// $workflow->workflow_id = isset($_GET['id']) ? $_GET['id'] : die();

$result = $workflow->delete_workflow();
if($result) {
    echo json_encode(
        array("Message" => "All workflow and steps are deleted")
    );
}
else {
    echo json_encode(
        array("Message" => "Falied to delete workflow")
    );
}
?>