<?php
function showLoginContent()
{
  // if (!isset($loginResult['logvalid']) || !$loginResult['logvalid']) { /* Show the next part only when $valid is false */
    // Extract form data for convenience
    // $loginData = $loginResult['loginData'] ?? [];
    echo "<div class=\"formcarry-container\">";
    echo  "<form action=\"index.php\" method=\"POST\" class=\"formcarry-form\">";
    echo  "<!-- Hidden field to identify the login form -->";
    echo "<input type=\"hidden\" name=\"form_type\" value=\"login\">";
    echo "<div class=\"input\">";
    echo "<br>";
    echo "<br>";
    echo "<label for=\"email\">Email Address</label>";
    echo "<input type=\"email\" id=\"logemail\" name=\"logemail\" value=\"";
    // echo htmlspecialchars($loginData['logemail'] ?? '');
    echo "\" />";
    echo "<span class=\"error\">*"; 
    // echo $loginResult['errors']['logemailErr'] ?? '';
    echo "</span>";
    echo "<br>";
    echo "<br>";
    echo "<label for=\"password\">Password</label>";
    echo "<input type=\"password\" id=\"logpassword\" name=\"logpassword\" />";
    echo "<span class=\"error\">*"; 
    // echo $loginResult['errors']['logpasswordErr'] ?? ''; 
    echo "</span>";
    echo "<br>";
    echo "<br>";
    echo "<button type=\"Submit\">Send</button>";
    echo "</form>";
    echo "</div>";
  }
// }
?>