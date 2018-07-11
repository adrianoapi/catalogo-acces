<?php

require_once 'includes/connect.php';
require_once 'includes/functions.php';

function check_pessoa($pdo, $email, $senha)
{
    try{
        
        $sql = " SELECT TOP 1 * FROM PESSOA AS P      " .
               " INNER JOIN PESSOA_MEIOCONTATO AS PM ON ( PM.PESSOA_CONTROLE = P.PESSOA_CONTROLE AND PM.TIPOMEIOCONTATO_CONTROLE = 2 AND PM.STATUS = 1 ) " .
               " WHERE P.SENHA = '{$senha}' AND P.STATUS = 1 AND  PM.VALOR = '{$email}' ";
        if($pdo->query($sql)){
            $qry = $pdo->query($sql);
            return $qry->fetch();
        }
        
    } catch( PDOException $Exception){
        
    }
}

if(isset($_POST['action'])){
    
    /**
     * Verifica se existe a conta
     */
    if($_POST['action'] == "autenticar"){
        
        $status = 0;
        $email  = addslashes($_POST['email']);
        $senha  = addslashes($_POST['senha']);

        $rst = check_pessoa($pdo, $email, $senha);
        
        if(is_array($rst)){
            
            if(registra_login($rst)){
                $status = 1;
            }
            
        }
        
        echo $status;

    }
    
}