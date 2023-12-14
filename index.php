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
    case 'change_password':
      $data = validateChangePassword();
      if ($data['changevalid'])
      {
        // echo "<p>Password changed successfully.</p>";
        echo "<script>alert('Password changed successfully!');</script>";
        $page = 'home';
      }
      else
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
    default:
      echo '404 Page Not Found';
      break;
  }
  echo "</h1>";
}
// {
//   echo "<nav>
//     <ul class=\"menu\">
//     <li><a href=\"index.php?page=home\">Home</a></li>
//     <li><a href=\"index.php?page=about\">About</a></li>
//     <li><a href=\"index.php?page=contact\">Contact</a></li>";

//   if (isset($_SESSION['user']))
//   {
//     echo "<li><a href=\"index.php?page=logout\">Logout[";
//     echo $_SESSION['user']['logname'] . "]";
//     echo "</a></li>";
//     echo "<li><a href=\"index.php?page=change_password\">Change Password</a></li>";
//   } else
//   {
//     echo "<li><a href=\"index.php?page=register\">Register</a></li>
//       <li><a href=\"index.php?page=login\">Login</a></li>";
//   }
//   ;
//   echo "</ul>
// </nav>";
// }



// function showContent($page)
// {
//   echo "<div class=\"text\">";
//   switch ($page)
//   {
//     case 'home':
//       include('home.php');
//       showHomeContent();
//       break;
//     case 'about':
//       include('about.php');
//       showAboutContent();
//       break;
//     case 'contact':
//       $formResult = validateContact();
//       include('contact.php');
//       showContactContent($formResult);
//       break;
//     case 'register':
//       $registerResult = validateRegister();
//       include('register.php');
//       showRegisterContent($registerResult);
//       if ($registerResult['regvalid'])
//       {
//         $_SESSION['registration_success'] = true;
//         include('login.php');
//         showLoginContent($loginResult);
//       }
//       break;
//     case 'login':
//       $loginResult = validateLogin();
//       include('login.php');
//       showLoginContent($loginResult);
//       if ($loginResult['logvalid'])
//       {
//         include 'home.php';
//         showHomeContent();
//       }
//       break;
//     case 'logout':
//       session_destroy();
//       session_start();
//       include('home.php');
//       showHomeContent();
//       break;
//     case 'change_password':
//       $changeResult = validateChangePassword();
//       include('change_password.php');
//       showChangePasswordContent($changeResult);
//       if ($changeResult['changevalid'])
//       {
//         echo "<p>Password changed successfully.</p>";
//         include('home.php');  // Redirect to home after successful change
//         showHomeContent();
//       }
//       break;
//     default:
//       include('404.php');
//       show404Content();
//       break;
//   }
//   echo "</div>";
// }

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
  $allowedPages = ['home', 'about', 'contact', 'register', 'login', 'logout', 'change_password', 'thanks'];

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