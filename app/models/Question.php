<?php
class Question {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO Questions 
            (Content, OptionA, OptionB, OptionC, OptionD, CorrectAnswer, SubjectId, GradeLevel, DifficultyLevel) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['content'], 
            $data['optionA'], 
            $data['optionB'], 
            $data['optionC'], 
            $data['optionD'],
            $data['correctAnswer'], 
            $data['subjectId'], 
            $data['gradeLevel'], 
            $data['difficultyLevel']
        ]);
    }

    public function getAll() {
        $sql = "SELECT q.*, s.SubjectName 
                FROM Questions q
                JOIN Subjects s ON q.SubjectId = s.SubjectId
                ORDER BY q.CreatedAt DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT q.*, s.SubjectName 
                FROM Questions q
                JOIN Subjects s ON q.SubjectId = s.SubjectId
                WHERE q.QuestionId = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE Questions SET 
            Content=?, OptionA=?, OptionB=?, OptionC=?, OptionD=?, CorrectAnswer=?, SubjectId=?, GradeLevel=?, DifficultyLevel=?
            WHERE QuestionId=?");
        return $stmt->execute([
            $data['content'], 
            $data['optionA'], 
            $data['optionB'], 
            $data['optionC'], 
            $data['optionD'],
            $data['correctAnswer'], 
            $data['subjectId'], 
            $data['gradeLevel'], 
            $data['difficultyLevel'], 
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Questions WHERE QuestionId = ?");
        return $stmt->execute([$id]);
    }

    // 👉 Lấy ngẫu nhiên N câu hỏi (mặc định 40)
    public function getRandom($limit = 40) {
        $stmt = $this->db->prepare("SELECT q.*, s.SubjectName 
                                    FROM Questions q
                                    JOIN Subjects s ON q.SubjectId = s.SubjectId
                                    ORDER BY RAND() LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 👉 Lấy ngẫu nhiên N câu hỏi theo môn học
    public function getRandomBySubject($subjectId, $limit = 40) {
        $stmt = $this->db->prepare("SELECT q.*, s.SubjectName 
                                    FROM Questions q
                                    JOIN Subjects s ON q.SubjectId = s.SubjectId
                                    WHERE q.SubjectId = :subjectId
                                    ORDER BY RAND() LIMIT :limit");
        $stmt->bindValue(':subjectId', (int)$subjectId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 👉 Lấy ngẫu nhiên N câu hỏi theo môn, lớp, học lực (user)
    public function getRandomBySubjectGradePerformance($subjectId, $gradeLevel, $currentLevel, $limit = 40) {
        // Map CurrentLevel (user) -> DifficultyLevel (câu hỏi)
        $map = [
            'Yếu' => 'Dễ',
            'Khá' => 'TB',
            'Giỏi' => 'Khó'
        ];
        $difficulty = $map[$currentLevel] ?? 'TB';

        $sql = "SELECT q.*, s.SubjectName 
                FROM Questions q
                JOIN Subjects s ON q.SubjectId = s.SubjectId
                WHERE q.SubjectId = :subjectId
                  AND q.GradeLevel = :gradeLevel
                  AND q.DifficultyLevel = :difficulty
                ORDER BY RAND()
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':subjectId', (int)$subjectId, PDO::PARAM_INT);
        $stmt->bindValue(':gradeLevel', (int)$gradeLevel, PDO::PARAM_INT);
        $stmt->bindValue(':difficulty', $difficulty, PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
