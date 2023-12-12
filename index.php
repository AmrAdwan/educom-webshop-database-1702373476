<?php
session_start();

// Database configuration
$servername = '127.0.0.1';
$username = 'amr_web_shop_user';
$password = 'Amr-ma,236037';
$dbname = 'amr_webshop';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn)
{
  die("Connection failed: " . mysqli_connect_error());
}

function showHtmlstatement()
{
  echo "<!DOCTYPE html>\n";
  "<html>";
}

function showHeadSection($page)
{
  echo "<head>";
  echo "<title>";
  switch ($page)
  {
    case 'home':
      echo "Home";
      break;
    case 'about':
      echo "About";
      break;
    case 'contact':
      echo "Contact";
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
      break;
  }
  echo "</title>";
  echo "<link rel=\"stylesheet\" href=\"./CSS/stylesheet.css\">";
  echo "</head>";
}

function showHeader($page)
{
  echo "<h1>";
  switch ($page)
  {
    case 'home':
      echo "Home";
      break;
    case 'about':
      echo "About";
      break;
    case 'contact':
      echo "Contact";
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

function showMenu()
{
  echo "<nav>
    <ul class=\"menu\">
    <li><a href=\"index.php?page=home\">Home</a></li>
    <li><a href=\"index.php?page=about\">About</a></li>
    <li><a href=\"index.php?page=contact\">Contact</a></li>";

  if (isset($_SESSION['user']))
  {
    echo "<li><a href=\"index.php?page=logout\">Logout[";
    echo htmlspecialchars($_SESSION['user']['logname']);
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

function showContent($page)
{
  echo "<div class=\"text\">";
  switch ($page)
  {
    case 'home':
      include('home.php');
      showHomeContent();
      break;
    case 'about':
      include('about.php');
      showAboutContent();
      break;
    case 'contact':
      $formResult = validateContactForm();
      include('contact.php');
      showContactContent($formResult);
      break;
    case 'register':
      include('register.php');
      showRegisterContent();
      break;
    case 'login':
      include('login.php');
      showLoginContent();
      break;
    case 'change_password':
      include('change_password.php');
      showChangePasswordContent();
      break;
    default:
      include('404.php');
      show404Content();
      break;
  }
  echo "</div>";
}

function showFooter()
{
  echo "<footer>";
  echo "<p>&copy; Amr Adwan 2023</p>";
  echo "</footer>";
}
function showBodySection($page)
{
  echo "<body>";
  ShowHeader($page);
  echo "<div class=\"text\">";
  showMenu();
  showContent($page);
  echo "</div>";
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
  $allowedPages = ['home', 'about', 'contact', 'register', 'login', 'logout', 'change_password'];

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

function getPostVar($key, $default = '')
{
  if (isset($_POST[$key]))
  {
    return testInput($_POST[$key]);
  }
  return $default;
}

function testInput($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function getVar($key, $default = '')
{
  if (isset($_GET[$key]))
  {
    return testInput($_GET[$key]);
  }
  return $default;
}

function validateContactForm()
{
  $formData = [
    'gender' => '',
    'name' => '',
    'email' => '',
    'phone' => '',
    'street' => '',
    'housenumber' => '',
    'addition' => '',
    'zipcode' => '',
    'city' => '',
    'province' => '',
    'country' => '',
    'message' => '',
    'contact' => ''
  ];
  $errors = [];

  // $gender = $name = $email = $phone = $street = $housenumber = $addition = $zipcode =
  //   $city = $province = $country = $message = $contactmethod = '';
  // $genderErr = $nameErr = $emailErr = $phoneErr = $streetErr =
  //   $housenumberErr = $zipcodeErr = $cityErr = $provinceErr = $countryErr =
  //   $messageErr = $contactmethodErr = '';

  $valid = false;

  // check whether the form is sent
  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    // $gender = getPostVar('gender');
    // $name = getPostVar('name');
    // $email = getPostVar('email');
    // $phone = getPostVar('phone');
    // $street = getPostVar('street');
    // $housenumber = getPostVar('housenumber');
    // $addition = getPostVar('address addition');
    // $zipcode = getPostVar('zip');
    // $city = getPostVar('city');
    // $province = getPostVar('province');
    // $country = getPostVar('country');
    // $message = getPostVar('message');
    // $contactmethod = getPostVar('contact');

    foreach ($formData as $key => $value)
    {
      $formData[$key] = getPostVar($key);
    }

    if (empty($formData['gender']))
    {
      $errors['gender'] = 'Select your gender.';
    }

    if (empty($formData['name']))
    {
      $errors['name'] = 'Insert a name.';
    }

    if (empty($formData['message']))
    {
      $errors['message'] = 'Write your message.';
    }

    if (empty($formData['contact']))
    {
      $errors['contact'] = 'Choose your preferred contact method.';
    } else
    {
      // Additional validation based on the chosen method
      switch ($formData['contact'])
      {
        case 'email':
          if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL) || empty($formData['email']))
          {
            $errors['email'] = 'Insert a valid e-mail address.';
          }
          break;
        case 'phone':
          if (empty($formData['phone']))
          {
            $errors['phone'] = 'Insert a phone number.';
          }
          break;
        case 'post':
          if (
            empty($formData['street']) || empty($formData['housenumber']) ||
            empty($formData['zipcode']) || empty($formData['city']) || empty($formData['province']) || empty($formData['country'])
          )
          {
            $errors['street'] = 'Inster a street name.';
            $errors['housenumber'] = 'Insert a house number.';
            $errors['zipcode'] = 'Insert a zip code.';
            $errors['city'] = 'Insert a city.';
            $errors['province'] = 'Insert a province.';
            $errors['country'] = 'Insert a country.';
          }
          break;
      }
    }

    // if ($formData['contactmethod'] === 'email' && (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL) || empty($formData['email'])))
    // {
    //   $errors['email'] = 'Insert a valid e-mailaddress.';
    // }
    // if ($formData['contactmethod'] === 'phone' && empty($formData['phone']))
    // {
    //   $errors['phone'] = 'Insert a phone number.';
    // }
    // if (
    //   $formData['contactmethod'] === 'post' && (empty($formData['street']) || empty($formData['housenumber']) ||
    //     empty($formData['zipcode']) || empty($formData['city']) || empty($formData['province']) || empty($formData['country']))
    // )
    // {
    //   $errors['street'] = 'Inster a street name.';
    //   $errors['housenumber'] = 'Insert a house number.';
    //   $errors['zipcode'] = 'Insert a zip code.';
    //   $errors['city'] = 'Insert a city.';
    //   $errors['province'] = 'Insert a province.';
    //   $errors['country'] = 'Insert a country.';
    // }

    // if (
    //   empty($genderErr) && empty($nameErr) && empty($emailErr) && empty($phoneErr)
    //   && empty($streetErr) && empty($housenumberErr) && empty($zipcodeErr) && empty($cityErr)
    //   && empty($provinceErr) && empty($countryErr) && empty($messageErr) && empty($contactmethodErr)
    // )
    // {
    //   $valid = true;
    // }
    if (empty($errors))
    {
      $valid = true;
    }
  }
  // Collect form data
  // $formData = [
  //   'gender' => $gender,
  //   'name' => $name,
  //   'email' => $email,
  //   'phone' => $phone,
  //   'street' => $street,
  //   'housenumber' => $housenumber,
  //   'addition' => $addition,
  //   'zipcode' => $zipcode,
  //   'city' => $city,
  //   'province' => $province,
  //   'country' => $country,
  //   'message' => $message,
  //   'contactmethod' => $contactmethod
  // ];
  return [
    'valid' => $valid,
    'errors' => $errors,
    'formData' => $formData
  ];
}

function validateRegisterForm()
{
  global $conn; // Use the global connection variable

  $regname = $regemail = $regpassword1 = $regpassword2 = '';
  $regnameErr = $regemailErr = $regpassword1Err = $regpassword2Err = '';
  $regvalid = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $regname = getPostVar('regname');
    $regemail = getPostVar('regemail');
    $regpassword1 = getPostVar('regpassword1');
    $regpassword2 = getPostVar('regpassword2');


    // Validation checks
    if (empty($regname))
    {
      $regnameErr = 'Please insert your name';
    }

    if (empty($regemail) || !filter_var($regemail, FILTER_VALIDATE_EMAIL))
    {
      $regemailErr = 'Please insert a valid email';
    }

    if (empty($regpassword1))
    {
      $regpassword1Err = 'Please insert a password';
    }
    if (empty($regpassword2))
    {
      $regpassword2Err = 'Please insert the password one more time';
    }
    if (isset($regpassword1) && isset($regpassword2))
    {
      if ($regpassword1 != $regpassword2)
      {
        $regpassword2Err = 'The second password does not match the first password!';
      }
    }

    if (empty($regnameErr) && empty($regemailErr) && empty($regpassword1Err) && empty($regpassword2Err))
    {
      // Check if email already exists
      $sql = "SELECT email FROM users WHERE email = '" . mysqli_real_escape_string($conn, $regemail) . "'";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0)
      {
        $regemailErr = "Email already exists!";
      } else
      {
        // Email does not exist, insert new user
        $hashedPassword = password_hash($regpassword1, PASSWORD_DEFAULT); // Hash the password
        $insertSql = "INSERT INTO users (name, email, password) VALUES ('" . mysqli_real_escape_string($conn, $regname) . "', '" . mysqli_real_escape_string($conn, $regemail) . "', '$hashedPassword')";
        if (mysqli_query($conn, $insertSql))
        {
          $regvalid = true; // Registration successful
        } else
        {
          // Handle error, e.g. database insertion failed
          echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
      }

      mysqli_free_result($result);
    }
  }

  return [
    'regvalid' => $regvalid,
    'errors' => [
      'regnameErr' => $regnameErr,
      'regemailErr' => $regemailErr,
      'regpassword1Err' => $regpassword1Err,
      'regpassword2Err' => $regpassword2Err
    ],
    'registerData' => [
      'regname' => $regname,
      'regemail' => $regemail,
      'regpassword1' => $regpassword1,
      'regpassword2' => $regpassword2
    ]
  ];
}

function validateLoginForm()
{
  global $conn; // Use the global connection variable

  $logemail = $logpassword = '';
  $logemailErr = $logpasswordErr = '';
  $logvalid = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $logemail = getPostVar('logemail');
    $logpassword = getPostVar('logpassword');

    // Check if email and password are not empty
    if (empty($logemail))
    {
      $logemailErr = 'Please enter your email.';
      return [
        'logvalid' => $logvalid,
        'errors' => ['logemailErr' => $logemailErr, 'logpasswordErr' => $logpasswordErr],
        'loginData' => ['logemail' => $logemail, 'logpassword' => $logpassword]
      ];
    }

    if (empty($logpassword))
    {
      $logpasswordErr = 'Please enter your password.';
      return [
        'logvalid' => $logvalid,
        'errors' => ['logemailErr' => $logemailErr, 'logpasswordErr' => $logpasswordErr],
        'loginData' => ['logemail' => $logemail, 'logpassword' => $logpassword]
      ];
    }

    // Prepare and execute the SQL statement
    $sql = "SELECT name, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $logemail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result))
    {
      if (password_verify($logpassword, $row['password']))
      {
        $_SESSION['user'] = ['logemail' => $logemail, 'logname' => $row['name']];
        $logvalid = true;
      } else
      {
        $logpasswordErr = 'Incorrect password. Please try again.';
      }
    } else
    {
      $logemailErr = 'Email address not found. Please try again or register.';
    }

    mysqli_free_result($result);
  }

  return [
    'logvalid' => $logvalid,
    'errors' => ['logemailErr' => $logemailErr, 'logpasswordErr' => $logpasswordErr],
    'loginData' => ['logemail' => $logemail, 'logpassword' => $logpassword]
  ];
}


function validateChangePasswordForm()
{
  global $conn; // Use the global connection variable

  $old_password = $new_password = $confirm_new_password = '';
  $old_passwordErr = $new_passwordErr = $confirm_new_passwordErr = '';
  $changevalid = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $old_password = getPostVar('old_password');
    $new_password = getPostVar('new_password');
    $confirm_new_password = getPostVar('confirm_new_password');

    // Validation checks
    if (empty($old_password))
    {
      $old_passwordErr = 'Please enter your old password.';
    }
    if (empty($new_password))
    {
      $new_passwordErr = 'Please enter a new password.';
    } elseif ($new_password === $old_password)
    {
      $new_passwordErr = 'New password cannot be the same as the old password.';
    }
    if ($new_password !== $confirm_new_password)
    {
      $confirm_new_passwordErr = 'Passwords do not match.';
    }

    // Check old password and update new password
    if (empty($old_passwordErr) && empty($new_passwordErr) && empty($confirm_new_passwordErr))
    {
      $email = $_SESSION['user']['logemail'];
      // Query to fetch the user's current password
      $sql = "SELECT password FROM users WHERE email = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result))
      {
        if (password_verify($old_password, $row['password']))
        {
          // Update password
          $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
          $updateSql = "UPDATE users SET password = ? WHERE email = ?";
          $updateStmt = mysqli_prepare($conn, $updateSql);
          mysqli_stmt_bind_param($updateStmt, "ss", $hashedPassword, $email);
          if (mysqli_stmt_execute($updateStmt))
          {
            $changevalid = true;
          }
          mysqli_stmt_close($updateStmt);
        } else
        {
          $old_passwordErr = 'Incorrect old password.';
        }
      }
      mysqli_stmt_close($stmt);
    }
  }
  return [
    'changevalid' => $changevalid,
    'old_passwordErr' => $old_passwordErr,
    'new_passwordErr' => $new_passwordErr,
    'confirm_new_passwordErr' => $confirm_new_passwordErr
  ];
}

// function showResponsePage($page)
// {
//   if ($page === 'contact') {
//     $formResult = validateContactForm();
//     include 'contact.php';
//   } elseif ($page === 'register') {
//     $registerResult = validateRegisterForm();
//     if ($registerResult['regvalid']) {
//       $_SESSION['registration_success'] = true;
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

function showResponsePage($page)
{
  showHtmlstatement();
  showHeadSection($page);
  showBodySection($page);
  showHtmlEnd();

  // if ($page === 'contact')
  // {
  //   $formResult = validateContactForm();
  //   showContactContent($formResult);
  // }
}

$page = getRequestedPage();
showResponsePage($page);
// Close the database connection at the end of the script
$conn->close();