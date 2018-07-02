<?php 

require_once '../includes/connect.php';

function alterar_subgrupo($pdo, $controle, $data = array()){

    # Inativa todos os subgrupos do grupo
    $pdo->exec("UPDATE SUBGRUPO SET STATUS = 0 WHERE GRUPO_CONTROLE = {$controle}");

    foreach ($data as $key => $value):
        # Atualiza a oferta passada no formulário
        if(!$pdo->exec("UPDATE SUBGRUPO SET ".
               " NOME  = '{$value['nome']}',".
               " STATUS = 1".
               " WHERE SUBGRUPO_CONTROLE = {$key} AND GRUPO_CONTROLE = {$controle}")){
                   # Insere um novo subgrupo
                   $pdo->exec("INSERT INTO SUBGRUPO(GRUPO_CONTROLE, NOME, STATUS) VALUES({$controle}, '{$value['nome']}', 1)");
               }
    endforeach;
}

if($_REQUEST != ""){
    
    if($_REQUEST['action'] == "cadastrar"){
        
        $nome      = utf8_decode(trataString($_POST['nome'     ]));
        
        try {
            
            if(!$rst = $pdo->exec("INSERT INTO GRUPO(NOME, STATUS) VALUES('{$nome}', 1)")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }

               $_SESSION['confirm'] = "Cadastrado";
               header("Location: grupo.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
    if($_REQUEST['action'] == "alterar"){
                        
        $controle  = $_POST['controle'];
        $subgrupo  = $_POST['subgrupo'];
        $nome      = utf8_decode(trataString($_POST['nome']));
        
        try {
            if(!$pdo->exec("UPDATE GRUPO SET ".
               " NOME                   = '{$nome}'".
               " WHERE GRUPO_CONTROLE = {$controle}")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               alterar_subgrupo($pdo, $controle, $subgrupo);
               
               $_SESSION['confirm'] = "Alterado";
               header("Location: grupo.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException($Exception->getMessage(), (int)$Exception->getCode());
            
        }
        
    }
    
    if($_REQUEST['action'] == "excluir"){
        
                
        $controle  = $_GET['controle' ];
        
        try {
            if(!$pdo->exec("UPDATE GRUPO SET ".
               " STATUS  = '0'".
               " WHERE GRUPO_CONTROLE = {$controle}")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               $_SESSION['confirm'] = "Removido";
               header("Location: grupo.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
}
