<?php
session_start();

function doLoginUser($id, $name)
{
  // Set session variables for the logged-in user
  $_SESSION['user_logged_in'] = true;
  $_SESSION['user_id'] = $id;
  $_SESSION['user_name'] = $name;
}

function isUserLoggedIn()
{
  // Check if the user is logged in
  return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
}

function getLoggedInUserName()
{
  // Return the name of the logged-in user
  if (isUserLoggedIn())
  {
    return $_SESSION['user_name'];
  }
  return null; // No user is logged in
}

function doLogoutUser()
{
  // Unset session variables and destroy the session
  unset($_SESSION['user_logged_in']);
  unset($_SESSION['user_name']);
  session_destroy();
}



function showMenu()
{
  echo "<nav>
    <ul class=\"menu\">
    <li><a href=\"index.php?page=home\">Home</a></li>
    <li><a href=\"index.php?page=about\">About</a></li>
    <li><a href=\"index.php?page=contact\">Contact</a></li>
    <li><a href=\"index.php?page=webshop\">Webshop</a></li>";

  if (isUserLoggedIn())
  {
    echo "<li><a href=\"index.php?page=shoppingcart\">ShoppingCart</a></li>";
    echo "<li><a href=\"index.php?page=logout\">Logout[";
    echo getLoggedInUserName()."]";
    echo "</a></li>";
    echo "<li><a href=\"index.php?page=change_password\">Change Password</a></li>";
  } else
  {
    echo "<li><a href=\"index.php?page=register\">Register</a></li>
      <li><a href=\"index.php?page=login\">Login</a></li>";
  }
  ;
  echo "</ul>
</nav>";
}

?>