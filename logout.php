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
              <a href="home.php" class="btn btn-primary mt-3">Return to Home</a>
            </div> 
            </div>
         </div>
      </div>            
_LOGOUT;

?>