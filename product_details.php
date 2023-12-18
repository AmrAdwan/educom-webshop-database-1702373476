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
  } else
  {
    echo "<p>Product not found.</p>";
  }
}

?>