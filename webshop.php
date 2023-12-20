<?php
// include 'product_detail.php';
// function showWebshopContent()
// {
//   $products = getProducts();

//   // echo "<div class='products'>";
//   echo "<div class=\"row\">";
//   echo "<br>";
//   echo "<br>";
//   foreach ($products as $product)
//   {
//     // echo "<div class='product'>";
//     echo "<div class=\"column\">";
//     // </div>
//     echo "<br>";
//     // Link to product details page
//     echo "<a href='index.php?page=product_details&product_id=" . $product['id'] . "' style='cursor: pointer;'>";
//     echo "<img src='Images/" . $product['file_name'] . "' alt='" . htmlspecialchars($product['name']) . "' style='width: 45%;' />";
//     echo "</a>";
//     echo "<h3> id: " . $product['id'] . "</h3>";
//     echo "<h3>" . $product['name'] . "</h3>";
//     echo "<h3>Price: €" . $product['price'] . "</h3>";

//     echo "</form>";
//     echo "<br>";

//     if (isUserLoggedIn())
//     {
//       echo "<form action='index.php' method='post' onsubmit='redirectToCart()'>";
//       echo "<input type='hidden' name='page' value='shoppingcart'>";
//       echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
//       echo "<button style=\"font-size:12px\">Add to Cart <i class=\"fa fa-shopping-cart\"></i></button>";
//       echo "</form>";

//       echo "<script>
//       function redirectToCart() {
//           setTimeout(function() {
//               window.location.href = 'index.php?page=shoppingcart';
//           }, 10); // Redirect after a short delay
//       }
//       </script>";
//     }
//     echo "</div>";

//   }
//   echo "</div>";
// }
function showWebshopContent()
{
  $products = getProducts();

  echo "<div class=\"row\">";

  // Check if the user is an admin and display the Add Product button
  echo "<br>";
  echo "<br>";
  if (isUserAdmin())
  {
    echo "<div class='add-product-button'>";
    echo "<a href='index.php?page=add_product' style='cursor: pointer;'>Add New Product</a>";
    echo "</div>";
  }

  foreach ($products as $product)
  {
    echo "<div class=\"column\">";
    echo "<br>";

    // Link to product details page
    echo "<a href='index.php?page=product_details&product_id=" . $product['id'] . "' style='cursor: pointer;'>";
    echo "<img src='Images/" . $product['file_name'] . "' alt='" . htmlspecialchars($product['name']) . "' style='width: 45%;' />";
    echo "</a>";
    echo "<h3> id: " . $product['id'] . "</h3>";
    echo "<h3>" . $product['name'] . "</h3>";
    echo "<h3>Price: €" . $product['price'] . "</h3>";

    if (isUserLoggedIn())
    {
      echo "<form action='index.php' method='post' onsubmit='redirectToCart()'>";
      echo "<input type='hidden' name='page' value='shoppingcart'>";
      echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
      echo "<button style=\"font-size:12px\">Add to Cart <i class=\"fa fa-shopping-cart\"></i></button>";
      echo "</form>";
    }

    echo "</div>";
  }
  echo "</div>";
}

?>