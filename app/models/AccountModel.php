<?php
class AccountModel {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance();
    }

public function findByUsernameOrEmail($usernameOrEmail) {
    try {
        $query = "SELECT UserId, Username, Email, PasswordHash FROM Users WHERE Username = :username OR Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $usernameOrEmail);
        $stmt->bindParam(':email', $usernameOrEmail);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Lỗi cơ sở dữ liệu: " . $e->getMessage());
        throw new RuntimeException("Lỗi hệ thống, vui lòng thử lại sau.");
    }
}




    public function findById($id) {
        $stm = $this->db->prepare("SELECT * FROM Users WHERE UserId = :id");
        $stm->execute([':id' => $id]);
        return $stm->fetch();
    }

    public function isUsernameTaken($username) {
        $stm = $this->db->prepare("SELECT 1 FROM Users WHERE Username = :u");
        $stm->execute([':u' => $username]);
        return (bool)$stm->fetchColumn();
    }

    public function isEmailTaken($email) {
        $stm = $this->db->prepare("SELECT 1 FROM Users WHERE Email = :e");
        $stm->execute([':e' => $email]);
        return (bool)$stm->fetchColumn();
    }

    public function create($username, $email, $password, $gradeLevel, $currentLevel, $role = 'User') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Users (Username, PasswordHash, Email, Role, GradeLevel, CurrentLevel)
                VALUES (:u, :ph, :e, :r, :g, :cl)";
        $stm = $this->db->prepare($sql);
        $stm->execute([
            ':u' => $username,
            ':ph' => $hash,
            ':e' => $email,
            ':r' => $role,
            ':g' => (int)$gradeLevel,
            ':cl' => $currentLevel
        ]);
        return $this->db->lastInsertId();
    }

    public function verifyLogin($usernameOrEmail, $password) {
    $user = $this->findByUsernameOrEmail($usernameOrEmail);
    if ($user && password_verify($password, $user['PasswordHash'])) {
        return $user;
    }
    return false;
}

    public function updateProfile($userId, $email, $gradeLevel, $currentLevel, $newPassword = null) {
        if ($newPassword && trim($newPassword) !== '') {
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE Users
                    SET Email = :e, GradeLevel = :g, CurrentLevel = :cl, PasswordHash = :ph
                    WHERE UserId = :id";
            $params = [':e'=>$email, ':g'=>(int)$gradeLevel, ':cl'=>$currentLevel, ':ph'=>$hash, ':id'=>$userId];
        } else {
            $sql = "UPDATE Users
                    SET Email = :e, GradeLevel = :g, CurrentLevel = :cl
                    WHERE UserId = :id";
            $params = [':e'=>$email, ':g'=>(int)$gradeLevel, ':cl'=>$currentLevel, ':id'=>$userId];
        }
        $stm = $this->db->prepare($sql);
        return $stm->execute($params);
    }
}
