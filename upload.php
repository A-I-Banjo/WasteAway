<?php
require_once 'navbar.php';

if($loggedin) {

echo <<<_UPLOAD
<form class="upload-form" method="post" enctype="multipart/form-data">
  
<h2> Upload image of item to sell: </h2><br>
  <input type="file" name="fileToUpload" id="fileToUpload">
  <br><br>

  <div class="col-md-10">
      <input type="text" name="item" placeholder="Item Name" class="form-control" aria-describedby="inputGroupPrepend" maxlength="50" required>
  </div>
  <br>

  <div class="col-md-10">
      <input type="number" min="1" name="price" placeholder="Item Price" class="form-control" aria-describedby="inputGroupPrepend" minlength="10" required>
  </div>
  <br>

  <div class="col-md-10">
     Expiry Date: <input type="date" name="expiry" placeholder="Expiry Date" class="form-control" aria-describedby="inputGroupPrepend" minlength="4" required>
  </div>
  <br>

<div class="col-md-10">
<input type="number" min="1" name="quantity" placeholder="Quantity" class="form-control" aria-describedby="inputGroupPrepend" minlength="4" required>
  </div>
  <br>

  <div class="col-2">
    <button class="btn btn-primary signup-btn" input type="submit" name="upload">Upload</button>
  </div>
</form>
_UPLOAD;

//Form Logic
if (isset($_POST['upload'])) {
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $item = $_POST['item'];
    $price = $_POST['price'];
    $expiry = $_POST['expiry'];
    $quantity = $_POST['quantity'];
    $image_path = $target_file;
    $member_id = queryMysql("SELECT member_id FROM members WHERE username='$username'")->fetchColumn();

  // Check if image file is a actual image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "<script>alert('File is an image - " . $check["mime"] . ".');</script>";
      $uploadOk = 1;
    } else {
      echo "<script>alert('File is not an image.');</script>";
      $uploadOk = 0;
    }

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "<script>alert('Sorry, file already exists.');</script>";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<script>alert('Sorry, your file is too large.');</script>";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "<script>alert('Sorry, your file was not uploaded.');</script>";
  }
  // if everything is ok, try to upload file
  } elseif (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

    //check if expiry date is in the future
    $current_date = date("Y-m-d");
    if ($expiry < $current_date) {
      echo "<script>alert('Sorry, the expiry date must be in the future.');</script>";
      exit();
      $uploadOk = 0;
    }
    //check if file exists in the database
    $result = queryMysql("SELECT * FROM items WHERE image_path='$image_path'");
    if ($result->rowCount() > 0) {
      echo "<script>alert('Sorry, this file already exists in the database.');</script>";
    } else {
  //Insert item details into the database
  queryMysql("INSERT INTO items (item_name, item_price, expiry_date, quantity, image_path, member_id) VALUES ('$item', '$price', '$expiry', '$quantity', '$image_path', '$member_id')");
  $result = queryMysql("SELECT image_path FROM items WHERE member_id=(SELECT member_id FROM members WHERE username='$username')");
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
    echo "<script>alert('The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded successfully.'); window.location.href = 'profile.php';</script>";
    } else {
      echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
    }
  }
}
  } 
  }else {
 echo "<script>alert('Please log in to view your profile.'); window.location.href = 'login.php';</script>";
}


/*Update the member_id of the item to the current user's member_id
  if ($row) {
    $item_id = $row['item_id'];
    queryMysql("UPDATE items SET member_id=(SELECT member_id FROM members WHERE username='$username') WHERE item_id='$item_id'");
  }
    */
?>

