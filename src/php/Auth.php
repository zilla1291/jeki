<?php
/**
 * Authentication Class
 * Handles user authentication and session management
 */

class Auth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Login user
     */
    public function login($email, $password) {
        $user = $this->db->selectOne(
            "SELECT id, email, password, role FROM users WHERE email = ? AND status = 'active'",
            [$email]
        );

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            return true;
        }

        return false;
    }

    /**
     * Register user
     */
    public function register($email, $password, $name) {
        // Check if user exists
        $existing = $this->db->selectOne(
            "SELECT id FROM users WHERE email = ?",
            [$email]
        );

        if ($existing) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $result = $this->db->insert('users', [
            'email' => $email,
            'password' => $hashedPassword,
            'name' => $name,
            'role' => 'customer',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $result ? true : false;
    }

    /**
     * Logout user
     */
    public function logout() {
        session_destroy();
        return true;
    }

    /**
     * Check if user is logged in
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get current user
     */
    public function getUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }

        return $this->db->selectOne(
            "SELECT id, email, name, role FROM users WHERE id = ?",
            [$_SESSION['user_id']]
        );
    }

    /**
     * Check if user has role
     */
    public function hasRole($role) {
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }

    /**
     * Require login
     */
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'login.php');
            exit;
        }
    }

    /**
     * Require admin
     */
    public function requireAdmin() {
        $this->requireLogin();
        if (!$this->hasRole('admin')) {
            header('HTTP/1.0 403 Forbidden');
            exit;
        }
    }
}
?>
