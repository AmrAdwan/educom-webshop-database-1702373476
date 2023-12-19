<?php

function showshoppingcartContent()
{
  $cartItems = getCartItems();
  $totalPrice = 0;

  echo "<h2>Shopping Cart</h2>";

  if (empty($cartItems))
  {
    echo "<p>Your cart is empty.</p>";
    return;
  }

  foreach ($cartItems as $item)
  {
    echo "<div class='cart-item'>";
    echo "<img src='Images/" . $item['file_name'] . "' alt='" . $item['name'] . "' style='width: 100px;' />";
    echo "<h3>" . $item['name'] . "</h3>";
    echo "<p>Price: $" . $item['price'] . "</p>";
    echo "<p>Quantity: " . $item['quantity'] . "</p>";
    echo "<p>Subtotal: $" . $item['subtotal'] . "</p>";

    // Form for updating quantity
    echo "<form onsubmit='handleSubmit(this); return false;' method='post'>";
    echo "<input type='hidden' name='page' value='update_cart'>";
    echo "<input type='hidden' name='product_id' value='" . $item['id'] . "'>";
    echo "<input type='number' name='quantity' value='" . $item['quantity'] . "' min='1'>";
    echo "<input type='submit' value='Update Quantity'>";
    echo "</form>";

    echo "<br>";

    // Button for removing item
    echo "<form onsubmit='handleSubmit(this); return false;' method='post'>";
    echo "<input type='hidden' name='page' value='remove_from_cart'>";
    echo "<input type='hidden' name='product_id' value='" . $item['id'] . "'>";
    echo "<input type='submit' value='Remove Item'>";
    echo "</form>";

    echo "<br>";

    echo "</div>";

    $totalPrice += $item['subtotal'];
  }
  echo "<form action='index.php' method='post'>";
  echo "<input type='hidden' name='page' value='checkout'>";
  // echo "<input type='submit' value='Checkout'>";
  echo "<button style=\"font-size:24px\"><i class=\"fa fa-shopping-cart\"></i></button>";
  echo "</form>";

  echo "<h3>Total Price: $" . $totalPrice . "</h3>";

  // JavaScript function
  echo "<script>
   function handleSubmit(form) {
       var formData = new FormData(form);
       fetch('index.php', {
           method: 'POST',
           body: formData
       }).then(response => {
           if (response.ok) {
               window.location.href = 'index.php?page=shoppingcart';
           } else {
               alert('Error submitting form');
           }
       }).catch(error => console.error('Error:', error));
   }
   </script>";
}



function addToCart($productId)
{
  if (!isset($_SESSION['cart']))
  {
    $_SESSION['cart'] = [];
  }

  // Check if the product is already in the cart
  if (isset($_SESSION['cart'][$productId]))
  {
    $_SESSION['cart'][$productId]++; // Increase quantity
  } else
  {
    $_SESSION['cart'][$productId] = 1; // Add product with quantity 1
  }
}


function getCartItems()
{
  if (!isset($_SESSION['cart']))
  {
    return [];
  }

  $cartItems = [];
  foreach ($_SESSION['cart'] as $productId => $quantity)
  {
    $product = getProductById($productId);
    if ($product)
    {
      $product['quantity'] = $quantity;
      $product['subtotal'] = $quantity * $product['price'];
      $cartItems[] = $product;
    }
  }
  return $cartItems;
}

function updateCartQuantity($productId, $quantity)
{
  if (isset($_SESSION['cart'][$productId]))
  {
    if ($quantity > 0)
    {
      $_SESSION['cart'][$productId] = $quantity;
    } else
    {
      unset($_SESSION['cart'][$productId]); // Remove item if quantity is 0
    }
  }
}

function removeFromCart($productId)
{
  if (isset($_SESSION['cart'][$productId]))
  {
    unset($_SESSION['cart'][$productId]);
  }
}

function calculateTotalPrice($cartItems)
{
  $totalPrice = 0;

  foreach ($cartItems as $item)
  {
    $totalPrice += $item['price'] * $item['quantity'];
  }

  return $totalPrice;
}


function processCheckout()
{
  $userId = $_SESSION['user_id'];

  $cartItems = getCartItems();
  $totalPrice = calculateTotalPrice($cartItems);

  // Call insertOrder to save the order in the database
  $orderPlaced = insertOrder($userId, $cartItems, $totalPrice);

  if ($orderPlaced)
  {
    $_SESSION['cart'] = []; // Empty the cart
  }
}

?>