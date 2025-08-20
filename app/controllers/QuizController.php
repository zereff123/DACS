<?php
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/Quiz.php';

class QuizController {
    private $db;
    private $questionModel;
    private $subjectModel;
    private $quizModel;

    public function __construct() {
        SessionHelper::start();

        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=account&action=login");
            exit;
        }

        $this->db = new PDO('mysql:host=localhost;dbname=AdaptiveQuizDB', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->questionModel = new Question($this->db);
        $this->subjectModel = new Subject($this->db);
        $this->quizModel = new Quiz($this->db);
    }
    
    public function start() {
    $user = $_SESSION['user'];
    $subjectId = $_POST['subject_id'] ?? null;

    if (!$subjectId) die("Vui lòng chọn môn học!");

    $gradeLevel = $user['GradeLevel'] ?? 1;
    $currentLevel = $user['CurrentLevel'] ?? 'TB';

    // Lấy câu hỏi theo môn, lớp và trình độ
    $questions = $this->questionModel->getRandomBySubjectGradePerformance($subjectId, $gradeLevel, $currentLevel, 40);

    if (empty($questions)) {
        die("Chưa có câu hỏi cho môn học này!");
    }

    // Tạo Quiz tạm thời để lưu lịch sử
    $quizId = $this->quizModel->createTempQuiz($subjectId, $gradeLevel, $user['UserId'], $questions);

    require 'app/views/quiz/start.php';
}public function submit() {
    $userId = $_SESSION['user']['UserId'];
    $quizId = $_POST['quiz_id'] ?? null;
    $answers = $_POST['answers'] ?? [];

    if (!$quizId || empty($answers)) die("Thiếu dữ liệu nộp bài!");

    $questions = $this->quizModel->getQuizQuestions($quizId);
    $correctCount = 0;
    $resultDetails = [];

    foreach ($questions as $q) {
        $qid = $q['QuestionId'];
        $userAnswer = $answers[$qid] ?? '';
        $isCorrect = ($userAnswer === $q['CorrectAnswer']);
        if ($isCorrect) $correctCount++;

        $resultDetails[] = [
            'QuestionId' => $qid,
            'UserAnswer' => $userAnswer,
            'IsCorrect' => $isCorrect,
            'CorrectAnswer' => $q['CorrectAnswer'],
            'Options' => [
                'A' => $q['OptionA'],
                'B' => $q['OptionB'],
                'C' => $q['OptionC'],
                'D' => $q['OptionD']
            ]
        ];
    }

    $score = round(($correctCount / count($questions)) * 100, 2);

    // Lưu kết quả bài làm
    $quizResultId = $this->quizModel->saveQuizResult($quizId, $userId, $score);

    foreach ($resultDetails as $detail) {
        $this->quizModel->saveQuizResultDetail($quizResultId, $detail['QuestionId'], $detail['UserAnswer'], $detail['IsCorrect']);
    }

    // Cập nhật LevelProgress và CurrentLevel
    require_once __DIR__ . '/LevelController.php';
    $levelController = new LevelController($this->db);
    $levelInfo = $levelController->updateLevelProgress($userId, $score);

    // Cập nhật session user
    $_SESSION['user']['CurrentLevel'] = $levelInfo['CurrentLevel'];
    $_SESSION['user']['LevelProgress'] = $levelInfo['LevelProgress'];

    $_SESSION['last_result_details'] = $resultDetails;
    $_SESSION['last_score'] = $score;

    header("Location: index.php?controller=quiz&action=result&quizResultId=$quizResultId");
    exit();
}


    // Trang hiển thị kết quả bài làm
    public function result() {
        $quizResultId = $_GET['quizResultId'] ?? null;
        if (!$quizResultId) die("Thiếu QuizResultId");

        $quizResult = $this->quizModel->getQuizResult($quizResultId);
        $details = $_SESSION['last_result_details'] ?? [];

        require 'app/views/quiz/result.php';
    }
    public function history() {
    $userId = $_SESSION['user']['UserId'];
    $results = $this->quizModel->getUserQuizResults($userId);

    require 'app/views/quiz/history.php';
    }

// Xem chi tiết 1 bài làm
public function viewResult() {
    $quizResultId = $_GET['quizResultId'] ?? null;
    if (!$quizResultId) die("Thiếu QuizResultId");

    $quizResult = $this->quizModel->getQuizResult($quizResultId);
    $details = $this->quizModel->getQuizResultDetailsByResultId($quizResultId);

    // Chuẩn bị Options cho hiển thị
    foreach ($details as &$d) {
        $d['Options'] = [
            'A' => $d['OptionA'],
            'B' => $d['OptionB'],
            'C' => $d['OptionC'],
            'D' => $d['OptionD']
        ];
    }

    require 'app/views/quiz/viewResult.php';
    }
}
