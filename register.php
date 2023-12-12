<?php
function showRegisterContent()
{

  // if (!isset($registerResult['regvalid']) || !$registerResult['regvalid']) { /* Show the next part only when $valid is false */
    // Extract form data for convenience
    // $registerData = $registerResult['registerData'] ?? [];
    echo "<div class=\"formcarry-container\">";
    echo "<form action=\"index.php\" method=\"POST\" class=\"formcarry-form\">";
    echo "<!-- Hidden field to identify the register form -->";
    echo "<input type=\"hidden\" name=\"form_type\" value=\"register\">";
    echo "<div class=\"input\">";
    echo "<br>";
    echo "<br>";
    echo "<label for=\"name\">Name</label>";
    echo "<input type=\"text\" id=\"regname\" name=\"regname\" value=\"";
    // echo htmlspecialchars($registerData['regname'] ?? '');
    echo "\" />";
    echo "<span class=\"error\">*";
    // echo $registerResult['errors']['regnameErr'] ?? '';
    echo "</span>";
    echo "<br>";
    echo "<br>";
    echo "<label for=\"email\">Email Address</label>";
    echo "<input type=\"email\" id=\"regemail\" name=\"regemail\" value=\"";
    // echo htmlspecialchars($registerData['regemail'] ?? '');
    echo "\" />";
    echo "<span class=\"error\">*";
    // echo $registerResult['errors']['regemailErr'] ?? '';
    echo "</span>";
    echo "<br>";
    echo "<br>";
    echo "<label for=\"phone\">Password</label>";
    echo "<input type=\"password\" id=\"regpassword1\" name=\"regpassword1\" />";
    echo "<span class=\"error\">*";
    // echo $registerResult['errors']['regpassword1Err'] ?? '';
    echo "</span>";
    echo "<br>";
    echo "<br>";
    echo "<label for=\"phone\">Repeat Password</label>";
    echo "<input type=\"password\" id=\"regpassword2\" name=\"regpassword2\" />";
    echo "<span class=\"error\">*";
    // echo $registerResult['errors']['regpassword2Err'] ?? '';
    echo "</span>";
    echo "<br>";
    echo "<br>";
    echo "<button type=\"Submit\">Send</button>";
    echo "</form>";
  }
// }
?>