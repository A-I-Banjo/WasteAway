<?php 
require_once 'navbar.php';

if($loggedin) {

    $result = queryMysql("SELECT * FROM profiles WHERE user='$username'");
    
    if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);

    if ($result->rowCount())
         queryMysql("UPDATE profiles SET text='$text' where user='$username'");
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
      <textarea name='text' placeholder='Edit your bio'></textarea><br>
      Update your profile picture: <input type='file' name='image'>
      <span><input type='submit' value='Save Profile'></span>
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

  //showProfile($user);
// Show listings (img and price) as default profile view
//So when you click on  a member profule you see their listings as you the deafult.
//


} else {
 echo "<script>alert('Please log in to view your profile.'); window.location.href = 'login.php';</script>";
}
?>