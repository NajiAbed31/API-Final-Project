<?php
include('task.php');
class Database
{
    private $conn;
    private $tasksTableName = "tasks";

    public function __construct()
    {
        $this->conn = mysqli_connect(
            "localhost",
            "root",
            "",
            "api_final_project"
        );
    }

    /**
     * 
     * This method inserts a new task to the database and returns its id if the insertion process was successfully done, -1 otherwise.
     * @param Task $task
     * @return int|string
     * 
     */
    public function insertTask(Task $task): int
    {
        $query = "INSERT INTO {$this->tasksTableName}(description)
        VALUES('{$task->getDescription()}')";
        if ($this->conn->query($query)) {
            return $this->conn->insert_id;
        }
        return -1;

    }

    /**
     * This method gets the task of the given id and returns it if the retreiving process was successfully done, null otherwise.
     * @param mixed $id
     * @return Task|null
     */
    public function getTask($id): Task|null
    {
        $query = "SELECT * FROM {$this->tasksTableName} WHERE id = $id";
        $row = $this->conn->query($query);
        if ($row->num_rows == 1) {
            $result = $row->fetch_assoc();
            $task = new Task( /*$result['title'],*/$result['description']);
            $task->setId($result['id']);
            $task->setChecked($result['isChecked']);
            return $task;
        }
        return null;

    }

    /**
     * This method returns a json structured string of a passed task object.
     * @param Task $task
     * @return bool|string
     */
    public function getJsonResponse(Task $task)
    {
        return json_encode(
            array(
                "id" => $task->getId(),
                "description" => $task->getDescription(),
                "isChecked" => $task->isChecked() ? "true" : "false"
            )
        );
    }

    /**
     * This method returns an array of all the tasks in the database, or an empty array if the database was empty.
     * @return array
     */
    public function getAllTasks()
    {
        $query = "SELECT * FROM {$this->tasksTableName}";
        $rows = $this->conn->query($query);
        $result = array();
        while ($row = $rows->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * This method updates a task with a given id and an associative array of the fields that you want to update with their corresponding values.
     * Returns true if the updating process was successfully done, false otherwise.
     * @param mixed $id
     * @param mixed $updatesFields
     * @return bool
     */
    public function updateTask($id, $updatesFields)
    {
        $query = "UPDATE {$this->tasksTableName}
        SET ";
        $fieldsCount = count($updatesFields);
        $iteration = 0;
        foreach ($updatesFields as $key => $value) {
            if ($key == "isChecked")
                $query = $query . "$key = $value";
            else
                $query = $query . "$key = '$value'";

            $iteration++;
            if ($iteration < $fieldsCount) {
                $query = $query . ", ";
            }
        }
        $query = $query . " WHERE id = $id";
        // echo $query;
        if ($this->conn->query($query))
            return true;
        return false;
    }

    /**
     * This method deletes a task with a given id.
     * Returns true if the deleting process was successfully done, false otherwise.
     * @param mixed $id
     * @return bool
     */
    public function deleteTask($id)
    {
        $query = "DELETE FROM {$this->tasksTableName}
        WHERE id = $id";
        if ($this->conn->query($query))
            return true;
        return false;
    }
}
?>