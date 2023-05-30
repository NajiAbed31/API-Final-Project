<?php
class Task {
    private $id;
    // private $title;
    private $description;

    private $checked;

    public function __construct(/*$title,*/ $description) {
        // $this->title = $title;
        $this->description = $description;
        $this->checked = false;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    // public function setTitle($title) {
    //     $this->title = $title;
    // }

    // public function getTitle() {
    //     return $this->title;
    // }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setChecked($checked) {
        $this->checked = $checked;
    }

    public function isChecked() {
        return $this->checked;
    }
}
?>