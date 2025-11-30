<?php
/**
 * Login Page
 */
session_start();

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/src/php/Database.php';
require_once dirname(__DIR__, 2) . '/src/php/Auth.php';

$db = new Database($pdo);
$auth = new Auth($db);

$error = '';
$success = '';

// If already logged in, redirect
if ($auth->isLoggedIn()) {
    header('Location: ' . BASE_URL);
    exit;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
    if ($email && $password) {
        if ($auth->login($email, $password)) {
            $_SESSION['success'] = 'Login successful! Welcome back.';
            header('Location: ' . BASE_URL);
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/styles.css">
</head>
<body>
    <section style="min-height: 100vh; display: flex; align-items: center; background: var(--gradient-light);">
        <div class="container-sm">
            <div class="card" style="max-width: 400px; margin: 0 auto;">
                <div class="card-body">
                    <h2 class="text-center mb-3">Login to Your Account</h2>
                    
                    <?php if ($error): ?>
                        <div style="background: #fee; border: 1px solid #fcc; padding: 12px; border-radius: 8px; margin-bottom: 1.5rem; color: #c33;">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
                    </form>
                    
                    <p style="text-align: center; margin-top: 1rem;">
                        Don't have an account? <a href="?page=register">Register here</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
