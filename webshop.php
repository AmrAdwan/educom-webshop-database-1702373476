<?php
// include 'product_detail.php';
function showWebshopContent()
{
  $products = getProducts();

  // echo "<div class='products'>";
  echo "<div class=\"row\">";
  echo "<br>";
  echo "<br>";
  foreach ($products as $product)
  {
    // echo "<div class='product'>";
    echo "<div class=\"column\">";
  // </div>
    echo "<br>";
    echo "<img src='Images/" . $product['file_name'] . "' alt='" . $product['name'] . "' style='width: 45%;' />";
    echo "<h3> id: " . $product['id'] . "</h3>";
    echo "<h3>" . $product['name'] . "</h3>";
    echo "<h3>Price: €" . $product['price'] . "</h3>";
    echo "<form action='index.php' method='post'>";
    echo "<input type='hidden' name='page' value='product_details'>";
    echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
    // echo "<input type='submit' value='View Details'>";
    echo "<button style=\"font-size:12px\">View Details <i class=\"fa fa-info-circle\"></i></button>";
    echo "</form>";
    // echo "</div>";
    echo "<br>";

    if (isUserLoggedIn())
    {
      echo "<form action='index.php' method='post' onsubmit='redirectToCart()'>";
      echo "<input type='hidden' name='page' value='shoppingcart'>";
      echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
      // echo "<input type='submit' value='Add to Cart'>";
      echo "<button style=\"font-size:12px\">Add to Cart <i class=\"fa fa-shopping-cart\"></i></button>";
      echo "</form>";

      echo "<script>
      function redirectToCart() {
          setTimeout(function() {
              window.location.href = 'index.php?page=shoppingcart';
          }, 10); // Redirect after a short delay
      }
      </script>";
    }
    echo "</div>";

  }
  echo "</div>";
}

?>