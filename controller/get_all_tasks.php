<?php
header('Content-Type: application/json');
include("../model/database.php");

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod == "GET") {
    $db = new Database();
    $allTasks = $db->getAllTasks();
    for ($i = 0; $i < count($allTasks); $i++) {
        $allTasks[$i]['isChecked'] = $allTasks[$i]['isChecked'] ? "true" : "false";
    }

    if (count($allTasks) > 0) {
        http_response_code(200);
        echo json_encode($allTasks);
    } else {
        http_response_code(404);
        echo json_encode(
            array(
                "error" => "No tasks found."
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