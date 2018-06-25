<?php 

require_once '../includes/connect.php'; 

if($_REQUEST != ""){
    
    if($_REQUEST['action'] == "cadastrar"){
        
        $nome      = utf8_decode($_POST['nome'     ]);
        $descricao = utf8_decode($_POST['descricao']);
        
        try {
            if(!$pdo->exec("INSERT INTO PRODUTO(NOME, DESCRICAO_LOJA) VALUES('{$nome}','{$descricao}')")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               $_SESSION['confirm'] = "Cadastrado";
               header("Location: produto.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
    if($_REQUEST['action'] == "alterar"){
        
                
        $controle  = $_POST['controle' ];
        $nome      = utf8_decode($_POST['nome'     ]);
        $descricao = utf8_decode($_POST['descricao']);
        
        try {
            if(!$pdo->exec("UPDATE PRODUTO SET ".
               " DESCRICAO_LOJA         = '{$descricao}',". 
               " NOME                   = '{$nome}'".
               " WHERE PRODUTO_CONTROLE = {$controle}")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               $_SESSION['confirm'] = "Alterado";
               header("Location: produto.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
    if($_REQUEST['action'] == "excluir"){
        
                
        $controle  = $_GET['controle' ];
        
        try {
            if(!$pdo->exec("UPDATE PRODUTO SET ".
               " STATUS  = '0'".
               " WHERE PRODUTO_CONTROLE = {$controle}")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               $_SESSION['confirm'] = "Alterado";
               header("Location: produto.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
//    if($_REQUEST['action'] == "excluir"){
//        
//        $controle  = $_GET['controle'];
//        
//        try {
//            if(!$pdo->exec("DELETE FROM PRODUTO WHERE PRODUTO_CONTROLE = {$controle}")){
//                   
//                    throw new \Exception('===> Erro de SQL <===');
//                    
//               }
//               
//               $_SESSION['confirm'] = "Excluído";
//               header("Location: produto.php");
//               
//        } catch (PDOException $Exceptio) {
//            
//            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
//            
//        }
//        
//    }
    
}
