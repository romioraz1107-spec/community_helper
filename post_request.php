<?php
require_once 'config.php';
if (!is_logged_in()) { header('Location: login.php'); exit; }

$errors = [];
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $location_text = trim($_POST['location_text'] ?? '');
    $latitude = trim($_POST['latitude'] ?? '');
    $longitude = trim($_POST['longitude'] ?? '');

    if ($title === '' || $description === '') $errors[] = 'Title and description are required.';
    if ($latitude !== '' && !is_numeric($latitude)) $errors[] = 'Latitude must be numeric.';
    if ($longitude !== '' && !is_numeric($longitude)) $errors[] = 'Longitude must be numeric.';

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO requests (user_id, title, description, category, location_text, latitude, longitude)
                               VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([current_user_id(), $title, $description, $category ?: null, $location_text ?: null,
                        $latitude !== '' ? $latitude : null, $longitude !== '' ? $longitude : null]);
        $success = 'Request posted successfully! Helpers can now respond.';
    }
}

include 'header.php';
?>
<h2>Post a Request</h2>
<?php if ($success): ?><div class="success"><?php echo h($success); ?></div><?php endif; ?>
<?php if ($errors): ?><div class="alert"><?php echo implode('<br>', array_map('h',$errors)); ?></div><?php endif; ?>

<form method="post" class="form card">
  <label>Title <input type="text" name="title" required placeholder="e.g., Need a plumber near Andheri"></label>
  <label>Description <textarea name="description" rows="4" required placeholder="Describe your requirement"></textarea></label>
  <label>Category <input type="text" name="category" placeholder="e.g., Plumbing, Tutoring, Delivery"></label>
  <label>Location (text) <input type="text" name="location_text" placeholder="e.g., Andheri West, Mumbai"></label>
  <div class="row">
    <label>Latitude <input type="text" name="latitude" id="lat" placeholder="Optional"></label>
    <label>Longitude <input type="text" name="longitude" id="lng" placeholder="Optional"></label>
  </div>
  <button class="btn" type="button" id="geoBtn">Use my current location</button>
  <button class="btn primary" type="submit">Submit Request</button>
</form>

<p>Tip: Helpers will see your request on their Helper Desk and can respond with contact details and images.</p>
<?php include 'footer.php'; ?>
