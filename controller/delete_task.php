<?php
header('Content-Type: application/json');
include("../model/database.php");

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod == "DELETE") {
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
    if($task == null){
        http_response_code(404);
        echo json_encode(
            array(
                "error" => "Task not found with the id $id."
            )
        );
    } else {
        if ($db->deleteTask($id)) {
            http_response_code(200);
            echo json_encode(
                array(
                    "message" => "The task of id $id was successfully deleted.",
                    "deletedTask" => array(
                        "id" => $task->getId(),
                        // "title" => $task->getTitle(),
                        "description" => $task->getDescription(),
                        "isChecked" => $task->isChecked() ? "true" : "false"
                    )
                )
            );
        } else {
            http_response_code(500);
            echo json_encode(
                array(
                    "error" => "Failed to delete the task with id $id."
                )
            );
        }
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