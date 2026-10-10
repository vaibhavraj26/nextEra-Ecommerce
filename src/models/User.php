<!-- user.php -->
<?php
require_once __DIR__ . '/../database/Database.php';

class User {
    public static function findByEmail($email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $db = Database::getInstance(); 
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function findAdminByEmail($email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $db = Database::getInstance(); 
        $stmt = $db->prepare("SELECT * FROM admin_user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($name, $email, $phone, $password) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $db = Database::getInstance(); 
        $stmt = $db->prepare("INSERT INTO users (user_name, email, phone, user_password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $password]);
    }
    public static function updateRememberToken($userId, $token) {
        $db = Database::getInstance(); // Changed to getInstance()
        $stmt = $db->prepare("UPDATE users SET remember_token = ? WHERE user_id = ?");
        $stmt->execute([$token, $userId]);
    }
    public static function findByToken($token) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE remember_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 
}
?>
