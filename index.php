<?php include 'header.php'; ?>
<section class="hero">
  <h1 class="glow">Find help fast. Offer help faster.</h1>
  <p>Post your requirement (with location) and let nearby helpers respond with contact details and images.</p>
  <?php if (!is_logged_in()): ?>
    <div class="actions">
      <a class="btn primary" href="register.php">Get Started</a>
      <a class="btn" href="login.php">I already have an account</a>
    </div>
  <?php else: ?>
    <div class="actions">
      <a class="btn primary" href="post_request.php">Post a Request</a>
      <a class="btn" href="dashboard_user.php">Go to Dashboard</a>
    </div>
  <?php endif; ?>
</section>

<section class="grid">
  <div class="card">
    <h3>🔒 Secure</h3>
    <p>Your data stays private. Only helpers see what they need.</p>
  </div>
  <div class="card">
    <h3>📍 Location</h3>
    <p>Share exact or approximate location so helpers can reach you.</p>
  </div>
  <div class="card">
    <h3>🖼️ Rich Responses</h3>
    <p>Helpers can attach images and share phone/email.</p>
  </div>
</section>
<?php include 'footer.php'; ?>
