<?php
header('Content-Type: application/json');
include("../model/database.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $description = $_POST['description'];

    $task = new Task($description);

    $db = new Database();
    if (($id = $db->insertTask($task)) > -1) {
        $task->setId($id);
        http_response_code(201);
        echo $db->getJsonResponse($task);
    } else {
        http_response_code(422);
        echo json_encode(
            array(
                "error" => "Failed to add the task."
            )
        );
    }
}
?>