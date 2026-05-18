<?php
require_once 'functions.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];

    $messages = queryMysql("SELECT * FROM messages WHERE (sender='$sender' AND recipient='$receiver') OR (sender='$receiver' AND recipient='$sender') ORDER BY date ASC");
    
        while ($row = $messages->fetch(PDO::FETCH_ASSOC)) {
            $sender = $row['sender'];
            $recipient = $row['recipient'];
            $message = $row['message']; 
            $date = $row['date'];
            $time = $row['time'];
            echo '<div class="message">
            <strong>' . ucfirst($row['sender']) . ':</strong> ' 
            . $row['message'] . '  </div>';
        }
    }


?>