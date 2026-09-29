<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../config.php";

$totalFacilitiesStmt = $pdo->query(
    "SELECT COUNT(*) FROM facilities"
);

$totalFacilities = $totalFacilitiesStmt->fetchColumn();


$totalBookingsStmt = $pdo->query(
    "SELECT COUNT(*) FROM bookings"
);

$totalBookings = $totalBookingsStmt->fetchColumn();


$pendingBookingsStmt = $pdo->query(
    "SELECT COUNT(*) FROM bookings WHERE status = 'Pending'"
);

$pendingBookings = $pendingBookingsStmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - UTB Sport Facilities</title>

    <link rel="stylesheet"
          href="/asg_wd/assets/style.css">

</head>

<body>

<header>

    <h1>UTB Sport Facilities Admin</h1>

    <nav>

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="facilities.php">
            Facilities
        </a>

        <a href="bookings.php">
            Bookings
        </a>

        <a href="report.php">
            Report
        </a>

        <a href="../logout.php">
            Logout
        </a>

    </nav>

</header>

<main>

<section>

    <h2>
        Welcome,
        <?php echo htmlspecialchars($_SESSION["admin_name"]); ?>
    </h2>

    <div class="dashboard-cards">

        <article>
            <h3>Facilities</h3>
            <p><?php echo $totalFacilities; ?></p>
        </article>

        <article>
            <h3>Total Bookings</h3>
            <p><?php echo $totalBookings; ?></p>
        </article>

        <article>
            <h3>Pending Bookings</h3>
            <p><?php echo $pendingBookings; ?></p>
        </article>

    </div>

</section>

</main>

<footer>

    <p>&copy; 2026 UTB Sport Facilities</p>

</footer>

</body>

</html>