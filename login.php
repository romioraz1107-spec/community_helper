<?php
require_once 'config.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email === '' || $password === '') $errors[] = 'Email and password are required.';

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            // Redirect immediately to post request page after login (as requested)
            header('Location: post_request.php');
            exit;
        } else {
            $errors[] = 'Invalid credentials.';
        }
    }
}
include 'header.php';
?>
<h2>Login</h2>
<?php if ($errors): ?>
  <div class="alert"><?php echo implode('<br>', array_map('h',$errors)); ?></div>
<?php endif; ?>
<form method="post" class="form card">
  <label>Email <input type="email" name="email" required></label>
  <label>Password <input type="password" name="password" required></label>
  <button class="btn primary" type="submit">Login</button>
  <p><a href="forgot_password.php">Forgot password?</a></p>
</form>
<?php include 'footer.php'; ?>
