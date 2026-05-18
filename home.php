<?php //04
require_once 'navbar.php';



//$rown=null;
//$item_id = queryMysql("SELECT item_id FROM items")->fetchColumn();
//$images = queryMysql("SELECT image_path FROM items WHERE member_id=(SELECT member_id FROM members WHERE username='$username')")->fetchColumn();
//$item_name = queryMysql("SELECT item_name FROM items")->fetchColumn();
//$item_price = queryMysql("SELECT item_price FROM items")->fetchColumn();


//Only show images not posted by currently logged in user.
$images = queryMysql("SELECT * FROM items WHERE member_id != (SELECT member_id FROM members WHERE username='$username')")->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='row image-container'>"; 
foreach ($images as $image) {
$poster_username = queryMysql("SELECT username FROM members WHERE member_id='" . $image['member_id'] . "'")->fetchColumn(); //get the username of the person who posted the item. This will be used in the message modal to message the seller.
 $averageString = "No ratings";
//Calculate rating
    $result = queryMysql("SELECT AVG(rating) AS avg_rating FROM user_reviews WHERE reviewee='$username'")->fetch(PDO::FETCH_OBJ);
    //Convert PDO object to string and provide a default if no ratings exist.
   
    if ($result && isset($result->avg_rating) && $result->avg_rating !== null) {
        // format to 2 decimal places
        $averageString = number_format((float)$result->avg_rating, 2);
    }
    echo "<div class='col-md-3 mb-3'>";
    echo "<div class='card'>";
    echo "<img src='" . $image['image_path'] . "' class='card-img-top' alt='" . $image['item_name'] . "'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'><b><u>" . $image['item_name'] . "</b></u></h5>";
    echo "<p class='card-text'>Price: R" . $image['item_price'] . "</p>";
    echo "<p class='card-text'>Expiry Date: " . $image['expiry_date'] . "</p>";
    echo "<p class='card-text'>Quantity: " . $image['quantity'] . "</p>";
    echo "<p class='card-text'>Posted by: " . $poster_username . "</p>";
    echo "<p class='card-text'>Poster Rating: " . $averageString . "</p>";
    echo "</div>";
    echo "</div>";  
    echo "</div>"; 
} 
echo   "</div>"; 
 

if (empty($images)) {
    echo "<p>No items available.</p>";
}



          


/*        
$recipient_id = queryMysql("SELECT member_id FROM items WHERE item_id='" . $image['item_id'] . "'")->fetchColumn();

echo <<<_MESSAGE
    <div class='form' method='post' action='messages.php' enctype='multipart/form-data'>
     <h3> Message the seller </h3>
     <textarea name='message' placeholder='Type your message here'></textarea>
     <br>
     <button class="btn btn-primary signup-btn" input type="submit" value="Send Message">Send Message</button>
     </div>
_MESSAGE;    

        // Go to messages.php and After message is sent, decrement quantity of item by 1
     
        
       /* $quantity = $item_quantity - 1;
        queryMysql("UPDATE items SET quantity='$quantity' WHERE item_id='$item_id'");

        $sender_id = queryMysql("SELECT member_id FROM members WHERE username='$username'")->fetchColumn();
        $recipient_id = queryMysql("SELECT member_id FROM items WHERE item_id='$item_id'")->fetchColumn();
        $subject = "Item Purchased";
        $body = "You have purchased " . $image['item_name'] . " for R" . $image['item_price'];
        $is_read = 0;
        $timestamp = date("Y-m-d H:i:s");
        queryMysql("INSERT INTO messages (sender_id, recipient_id, subject, body, is_read, timestamp) VALUES ('$sender_id', '$recipient_id', '$subject', '$body', '$is_read', '$timestamp')");
        
        header("Location: messages.php");
        exit();
*/
    
    /*decrement quantity of item by 1
    $item_id = $image['item_id'];
    // AFTER MESSAGE IS SENT --->> $quantity = $image['quantity'] - 1;
    queryMysql("UPDATE items SET quantity='$quantity' WHERE item_id='$item_id'");
    //insert message into messages table with sender_id = username, recipient_id = memberid attacheed to item on click buy, subject = "Item Purchased", body = "You have purchased item_name for item_price", is_read = 0, timestamp = current time
    $sender_id = queryMysql("SELECT member_id FROM members WHERE username='$username'")->fetchColumn();
    $recipient_id = queryMysql("SELECT member_id FROM items WHERE item_id='$item_id'")->fetchColumn();
    $subject = "Item Purchased";
    $body = "You have purchased " . $image['item_name'] . " for R" . $image['item_price'];
    $is_read = 0;
    $timestamp = date("Y-m-d H:i:s");
    queryMysql("INSERT INTO messages (sender_id, recipient_id, subject, body, is_read, timestamp) VALUES ('$sender_id', '$recipient_id', '$subject', '$body', '$is_read', '$timestamp')");
    header("Location: messages.php");
    exit();
    */


//INCLUDE REVIEWS AS A SECURITY FEATURE. 

?>