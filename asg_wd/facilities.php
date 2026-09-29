<?php
require_once "config.php"; // same as homepage
require_once "includes/header.php"; // same as homepage

$sql = "SELECT * FROM facilities ORDER BY name ASC"; // show all facilities but in order of name assending 

$stmt = $pdo->query($sql); // this use to look from my database for the facilities data

$facilities = $stmt->fetchAll(PDO::FETCH_ASSOC); // return the result from database and put into facilities
?>

<section>

    <h2>Our Sports Facilities</h2>

    <p>
        Browse the sports facilities available at UTB.
    </p>

    <?php if (count($facilities) > 0): ?>

        <div class="facilities">

            
            <?php foreach ($facilities as $facility): ?> 

                <article>

                    
                    <h3>
                        <?php echo htmlspecialchars($facility['name']); ?>
                    </h3>

                    <p>
                        <strong>Location:</strong>
                        <?php echo htmlspecialchars($facility['location']); ?>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($facility['description']); ?>
                    </p>

                    <a href="booking.php">
                        Book This
                    </a>

                </article>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <p>No facilities are currently available</p>

    <?php endif; ?>

</section>

<?php
require_once "includes/footer.php";
?>