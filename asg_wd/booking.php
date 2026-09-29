<?php
require_once "config.php";

$message = "";
$error = "";

$customer_name = "";
$customer_email = "";
$facility_id = "";
$booking_date = "";
$start_time = "";
$end_time = "";
$purpose = "";


/* Process booking form */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $customer_name = trim($_POST["customer_name"] ?? "");
    $customer_email = trim($_POST["customer_email"] ?? "");
    $roll_number = strtoupper(trim($_POST["roll_number"] ?? ""));
    $facility_id = $_POST["facility_id"] ?? "";
    $booking_date = $_POST["booking_date"] ?? "";
    $start_time = $_POST["start_time"] ?? "";
    $end_time = $_POST["end_time"] ?? "";
    $purpose = trim($_POST["purpose"] ?? "");


    /* Step 1: Basic validation */

    if (
        $customer_name === "" ||
        $customer_email === "" ||
        $facility_id === "" ||
        $booking_date === "" ||
        $start_time === "" ||
        $end_time === "" ||
        $purpose === ""
    ) {

        $error = "Please complete all fields";

    } elseif (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address";

    } elseif (strlen($customer_name) > 100) {
        $error = "Name must not exceed 100 characters";

    } elseif (strlen($purpose) > 255) {
        $error = "Purpose must not exceed 255 characters";

    } elseif (!filter_var($facility_id, FILTER_VALIDATE_INT)) {
        $error = "Please select a valid facility";

    } else {

        /* Step 2: Check facility */

        $facilitySql = "
            SELECT id, name
            FROM facilities
            WHERE id = ?
        ";

        $facilityStmt = $pdo->prepare($facilitySql);
        $facilityStmt->execute([$facility_id]);

        $facility = $facilityStmt->fetch(PDO::FETCH_ASSOC);


        if (!$facility) {
            $error = "The selected facility does not exist";

        } else {

            /* Step 3: Check date */

            $today = date("Y-m-d");

            if ($booking_date < $today) {
                $error = "Booking date cannot be in the past";

            } elseif ($start_time >= $end_time) {
                $error = "End time must be later than start time";

            } else {

                /* Step 4: Check booking conflict */

                $conflictSql = "
                    SELECT id
                    FROM bookings
                    WHERE facility_id = ?
                    AND booking_date = ?
                    AND status IN ('Pending', 'Approved')
                    AND start_time < ?
                    AND end_time > ?
                ";

                $conflictStmt = $pdo->prepare($conflictSql);

                $conflictStmt->execute([
                    $facility_id,
                    $booking_date,
                    $end_time,
                    $start_time
                ]);

                $conflict = $conflictStmt->fetch(PDO::FETCH_ASSOC);


                if ($conflict) {
                    $error = "Sorry, this facility is already booked during the selected time";

                } else {

                    /* Step 5: Insert booking */

                    $sql = "
                        INSERT INTO bookings
                        (
                            customer_name,
                            customer_email,
                            roll_number,
                            facility_id,
                            booking_date,
                            start_time,
                            end_time,
                            purpose,
                            status
                        )
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ";

                    $stmt = $pdo->prepare($sql);

                    $stmt->execute([
                        $customer_name,
                        $customer_email,
                        $roll_number,
                        $facility_id,
                        $booking_date,
                        $start_time,
                        $end_time,
                        $purpose,
                        "Pending"
                    ]);

                    $message = "Booking request submitted successfully! Kindly wait for the approval";

                    /* Clear form after successful booking */

                    $customer_name = "";
                    $customer_email = "";
                    $facility_id = "";
                    $booking_date = "";
                    $start_time = "";
                    $end_time = "";
                    $purpose = "";
                }
            }
        }
    }
}


require_once "includes/header.php";

?>

<section>
    <h2>Book your Sport Facility </h2>
    <p>
        Fill in the form below to submit your booking request.
    </p>


    <?php if ($message !== ""): ?>

        <div class="success">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>


    <?php if ($error !== ""): ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <form action="booking.php" method="POST">

        <div>
            <label for="customer_name">
                Your Name
            </label>

            <br>

            <input
                type="text"
                id="customer_name"
                name="customer_name"
                placeholder="Example: Ali Bin Abu"
                value="<?php echo htmlspecialchars($customer_name); ?>"
                required
            >
        </div>


        <br>


        <div>
            <label for="customer_email">
                Email
            </label>

            <br>

            <input
                type="email"
                id="customer_email"
                name="customer_email"
                name="customer_name"
                placeholder="Example: B2025000@utb.edu.bn"
                value="<?php echo htmlspecialchars($customer_email); ?>"
                required
            >
        </div>


        <br>


        <div class="form-group">
            <label for="roll_number">Student / Staff Roll Number</label>

            <input
                type="text"
                id="roll_number"
                name="roll_number"
                placeholder="Example: B2025000"
                maxlength="20"
                required
            >

            <small>Enter your UTB student or staff roll number.</small>
    </div>


        <br>


        <div>
            <label for="facility_id">
                Choose Facility
            </label>

            <br>

            <select
                id="facility_id"
                name="facility_id"
                required
            >

                <option value="">
                    Select a Facility
                </option>

                <?php

                $facilityListSql = "
                    SELECT id, name
                    FROM facilities
                    ORDER BY name ASC
                ";

                $facilityListStmt = $pdo->query($facilityListSql);

                $facilityList = $facilityListStmt->fetchAll(PDO::FETCH_ASSOC);

                ?>

                <?php foreach ($facilityList as $facilityItem): ?>

                    <option
                        value="<?php echo $facilityItem['id']; ?>"
                        <?php
                        if ($facility_id == $facilityItem['id']) {
                            echo "selected";
                        }
                        ?>
                    >

                        <?php
                        echo htmlspecialchars($facilityItem['name']);
                        ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <br>


        <div>
            <label for="booking_date">
                Booking Date
            </label>

            <br>

            <input
                type="date"
                id="booking_date"
                name="booking_date"
                value="<?php echo htmlspecialchars($booking_date); ?>"
                required
            >
        </div>


        <br>


        <div>
            <label for="start_time">
                Start Time
            </label>

            <br>

            <input
                type="time"
                id="start_time"
                name="start_time"
                value="<?php echo htmlspecialchars($start_time); ?>"
                required
            >
        </div>


        <br>


        <div>
            <label for="end_time">
                End Time
            </label>

            <br>

            <input
                type="time"
                id="end_time"
                name="end_time"
                value="<?php echo htmlspecialchars($end_time); ?>"
                required
            >
        </div>


        <br>


        <div>
            <label for="purpose">
                Purpose of Booking
            </label>

            <br>

            <textarea
                id="purpose"
                name="purpose"
                rows="4"
                required
            ><?php echo htmlspecialchars($purpose); ?></textarea>
        </div>


        <br>


        <button type="submit">
            Submit Booking
        </button>

    </form>

</section>


<?php
require_once "includes/footer.php";
?>