<?php

require_once '../includes/connect.php';   
require_once '../includes/functions.php';


if(isset($_REQUEST['action'])){
    
    if($_REQUEST['action'] == "excluir"){
        
        $controle = $_GET['controle'];
        
        try {
            if(!$pdo->exec("UPDATE PESSOA SET ".
               " STATUS  = '0'".
               " WHERE PESSOA_CONTROLE = {$controle}")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               $_SESSION['confirm'] = "Removido";
               header("Location: pessoa.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
    if($_REQUEST['action'] == "restaurar"){
        
                
        $controle  = $_GET['controle' ];
        
        try {
            if(!$pdo->exec("UPDATE PESSOA SET ".
               " STATUS  = '1'".
               " WHERE PESSOA_CONTROLE = {$controle}")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               $_SESSION['confirm'] = "Alterado";
               header("Location: pessoa_excluido.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
}