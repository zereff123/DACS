<?php
require_once __DIR__ . '/../models/Subject.php';

class SubjectController {
    private $db;
    private $subjectModel;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=AdaptiveQuizDB', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->subjectModel = new Subject($this->db);
    }

    public function index() {
        $subjects = $this->subjectModel->getAll();
        require 'app/views/subjects/index.php';
    }

    public function create() {
        require 'app/views/subjects/create.php';
    }

    public function store() {
        $this->subjectModel->create($_POST);
        header("Location: /Subject/index");
    }

    public function edit($id) {
        $subject = $this->subjectModel->getById($id);
        require 'app/views/subjects/edit.php';
    }

    public function update($id) {
        $this->subjectModel->update($id, $_POST);
        header("Location: /Subject/index");
    }

    public function delete($id) {
        $this->subjectModel->delete($id);
        header("Location: /Subject/index");
    }
}
