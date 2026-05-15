<?php //02
 require_once 'functions.php';

  createTable('members', 
              'member_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
              username VARCHAR(35) NOT NULL, 
              password VARCHAR(255) NOT NULL, 
              email VARCHAR (100) NOT NULL, 
              INDEX(username(35)), 
              INDEX(email(100))');

  createTable('items', 
              'item_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,  
              item_name VARCHAR(255) NOT NULL, 
              item_price DECIMAL(10, 2) NOT NULL, 
              quantity INT NOT NULL,   
              expiry_date DATE, 
              image_path VARCHAR(255) NOT NULL,
              uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              member_id INT UNSIGNED,
              CONSTRAINT fk_members
              FOREIGN KEY (member_id)
              REFERENCES members(member_id)');

  createTable('messages', 
              'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              sender VARCHAR(16),
              recipient VARCHAR(16),
              pm CHAR(1),
              time INT UNSIGNED,
              message VARCHAR(4096),
              INDEX(sender(6)),
              INDEX(recipient(6))');
              
  createTable('friends',
              'user VARCHAR(16),
              friend VARCHAR(16),
              INDEX(user(6)),
              INDEX(friend(6))');

  createTable('profiles',
              'user VARCHAR(16),
              text VARCHAR(4096),
              INDEX(user(6))');    
              
  //createTable('suburbs', 'suburb VARCHAR(50), INDEX(suburb(6))');
                            
?>
