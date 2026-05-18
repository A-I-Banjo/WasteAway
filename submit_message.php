<?php

require_once 'functions.php';




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (similar to chat.php)

    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];
    date_default_timezone_set('Africa/Johannesburg');
    $date = date("Y-m-d");
    $time = date("H:i:s");
    

    $insert_msg = queryMysql("INSERT INTO messages (sender, recipient, message, date, time ) VALUES ('$sender', '$receiver', '$message', '$date', '$time')");

}


?>