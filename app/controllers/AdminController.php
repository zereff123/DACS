<?php
class AdminController {
    public function index() {
        require 'app/views/admin/dashboard.php';
    } 
    public function dashboard()
    {
        include ROOT_PATH . "/app/views/shares/header.php";
        include ROOT_PATH . "/app/views/admin/dashboard.php";
        include ROOT_PATH . "/app/views/shares/footer.php";
    }
}
