<?php
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/Subject.php'; // thêm model môn học

class QuestionController {
    private $db;
    private $questionModel;
    private $subjectModel;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=AdaptiveQuizDB', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->questionModel = new Question($this->db);
        $this->subjectModel  = new Subject($this->db);
    }

    public function index() {
        $questions = $this->questionModel->getAll();
        require 'app/views/questions/index.php';
    }

    public function create() {
        // Lấy danh sách môn học từ DB
        $subjects = $this->subjectModel->getAll();
        require 'app/views/questions/create.php';
    }

    public function store() {
        $this->questionModel->create($_POST);
        header("Location: /Question/index");
        exit();
    }
    
    public function edit() {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Thiếu ID câu hỏi");
    }

    $question = $this->questionModel->getById($id);

    // Lấy danh sách môn học để hiển thị tên
    $subjects = $this->subjectModel->getAll();

    require 'app/views/questions/edit.php';
}

    public function update($id) {
        $this->questionModel->update($id, $_POST);
        header("Location: /Question/index");
        exit();
    }

    public function delete($id) {
        $this->questionModel->delete($id);
        header("Location: /Question/index");
        exit();
    }
}
