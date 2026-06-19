<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    <h4 class="logo">ADMIN PANEL</h4>

    <a href="dashboard.php" class="<?= ($current=='dashboard.php')?'active':'' ?>">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <a href="manage_users.php" class="<?= ($current=='manage_users.php')?'active':'' ?>">
        <i class="bi bi-people"></i>
        <span>Users</span>
    </a>

    <a href="manage_properties.php" class="<?= ($current=='manage_properties.php')?'active':'' ?>">
        <i class="bi bi-house"></i>
        <span>Properties</span>
    </a>

    <a href="manage_bookings.php" class="<?= ($current=='manage_bookings.php')?'active':'' ?>">
        <i class="bi bi-calendar-check"></i>
        <span>Bookings</span>
    </a>

    <a href="transactions.php" class="<?= ($current=='transactions.php')?'active':'' ?>">
        <i class="bi bi-cash"></i>
        <span>Transactions</span>
    </a>

    <a href="../logout.php" class="logout">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
    </a>
</div>
