<?php 
    
    require_once 'includes/connect.php'; 
    
    $_SESSION['AUTH'] = FALSE;
    unset($_SESSION['AUTH']);
    
    header('Location: login.php');

?>