<?php

function showProductDetails($product)
{
  if ($product)
  {
    echo "<br>";
    echo "<div class='product-detail'>";
    echo "<img src='Images/" . $product['file_name'] . "' alt='" . $product['name'] . "' style='width: 60%;' />";
    echo "<h2>" . $product['name'] . "</h2>";
    echo "<h3>Price: €" . $product['price'] . "</h3>";
    echo "<h3>Description: " . $product['description'] . "</h3>";
    echo "</div>";

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

  } else
  {
    echo "<p>Product not found.</p>";
  }
}

?>