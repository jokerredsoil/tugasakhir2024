<?php


$host = 'localhost'; //localhost ; 127.0.0.1
$user = 'root';
$passw = '';
$db = 'db_parkir';

$conn = mysqli_connect($host, $user, $passw, $db);



if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "<div class='alert alert-primary ' role='alert'>
            <marquee>
            welcome $user
            </marquee>
            
            </div> ";
}



function myquery($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    $list = [];

    while ($data = mysqli_fetch_assoc($result)) {
        $list[] = $data;
    }
    return $list;
}
