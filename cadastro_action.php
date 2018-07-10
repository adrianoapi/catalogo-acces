<?php

require_once 'includes/connect.php';
require_once 'includes/functions.php';

/*
 * Checa se o formulário foi preenchido manualmente
 * Checa se já existe o cpf cadastrado
 * Faz o cadastro
 * Faz a autenticação
 */

/**
 * Consulta pessoa por CPF
 * @param type $pdo
 * @param type $cpf
 * @return type
 */
function consultar_pessoa($pdo, $cpf)
{
    
    $sql    = "SELECT TOP 1 PESSOA_CONTROLE FROM PESSOA WHERE CPF_CNPJ = '{$cpf}'";
    
    if($pdo->query($sql)){
        
        $result = $pdo->query($sql);
        $total  = $result->fetch();
        return  $total['PESSOA_CONTROLE'];
        
    }else{
        return NULL;
        
    }
}

function consultar_email($pdo, $mail)
{
    $sql    = " SELECT TOP 1 PESSOA_CONTROLE FROM PESSOA_MEIOCONTATO " .
              " WHERE VALOR = '{$mail}' AND STATUS = 1 ";
    
    if($pdo->query($sql)){
        
        $result = $pdo->query($sql);
        $total  = $result->fetch();
        return  $total['PESSOA_CONTROLE'];
        
    }else{
        return NULL;
        
    }
}

function cadastra_pessoa($pdo, $nome, $cpf)
{
    try{
        
        if(!$rst = $pdo->exec("INSERT INTO PESSOA(NOME, CPF_CNPJ) VALUES('{$nome}', '{$cpf}')")){
            throw new \Exception('===> Erro de SQL <===');
        }
        
        $sql    = "SELECT TOP 1 PESSOA_CONTROLE FROM PESSOA WHERE CPF_CNPJ = '{$cpf}'";
        $result = $pdo->query($sql);
        $total  = $result->fetch();
        return  $total['PESSOA_CONTROLE'];
        
    } catch (PDOException $Exception) {
        throw new MyDatabaseException($Exception->getMessage(), (int)$Exception->getCode());
    }
}

function cadastra_endereco($pdo, $pessoa_controle, $tipo_endereco, $cep, $logradouro, $numero, $complemento = NULL, $bairro, $municipio, $uf)
{
    try{
        
        if($rst = $pdo->exec("INSERT INTO PESSOA_ENDERECO(PESSOA_CONTROLE, TIPOENDERECO_CONTROLE, CEP, LOGRADOURO, NUMERO, COMPLEMENTO, BAIRRO, MUNICIPIO, UF) ".
                " VALUES({$pessoa_controle}, {$tipo_endereco}, '{$cep}', '{$logradouro}', '{$numero}', '{$complemento}', '{$bairro}', '{$municipio}', '{$uf}')")){
           
        }
        
    } catch (PDOException $Exception) {
        throw new MyDatabaseException($Exception->getMessage(), (int)$Exception->getCode());
    }
}

/*
 * 
 *1 -> Telefone
 *2 -> Email
 *3 -> Celular
 *4 -> Fax
 * 
 */
function cadastra_meio_contato($pdo, $pessoa_controle, $tipo, $valor)
{
    try{
        
        if($rst = $pdo->exec("INSERT INTO PESSOA_MEIOCONTATO(PESSOA_CONTROLE, TIPOMEIOCONTATO_CONTROLE, VALOR, STATUS) VALUES({$pessoa_controle}, {$tipo}, '{$valor}', 1)")){
           
        }
        
    }catch(PDOException $Exception){
        throw new MyDataBaseException($Exception->getMessage(), (int)$Exception->getCode());
    }
}

if($_REQUEST != "")
{
    
    if($_POST['action'] == "cadastrar")
    {
        # Chaca se o campo robô foi preenchido
        if(strlen($_POST['check']) == 0){
            
            $nome              = $_POST['nome'             ];
            $cpf               = $_POST['cpf'              ];
            $cep               = $_POST['cep'              ];
            $logradouro        = $_POST['logradouro'       ];
            $numero            = $_POST['numero'           ];
            $complemento       = $_POST['complemento'      ];
            $bairro            = $_POST['bairro'           ];
            $municipio         = $_POST['municipio'        ];
            $uf                = $_POST['uf'               ];
            $telefone          = $_POST['telefone'         ];
            $email             = $_POST['email'            ];
            $email_confirmacao = $_POST['email_confirmacao'];
            
            # Consulta pessoa
            if(!consultar_pessoa($pdo, $cpf)){
                
                # Consulta e-mail
                if(!consultar_email($pdo, $email)){
                    
                    # Registra pessoa
                    $PESSOA_CONTROLE = cadastra_pessoa($pdo, $nome, $cpf);

                    # Registra endereço
                    cadastra_endereco($pdo, $PESSOA_CONTROLE, 1, $cep, $logradouro, $numero, $complemento, $bairro, $municipio, $uf);
                    cadastra_meio_contato($pdo, $PESSOA_CONTROLE, 1, $telefone); # Registar meio contato: Telefone
                    cadastra_meio_contato($pdo, $PESSOA_CONTROLE, 2, $email   ); # Registar meio contato: e-mail
                    
                }
                
                
            }else{
                
                error("<h4>Cadastro já existe!</h4>");
                die();
                
            }
            
        }else{
            
            die('Erro: Você não é humano!');
            
        }
    }
    
}



