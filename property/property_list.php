<?php
session_start();
include('../include/db.php');

if (!isset($_SESSION['user_id'])) {
    echo "Please login first";
    exit();
}

$role = strtolower($_SESSION['role']);

// Query
if ($role == 'seller') {
    $stmt = $conn->prepare("SELECT * FROM properties WHERE seller_id=?");
    $stmt->bind_param("i", $_SESSION['user_id']);
} else {
    $stmt = $conn->prepare("SELECT * FROM properties WHERE status='available'");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Properties</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>

/* 🌙 DARK BACKGROUND */
body {
    background: linear-gradient(135deg,#0f172a,#020617);
    font-family: 'Segoe UI', sans-serif;
    color: white;
}

/* TITLE */
.title {
    font-weight: bold;
    color: #ffffff;
}

/* CARD */
.property-card {
    border-radius: 20px;
    overflow: hidden;
    transition: 0.4s;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
}

/* HOVER EFFECT */
.property-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.6);
}

/* IMAGE */
.property-img {
    height: 230px;
    object-fit: cover;
    transition: 0.4s;
}

.property-card:hover .property-img {
    transform: scale(1.1);
}

/* TEXT */
.card-body h5 {
    color: #ffffff;
}

.text-muted {
    color: #cbd5e1 !important;
}

/* PRICE */
.price {
    font-size: 20px;
    font-weight: bold;
    color: #00ffcc;
}

/* BUTTON */
.btn-modern {
    border-radius: 30px;
    background: linear-gradient(45deg,#00c6ff,#0072ff);
    border: none;
    color: white;
    font-weight: 500;
}

.btn-modern:hover {
    transform: scale(1.05);
}

</style>
</head>

<body>

<div class="container py-5">

<h2 class="title mb-4">🏡 Explore Properties</h2>

<div class="row">

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $img = $conn->query("SELECT image FROM property_images WHERE property_id=".$row['id']." LIMIT 1")->fetch_assoc();
        $image = $img['image'] ?? 'default.jpg';
        $image_path = "/plan_your_perfect_stay/uploads/properties/".$image;
?>

<div class="col-md-4 mb-4">
    <div class="card property-card">

        <img src="<?php echo $image_path; ?>" class="w-100 property-img">

        <div class="card-body">

            <h5 class="fw-bold"><?php echo $row['title']; ?></h5>

            <p class="text-muted mb-1">
                <i class="bi bi-geo-alt"></i> <?php echo $row['location']; ?>
            </p>

            <p class="price">₹<?php echo number_format($row['price']); ?></p>

            <a href="property_details.php?id=<?php echo $row['id']; ?>" 
               class="btn btn-modern w-100">
               View Details →
            </a>

        </div>
    </div>
</div>

<?php
    }
} else {
    echo "<h5 class='text-center'>No Properties Found</h5>";
}
?>

</div>
</div>

</body>
</html>