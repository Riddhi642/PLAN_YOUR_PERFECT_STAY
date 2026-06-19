<?php
session_start();
include('../include/db.php');

if (!isset($_SESSION['user_id'])) {
    die("Please login first");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];
$role = strtolower($_SESSION['role']);

// Fetch property
$property = $conn->query("SELECT * FROM properties WHERE id=$id")->fetch_assoc();
if (!$property) die("Property not found");

// Fetch images
$images = $conn->query("SELECT image FROM property_images WHERE property_id=$id");
$first = $images->fetch_assoc();
$main = "/plan_your_perfect_stay/uploads/properties/" . ($first['image'] ?? 'default.jpg');
?>

<!DOCTYPE html>
<html>
<head>
<title><?= $property['title']; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>

/* 🌙 DARK BACKGROUND */
body {
    background: linear-gradient(135deg,#0f172a,#020617);
    font-family:'Segoe UI', sans-serif;
    color:white;
}

/* MAIN IMAGE */
.main-img {
    height: 480px;
    object-fit: cover;
    border-radius:20px;
    transition:0.4s;
    box-shadow:0 20px 50px rgba(0,0,0,0.7);
}

.main-img:hover {
    transform: scale(1.02);
}

/* GALLERY */
.gallery img {
    height:90px;
    object-fit:cover;
    border-radius:12px;
    cursor:pointer;
    transition:0.3s;
    border:2px solid transparent;
}

.gallery img:hover {
    transform: scale(1.1);
    border:2px solid #00c6ff;
}

/* BIGGER CARD */
.details-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    border-radius:25px;
    padding:40px;
    min-height:480px;
    box-shadow:0 25px 60px rgba(0,0,0,0.7);
    border:1px solid rgba(255,255,255,0.1);
}

/* TEXT */
.text-muted {
    color:#cbd5e1 !important;
}

/* PRICE */
.price {
    font-size:30px;
    font-weight:bold;
    color:#00ffcc;
}

/* BUTTONS */
.btn-modern {
    border-radius:30px;
    font-weight:500;
    transition:0.3s;
}

.btn-modern:hover {
    transform:scale(1.05);
}

/* CUSTOM BUTTONS */
.btn-primary {
    background: linear-gradient(45deg,#00c6ff,#0072ff);
    border:none;
}

.btn-warning {
    background: linear-gradient(45deg,#f7971e,#ffd200);
    border:none;
    color:black;
}

.btn-danger {
    background: linear-gradient(45deg,#ff416c,#ff4b2b);
    border:none;
}

/* BACK BUTTON */
.back-btn {
    border-radius:30px;
    background: rgba(255,255,255,0.1);
    color:white;
    border:none;
}

.back-btn:hover {
    background: rgba(255,255,255,0.2);
}

/* INPUT */
input.form-control {
    background: rgba(255,255,255,0.08);
    border:none;
    color:white;
}

input.form-control:focus {
    box-shadow:0 0 0 2px #00c6ff;
}

label {
    font-size:14px;
    margin-top:5px;
}

</style>
</head>

<body>

<div class="container py-5">

<!-- BACK BUTTON -->
<a href="property_list.php" class="btn back-btn mb-4">
    <i class="bi bi-arrow-left"></i> Back
</a>

<div class="row g-4 align-items-start">

<!-- IMAGE SECTION -->
<div class="col-md-6">

<img src="<?= $main; ?>" id="mainImage" class="w-100 main-img mb-3">

<div class="row gallery">
<?php
if ($images->num_rows > 0) {
    $images->data_seek(0);
    while($img = $images->fetch_assoc()){ ?>
<div class="col-3 mb-2">
<img src="/plan_your_perfect_stay/uploads/properties/<?= $img['image']; ?>" 
     onclick="changeImage(this.src)" 
     class="w-100">
</div>
<?php }} ?>
</div>

</div>

<!-- DETAILS SECTION -->
<div class="col-md-6">

<div class="details-card">

<h2 class="fw-bold"><?= $property['title']; ?></h2>

<p class="text-muted mb-2">
<i class="bi bi-geo-alt"></i> <?= $property['location']; ?>
</p>

<p>
<span class="badge bg-primary"><?= $property['property_type']; ?></span>
</p>

<p class="price">₹<?= number_format($property['price']); ?> / day</p>

<hr style="border-color:rgba(255,255,255,0.1);">

<p class="text-muted">
<?= $property['description'] ?? "No description available"; ?>
</p>

<!-- SELLER -->
<?php if($role == 'seller'){ ?>
<div class="d-flex gap-2 mt-3">
    <a href="edit_property.php?id=<?= $property['id']; ?>" class="btn btn-warning w-50 btn-modern">
        <i class="bi bi-pencil"></i> Edit
    </a>

    <a href="delete_property.php?id=<?= $property['id']; ?>" 
       onclick="return confirm('Delete this property?')" 
       class="btn btn-danger w-50 btn-modern">
        <i class="bi bi-trash"></i> Delete
    </a>
</div>
<?php } else { ?>

<!-- BOOKING -->
<form action="/plan_your_perfect_stay/transaction/request_booking.php" method="POST" class="mt-3">

<input type="hidden" name="property_id" value="<?= $property['id']; ?>">

<label>Check-in</label>
<input type="date" name="check_in" class="form-control mb-2" required>

<label>Check-out</label>
<input type="date" name="check_out" class="form-control mb-2" required>

<button type="submit" class="btn btn-primary w-100 mt-3 btn-modern">
    🛒 Book Now
</button>

</form>

<?php } ?>

</div>
</div>

</div>
</div>

<script>
function changeImage(src){
    document.getElementById("mainImage").src = src;
}
</script>

</body>
</html>