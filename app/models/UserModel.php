<?php
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Đăng ký
    public function register($username, $passwordHash, $email, $gradeLevel, $currentLevel, $role = "User") {
        $stmt = $this->pdo->prepare("INSERT INTO Users (Username, PasswordHash, Email, Role, GradeLevel, CurrentLevel) 
                                     VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$username, $passwordHash, $email, $role, $gradeLevel, $currentLevel]);
    }

    // Kiểm tra username tồn tại
    public function usernameExists($username) {
        $stmt = $this->pdo->prepare("SELECT UserId FROM Users WHERE Username = ?");
        $stmt->execute([$username]);
        return $stmt->rowCount() > 0;
    }

    // Lấy thông tin user theo username
    public function getUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE Username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
