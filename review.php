<?php 
require_once 'navbar.php';

//INCLUDE REVIEWS AS A SECURITY FEATURE. 
//NO SEARCH BAR TO INCREASE INTENTIONALITY; if a user considers it tedious to scroll in order to find their reviewee then the review isn't impassioned enough.  



if($loggedin) {
 
echo '<br><br>';
echo '<div class="card">';
echo '<div class="card-body">';
echo '<div class="container mt-5">';
echo '<h1>Review</h1>';   
echo '</div>';
echo '</div>';
echo '</div>';

echo <<<_REVIEW_FORM

<form class="upload-form" method="post" enctype="multipart/form-data">
  <p>Here you can leave a review for other users.</p>
  <div class="col-md-10">
      <input type="text" name="reviewee" placeholder="Enter Name of User to Review" class="form-control" aria-describedby="inputGroupPrepend" minlength="3" required>
  </div>
  <br>

  <div class="col-md-10">
    <label for="review">Leave a review:</label>
    <textarea id="review" name="review" rows="2" cols="50" placeholder="Type user review here...">
    </textarea>
  </div>
  <br>

<div class="col-md-10">
<input type="number" min="1" max="5" name="rating" placeholder="Rating (/5)" class="form-control" aria-describedby="inputGroupPrepend" maxlength="1" required>
  </div>
  <br>

  <div class="col-2">
    <button class="btn btn-primary signup-btn" input type="submit" name="upload">Upload Review</button>
  </div>

</form>
</div>
_REVIEW_FORM;

if (isset($_POST['upload'])) {
    $reviewer = $username;
    $reviewee = $_POST['reviewee'];
    $message = $_POST['review'];
    $rating = $_POST['rating'];

    //check if reviewee exists in the database
    $result = queryMysql("SELECT * FROM members WHERE username='$reviewee'");
    if ($result->rowCount() <= 0) {
      echo "<script>alert('Please try again! The user you are trying to review does not exist.');</script>";
    }else{
    //no duplicate reviews of one user by another 
    $result = queryMysql("SELECT rating FROM user_reviews WHERE reviewer='$reviewer' AND reviewee='$reviewee'");
     if ($result->rowCount() > 0) {
      echo "<script>alert('Please try again!. You cannot rate a user more than once.');</script>";
    }else{
        //check if reviewee is reviewer
    if ($reviewer == $reviewee) {
      echo "<script>alert('Please try again! You cannot review yourself.');</script>";
    }else{
    queryMysql("INSERT INTO user_reviews (reviewer, reviewee, message, rating) VALUES ('$reviewer', '$reviewee', '$message', '$rating')");
    echo "<script>alert('Thank you for leaving a review.');</script>";
    }
        
    }
    }

   

    
    
}






}else{
    echo "<script>alert('You must be logged in to review.'); window.location.href = 'login.php';</script>";
  exit();
}
?>



