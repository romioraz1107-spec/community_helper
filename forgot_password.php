<?php
require_once 'config.php';
$info = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $email = trim($_POST['email'] ?? '');
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[]='Enter a valid email.';
  if (!$errors) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user) {
      $token = bin2hex(random_bytes(16));
      $expires = date('Y-m-d H:i:s', time() + 3600);
      $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?,?,?)")->execute([$user['id'],$token,$expires]);
      $link = sprintf("%s/reset_password.php?token=%s", rtrim((isset($_SERVER['HTTPS'])?'https':'http') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']), '/'), $token);
      // In a real app, send $link by email. For local demo, show it:
      $info = 'Password reset link (demo): <a href="'.h($link).'">'.h($link).'</a>';
    } else {
      $info = 'If that email exists, a reset link has been generated (demo shows it below).';
    }
  }
}

include 'header.php';
?>
<h2>Forgot Password</h2>
<?php if ($errors): ?><div class="alert"><?php echo implode('<br>', array_map('h',$errors)); ?></div><?php endif; ?>
<?php if ($info): ?><div class="success"><?php echo $info; ?></div><?php endif; ?>
<form method="post" class="form card">
  <label>Email <input type="email" name="email" required></label>
  <button class="btn primary" type="submit">Generate reset link</button>
</form>
<?php include 'footer.php'; ?>
