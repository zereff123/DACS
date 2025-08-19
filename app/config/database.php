<?php
class Database {
    private $host = "localhost";
    private $db   = "AdaptiveQuizDB"; // đúng theo SQL bạn gửi
    private $user = "root";
    private $pass = "";
    private $charset = "utf8mb4";
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            $dsn = "mysql:host=localhost;dbname=AdaptiveQuizDB;charset=utf8mb4";
            $opts = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            try {
                self::$instance = new PDO($dsn, "root", "", $opts);
            } catch (PDOException $e) {
                die("Kết nối DB thất bại: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
