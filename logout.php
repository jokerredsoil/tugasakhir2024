<?php
//memulai sesi
session_start();

//di hapus seisinya
session_destroy();

header("Location: login.php");
exit();
?>