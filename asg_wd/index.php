<?php
require_once "includes/header.php";
?>

-- Test

<section class="hero">

    <div class="hero-grid-layout">

        <!-- Left Column: Welcome & Main Actions -->
        <div class="hero-content">

            <h1>
                WELCOME TO UTB<br>
                SPORT FACILITIES
            </h1>

            <p>
                Easily explore available sports facilities and submit your booking request online.
            </p>

            <div class="hero-buttons">
                <a href="facilities.php" class="btn">
                    View Facilities
                </a>

                <a href="booking.php" class="btn">
                    Book a Facility
                </a>
            </div>

        </div>

        <!-- Right Column: Ready to Book Card -->
        <div class="hero-card">

            <h2>
                Ready to Book?
            </h2>

            <p>
                Find a suitable facility and submit your booking request today.
            </p>

            <a href="booking.php" class="btn-outline">
                Start a Booking
            </a>

        </div>

    </div>

</section>


<section class="info-section">

    <h2>
        Why Use UTB Sport Facilities?
    </h2>

    <div class="info-grid">

        <article>

            <h3>
                View Facilities
            </h3>

            <p>
                Browse available sports facilities, locations and capacity information.
            </p>

        </article>


        <article>

            <h3>
                Easy Booking
            </h3>

            <p>
                Submit your facility booking request through a simple online form.
            </p>

        </article>


        <article>

            <h3>
                Booking Management
            </h3>

            <p>
                Administrators can review and manage facility booking requests.
            </p>

        </article>

    </div>

</section>


<?php
require_once "includes/footer.php";
?>