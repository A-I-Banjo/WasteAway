<?php
require_once 'functions.php';

if(isset($_SESSION['username'])){
    if(isset($_POST['key'])){

        //searching algorithm
        $key = "{$_POST['key']}";
        $search_users = queryMysql("SELECT * FROM members WHERE username LIKE $key");
        if($search_users()->fetchAll(PDO::FETCH_ASSOC) > 0){
            foreach($search_users as $search_user){
            echo '<ul class="user-list">';
            echo "<li><a href='chat.php?recipient=$search_users'>$search_users</a>";
            echo '</ul>';
            }
           

        }else{
            echo "<script>alert('User does not exist. Try again.'); window.location.href = 'chat.php';</script>";
        }
    }
}

?>