<?php //03
session_start();
require_once 'setup.php';

echo <<<_HEAD
<!DOCTYPE html> 
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>  
    <script src='bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js'></script>
    <script src='jquery/jquery.mobile-1.4.5.min.js'></script>
    <link rel='stylesheet' href='bootstrap-5.3.8-dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='jquery/jquery.mobile-1.4.5.min.css'>
    <link rel='stylesheet' href='styles.css' type='text/css'>
    <title>Waste Away</title>
  </head>
_HEAD;

echo <<<_NAVBAR
<nav class="navbar bg-body-tertiary fixed-top">
  <div class="container-fluid custom-navbar-background">
  <div class="links-container">
  <ul>
    <li><a href="signup.php">Sign-Up</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
  </div>
    <a class="navbar-brand" href="home.php"> <div id='wa-logo-text'> Waste Away </div> <img id='wa-logo' src='logo.jpg'></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Waste Away</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact Us</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="profile-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Your Profile
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="profile.php">Profile</a></li>
              <li><a class="dropdown-item" href="#">Cart</a></li>
              <li><a class="dropdown-item" href="#">Messages</a></li>
              <li><a class="dropdown-item" href="#">Members</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
        <form class="d-flex mt-3" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>
_NAVBAR;

?>

<?php
if (isset($_SESSION['username']))
  {
    $username = $_SESSION['username'];
    $loggedin = TRUE;
    $userstr  = "Logged in as: $username";
  }
  else $loggedin = FALSE;
  {
    $userstr = "Not logged in";
  }
?>