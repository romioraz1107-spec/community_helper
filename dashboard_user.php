<?php
require_once 'config.php';
if (!is_logged_in()) { header('Location: login.php'); exit; }

// Fetch my requests and responses
$stmt = $pdo->prepare("SELECT * FROM requests WHERE user_id=? ORDER BY created_at DESC");
$stmt->execute([current_user_id()]);
$my_requests = $stmt->fetchAll();

include 'header.php';
?>
<h2>My Dashboard</h2>
<?php if (!$my_requests): ?>
  <p>You haven't posted any requests yet. <a href="post_request.php">Post one now</a>.</p>
<?php endif; ?>

<?php foreach ($my_requests as $req): ?>
  <div class="card">
    <h3><?php echo h($req['title']); ?> <small class="pill"><?php echo h($req['status']); ?></small></h3>
    <p><?php echo nl2br(h($req['description'])); ?></p>
    <p class="muted">Category: <?php echo h($req['category'] ?? '—'); ?> • Location: <?php echo h($req['location_text'] ?? '—'); ?>
      <?php if ($req['latitude'] && $req['longitude']): ?>
        • <a target="_blank" rel="noreferrer" href="<?php echo 'https://maps.google.com/?q='.$req['latitude'].','.$req['longitude']; ?>">Map</a>
      <?php endif; ?>
    </p>
    <details>
      <summary>View helper responses</summary>
      <?php
        $st = $pdo->prepare("SELECT * FROM responses WHERE request_id=? ORDER BY created_at DESC");
        $st->execute([$req['id']]);
        $responses = $st->fetchAll();
      ?>
      <?php if (!$responses): ?>
        <p class="muted">No responses yet.</p>
      <?php else: ?>
        <?php foreach ($responses as $r): ?>
          <div class="response">
            <p><strong><?php echo h($r['responder_name']); ?></strong> • <?php echo h($r['email']); ?> • <?php echo h($r['phone'] ?? ''); ?></p>
            <p><?php echo nl2br(h($r['message'])); ?></p>
            <?php if ($r['image_path']): ?>
              <img src="<?php echo h($r['image_path']); ?>" alt="attachment" class="thumb">
            <?php endif; ?>
            <span class="muted"><?php echo h($r['created_at']); ?></span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </details>
  </div>
<?php endforeach; ?>

<?php include 'footer.php'; ?>
