<?php

session_start();

require_once "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {

        $error = "Please enter your email and password.";

    } else {

        $sql = "
            SELECT id, name, email, password_hash
            FROM admins
            WHERE email = ?
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin["password_hash"])) {

            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_name"] = $admin["name"];
            $_SESSION["admin_email"] = $admin["email"];

            header("Location: admin/dashboard.php");
            exit;

        } else {

            $error = "Invalid email or password.";

        }
    }
}

require_once "includes/header.php";

?>

<section>

    <h2>Admin Login</h2>

    <?php if ($error !== ""): ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>

    <form method="POST" action="login.php">

        <label for="email">Email</label>

        <input
            type="email"
            id="email"
            name="email"
            required
        >

        <br><br>

        <label for="password">Password</label>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit">
            Login
        </button>

    </form>

</section>

<?php
require_once "includes/footer.php";
?>