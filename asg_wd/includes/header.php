<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>UTB Sport Facilities</title>
    <link
        rel="stylesheet"
        href="/asg_wd/assets/style.css">
</head>

<body>
<header>
    <div class="header-container">
        <h1>UTB Sport Facilities</h1>

        <nav>

            <a
                href="index.php"
                class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">Home
            </a>

            <a
                href="facilities.php"
                class="<?php echo $currentPage === 'facilities.php' ? 'active' : ''; ?>"> Facility
            </a>

            <a
                href="booking.php"
                class="<?php echo $currentPage === 'booking.php' ? 'active' : ''; ?>">Book
            </a>

            <a
                href="about.php"
                class="<?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">Help
            </a>

            <a
                href="login.php"
                class="<?php echo $currentPage === 'login.php' ? 'active' : ''; ?>">Admin
            </a>

        </nav>
    </div>
</header>
<main>