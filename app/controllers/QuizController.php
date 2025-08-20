<?php
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/Subject.php';

class QuizController {
    private $db;
    private $questionModel;
    private $subjectModel;

    public function __construct() {
        SessionHelper::start();

        // Kiểm tra user login
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=account&action=login");
            exit;
        }

        $this->db = new PDO('mysql:host=localhost;dbname=AdaptiveQuizDB', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->questionModel = new Question($this->db);
        $this->subjectModel = new Subject($this->db);
    }

    public function start() {
        // Lấy thông tin user
        $user = $_SESSION['user'];
        $subjectId = $_POST['subject_id'] ?? null;

        if (!$subjectId) {
            die("Vui lòng chọn môn học!");
        }

        $gradeLevel = $user['GradeLevel'] ?? 1;      // Lớp của học sinh
        $currentLevel = $user['CurrentLevel'] ?? 'TB'; // Trình độ: Yếu, TB, Giỏi

        // Lấy ngẫu nhiên 40 câu hỏi theo môn, lớp và trình độ
        $questions = $this->questionModel->getRandomBySubjectGradePerformance($subjectId, $gradeLevel, $currentLevel, 40);

        require 'app/views/quiz/start.php';
    }
}
