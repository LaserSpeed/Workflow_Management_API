<?php
    // important header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // include external script
    include_once "../../../config/Database.php";
    include_once "../../../model/Workflow.php";

    // create instance of the Database class
    $database = new Database();
    $db = $database->connect();

    // create instance of the Workflow class
    $workflow = new Workflow($db);
    $result = $workflow->get_workflow();
    $num_of_records = $result->rowCount();

    if($num_of_records > 0) {
        $workflow_array = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $items = array(
                "workflow_id" => $workflow_id,
                "workflow_title" => $workflow_name,
                "workflow_description" => $workflow_description,
                "created_at" => $created_at
            );

            // push data to the array
            array_push($workflow_array, $items);

        }
        // convert to json
        echo json_encode($workflow_array);
    }
    else {
        echo json_encode(
            array("Message" => "No workflow found")
        );
    }
?>