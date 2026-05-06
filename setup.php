<?php //02
 require_once 'functions.php';

  createTable('members', 'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, username VARCHAR(35) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR (100) NOT NULL, INDEX(username(35)), INDEX(email(100))');
              
  //createTable('suburbs', 'suburb VARCHAR(50), INDEX(suburb(6))');
                            
?>
