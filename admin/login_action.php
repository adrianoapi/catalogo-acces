<?php 

require_once '../includes/connect.php';
require_once '../includes/functions.php';

$username = "admin";
$password = "admin";

if(isset($_POST['action'])){
    
    if($_POST['action'] == "autenticar"){
        
        $status = 0;
        
        if($username == addslashes($_POST['email']) && $password == addslashes($_POST['senha'])){
            
            // Cria a sessão do usuário
            $_SESSION['USER'] = array(
                'nome'     => $username,
                'time'     => date('Y-m-d H:i:s')
            );
        
            $status = 1;
            
        }

        echo $status;

    }
    
}

if(isset($_GET['action'])){
    
    unset($_SESSION['USER']);
    header('Location: login.php');
    
}