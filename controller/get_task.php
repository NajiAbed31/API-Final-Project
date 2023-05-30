<?php
header('Content-Type: application/json');
include("../model/database.php");

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod == "GET") {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(
            array(
                "error" => "id parameter is not found."
            )
        );
        die();
    }

    $id = $_GET['id'];
    if($id == null){
        http_response_code(400);
        echo json_encode(
            array(
                "error" => "The value of id parameter is missing or invalid."
            )
        );
        die();
    }

    $db = new Database();
    $task = $db->getTask($id);
    if ($task) {
        http_response_code(200);
        echo $db->getJsonResponse($task);
    } else {
        http_response_code(404);
        echo json_encode(
            array(
                "error" => "Task not found with the id $id."
            )
        );
    }
} else {
    http_response_code(405);
    echo json_encode(
        array(
            "error" => "$requestMethod method is not allowed."
        )
    );
}
?>  