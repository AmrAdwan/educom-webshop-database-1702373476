<?php
function getErrorAddProduct($addProductResult, $key)
{
  return isset($addProductResult['errors'][$key]) ? $addProductResult['errors'][$key] : '';
}
// function getErrorEditProduct($editProductResult, $key)
// {
//   return isset($editProductResult['errors'][$key]) ? $editProductResult['errors'][$key] : '';
// }


// if (isset($_GET['product_id']))
// {
// function showEditProductForm($editProductResult)
// {
//   if (!isset($editProductResult['editvalid']) || !$editProductResult['editvalid'])
//   {
//     $productId = $_GET['product_id'];
//     $product = getProductById($productId);

//     // Extract form data for convenience
//     $editProductData = $editProductResult['editData'] ?? [];

//     echo "<br><br>";
//     echo "<div class=\"formcarry-container\">";
//     echo "<form action=\"index.php\" method=\"POST\" enctype=\"multipart/form-data\" class=\"formcarry-form\">";
//     echo "<input type=\"hidden\" name=\"page\" value=\"add_product\">";

//     // Product Name
//     echo "<div class=\"input\">";
//     echo "<label for='editname'>Product Name:</label>";
//     echo "<input type=\"text\" id=\"editname\" name=\"editname\" value=\"" . htmlspecialchars($editProductData['editname'] ?? '') . "\">";
//     echo "<span class=\"error\"> *" . getErrorEditProduct($editProductResult, 'editname') . "</span>";
//     // echo "</div>";

//     echo "<br>";
//     echo "<br>";
//     // Description
//     echo "<label for=\"editdescription\">Description:</label>";
//     echo "<br>";
//     echo "<textarea id=\"editdescription\" name=\"editdescription\" cols=\"30\" rows=\"10\">" . htmlspecialchars($editProductData['editdescription'] ?? '') . "</textarea>";
//     echo "<span class=\"error\"> *" . getErrorEditProduct($editProductResult, 'editdescription') . "</span>";

//     echo "<br>";
//     echo "<br>";

//     // Price
//     echo "<label for=\"editprice\">Price (€):</label>";
//     echo "<input id=\"editprice\" name=\"editprice\" step=\"0.01\" value=\"" . htmlspecialchars($editProductData['editprice']) . "\">";
//     echo "<span class=\"error\"> *" . getErrorEditProduct($editProductResult, 'editprice') . "</span>";

//     echo "<br>";
//     echo "<br>";

//     // Image Upload
//     echo "<label for=\"editimage\">Product Image:</label>";
//     echo "<input type=\"file\" id=\"editimage\" name=\"editimage\ . value\"" . htmlspecialchars($editProductData['editimage'] ?? '') . "\">";
//     echo "<span class=\"error\">*" . getErrorEditProduct($editProductResult, 'editimage') . "</span>";

//     echo "<br>";
//     echo "<br>";

//     // Submit Button
//     echo "<input type=\"submit\" value=\"Edit Product\">";
//     echo "</div>";

//     echo "</form>";
//     echo "</div>";
//   }
// }
// } else
// {
function showAddProductForm($addProductResult)
{
  if (!isset($addProductResult['addvalid']) || !$addProductResult['addvalid'])
  {
    // Extract form data for convenience
    $addProductData = $addProductResult['addData'] ?? [];

    echo "<br><br>";
    echo "<div class=\"formcarry-container\">";
    echo "<form action=\"index.php\" method=\"POST\" enctype=\"multipart/form-data\" class=\"formcarry-form\">";
    echo "<input type=\"hidden\" name=\"page\" value=\"add_product\">";

    // Product Name
    echo "<div class=\"input\">";
    echo "<label for=\"prodname\">Product Name:</label>";
    echo "<input type=\"text\" id=\"prodname\" name=\"prodname\" value=\"" . htmlspecialchars($addProductData['prodname'] ?? '') . "\">";
    echo "<span class=\"error\"> *" . getErrorAddProduct($addProductResult, 'prodname') . "</span>";
    // echo "</div>";

    echo "<br>";
    echo "<br>";
    // Description
    echo "<label for=\"proddescription\">Description:</label>";
    echo "<br>";
    echo "<textarea id=\"proddescription\" name=\"proddescription\" cols=\"30\" rows=\"10\">" . htmlspecialchars($addProductData['proddescription'] ?? '') . "</textarea>";
    echo "<span class=\"error\"> *" . getErrorAddProduct($addProductResult, 'proddescription') . "</span>";

    echo "<br>";
    echo "<br>";

    // Price
    echo "<label for=\"prodprice\">Price (€):</label>";
    echo "<input id=\"prodprice\" name=\"prodprice\" step=\"0.01\" value=\"" . htmlspecialchars($addProductData['prodprice'] ?? '') . "\">";
    echo "<span class=\"error\"> *" . getErrorAddProduct($addProductResult, 'prodprice') . "</span>";

    echo "<br>";
    echo "<br>";

    // Image Upload
    echo "<label for=\"prodimage\">Product Image:</label>";
    echo "<input type=\"file\" id=\"prodimage\" name=\"prodimage\">";
    echo "<span class=\"error\">*" . getErrorAddProduct($addProductResult, 'prodimage') . "</span>";

    echo "<br>";
    echo "<br>";

    // Submit Button
    echo "<input type=\"submit\" value=\"Add Product\">";
    echo "</div>";

    echo "</form>";
    echo "</div>";
  }
}
// }
