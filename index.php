<?php
// session_start();

// // Database configuration
// $servername = '127.0.0.1';
// $username = 'amr_web_shop_user';
// $password = 'Amr-ma,236037';
// $dbname = 'amr_webshop';

// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// if (!$conn)
// {
//   die("Connection failed: " . mysqli_connect_error());
// }


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
      if ($data['valid'])
      {
        doLoginUser($data['name']);
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
      if ($data['valid'])
      {
        $page = 'login';
      }
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

// function showMenu()
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

// function getPostVar($key, $default = '')
// {
//   if (isset($_POST[$key]))
//   {
//     return testInput($_POST[$key]);
//   }
//   return $default;
// }

// function testInput($data)
// {
//   $data = trim($data);
//   $data = stripslashes($data);
//   $data = htmlspecialchars($data);
//   return $data;
// }

// function getVar($key, $default = '')
// {
//   if (isset($_GET[$key]))
//   {
//     return testInput($_GET[$key]);
//   }
//   return $default;
// }

// function validateContactForm()
// {
//   $formData = [
//     'gender' => '',
//     'name' => '',
//     'email' => '',
//     'phone' => '',
//     'street' => '',
//     'housenumber' => '',
//     'addition' => '',
//     'zipcode' => '',
//     'city' => '',
//     'province' => '',
//     'country' => '',
//     'message' => '',
//     'contact' => ''
//   ];
//   $errors = [];

//   $valid = false;

//   // check whether the form is sent
//   if ($_SERVER['REQUEST_METHOD'] === 'POST')
//   {
//     foreach ($formData as $key => $value)
//     {
//       $formData[$key] = getPostVar($key);
//     }

//     if (empty($formData['gender']))
//     {
//       $errors['gender'] = 'Select your gender.';
//     }

//     if (empty($formData['name']))
//     {
//       $errors['name'] = 'Insert a name.';
//     }

//     if (empty($formData['message']))
//     {
//       $errors['message'] = 'Write your message.';
//     }

//     if (empty($formData['contact']))
//     {
//       $errors['contact'] = 'Choose your preferred contact method.';
//     } else
//     {
//       // Additional validation based on the chosen method
//       switch ($formData['contact'])
//       {
//         case 'email':
//           if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL) || empty($formData['email']))
//           {
//             $errors['email'] = 'Insert a valid e-mail address.';
//           }
//           break;
//         case 'phone':
//           if (empty($formData['phone']))
//           {
//             $errors['phone'] = 'Insert a phone number.';
//           }
//           break;
//         case 'post':
//           if (
//             empty($formData['street']) || empty($formData['housenumber']) ||
//             empty($formData['zipcode']) || empty($formData['city']) || empty($formData['province']) || empty($formData['country'])
//           )
//           {
//             $errors['street'] = 'Inster a street name.';
//             $errors['housenumber'] = 'Insert a house number.';
//             $errors['zipcode'] = 'Insert a zip code.';
//             $errors['city'] = 'Insert a city.';
//             $errors['province'] = 'Insert a province.';
//             $errors['country'] = 'Insert a country.';
//           }
//           break;
//       }
//     }

//     if (empty($errors))
//     {
//       $valid = true;
//     }
//   }
//   return [
//     'valid' => $valid,
//     'errors' => $errors,
//     'formData' => $formData
//   ];
// }

// function validateRegisterForm()
// {
//   global $conn; // Use the global connection variable

//   $registerData = [
//     'regname' => '',
//     'regemail' => '',
//     'regpassword1' => '',
//     'regpassword2' => '',
//   ];
//   $errors = [];

//   $regvalid = false;

//   if ($_SERVER['REQUEST_METHOD'] === 'POST')
//   {
//     foreach ($registerData as $key => $value)
//     {
//       $registerData[$key] = getPostVar($key);
//     }

//     // Validation checks
//     if (empty($registerData['regname']))
//     {
//       $errors['regname'] = 'Insert a name.';
//     }

//     if (empty($registerData['regemail']) || !filter_var($registerData['regemail'], FILTER_VALIDATE_EMAIL))
//     {
//       $errors['regemail'] = 'Please insert a valid email';
//     }


//     if (empty($registerData['regpassword1']))
//     {
//       $errors['regpassword1'] = 'Please insert a password';
//     }
//     if (empty($registerData['regpassword2']))
//     {
//       $errors['regpassword2'] = 'Please insert the password one more time';
//     }
//     if (isset($registerData['regpassword1']) && isset($registerData['regpassword2']))
//     {
//       if ($registerData['regpassword1'] != $registerData['regpassword2'])
//       {
//         $errors['regpassword2'] = 'The second password does not match the first password!';
//       }
//     }

//     if (empty($errors))
//     {
//       // Check if email already exists
//       $sql = "SELECT email FROM users WHERE email = '" . mysqli_real_escape_string($conn, $registerData['regemail']) . "'";
//       $result = mysqli_query($conn, $sql);
//       if (mysqli_num_rows($result) > 0)
//       {
//         $errors['regemail'] = "Email already exists!";
//       } else
//       {
//         // Email does not exist, insert new user
//         $hashedPassword = password_hash($registerData['regpassword1'], PASSWORD_DEFAULT); // Hash the password
//         $insertSql = "INSERT INTO users (name, email, password) VALUES ('" . mysqli_real_escape_string($conn, $registerData['regname']) . "', '" . mysqli_real_escape_string($conn, $registerData['regemail']) . "', '$hashedPassword')";
//         if (mysqli_query($conn, $insertSql))
//         {
//           $regvalid = true; // Registration successful
//         } else
//         {
//           // Handle error, e.g. database insertion failed
//           echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
//         }
//       }

//       mysqli_free_result($result);
//     }
//   }

//   return [
//     'regvalid' => $regvalid,
//     'errors' => $errors,
//     'registerData' => $registerData
//   ];
// }

// function validateLoginForm()
// {
//   global $conn; // Use the global connection variable

//   $loginData = [
//     'logemail' => '',
//     'logpassword' => '',
//   ];
//   $errors = [];

//   $logvalid = false;

//   if ($_SERVER['REQUEST_METHOD'] === 'POST')
//   {
//     foreach ($loginData as $key => $value)
//     {
//       $loginData[$key] = getPostVar($key);
//     }

//     // Check if email and password are not empty
//     if (empty($loginData['logemail']))
//     {
//       $errors['logemail'] = 'Please enter your email.';
//     }

//     if (empty($loginData['logpassword']))
//     {
//       $errors['logpassword'] = 'Please enter your password.';
//     }

//     // Prepare and execute the SQL statement
//     $sql = "SELECT name, password FROM users WHERE email = ?";
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "s", $loginData['logemail']);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);

//     if ($row = mysqli_fetch_assoc($result))
//     {
//       if (password_verify($loginData['logpassword'], $row['password']))
//       {
//         $_SESSION['user'] = ['logemail' => $loginData['logemail'], 'logname' => $row['name']];
//         $logvalid = true;
//       } else
//       {
//         if (!empty($loginData['logpassword']))
//           $errors['logpassword'] = 'Incorrect password. Please try again.';
//       }
//     } else
//     {
//       if (!empty($loginData['logemail']))
//         $errors['logemail'] = 'Email address not found. Please try again or register.';
//     }

//     mysqli_free_result($result);
//   }

//   return [
//     'logvalid' => $logvalid,
//     'errors' => $errors,
//     'loginData' => $loginData
//   ];
// }


// function validateChangePasswordForm()
// {
//   global $conn; // Use the global connection variable

//   $changeData = [
//     'old_password' => '',
//     'new_password' => '',
//     'confirm_new_password' => '',
//   ];
//   $errors = [];
//   $changevalid = false;

//   if ($_SERVER['REQUEST_METHOD'] === 'POST')
//   {

//     foreach ($changeData as $key => $value)
//     {
//       $changeData[$key] = getPostVar($key);
//     }

//     // Validation checks
//     if (empty($changeData['old_password']))
//     {
//       $errors['old_password'] = 'Please enter your old password.';
//     }
//     if (empty($changeData['new_password']))
//     {
//       $errors['new_password'] = 'Please enter a new password.';
//     } elseif ($changeData['new_password'] === $changeData['old_password'])
//     {
//       $errors['new_password'] = 'New password cannot be the same as the old password.';
//     }
//     if ($changeData['new_password'] !== $changeData['confirm_new_password'])
//     {
//       $errors['confirm_new_password'] = 'Passwords do not match.';
//     }

//     // Check old password and update new password
//     if (empty($errors))
//     {
//       $email = $_SESSION['user']['logemail'];
//       // Query to fetch the user's current password
//       $sql = "SELECT password FROM users WHERE email = ?";
//       $stmt = mysqli_prepare($conn, $sql);
//       mysqli_stmt_bind_param($stmt, "s", $email);
//       mysqli_stmt_execute($stmt);
//       $result = mysqli_stmt_get_result($stmt);

//       if ($row = mysqli_fetch_assoc($result))
//       {
//         if (password_verify($changeData['old_password'], $row['password']))
//         {
//           // Update password
//           $hashedPassword = password_hash($changeData['new_password'], PASSWORD_DEFAULT);
//           $updateSql = "UPDATE users SET password = ? WHERE email = ?";
//           $updateStmt = mysqli_prepare($conn, $updateSql);
//           mysqli_stmt_bind_param($updateStmt, "ss", $hashedPassword, $email);
//           if (mysqli_stmt_execute($updateStmt))
//           {
//             $changevalid = true;
//           }
//           mysqli_stmt_close($updateStmt);
//         } else
//         {
//           $errors['old_password'] = 'Incorrect old password.';
//         }
//       }
//       mysqli_stmt_close($stmt);
//     }
//   }
//   return [
//     'changevalid' => $changevalid,
//     'errors' => $errors,
//     'changeData' => $changeData
//   ];
// }

// function showResponsePage($page)
// {
//   if ($page === 'contact') {
//     $formResult = validateContactForm();
//     include 'contact.php';
//   } elseif ($page === 'register') {
//     $registerResult = validateRegisterForm();
//    if ($registerResult['regvalid']) {
//    $_SESSION['registration_success'] = true;
//       include 'login.php';
//     } else {
//       include 'register.php';
//     }
//   } elseif ($page === 'login') {
//     $loginResult = validateLoginForm();
//     if ($loginResult['logvalid']) {
//       include 'home.php';
//     } else {
//       include 'login.php';
//     }
//   } elseif ($page === 'logout') {
//     session_destroy();
//     session_start();
//     include 'home.php';
//   } elseif ($page === 'change_password') {
//     $changeResult = validateChangePasswordForm();
//     if ($changeResult['changevalid']) {
//       echo "<p>Password changed successfully.</p>";
//       include 'home.php';  // Redirect to home after successful change
//     } else {
//       include 'change_password.php';  // Show change password form with errors
//     }
//   } else {
//     switch ($page) {
//       case 'home':
//         include 'home.php';
//         break;
//       case 'about':
//         include 'about.php';
//         break;
//       default:
//         include '404.php';
//         break;
//     }
//   }
// }

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


// Close the database connection at the end of the script
// $conn->close();