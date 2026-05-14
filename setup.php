<?php //02
 require_once 'functions.php';

  createTable('members', 'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, username VARCHAR(35) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR (100) NOT NULL, INDEX(username(35)), INDEX(email(100))');
  createTable('messages', 
              'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              auth VARCHAR(16),
              recip VARCHAR(16),
              pm CHAR(1),
              time INT UNSIGNED,
              message VARCHAR(4096),
              INDEX(auth(6)),
              INDEX(recip(6))');
              
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
