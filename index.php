<?php
// session_start();

include 'home.php';
include 'about.php';
include '404.php';
include 'register.php';
include 'login.php';
include 'contact.php';
include 'thanks.php';
include 'change_password.php';
include 'validations.php';
include 'session_manager.php';
include 'webshop.php';
include 'product_details.php';
include 'shoppingcart.php';


function processRequest($page)
{
  switch ($page)
  {
    case 'login':
      $data = validateLogin();
      if ($data['logvalid'])
      {
        doLoginUser($data['id'], $data['name']);
        $page = 'home';
      }
      break;
    case 'logout':
      doLogoutUser();
      $page = 'home';
      break;
    case 'contact':
      $data = validateContact();
      if ($data['valid'])
      {
        $page = 'thanks';
      }
      break;
    case 'register':
      $data = validateRegister();
      if ($data['regvalid'])
      {
        $page = 'login';
      }
      break;
    case 'product_details':
      if (isset($_POST['product_id']))
      {
        $productId = $_POST['product_id'];
        $product = getProductById($productId);
        if ($product)
        {
          $data['product'] = $product;
          $page = 'product_details';
        }
      }
      break;
    case 'shoppingcart':
      if (isset($_POST['product_id']))
      {
        // Function to add product to cart
        addToCart($_POST['product_id']);
      }
      // Always show the shopping cart page, whether or not a new item was added
      $page = 'shoppingcart';
      $data['cart'] = getCartItems(); // Function to get items in the cart
      break;
    case 'update_cart':
      if (isset($_POST['product_id']) && isset($_POST['quantity']))
      {
        updateCartQuantity($_POST['product_id'], $_POST['quantity']);
      }
      break;

    case 'remove_from_cart':
      if (isset($_POST['product_id']))
      {
        removeFromCart($_POST['product_id']);
      }
      break;
    case 'change_password':
      $data = validateChangePassword();
      if ($data['changevalid'])
      {
        echo "<script>alert('Password changed successfully!');</script>";
        $page = 'home';
      } else
        echo "<script>alert('Failure!');</script>";
      break;
  }

  $data['page'] = $page;
  return $data;
}

function showHtmlstatement()
{
  echo "<!DOCTYPE html>\n";
  "<html>";
}

function showHeadSection($data)
{
  echo "<head>";
  echo "<title>";
  switch ($data['page'])
  {
    case 'home':
    case 'logout':
      echo "Home";
      break;
    case 'about':
      echo "About";
      break;
    case 'contact':
      echo "Contact";
      break;
    case 'thanks':
      echo 'Thanks';
      break;
    case 'register':
      echo "Register";
      break;
    case 'login':
      echo "Login";
      break;
    case 'change_password':
      echo "Change Password";
      break;
    case 'webshop':
      echo 'Webshop';
      break;
    case 'product_details':
      echo 'Product Details';
      break;
    case 'shoppingcart':
      echo 'Shopping Cart';
      break;
    default:
      echo "404 Not Found";
      echo "</title>";
      echo "</head>";
      break;
  }
  if ($data != '404')
  {
    echo "</title>";
    echo "<link rel=\"stylesheet\" href=\"./CSS/stylesheet.css\">";
    echo "</head>";
  }
}

function showHeader($data)
{
  echo "<h1>";
  switch ($data['page'])
  {
    case 'home':
    case 'logout':
      echo "Home";
      break;
    case 'about':
      echo "About";
      break;
    case 'contact':
      echo "Contact";
      break;
    case 'thanks':
      echo "Thanks";
      break;
    case 'register':
      echo "Register";
      break;
    case 'login':
      echo "Login";
      break;
    case 'change_password':
      echo "Change Password";
      break;
    case 'webshop':
      echo "Webshop";
      break;
    case 'product_details':
      echo 'Product Details';
      break;
    case 'shoppingcart':
      echo 'Shopping Cart';
      break;
    default:
      echo '404 Page Not Found';
      break;
  }
  echo "</h1>";
}

function showContent($data)
{
  switch ($data['page'])
  {
    case 'home':
      showHomeContent();
      break;
    case 'about':
      showAboutContent();
      break;
    case 'contact':
      showContactForm($data);
      break;
    case 'thanks':
      showContactThanks($data);
      break;
    case 'login':
      showLoginForm($data);
      break;
    case 'register':
      showRegisterForm($data);
      break;
    case 'change_password':
      showChangePasswordForm($data);
      break;
    case 'webshop':
      showWebshopContent();
      break;
    case 'product_details':
      if (isset($data['product']))
      {
        showProductDetails($data['product']);
      }
      break;
    case 'shoppingcart':
      if (isset($data['cart']))
      {
        showshoppingcartContent($data['cart']);
      }
      break;
    default:
      show404Content();
      break;
  }
}

function showFooter()
{
  echo "<footer>";
  echo "<p>&copy; Amr Adwan 2023</p>";
  echo "</footer>";
}
function showBodySection($data)
{
  echo "<body>";
  ShowHeader($data);

  if ($data['page'] !== "404")
  {
    echo "<div class=\"text\">";
    showMenu();
  }
  showContent($data);
  echo "</div>";
  if ($data['page'] !== "404")
    showFooter();
  echo "</body>";
}

function showHtmlEnd()
{
  echo "</html>";
}

function getRequestedPage()
{
  // A list of allowed pages
  $allowedPages = ['home', 'about', 'contact', 'register', 'login', 'logout',
    'change_password', 'thanks', 'webshop', 'product_details', 'shoppingcart'];

  // Check if it's a POST request
  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    // Check the form_type field to determine which form was submitted
    if (isset($_POST['form_type']))
    {
      if ($_POST['form_type'] === 'register')
      {
        return 'register';
      } else if ($_POST['form_type'] === 'contact')
      {
        return 'contact';
      } else if ($_POST['form_type'] === 'login')
      {
        return 'login';
      } elseif ($_POST['form_type'] === 'change_password')
      {
        return 'change_password';
      }
    } elseif (isset($_POST['page']))
    {
      return $_POST['page'];
    }
  }

  // Retrieving the 'page' parameter from the GET request
  $requestedPage = $_GET['page'] ?? null;

  // Check whether the requested page is in the list of allowed pages
  if (in_array($requestedPage, $allowedPages))
  {
    return $requestedPage;
  }

  // Return '404' for any other cases
  return '404';
}

function showResponsePage($data)
{
  showHtmlstatement();
  showHeadSection($data);
  showBodySection($data);
  showHtmlEnd();
}

$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);