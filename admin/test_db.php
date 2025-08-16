<?php
require_once 'db_con.php';
$result = mysqli_query($db_con, "SELECT 1");
echo $result ? "Database connected" : "Connection failed";
?>