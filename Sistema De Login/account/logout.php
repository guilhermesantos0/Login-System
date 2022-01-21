<?php

session_start();

if(isset($_SESSION['user_id'])){
    unlink($_SESSION['user_id']);
    session_abort();
    header('location: ../index.php');
}

?>