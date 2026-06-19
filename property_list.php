<?php
session_start();
include('include/db.php');

// SEARCH FILTER
$where = "WHERE status='available'";

if(isset($_GET['search'])){
    $location = $_GET['location'];
    $type = $_GET['type'];
    $price = $_GET['price'];

    if(!empty($location)){
        $where .= " AND location LIKE '%$location%'";
    }
    if(!empty($type)){
        $where .= " AND property_type='$type'";
    }
    if(!empty($price)){
        $where .= " AND price <= $price";
    }
}

$stmt = $conn->prepare("SELECT * FROM properties $where");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Search Properties</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body {
    background: linear-gradient(135deg,#0f172a,#020617);
    font-family: 'Segoe UI';
    color:white;
}

/* NAVBAR */
.navbar-custom{
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    border-radius: 15px;
    padding: 10px 20px;
}

/* SEARCH BOX */
.search-box{
    background: rgba(255,255,255,0.05);
    padding:20px;
    border-radius:15px;
    backdrop-filter: blur(10px);
}

.form-control, .form-select{
    background: rgba(255,255,255,0.08);
    border:none;
    color:white;
}

.form-control::placeholder{
    color:#bbb;
}

.form-control:focus, .form-select:focus{
    box-shadow:0 0 0 2px #00c6ff;
}

/* BUTTON */
.btn-search{
    background: linear-gradient(45deg,#00c6ff,#0072ff);
    border:none;
    color:white;
    font-weight:600;
}

/* CARD (UNCHANGED but slightly improved shadow) */
.card {
    border-radius: 15px;
    overflow: hidden;
    transition: 0.3s;
    background: #111827;
    color:white;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow:0 15px 30px rgba(0,0,0,0.5);
}

img {
    height: 200px;
    object-fit: cover;
}

</style>
</head>

<body>

<div class="container py-4">

    <!-- 🔥 NAVBAR -->
    <div class="d-flex justify-content-between align-items-center navbar-custom mb-4">
        <h4 class="mb-0">🏡 Stayz</h4>

        <div>
            <a href="index.php" class="btn btn-outline-light btn-sm me-2">Home</a>
            <a href="login.php" class="btn btn-outline-light btn-sm">Login</a>
        </div>
    </div>

    <!-- 🔍 SEARCH BOX -->
    <form method="GET" class="search-box mb-4">
        <div class="row g-3">

            <div class="col-md-4">
                <input type="text" name="location" class="form-control"
                       placeholder="📍 Location">
            </div>

            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">Property Type</option>
                    <option>Apartment</option>
                    <option>Villa</option>
                    <option>Hotel</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="price" class="form-select">
                    <option value="">Max Price</option>
                    <option value="2000">₹2000</option>
                    <option value="5000">₹5000</option>
                    <option value="10000">₹10000</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" name="search" class="btn btn-search w-100">
                    🔍 Search
                </button>
            </div>

        </div>
    </form>

    <!-- PROPERTIES -->
    <h4 class="mb-4">✨ Available Properties</h4>

    <div class="row">

    <?php while($row = $result->fetch_assoc()) { 

        $img = $conn->query("SELECT image FROM property_images WHERE property_id=".$row['id']." LIMIT 1")->fetch_assoc();
        $image = $img['image'] ?? 'default.jpg';
    ?>

    <div class="col-md-4 mb-4">
    <div class="card">

    <img src="uploads/properties/<?php echo $image; ?>">

    <div class="p-3">

    <h5><?php echo $row['title']; ?></h5>

    <p>📍 <?php echo $row['location']; ?></p>

    <p><strong>₹<?php echo $row['price']; ?></strong></p>

    <a href="property_details.php?id=<?php echo $row['id']; ?>" 
       class="btn btn-primary w-100">
       View Details
    </a>

    </div>
    </div>
    </div>

    <?php } ?>

    </div>

</div>

</body>
</html>