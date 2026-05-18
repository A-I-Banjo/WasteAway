<?php
require_once 'navbar.php';
//update details of $_SESSION['update_item_name'] (from profile.php)
//Make user enter the name of the item, it makes them name it something memorable as they have to remember it to update it. 
//No need to change uploaded at either which increases efficiency. 
if ($loggedin){

echo <<<_UPDATE

<form class="upload-form" method="post" enctype="multipart/form-data">
  
<h2> Update upload details: </h2><br>

<div class="col-md-10">
      <input type="text" name="currentName" placeholder="Enter Item's Current Name" class="form-control" aria-describedby="inputGroupPrepend" maxlength="50" required>
  </div>
  <br>
  
<div class="col-md-10">
      <input type="text" name="newName" placeholder="Update Item Name To" class="form-control" aria-describedby="inputGroupPrepend" maxlength="50" required>
  </div>
  <br>

  <div class="col-md-10">
      <input type="number" min="1" name="newPrice" placeholder="Update Item Price To" class="form-control" aria-describedby="inputGroupPrepend" minlength="10" required>
  </div>
  <br>

  <div class="col-md-10">
     Update Expiry Date To: <input type="date" name="newExpiry" class="form-control" aria-describedby="inputGroupPrepend" minlength="4" required>
  </div>
  <br>

<div class="col-md-10">
<input type="number" min="0" name="newQuantity" placeholder="Update Quantity To" class="form-control" aria-describedby="inputGroupPrepend" minlength="4" required>
  </div>
  <br>

  <div class="col-2">
    <button class="btn btn-primary signup-btn" input type="submit" name="update">Update</button>
  </div>
</form>
_UPDATE;

if (isset($_POST['update'])) {

  
    $currentName = $_POST['currentName'];
    $newName = $_POST['newName'];
    $newPrice = $_POST['newPrice'];
    $newQuantity = $_POST['newQuantity'];
    $newExpiry = $_POST['newExpiry'];
    $current_date = date("Y-m-d");


  //Check if currentName of item exist
    $result = queryMysql("SELECT * FROM items WHERE item_name='$currentName'");
    if ($result->rowCount() <= 0) {
      echo "<script>alert('Please try again! The item you are trying to update does not exist.');</script>";
    }elseif ($newExpiry < $current_date) {
        echo "<script>alert('Sorry, the expiry date must be in the future.');</script>";
      }else{
      //update
    $result = queryMysql("UPDATE items SET item_name='$newName', item_price='$newPrice', quantity='$newQuantity', expiry_date='$newExpiry'  where item_name='$currentName'");
     //check if update made
    $result = queryMysql("SELECT * FROM items WHERE item_name='$newName'");
    if ($result->rowCount() > 0) {
      echo "<script>alert('Item $newName successfully updated.');</script>";
    }
  }

   

}
}else{
   echo "<script>alert('You must be logged in.'); window.location.href = 'login.php';</script>";
}

?>