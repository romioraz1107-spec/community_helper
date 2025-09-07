<?php
require_once 'config.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if ($name === '' || $email === '' || $password === '') $errors[] = 'All fields are required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email.';
    if (!in_array($role, ['user','helper'])) $role = 'user';

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?,?,?,?)");
            $stmt->execute([$name, $email, $hash, $role]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            // Redirect immediately to post request page after register (as requested)
            header('Location: post_request.php');
            exit;
        }
    }
}
include 'header.php';
?>
<h2>Create account</h2>
<?php if ($errors): ?>
  <div class="alert"><?php echo implode('<br>', array_map('h',$errors)); ?></div>
<?php endif; ?>
<form method="post" class="form card">
  <label>Name <input type="text" name="name" required></label>
  <label>Email <input type="email" name="email" required></label>
  <label>Password <input type="password" name="password" required minlength="6"></label>
  <label>Role
    <select name="role">
      <option value="user">I need help (User)</option>
      <option value="helper">I can help (Helper)</option>
    </select>
  </label>
  <button class="btn primary" type="submit">Register</button>
  <p>Already have an account? <a href="login.php">Login</a></p>
</form>
<?php include 'footer.php'; ?>
