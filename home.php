<?php //04
require_once 'navbar.php';


//$rown=null;
//$item_id = queryMysql("SELECT item_id FROM items")->fetchColumn();
//$images = queryMysql("SELECT image_path FROM items WHERE member_id=(SELECT member_id FROM members WHERE username='$username')")->fetchColumn();
//$item_name = queryMysql("SELECT item_name FROM items")->fetchColumn();
//$item_price = queryMysql("SELECT item_price FROM items")->fetchColumn();

$images = queryMysql("SELECT * FROM items")->fetchAll(PDO::FETCH_ASSOC);
//echo "<div class='landscape-view'>";

echo "<div class='row image-container'>"; //Don't delete
//echo"<div style='display: flex; justify-content: center; align-items: center; height: 300px; border: 1px solid #ccc;'>";

foreach ($images as $image) {
    echo "<div class='col-md-3 mb-3'>";
    echo "<div class='card'>";
    echo "<img src='" . $image['image_path'] . "' class='card-img-top' alt='" . $image['item_name'] . "'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $image['item_name'] . "</h5>";
    echo "<p class='card-text'>Price: R" . $image['item_price'] . "</p>";
    echo "<p class='card-text'>Quantity: " . $image['quantity'] . "</p>";
    echo "<p class='card-text'><button class='btn btn-primary signup-btn' type='submit' name='buy'>Buy</button></p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
} 
echo   "</div>"; 

//INCLUDE REVIEWS AS A SECURITY FEATURE. 

?>