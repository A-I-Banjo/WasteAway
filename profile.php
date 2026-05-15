<?php 
require_once 'navbar.php';

//INCLUDE REVIEWS AS A SECURITY FEATURE. 


if($loggedin) {

    $result = queryMysql("SELECT * FROM profiles WHERE user='$username'");
    
    if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);

    if ($result->rowCount()){
         queryMysql("UPDATE profiles SET text='$text' where user='$username'");
  }
    else queryMysql("INSERT INTO profiles VALUES('$username', '$text')");
  }
  else
  {
if ($result->rowCount())
    {
      $row  = $result->fetch();
      $text = stripslashes($row['text']);
    }
    else $text = "";
  }

  $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

echo <<<_PROFILE

  <div class="profile-container">
  <h1>$username's Profile</h1>
  <img class="profile-pic" src='$username.jpg' style='float:left;'>
  </div>

      <form class="update-bio" data-ajax='false' method='post' enctype='multipart/form-data'>
      <h3>$text</h3>
      <textarea name='text' placeholder='Edit your bio'></textarea>
      <br>
      Update your profile picture: <input type='file' name='image'>
      <br><br>
      <button class="btn btn-primary signup-btn" input type="submit" value="Save Profile">Save Profile</button>
      </form>  
_PROFILE;

  if (isset($_FILES['image']['name']))
  {
    $saveto = "$username.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  // Both regular and progressive jpegs
      case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }

    if ($typeok)
    {
      list($w, $h) = getimagesize($saveto);

      $max = 100;
      $tw  = $w;
      $th  = $h;

      if ($w > $h && $max < $w)
      {
        $th = $max / $w * $h;
        $tw = $max;
      }
      elseif ($h > $w && $max < $h)
      {
        $tw = $max / $h * $w;
        $th = $max;
      }
      elseif ($max < $w)
      {
        $tw = $th = $max;
      }

      $tmp = imagecreatetruecolor($tw, $th);
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
      imageconvolution($tmp, array(array(-1, -1, -1),
        array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
      imagejpeg($tmp, $saveto);
      imagedestroy($tmp);
      imagedestroy($src);
    }
  }


echo '<h2>Your Listings</h2>';

$images = queryMysql("SELECT * FROM items WHERE member_id = (SELECT member_id FROM members WHERE username='$username')")->fetchAll(PDO::FETCH_ASSOC);
echo "<div class='row image-container'>"; 
foreach ($images as $image) {
    echo "<div class='col-md-3 mb-3'>";
    echo "<div class='card'>";
    echo "<img src='" . $image['image_path'] . "' class='card-img-top' alt='" . $image['item_name'] . "'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $image['item_name'] . "</h5>";
    echo "<p class='card-text'>Price: R" . $image['item_price'] . "</p>";
    echo "<p class='card-text'>Quantity: " . $image['quantity'] . "</p>";
    echo "<form method='post' action='profile.php' enctype='multipart/form-data'>";
    echo "<p class='card-text'><button class='btn btn-primary signup-btn' type='submit' name='delete'>Delete</button></p>";
    echo "<p class='card-text'><button class='btn btn-primary signup-btn' type='submit' name='edit'>Edit</button></p>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    if(isset($_POST['delete'])) {
    queryMysql("DELETE FROM items WHERE item_id='" . $image['item_id'] . "'");
    echo "<script>alert('Item deleted successfully.'); window.location.href = 'profile.php';</script>";

    if(isset($_POST['edit'])) {
    $_SESSION['edit_item_id'] = $image['item_id'];
    echo "<script>window.location.href='edit_item.php';</script>";
}
}
} 
echo   "</div>"; 

} else {
 echo "<script>alert('Please log in to view your profile.'); window.location.href = 'login.php';</script>";
}
?>