<?php

require_once '../includes/connect.php';   
require_once '../includes/functions.php';


if(isset($_REQUEST['action'])){
    
    if($_REQUEST['action'] == "informacao"){
        
        if(is_array($_POST['grupo'])){
            
            foreach ($_POST['grupo'] as $key => $value):
                
                $sql =  " UPDATE PESSOA_MEIOCONTATO SET ".
                        " VALOR = '{$value}' ".
                        " WHERE PESSOA_MEIOCONTATO_CONTROLE = {$key}";
                $pdo->exec($sql);
                
            endforeach;
            
        }
        
        $_SESSION['confirm'] = "Alterado";
        header("Location: pessoa.php");
        
    }
    
    if($_REQUEST['action'] == "endereco"){
        
        $controle          = $_POST['controle'   ];
        $cep               = $_POST['cep'        ];
        $logradouro        = $_POST['logradouro' ];
        $numero            = $_POST['numero'     ];
        $complemento       = $_POST['complemento'];
        $bairro            = $_POST['bairro'     ];
        $municipio         = $_POST['municipio'  ];
        $uf                = $_POST['uf'         ];

        # Atualiza os daso do endereço
        try{

            $sql = " UPDATE PESSOA_ENDERECO SET " .
                   " CEP         = '{$cep}'," .
                   " LOGRADOURO  = '{$logradouro}'," .
                   " NUMERO      = '{$numero}'," .
                   " COMPLEMENTO = '{$complemento}'," .
                   " BAIRRO      = '{$bairro}'," .
                   " MUNICIPIO   = '{$municipio}'," .
                   " UF          = '{$uf}'" .
                   " WHERE PESSOA_ENDERECO_CONTROLE = {$controle}";
            if($pdo->exec($sql)){
               $_SESSION['confirm'] = "Endereço alterado";
               header("Location: pessoa.php");
            }

        } catch (Exception $Exception) {
            throw new MyDatabaseException($Exception->getMessage(), (int)$Exception->getCode());
        }
        
    }
    
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