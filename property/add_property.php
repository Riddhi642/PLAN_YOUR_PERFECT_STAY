<?php
include "../include/auth.php";
include "../include/db.php";

if ($_SESSION['role'] !== 'seller') {
    header("Location: ../login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

if (isset($_POST['add_property'])) {

    $title       = trim($_POST['title']);
    $type        = trim($_POST['property_type']);
    $price       = floatval($_POST['price']);
    $location    = trim($_POST['location']);
    $description = trim($_POST['description']);
    $latitude    = $_POST['latitude'];
    $longitude   = $_POST['longitude'];

    $stmt = $conn->prepare("
        INSERT INTO properties 
        (seller_id, title, property_type, price, location, description, latitude, longitude, status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'available', NOW())
    ");

    $stmt->bind_param("issdssdd", 
        $seller_id, $title, $type, $price, $location, $description, $latitude, $longitude
    );

    if ($stmt->execute()) {

        $property_id = $stmt->insert_id;

        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {

                $file_name = time() . "_" . $_FILES['images']['name'][$key];
                $target = "../uploads/properties/" . $file_name;

                if (move_uploaded_file($tmp_name, $target)) {

                    $img_stmt = $conn->prepare("INSERT INTO property_images (property_id, image) VALUES (?, ?)");
                    $img_stmt->bind_param("is", $property_id, $file_name);
                    $img_stmt->execute();
                }
            }
        }

        echo "<script>
        alert('Property Added Successfully!');
        window.location='../seller/dashboard.php';
        </script>";
        exit();

    } else {
        $error = "Something went wrong!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Property</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#0f172a,#020617);
    color:#e2e8f0;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:100vh;
}

/* CARD */
.card{
    width:100%;
    max-width:800px;
    padding:30px;
    border-radius:20px;
    background: rgba(30,41,59,0.7);
    backdrop-filter: blur(15px);
    border:1px solid rgba(255,255,255,0.08);
    box-shadow:0 20px 40px rgba(0,0,0,0.6);
}

h4{
    color:#f8fafc;
    margin-bottom:20px;
}

/* INPUT FIX */
.form-control, .form-select{
    background: rgba(15,23,42,0.9);
    border:1px solid #334155;
    color:#ffffff !important;
    border-radius:10px;
}

.form-control::placeholder{
    color:#94a3b8 !important;
    opacity:1;
}

.form-control:focus, .form-select:focus{
    border-color:#38bdf8;
    box-shadow:0 0 10px rgba(56,189,248,0.6);
    background:#0f172a;
    color:#fff;
}

/* FILE INPUT */
input[type="file"]{
    color:#e2e8f0;
}

/* TEXTAREA */
textarea{
    color:#ffffff !important;
}

/* BUTTON */
.btn-primary{
    background: linear-gradient(45deg,#22c55e,#16a34a);
    border:none;
    border-radius:10px;
    padding:10px;
    font-weight:600;
    transition:0.3s;
}

.btn-primary:hover{
    transform:scale(1.05);
    box-shadow:0 0 12px #22c55e;
}

/* MAP */
#map{
    height:300px;
    border-radius:15px;
    margin-top:10px;
    border:2px solid #334155;
}

/* UPLOAD */
.upload-box{
    border:2px dashed #334155;
    padding:15px;
    border-radius:12px;
    text-align:center;
    background: rgba(15,23,42,0.5);
}

/* ALERT */
.alert{
    border-radius:10px;
}
</style>
</head>

<body>

<div class="card">

<h4>🏠 Add New Property</h4>

<?php if(isset($error)){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="title" placeholder="Property Title" class="form-control mb-3" required>

<input type="text" name="property_type" placeholder="Type (Apartment, Villa)" class="form-control mb-3">

<input type="number" name="price" placeholder="Price per day" class="form-control mb-3" required>

<input type="text" name="location" class="form-control mb-2" placeholder="Enter City" required>

<input type="text" id="map_location" class="form-control mb-2" placeholder="Select location from map" readonly>

<input type="hidden" name="latitude" id="lat">
<input type="hidden" name="longitude" id="lng">

<div id="map"></div>

<textarea name="description" placeholder="Description" class="form-control mt-3"></textarea>

<div class="upload-box mt-3">
    <input type="file" name="images[]" multiple class="form-control">
</div>

<button type="submit" name="add_property" class="btn btn-primary w-100 mt-3">
    Add Property
</button>

</form>

</div>

<!-- GOOGLE MAP -->
<script>
function initMap() {

    let map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 19.0760, lng: 72.8777 },
        zoom: 10
    });

    let marker;

    map.addListener("click", function(e) {

        let lat = e.latLng.lat();
        let lng = e.latLng.lng();

        document.getElementById("lat").value = lat;
        document.getElementById("lng").value = lng;

        document.getElementById("map_location").value = lat + ", " + lng;

        if (marker) marker.setMap(null);

        marker = new google.maps.Marker({
            position: e.latLng,
            map: map
        });
    });
}
</script>

<script async defer 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkx0YFV3Wq8tMRuqJYVz_T3qzxkT6ZpnI&callback=initMap">
</script>

</body>
</html>