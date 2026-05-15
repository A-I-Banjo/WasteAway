<?php 
require_once 'navbar.php';  

 echo <<<_LOGIN
<head>  
  <title>Waste Away - Login</title>
</head>
  <h1 class="upin-header"> LOGIN </h1>
  
  <form name="login-form" class="form" method="post">  
    <div class="col-md-2">
      <div class="input-group has-validation">
        <input type="text" name="username" placeholder="Enter Username" class="form-control" aria-describedby="inputGroupPrepend" maxlength="50" required>
      </div>
    </div>

    <div class="col-md-2">
      <div class="input-group has-validation">
        <input type="password" name="password" placeholder="Enter Password" class="form-control" aria-describedby="inputGroupPrepend" minlength="4" required>
      </div>
    </div>
   
    <div class="col-2">
      <button class="btn btn-primary signup-btn" input type="submit" name="submit">Login</button>
    </div>
  </form>
_LOGIN;
?>

<?php //Login Validation
if(isset($_SESSION['username'])) {
  echo "<script>alert('You are already logged in.'); window.location.href = 'home.php';</script>";
  exit();
}
// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = sanitizeString($_POST["username"]);
  $password = sanitizeString($_POST["password"]);
  $email = sanitizeString($_POST["email"]);

  // Query for the user's password
  $result = queryMysql("SELECT password FROM members WHERE username='$username'");

  // Fetch the row; if no row, the username does not exist
  $row = null;
  if ($result) {
    // If result is an object with fetch_assoc (e.g. mysqli_result)
    if (is_object($result) && method_exists($result, 'fetch_assoc')) {
      $row = $result->fetch_assoc();
    }
    // If result is a PDOStatement (from PDO) fetch an associative row
    elseif (is_object($result) && (get_class($result) === 'PDOStatement' || $result instanceof PDOStatement)) {
      $row = $result->fetch(PDO::FETCH_ASSOC);
    }
    // If queryMysql already returned an associative array
    elseif (is_array($result)) {
      $row = $result;
    }
  }

  if (!$row) {
    echo "<script>alert('Username does not exist. Please try again.');</script>";
  } else {
    // Verify password
    if ($password === $row['password']) {
      $_SESSION['username'] = $username;
      echo "<script>alert('Login successful!'); window.location.href = 'home.php';</script>";
    } else {
      echo "<script>alert('Incorrect password. Please try again.');</script>";
    }
  }
}
?>

