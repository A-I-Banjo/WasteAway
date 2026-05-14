<?php 
require_once 'navbar.php';

echo <<<_HEAD
  <head>
    <title>Logout</title>
  </head>
 _HEAD;

 echo <<<_LOGOUT
 <div class="container mt-5 pt-5">  
    <div class="row justify-content-center">
      <div class="col-md-6">
         <div class="card">
            <div class="card-body text-center">
              <h2 class="card-title mb-4">You have been logged out.</h2>
              <p class="card-text">Thank you for visiting Waste Away. We hope to see you again soon!</p>
              <a href="login.php" class="btn btn-primary mt-3">Return to Login</a>
            </div> 
            </div>
         </div>
      </div>            
_LOGOUT;


  if (isset($_SESSION['user']))
  {
    destroySession();
  }
  else echo "<script>alert('You are not currently logged in. Please log in to access this page.'); window.location.href='login.php';</script>";

?>