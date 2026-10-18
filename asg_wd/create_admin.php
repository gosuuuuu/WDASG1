<?php

require_once "config.php";

$name = "Na'aim";
$email = "naaim@hotmail.com";
$password = "NAAIM";

$password_hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$sql = "
    INSERT INTO admins
    (name, email, password_hash)
    VALUES (?, ?, ?)
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $name,
    $email,
    $password_hash
]);

echo "Admin account created successfully.";

?>