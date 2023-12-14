<?php
// Database configuration
$servername = '127.0.0.1';
$username = 'amr_web_shop_user';
$password = 'Amr-ma,236037';
$dbname = 'amr_webshop';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function findUserByEmail($email)
{
    global $conn; // Use the global connection variable
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);

    return $user;
}

function saveUser($email, $name, $password)
{
    global $conn; // Use the global connection variable
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (email, name, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $email, $name, $hashedPassword);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $success;
}

// Close the database connection at the end of the script
// $conn->close();
?>
