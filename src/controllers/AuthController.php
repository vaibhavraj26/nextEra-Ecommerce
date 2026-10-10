<!-- AuthController.php -->
<?php
require_once __DIR__ . '/../utils/Validator.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {

    public function login($email, $password, $rememberMe = false) {
        // Validate input
        if (!Validator::validateEmail($email) || !Validator::validatePassword($password)) {
            return "Invalid email or password. please try again.";
        }
        // Check user credentials
        $user = User::findByEmail($email);
        if ($user && password_verify($password, $user['user_password'])) {
            session_set_cookie_params([
                'lifetime' => 0,           // Cookie expires when the browser is closed
                'path' => '/',             // Cookie is available for the entire domain
                'domain' => '',            // Cookie is available for all subdomains
                'secure' => true,          // Only send cookies over HTTPS
                'httponly' => true,        // Prevent JavaScript access to cookies
                'samesite' => 'Strict'     // Prevent CSRF attacks
            ]);
            // Start session and set user data
            session_start();
            $_SESSION['user'] = $user;
                 
            if ($rememberMe) {
                $token = bin2hex(random_bytes(32)); // Generate a secure token
                setcookie('remember_token', $token, time() + 86400 * 30, '/'); // Set cookie for 30 days
                User::updateRememberToken($user['user_id'], $token);
            }
            header("Location: ../../public/dashboard.php");
            exit();
        } else {
            return "user not found, check your details or signup first";
        }
    }
    public function signup($name, $email, $phone_no, $password, $confirmPassword) {

        //confirm password matching, password pattern matching and name validation in form-tag by alp.js.
        if (!Validator::validateName($name) || !Validator::validateEmail($email) || !Validator::validatePassword($password) || $password !== $confirmPassword) {
            return "Invalid email or input.";
        }
        // Check if user already exists
        if (User::findByEmail($email)) {
            return "Email already exists. do login";
        }
        // Create new user
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        User::create($name, $email, $phone_no, $hashedPassword);
            return "Account successfully created.";
        header("Location: ../views/login.php");
        exit();
    }
    public function admin_login($name, $phone, $email, $password) {
        // Validate input
        if (!Validator::validateEmail($email) || !Validator::validatePassword($password)) {
            return "Invalid email or password. please try again.";
        }
        // Check admin credentials
        $user = User::findAdminByEmail($email);
        if (!$user) {
            return "No user found with this email.";
        }
        if (!password_verify($password, $user['user_password'])){
            return "Invalid password.";
        }
        if ($user && password_verify($password, $user['user_password']) && $user['user_name'] == $name && $user['phone'] == $phone) {
            session_set_cookie_params([
                'lifetime' => 0,           // Cookie expires when the browser is closed
                'path' => '/',             // Cookie is available for the entire domain
                'domain' => '',            // Cookie is available for all subdomains
                'secure' => true,          // Only send cookies over HTTPS
                'httponly' => true,        // Prevent JavaScript access to cookies
                'samesite' => 'Strict'     // Prevent CSRF attacks
            ]);
            // Start session and set user data
            session_start();
            $_SESSION['user'] = $user;
            header("Location: ../../admin/admin_dashboard.php");
            exit();
        } else {
            return "Invalid admin details.";
        }
    }
}
?>