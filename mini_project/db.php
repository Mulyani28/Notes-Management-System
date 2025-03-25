<?php
    // $host = 'localhost';
    // $username = 'niagaped_munchkin_user';
    // $password = 'munchkin%&^%$&';
    // $database = 'niagaped_munchkin';

    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'my_note';

    // define('DB_HOST', 'localhost'); //Add your db host
    // define('DB_USER', 'root'); // Add your DB root
    // define('DB_PASS', ''); //Add your DB pass
    // define('DB_NAME', 'mvcframework'); //Add your DB Name

    $conn = new mysqli($host, $username, $password, $database);

    if($conn->connect_error)
    {
        die("Connection failed:" . $conn->connect_error);
    }
    
?>