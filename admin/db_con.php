<?php 
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBNAME', 'student');


$db_con = mysqli_connect(DBHOST, DBUSER, '', DBNAME);
if (!$db_con) {
    error_log("DB Connection Error: " . mysqli_connect_error());
    die("Connection failed: " . mysqli_connect_error());
}

?>