<?php
session_start();
include('include/db.php');

if (!isset($_GET['id'])) {
    echo "Invalid Request";
    exit();
}

$id = intval($_GET['id']);

// GET PROPERTY
$stmt = $conn->prepare("SELECT * FROM properties WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();

if (!$property) {
    echo "Property not found";
    exit();
}

// GET IMAGES
$images_result = $conn->query("SELECT image FROM property_images WHERE property_id=$id");

$allImages = [];
while($row = $images_result->fetch_assoc()){
    $allImages[] = $row['image'];
}

$mainImage = !empty($allImages) ? $allImages[0] : "default.jpg";
?>

<!DOCTYPE html>
<html>
<head>
<title>Property Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* 🌙 DARK BACKGROUND */
body {
    background: linear-gradient(135deg,#0f172a,#020617);
    font-family: 'Segoe UI', sans-serif;
    color: white;
}

/* MAIN CONTAINER */
.container-box {
    background: rgba(255,255,255,0.05);
    padding: 30px;
    border-radius: 20px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
}

/* MAIN IMAGE */
.main-img {
    height: 420px;
    width: 100%;
    object-fit: cover;
    border-radius: 15px;
    transition: 0.4s;
}

/* GALLERY */
.gallery img {
    height: 90px;
    width: 120px;
    object-fit: cover;
    margin: 6px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
    border: 2px solid transparent;
}

.gallery img:hover {
    transform: scale(1.1);
    border: 2px solid #00c6ff;
}

/* TEXT */
h2 {
    font-weight: bold;
}

p {
    color: #cbd5e1;
}

/* PRICE */
.price {
    font-size: 26px;
    font-weight: bold;
    color: #00ffcc;
}

/* BUTTON */
.back-btn {
    border-radius: 30px;
    padding: 10px 25px;
    background: linear-gradient(45deg,#00c6ff,#0072ff);
    border: none;
    color: white;
    font-weight: 500;
}

.back-btn:hover {
    transform: scale(1.05);
}

/* HOVER IMAGE ZOOM */
.main-img:hover {
    transform: scale(1.02);
}

</style>

<script>
function changeImage(src){
    document.getElementById("mainImage").src = src;
}
</script>

</head>

<body>

<div class="container py-5">

<div class="container-box">

<h2 class="mb-3"><?php echo htmlspecialchars($property['title']); ?></h2>

<!-- MAIN IMAGE -->
<img id="mainImage" 
     src="uploads/properties/<?php echo htmlspecialchars($mainImage); ?>" 
     class="main-img mb-3">

<!-- GALLERY -->
<div class="gallery d-flex flex-wrap">
<?php foreach($allImages as $img) { ?>
    <img src="uploads/properties/<?php echo htmlspecialchars($img); ?>" 
         onclick="changeImage(this.src)">
<?php } ?>
</div>

<hr style="border-color:rgba(255,255,255,0.1);">

<p><strong>📍 Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>

<p class="price">💰 ₹<?php echo htmlspecialchars($property['price']); ?></p>

<p><strong>🏠 Type:</strong> <?php echo htmlspecialchars($property['property_type']); ?></p>

<p><strong>📝 Description:</strong><br>
<?php echo nl2br(htmlspecialchars($property['description'])); ?>
</p>

<a href="property_list.php" class="btn back-btn mt-3">⬅ Back</a>

</div>

</div>

</body>
</html>