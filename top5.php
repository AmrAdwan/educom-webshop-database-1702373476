<?php
function showTop5Content()
{
  $topProducts = getTop5Products();

  // echo "<div class='top-products'>";
  echo "<div class=\"row\">";
  foreach ($topProducts as $product)
  {
    echo "<div class=\"column\">";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    // echo "<div class='product'>";
    echo "<img src='Images/" . $product['file_name'] . "' alt='" . $product['name'] . "' style='width: 50%;' />";
    echo "<h3>" . $product['name'] . "</h3>";
    echo "<p>Total Sold: " . $product['total_quantity'] . "</p>";
    echo "</div>";
  }
  echo "</div>";
}



?>