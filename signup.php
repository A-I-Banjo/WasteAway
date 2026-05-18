<?php //05
require_once 'navbar.php';

echo <<<_SIGNUP
  <head>  
    <title>Waste Away - Sign Up</title>
  </head>

<h1 class="upin-header"> SIGN UP </h1>

<form name="signup-form" class="form" method="post">  
  <div class="col-md-2">
    <div class="input-group has-validation">
      <input type="text" name="username" placeholder="Enter Username" class="form-control" aria-describedby="inputGroupPrepend" minlength= "3" maxlength="50" required>
    </div>
  </div>

  <div class="col-md-2">
    <div class="input-group has-validation">
      <input type="email" name="email" placeholder="Enter Email" class="form-control" aria-describedby="inputGroupPrepend" pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$' minlength="10" required>
    </div>
  </div>

<div class="col-md-2">
    <div class="input-group has-validation">
      <input type="password" name="password" placeholder="Enter Password" class="form-control" aria-describedby="inputGroupPrepend" minlength="4" required>
    </div>
  </div>

  <div class="col-md-2">
    <div class="input-group has-validation">
      <input type="password" name="confirm_password" placeholder="Re-enter Password" class="form-control" aria-describedby="inputGroupPrepend" minlength="4" required>
    </div>
  </div>
 
  <div class="col-2">
    <button class="btn btn-primary signup-btn" input type="submit" name="submit">Sign Up</button>
  </div>
</form>
_SIGNUP;
?>

<?php //Sign-Up Validation
if(isset($_SESSION['username'])) {
    echo "<script>alert('You already have an account.'); window.location.href = 'home.php';</script>";
    exit();
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- Validate Name ---
    if (empty($_POST["username"])) {
        $nameErr = "Name is required";
        echo "<script>alert('Name is required');</script>";
    }else{
        $name = sanitizeString($_POST["username"]);
        // Check if name only contains letters and whitespace
        if(!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed in username";
            echo "<script>alert('Only letters and white space allowed in username');</script>";
        }else{
            // Check if username already exists in database
            $result = queryMysql("SELECT * FROM members WHERE username='$name'");
            if ($result->rowCount() > 0) {
                $nameErr = "Username already taken";
                echo "<script>alert('Username already taken');</script>";
            }else if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        echo "<script>alert('Email is required');</script>";
    } else {
        $email = sanitizeString($_POST["email"]);
        // Check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            echo "<script>alert('Invalid email format');</script>";
        }else{
            // Check if email already exists in database
            $result = queryMysql("SELECT * FROM members WHERE email='$email'");
            if ($result->rowCount() > 0) {
                $emailErr = "Email already registered";
                echo "<script>alert('Email already registered');</script>";
            }else if(empty($_POST["password"])) {
        $passwordErr = "Password is required";
        echo "<script>alert('Password is required');</script>";
    } else {
        $password = $_POST["password"];
        if ($password !== $_POST["confirm_password"]) {
            $passwordErr = "Passwords do not match";
            echo "<script>alert('Passwords do not match.');</script>";
        }else if(empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmErr)) {
        // Process data (e.g., save to database)
        $result = queryMysql("INSERT INTO members (username, email, password) VALUES ('$name', '$email', '$password')");
        if ($result) {
            echo "<script>alert('Registration successful! Go login :)'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error occurred during registration. Please try again.');</script>";
        }
}
    }
        }
    }
}  
    }
}

?>
