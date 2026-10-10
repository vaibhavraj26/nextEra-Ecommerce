<!-- validator.php -->
<?php
class Validator {
    public static function validateEmail($email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    public static function validatePassword($password) {
        return strlen($password) >= 6 && preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/\d/', $password);
    }
    public static function validateName($name) {
        return !empty($name);
    }
}
?>