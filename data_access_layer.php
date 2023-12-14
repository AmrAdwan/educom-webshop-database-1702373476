<?php
// Database configuration
$servername = '127.0.0.1';
$username = 'amr_web_shop_user';
$password = 'Amr-ma,236037';
$dbname = 'amr_webshop';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn)
{
  die("Connection failed: " . mysqli_connect_error());
}

function findUserByEmail($email)
{
  global $conn;
  $sql = "SELECT * FROM users WHERE email = ?"; // Select all columns
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt)
  {
    // Handle error in statement preparation
    die('Statement preparation failed: ' . mysqli_error($conn));
  }

  mysqli_stmt_bind_param($stmt, "s", $email);

  if (!mysqli_stmt_execute($stmt))
  {
    // Handle error in statement execution
    die('Execute failed: ' . mysqli_error($conn));
  }

  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);

  mysqli_free_result($result);
  mysqli_stmt_close($stmt);

  return $user;
}

function findEmailById($id)
{
  global $conn;
  $sql = "SELECT email FROM users WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt)
  {
    // Handle error in statement preparation
    die('Statement preparation failed: ' . mysqli_error($conn));
  }

  mysqli_stmt_bind_param($stmt, "i", $id);

  if (!mysqli_stmt_execute($stmt))
  {
    // Handle error in statement execution
    die('Execute failed: ' . mysqli_error($conn));
  }

  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);

  if ($user)
  {
    $email = $user['email']; // Fetch only the email
  } else
  {
    $email = null; // No user found with that ID
  }

  mysqli_free_result($result);
  mysqli_stmt_close($stmt);
  return $email;
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