<?php
// header.php
require_once __DIR__ . '/config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Community Helper</title>
  <link rel="stylesheet" href="styles.css">
  <script defer src="script.js"></script>
</head>
<body class="dark">
  <nav class="navbar">
    <a href="index.php" class="brand">🤝 Community Helper</a>
    <button id="navToggle" class="nav-toggle" aria-label="Toggle navigation">☰</button>
    <ul class="nav-links" id="navLinks">
      <li><a href="about.php">About</a></li>
      <?php if (!is_logged_in()): ?>
        <li><a href="register.php">Register</a></li>
        <li><a href="login.php">Login</a></li>
      <?php else: ?>
        <li><a href="post_request.php">Post Request</a></li>
        <li><a href="dashboard_user.php">My Dashboard</a></li>
        <li><a href="dashboard_helper.php">Helper Desk</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php endif; ?>
      <li><a href="https://www.google.com/maps" target="_blank" rel="noreferrer">Maps</a></li>
    </ul>
  </nav>
  <main class="container">
