<?php
// include 'product_detail.php';
function showWebshopContent()
{
  $products = getProducts();

  echo "<div class='products'>";
  echo "<br>";
  echo "<br>";
  foreach ($products as $product)
  {
    echo "<div class='product'>";
    echo "<img src='Images/" . $product['file_name'] . "' alt='" . $product['name'] . "' style='width: 30%;' />";
    echo "<h3> id: " . $product['id'] . "</h3>";
    echo "<h3>" . $product['name'] . "</h3>";
    echo "<h3>Price: €" . $product['price'] . "</h3>";
    echo "<form action='index.php' method='post'>";
    echo "<input type='hidden' name='page' value='product_details'>";
    echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
    echo "<input type='submit' value='View Details'>";
    echo "</form>";
    echo "</div>";
    echo "<br>";

    if (isUserLoggedIn())
    {
      echo "<form action='index.php' method='post' onsubmit='redirectToCart()'>";
      echo "<input type='hidden' name='page' value='shoppingcart'>";
      echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
      echo "<input type='submit' value='Add to Cart'>";
      echo "</form>";

      echo "<script>
      function redirectToCart() {
          setTimeout(function() {
              window.location.href = 'index.php?page=shoppingcart';
          }, 10); // Redirect after a short delay
      }
      </script>";
    }

  }
  echo "</div>";
}

?>