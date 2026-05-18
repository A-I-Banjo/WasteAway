
<?php
require_once 'navbar.php';
//alt https://www.youtube.com/watch?v=VnvzxGWiK54 1:37:00

if($loggedin) {
 
echo '<br><br>';
echo '<div class="card">';
echo '<div class="card-body">';
echo '<div class="container mt-5">';
echo '<h1>Chat</h1>';   
echo '<p>Welcome to the chat page! Here you can connect with other users.</p>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<p class="text-center mt-3">Select user to chat with:</p>';

echo '<form class="d-flex mt-3" role="search">
        <input class="form-control me-2" type="search" id="searchText" placeholder="Search user" aria-label="Search"/>
          <button class="btn btn-outline-success" id="searchBtn" type="submit">Search</button>
        </form>';



$members = queryMysql("SELECT username FROM members WHERE username != '$username'");

while($row = $members->fetch(PDO::FETCH_ASSOC)) {
    $recipient_username = $row['username'];
    //$recipient_username = ucfirst($recipient_username); // Capitalize the first letter of the username
    echo "<ul class='user-list'>
          <li>
          <a href='chat.php?recipient=$recipient_username'>$recipient_username
          </a>
          </li>
          </ul>";
}

if (isset($_GET['recipient'])) {
    $selectedUser = $_GET['recipient'];
    $showChatBox = true;


if($showChatBox) {   
echo <<<_CHATBOX
<div class="chat-box" id="chat-box">
        <div class="chat-box-header">
            <script>alert('You are about to message $selectedUser'); </script> $selectedUser
            <button class="close-btn" onclick="toggleChatBox()">✖</button>
        </div>
        <div class="chat-box-body" id="chat-box-body">
            <!-- Chat messages will be loaded here -->
        </div>
        <form class="chat-form" id="chat-form">
            <input type="hidden" id="sender" value="$username">
            <input type="hidden" id="receiver" value="$selectedUser">
            <input type="text" id="message" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
</div>
_CHATBOX;
}
}
}else{
    echo "<script>alert('You must be logged in to chat.'); window.location.href = 'login.php';</script>";
  exit();
}
?>

<script>

    // Function to toggle chat box visibility
    function toggleChatBox() {
    var chatBox = document.getElementById("chat-box");
    if (chatBox.style.display === "none") {
        chatBox.style.display = "block"; // Show the chat box
    } else {
        chatBox.style.display = "none"; // Hide the chat box
    }
}

    //Fetch messages 
    function fetchMessages() {
            var sender = $('#sender').val(); //store value from message sender
            var receiver = $('#receiver').val(); //store value from message recipient 
            
            //Send stored message values to a file called 'fetch_messages.php' 
            $.ajax({
                url: 'fetch_messages.php',
                type: 'POST',
                data: {sender: sender, receiver: receiver},
                success: function(data) {
                    $('#chat-box-body').html(data);
                    scrollChatToBottom();
                }
            });
}

    // Function to scroll the chat box to the bottom
        function scrollChatToBottom() {
            var chatBox = $('#chat-box-body');
            chatBox.scrollTop(chatBox.prop("scrollHeight")); //automatically scroll chat to bottom
        }

    $(document).ready(function() {
            // Fetch messages every 5 seconds
            fetchMessages();
            setInterval(fetchMessages, 5000);
        });

    
    // Submit the chat message
            $('#chat-form').submit(function(e) {
            e.preventDefault();
            var sender = $('#sender').val();
            var receiver = $('#receiver').val();
            var message = $('#message').val();

            $.ajax({
                url: 'submit_message.php',
                type: 'POST',
                data: {sender: sender, receiver: receiver, message: message},
                success: function() {
                    $('#message').val('');
                    fetchMessages(); // Fetch messages after submitting
                }
            });

});

</script>




