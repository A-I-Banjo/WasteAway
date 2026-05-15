<?php
require_once 'navbar.php';

//

// id, sender_id, recipient_id, subject, body, is_read, and timestamp.

     //Id of sender = $uername
     //id of receipient = memberid attacheed to item on vlick buy
     //home would have to show only items not posted by user. 
     //items posted by user visible only in their profile? 
$items = queryMysql("SELECT * FROM items")->fetchAll(PDO::FETCH_ASSOC);
$recipient_id = queryMysql("SELECT member_id FROM items WHERE item_id='" . $items['item_id'] . "'")->fetchColumn();
$recipient_username = queryMysql("SELECT username FROM members WHERE member_id='$recipient_id'")->fetchColumn();

echo <<<_MESSAGE
    <div class='form' method='post' action='messages.php' enctype='multipart/form-data'>
     <h3> Message $recipient_username </h3>
     <textarea name='message' placeholder='Type your message here'></textarea>
     <br>
     <button class="btn btn-primary signup-btn" input type="submit" value="Send Message">Send Message</button>
     </div>
_MESSAGE;     



     
//select * frome messages where recipient_id = (select member_id from members where username = '$username') order by timestamp desc


?>