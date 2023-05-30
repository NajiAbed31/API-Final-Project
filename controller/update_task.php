<?php
header('Content-Type: application/json');
include("../model/database.php");

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod === "PUT") {
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
    if ($id == null) {
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
    if ($task === null) {
        http_response_code(404);
        echo json_encode(
            array(
                "error" => "Task not found with the id $id."
            )
        );
    } else {
        $data = json_decode(file_get_contents("php://input"), true);

        $updatesFields = array();
        if (isset($data['description'])) {
            $updatesFields['description'] = $data['description'];
        }
        if (isset($data['isChecked'])) {
            $updatesFields['isChecked'] = $data['isChecked'];
        }
        if (!empty($updatesFields)) {
            if ($db->updateTask($id, $updatesFields)) {
                http_response_code(200);
                echo $db->getJsonResponse($db->getTask($id));
            } else {
                http_response_code(500);
                echo json_encode(
                    array(
                        "error" => "Failed to update the task."
                    )
                );
            }
        } else {
            http_response_code(400);
            echo json_encode(
                array(
                    "error" => "No data passed to update."
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