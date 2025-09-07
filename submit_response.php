<?php
require_once 'config.php';
if (!is_logged_in()) { header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $request_id = (int)($_POST['request_id'] ?? 0);
  $responder_name = trim($_POST['responder_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $message = trim($_POST['message'] ?? '');
  $image_path = null;

  // Handle image upload
  if (!empty($_FILES['image']['name'])) {
    $dir = __DIR__ . '/uploads';
    if (!is_dir($dir)) { mkdir($dir, 0777, true); }
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $safeExt = strtolower($ext);
    $allowed = ['jpg','jpeg','png','gif','webp'];
    if (in_array($safeExt, $allowed) && is_uploaded_file($_FILES['image']['tmp_name'])) {
      $fname = 'resp_' . time() . '_' . bin2hex(random_bytes(3)) . '.' . $safeExt;
      $dest = $dir . '/' . $fname;
      if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        $image_path = 'uploads/' . $fname;
      }
    }
  }

  if ($request_id && $responder_name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
    $stmt = $pdo->prepare("INSERT INTO responses (request_id, helper_id, responder_name, email, phone, message, image_path)
                           VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$request_id, current_user_id(), $responder_name, $email, $phone ?: null, $message, $image_path]);
  }
}
header('Location: dashboard_helper.php');
exit;
