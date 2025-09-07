<?php
require_once 'config.php';
$token = trim($_GET['token'] ?? '');
$errors = [];
$info = '';

if ($token === '') { die('Invalid token.'); }

$stmt = $pdo->prepare("SELECT pr.*, u.email FROM password_resets pr JOIN users u ON u.id=pr.user_id WHERE pr.token=? AND pr.used=0 AND pr.expires_at > NOW()");
$stmt->execute([$token]);
$record = $stmt->fetch();
if (!$record) {
  die('Token invalid or expired.');
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $pass = $_POST['password'] ?? '';
  if (strlen($pass) < 6) $errors[] = 'Password must be at least 6 characters.';
  if (!$errors) {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $pdo->prepare("UPDATE users SET password_hash=? WHERE id=?")->execute([$hash, $record['user_id']]);
    $pdo->prepare("UPDATE password_resets SET used=1 WHERE id=?")->execute([$record['id']]);
    $info = 'Password updated. You can now <a href="login.php">login</a>.';
  }
}

include 'header.php';
?>
<h2>Reset Password</h2>
<?php if ($errors): ?><div class="alert"><?php echo implode('<br>', array_map('h',$errors)); ?></div><?php endif; ?>
<?php if ($info): ?><div class="success"><?php echo $info; ?></div><?php endif; ?>
<form method="post" class="form card">
  <p>Resetting password for <?php echo h($record['email']); ?></p>
  <label>New Password <input type="password" name="password" required></label>
  <button class="btn primary" type="submit">Update Password</button>
</form>
<?php include 'footer.php'; ?>
