<?php
session_start();
include('../include/db.php');

if (!isset($_SESSION['user_id'])) {
    echo "Please login first";
    exit();
}

$seller_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: property_list.php");
    exit();
}

$id = $_GET['id'];

// Check ownership
$stmt = $conn->prepare("SELECT * FROM properties WHERE id=? AND seller_id=?");
$stmt->bind_param("ii", $id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Unauthorized Access";
    exit();
}

$property = $result->fetch_assoc();

// UPDATE PROPERTY
if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $property_type = $_POST['property_type'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $update = $conn->prepare("UPDATE properties 
        SET title=?, property_type=?, price=?, location=?, description=?, status=? 
        WHERE id=? AND seller_id=?");

    $update->bind_param("ssdsssii",
        $title,
        $property_type,
        $price,
        $location,
        $description,
        $status,
        $id,
        $seller_id
    );

    $update->execute();

    // Upload new image
    if (!empty($_FILES['new_image']['name'])) {

        $image = time() . "_" . $_FILES['new_image']['name'];
        $tmp = $_FILES['new_image']['tmp_name'];

        move_uploaded_file($tmp, "../uploads/properties/" . $image);

        $insert_img = $conn->prepare("INSERT INTO property_images (property_id, image) VALUES (?, ?)");
        $insert_img->bind_param("is", $id, $image);
        $insert_img->execute();
    }

    header("Location: property_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f172a, #020617);
            color: #e2e8f0;
        }

        .card{
            background: rgba(30,41,59,0.7);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        h3{
            color: #f8fafc;
        }

        label{
            color: #cbd5f5;
            font-weight: 500;
        }

        .form-control, .form-select{
            background: rgba(15,23,42,0.8);
            border: 1px solid #334155;
            color: #e2e8f0;
            border-radius: 10px;
        }

        .form-control:focus, .form-select:focus{
            border-color: #38bdf8;
            box-shadow: 0 0 10px rgba(56,189,248,0.5);
            background: #0f172a;
            color: #fff;
        }

        textarea{
            resize: none;
        }

        .btn-success{
            background: linear-gradient(45deg, #22c55e, #16a34a);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            transition: 0.3s;
        }

        .btn-success:hover{
            transform: scale(1.05);
            box-shadow: 0 0 10px #22c55e;
        }

        .btn-secondary{
            background: #475569;
            border: none;
            border-radius: 10px;
        }

        .btn-secondary:hover{
            background: #334155;
        }

        .btn-danger{
            background: #ef4444;
            border: none;
            border-radius: 8px;
        }

        .btn-danger:hover{
            background: #dc2626;
        }

        hr{
            border-color: #334155;
        }

        .image-card{
            background: rgba(15,23,42,0.7);
            border-radius: 12px;
            padding: 10px;
            transition: 0.3s;
        }

        .image-card:hover{
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }

        img{
            border-radius: 10px;
            border: 2px solid #334155;
            transition: 0.3s;
        }

        img:hover{
            transform: scale(1.05);
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="card shadow-lg p-4">

        <h3 class="mb-4 fw-bold">Edit Property</h3>

        <form method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control"
                        value="<?php echo $property['title']; ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Property Type</label>
                    <input type="text" name="property_type" class="form-control"
                        value="<?php echo $property['property_type']; ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control"
                        value="<?php echo $property['price']; ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control"
                        value="<?php echo $property['location']; ?>" required>
                </div>

                <div class="col-12 mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" required><?php echo $property['description']; ?></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="available" <?= $property['status']=="available"?"selected":""; ?>>Available</option>
                        <option value="sold" <?= $property['status']=="sold"?"selected":""; ?>>Sold</option>
                        <option value="booked" <?= $property['status']=="booked"?"selected":""; ?>>Booked</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Add New Image</label>
                    <input type="file" name="new_image" class="form-control">
                </div>
            </div>

            <button type="submit" name="update" class="btn btn-success">Update</button>
            <a href="property_list.php" class="btn btn-secondary">Cancel</a>

        </form>

        <hr class="my-4">

        <h5 class="fw-bold">Existing Images</h5>

        <div class="row">
        <?php
        $img_stmt = $conn->prepare("SELECT * FROM property_images WHERE property_id=?");
        $img_stmt->bind_param("i", $id);
        $img_stmt->execute();
        $images = $img_stmt->get_result();

        while ($img = $images->fetch_assoc()) {
            $img_path = "../uploads/properties/" . $img['image'];
        ?>
            <div class="col-md-3 mb-3">
                <div class="image-card text-center">
                    <?php if (file_exists($img_path)) { ?>
                        <img src="<?php echo $img_path; ?>" class="img-fluid mb-2" style="height:150px; object-fit:cover;">
                    <?php } ?>
                    <a href="delete_image.php?id=<?php echo $img['id']; ?>&property_id=<?php echo $id; ?>"
                       onclick="return confirm('Delete this image?')"
                       class="btn btn-danger btn-sm">
                       Delete
                    </a>
                </div>
            </div>
        <?php } ?>
        </div>

    </div>
</div>

</body>
</html>