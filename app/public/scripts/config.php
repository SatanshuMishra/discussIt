<?php
define('SERVERNAME', 'discussIt-mysql');
define('USERNAME', 'discussIt');
define('PASSWORD', 'password');
define('DBNAME', 'discussItDatabase');


$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

if(!$conn){
    die("[ERROR] CONNECTION FAILED: " . mysqli_connect_error());
}
?>