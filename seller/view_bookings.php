<?php
include "../include/db.php";
include "../include/auth.php";

/* =========================
   CHECK SELLER ROLE
========================= */
if ($_SESSION['role'] !== 'seller') {
    header("Location: ../login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

/* =========================
   APPROVE / REJECT LOGIC
========================= */
if (isset($_GET['action']) && isset($_GET['booking_id'])) {

    $booking_id = intval($_GET['booking_id']);
    $action = $_GET['action'];

    if ($action == "approve") {
        $status = "approved";
    } elseif ($action == "reject") {
        $status = "rejected";
    } else {
        $status = "pending";
    }

    // Update only if booking belongs to this seller
    $stmt = $conn->prepare("
        UPDATE bookings b
        JOIN properties p ON b.property_id = p.id
        SET b.status = ?
        WHERE b.id = ? AND p.seller_id = ?
    ");
    $stmt->bind_param("sii", $status, $booking_id, $seller_id);
    $stmt->execute();

    header("Location: view_bookings.php");
    exit();
}

/* =========================
   FETCH BOOKINGS
========================= */
$stmt = $conn->prepare("
    SELECT b.*, u.name, p.title 
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN properties p ON b.property_id = p.id
    WHERE p.seller_id = ?
");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking Requests</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    body {
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        min-height: 100vh;
    }

    .main-card {
        border-radius: 20px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(12px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    .table thead {
        background: #4e73df;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f2f6ff;
        transform: scale(1.01);
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .action-btn {
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 13px;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #666;
    }

    .back-btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 8px 20px;
    }
</style>
</head>

<body>

<div class="container py-5">

    <div class="card main-card p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">
                <i class="bi bi-journal-check text-primary"></i>
                Booking Requests
            </h4>

            <a href="dashboard.php" class="btn btn-outline-dark back-btn">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="table-responsive">

            <table class="table align-middle text-center">

                <thead>
                    <tr>
                        <th>Buyer</th>
                        <th>Property</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php if($result->num_rows > 0){ ?>
                    <?php while($row=$result->fetch_assoc()){ ?>
                    <tr>

                        <td class="fw-semibold"><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= $row['check_in'] ?></td>
                        <td><?= $row['check_out'] ?></td>

                        <td>
                            <?php if($row['status'] == 'pending'){ ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php } elseif($row['status'] == 'approved'){ ?>
                                <span class="badge bg-success">Approved</span>
                            <?php } elseif($row['status'] == 'rejected'){ ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php } ?>
                        </td>

                        <td>
                            <?php if($row['status'] == 'pending'){ ?>

                                <a href="view_bookings.php?action=approve&booking_id=<?= $row['id'] ?>"
                                   class="btn btn-success action-btn">
                                   Approve
                                </a>

                                <a href="view_bookings.php?action=reject&booking_id=<?= $row['id'] ?>"
                                   class="btn btn-danger action-btn"
                                   onclick="return confirm('Are you sure?')">
                                   Reject
                                </a>

                            <?php } else { ?>
                                <span class="text-muted">No Action</span>
                            <?php } ?>
                        </td>

                    </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-calendar-x display-6 text-muted"></i>
                                <p class="mt-3">No Booking Requests Yet</p>
                            </div>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
