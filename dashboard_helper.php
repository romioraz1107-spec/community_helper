<?php
require_once 'config.php';
if (!is_logged_in()) { header('Location: login.php'); exit; }

// Fetch latest open requests
$search = trim($_GET['q'] ?? '');
$sql = "SELECT r.*, u.name AS requester_name FROM requests r JOIN users u ON u.id = r.user_id WHERE 1";
$params = [];
if ($search !== '') {
  $sql .= " AND (r.title LIKE ? OR r.description LIKE ? OR r.category LIKE ? OR r.location_text LIKE ?)";
  $s = "%$search%";
  $params = [$s,$s,$s,$s];
}
$sql .= " ORDER BY r.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$requests = $stmt->fetchAll();

include 'header.php';
?>
<h2>Helper Desk</h2>
<form class="form card" method="get">
  <label>Search <input type="text" name="q" value="<?php echo h($search); ?>" placeholder="title, category, location..."></label>
  <button class="btn" type="submit">Filter</button>
</form>

<?php foreach ($requests as $req): ?>
  <div class="card">
    <h3><?php echo h($req['title']); ?> <small class="pill"><?php echo h($req['status']); ?></small></h3>
    <p class="muted">From: <?php echo h($req['requester_name']); ?> • Category: <?php echo h($req['category'] ?? '—'); ?> •
      <?php if ($req['location_text']): ?>Location: <?php echo h($req['location_text']); ?><?php endif; ?>
      <?php if ($req['latitude'] && $req['longitude']): ?> • <a target="_blank" rel="noreferrer" href="<?php echo 'https://maps.google.com/?q='.$req['latitude'].','.$req['longitude']; ?>">Map</a><?php endif; ?>
    </p>
    <p><?php echo nl2br(h($req['description'])); ?></p>
    <details>
      <summary>Respond to this request</summary>
      <form class="form" method="post" action="submit_response.php" enctype="multipart/form-data">
        <input type="hidden" name="request_id" value="<?php echo (int)$req['id']; ?>">
        <label>Your Name <input type="text" name="responder_name" required value="<?php echo h($_SESSION['name'] ?? ''); ?>"></label>
        <label>Email <input type="email" name="email" required value="<?php echo h($_SESSION['email'] ?? ''); ?>"></label>
        <label>Phone <input type="text" name="phone" placeholder="+91-..."></label>
        <label>Message <textarea name="message" rows="3" required placeholder="How can you help?"></textarea></label>
        <label>Attach Image (optional) <input type="file" name="image" accept="image/*"></label>
        <button class="btn primary" type="submit">Send Response</button>
      </form>
    </details>
  </div>
<?php endforeach; ?>

<?php include 'footer.php'; ?>
