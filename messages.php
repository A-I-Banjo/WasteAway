<?php
require_once 'navbar.php';

//

// id, sender_id, recipient_id, subject, body, is_read, and timestamp.


//select * frome messages where recipient_id = (select member_id from members where username = '$username') order by timestamp desc


?>