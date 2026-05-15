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
$recipient_id = $_SESSION['recipient_id'] = queryMysql("SELECT member_id FROM items WHERE item_id='" . $image['item_id'] . "'")->fetchColumn();
$recipient_username = $_SESSION['recipient_username'] = queryMysql("SELECT username FROM members WHERE member_id='" . $_SESSION['recipient_id'] . "'")->fetchColumn();


    echo "<div class='col-md-3 mb-3'>";
    echo "<div class='card'>";
    echo "<img src='" . $image['image_path'] . "' class='card-img-top' alt='" . $image['item_name'] . "'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $image['item_name'] . "</h5>";
    echo "<p class='card-text'>Price: R" . $image['item_price'] . "</p>";
    echo "<p class='card-text'>Quantity: " . $image['quantity'] . "</p>";
    echo "<form method='post' action='home.php' enctype='multipart/form-data'>";
    echo "<p class='card-text'><button class='btn btn-primary signup-btn' data-bs-toggle='modal' data-bs-target='#messageModal' type='button' name='buy'>Buy</button></p>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    
echo <<<_MESSAGE
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="messageModalLabel">Message $recipient_username</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method='post' action='messages.php' enctype='multipart/form-data'>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text" name='message'></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>

_MESSAGE;
} 
echo   "</div>"; 

if (empty($images)) {
    echo "<p>No items available.</p>";
}

if(isset($_POST['buy'])) {
    $item_quantity = queryMysql("SELECT quantity FROM items WHERE item_id='" . $image['item_id'] . "'")->fetchColumn();
    if ($item_quantity <= 0) {
        echo "<script>alert('Sorry, this item is out of stock.');</script>";
        //ADMIN can delete item from database if quantity is 0.
        exit();
    } 

    if($item_quantity > 0){
        $item_id = $image['item_id'];
        $_SESSION['item_id'] = $item_id;

          


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
    }
}
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