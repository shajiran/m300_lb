<?php
$host = 'mysql';
$user = 'Raveendran';
$password = 'Raveendran123';
$db = 'Raveendran_db';

$connection = new mysqli($host,$user,$password,$db);
if($connection->connect_error){
    echo 'Connection FAILED' . $connection->connect_error;
}
echo 'Raveendran Shajiran MYSQL: Connected';

?>
