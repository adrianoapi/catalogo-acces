<?php

require_once 'includes/connect.php';

function check_pessoa($pdo, $email, $senha)
{
    try{
        
        $sql = " SELECT * FROM PESSOA AS PE".
               " INNER JOIN ON".
               "";
        
    } catch( PDOException $Exception){
        
    }
}

if(isset($_POST['action'])){
    
    /**
     * Verifica se existe a conta
     */
    if($_POST['action'] == "autenticar"){
        
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        print_r(check_pessoa($pdo, $email, $senha));

    }
    
}