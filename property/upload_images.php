<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../include/db.php";

if(!isset($_GET['property_id'])){
    die("Property ID Missing");
}

$property_id = $_GET['property_id'];

if(isset($_POST['upload'])){

    foreach($_FILES['images']['name'] as $key => $val){

        $imageName = $_FILES['images']['name'][$key];
        $tmp = $_FILES['images']['tmp_name'][$key];

        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png'];

        if(in_array($ext, $allowed)){

            $newName = time().'_'.$key.'.'.$ext;

            if(move_uploaded_file($tmp, "../uploads/properties/".$newName)){

                $stmt = $conn->prepare("INSERT INTO property_images (property_id,image) VALUES (?,?)");
                $stmt->bind_param("is",$property_id,$newName);
                $stmt->execute();
            }
        }
    }

    echo "<script>
            alert('Images Uploaded Successfully');
            window.location='property_list.php';
          </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Property Images</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    body {
        background: linear-gradient(135deg, #667eea, #764ba2);
        min-height: 100vh;
    }

    .upload-card {
        border-radius: 20px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(12px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .upload-box {
        border: 2px dashed #667eea;
        border-radius: 15px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
        background: #f8f9ff;
    }

    .upload-box:hover {
        background: #eef1ff;
        transform: scale(1.02);
    }

    .upload-box i {
        font-size: 40px;
        color: #667eea;
    }

    .preview-img {
        height: 100px;
        width: 100px;
        object-fit: cover;
        border-radius: 10px;
        margin: 5px;
        border: 2px solid #ddd;
    }

    .btn-modern {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-modern:hover {
        transform: scale(1.05);
    }
</style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card upload-card p-4 w-100" style="max-width:600px;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">
                <i class="bi bi-images text-primary"></i>
                Upload Property Images
            </h3>

            <a href="property_list.php" class="btn btn-outline-dark btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <form method="POST" enctype="multipart/form-data">

            <label class="upload-box w-100">
                <i class="bi bi-cloud-arrow-up"></i>
                <p class="mt-3 mb-1 fw-semibold">Click to Upload or Drag Images</p>
                <small class="text-muted">JPG, JPEG, PNG only</small>

                <input type="file" name="images[]" multiple hidden required
                       onchange="previewImages(event)">
            </label>

            <div id="preview" class="mt-3 d-flex flex-wrap"></div>

            <button type="submit" name="upload"
                    class="btn btn-primary btn-modern w-100 mt-4">
                <i class="bi bi-upload"></i> Upload Images
            </button>

        </form>

    </div>

</div>

<script>
function previewImages(event) {
    const preview = document.getElementById('preview');
    preview.innerHTML = "";

    for (let i = 0; i < event.target.files.length; i++) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement("img");
            img.src = e.target.result;
            img.classList.add("preview-img");
            preview.appendChild(img);
        }
        reader.readAsDataURL(event.target.files[i]);
    }
}
</script>

</body>
</html>
