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
    die('Statement preparation failed: ' . mysqli_error($conn));
  }

  mysqli_stmt_bind_param($stmt, "i", $id);

  if (!mysqli_stmt_execute($stmt))
  {
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

function getProducts()
{
  global $conn;
  $sql = "SELECT * FROM products";
  $stmt = mysqli_prepare($conn, $sql);

  if (!mysqli_stmt_execute($stmt))
  {
    // Handle error in statement execution
    die('Execute failed: ' . mysqli_error($conn));
  }

  $result = mysqli_stmt_get_result($stmt);

  $products = [];
  while ($row = mysqli_fetch_assoc($result))
  {
    $products[] = [
      'id' => $row['id'],
      'name' => $row['name'],
      'description' => $row['description'],
      'price' => $row['price'],
      'file_name' => $row['file_name']
    ];
  }

  mysqli_free_result($result);
  mysqli_stmt_close($stmt);

  return $products;
}


function getProductById($id)
{
  global $conn;

  if (!$conn)
  {
    die("Database connection error: " . mysqli_connect_error());
  }

  $sql = "SELECT * FROM products WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt)
  {
    die("Error preparing statement: " . mysqli_error($conn));
  }

  mysqli_stmt_bind_param($stmt, "i", $id);

  if (!mysqli_stmt_execute($stmt))
  {
    die("Error executing query: " . mysqli_stmt_error($stmt));
  }

  $result = mysqli_stmt_get_result($stmt);

  if (!$result)
  {
    die("Error fetching result: " . mysqli_error($conn));
  }

  $product = mysqli_fetch_assoc($result);

  mysqli_free_result($result);
  mysqli_stmt_close($stmt);
  // var_dump($product);
  return $product;
}

function insertOrder($userId, $cartItems)
{
  global $conn;

  // Start transaction
  mysqli_begin_transaction($conn);

  try
  {
    // Get the next order number
    $result = mysqli_query($conn, "SELECT MAX(order_nr) as max_order_nr FROM orders");
    $row = mysqli_fetch_assoc($result);
    $nextOrderNr = $row['max_order_nr'] + 1;

    // Insert into orders table
    $orderDate = date('Y-m-d H:i:s'); // Current date and time
    $sqlOrder = "INSERT INTO orders (user_id, order_date, order_nr) VALUES (?, ?, ?)";
    $stmtOrder = mysqli_prepare($conn, $sqlOrder);
    mysqli_stmt_bind_param($stmtOrder, "isi", $userId, $orderDate, $nextOrderNr);
    mysqli_stmt_execute($stmtOrder);
    $orderId = mysqli_insert_id($conn); // Get the ID of the inserted order
    mysqli_stmt_close($stmtOrder);

    // Insert into order_lines table
    $sqlOrderLine = "INSERT INTO orderlines (orders_id, product_id, quantity_per_product) VALUES (?, ?, ?)";
    foreach ($cartItems as $item)
    {
      $stmtOrderLine = mysqli_prepare($conn, $sqlOrderLine);
      mysqli_stmt_bind_param($stmtOrderLine, "iii", $orderId, $item['id'], $item['quantity']);
      mysqli_stmt_execute($stmtOrderLine);
      mysqli_stmt_close($stmtOrderLine);
    }

    // Commit transaction
    mysqli_commit($conn);
    return true;
  } catch (Exception $e)
  {
    // Rollback transaction on error
    mysqli_rollback($conn);
    return false;
  }
}

// Close the database connection at the end of the script
// $conn->close();
?>