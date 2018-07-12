<?php 

require_once '../includes/connect.php';
require_once '../includes/functions.php';
require_once 'includes/security.php'; 

/**
 * Negativar todas as ofertas do produto
 * Atualizar ofertas, ou;
 * Inserir novas ofertas;
 * 
 * @param type $pdo
 * @param type $controle
 * @param type $data
 */
function alterar_produto_preco($pdo, $controle, $data = array())
{

    # Inativa todas as ofertas do produto
    $pdo->exec("UPDATE PRODUTOPRECO SET STATUS = 0 WHERE PRODUTO_CONTROLE = {$controle}");

    foreach ($data as $key => $value):
        # Atualiza a oferta passada no formulário
        if(!$pdo->exec("UPDATE PRODUTOPRECO SET ".
               " PRECO  = '{$value['preco']}',".
               " STATUS = 1".
               " WHERE PRODUTOPRECO_CONTROLE = {$key} AND PRODUTO_CONTROLE = {$controle}")){
                   # Insere uma nova oferta
                   $pdo->exec("INSERT INTO PRODUTOPRECO(PRODUTO_CONTROLE, PRECO, STATUS) VALUES({$controle}, '{$value['preco']}', 1)");
               }
    endforeach;
    
}

function alterar_produto_grupo($pdo, $controle, $data = array())
{
    
    # Inativa todas as ofertas do produto
    $pdo->exec("UPDATE PRODUTOGRUPO SET STATUS = 0 WHERE PRODUTO_CONTROLE = {$controle}");
    
    foreach ($data as $key => $value):
        # Atualiza a oferta passada no formulário
        if(!$pdo->exec("UPDATE PRODUTOGRUPO SET ".
               " GRUPO_CONTROLE     = {$value['grupo']},".
               " SUBGRUPO_CONTROLE  = {$value['subgrupo']},".
               " STATUS = 1".
               " WHERE PRODUTOGRUPO_CONTROLE = {$key} AND PRODUTO_CONTROLE = {$controle}")){
                   # Verifica se já existe a relação de curso e grupo registrada
                   $query = " SELECT * FROM PRODUTOGRUPO WHERE ".
                            " PRODUTO_CONTROLE   = {$controle} AND         " .
                            " GRUPO_CONTROLE     = {$value['grupo']} AND   " .
                            " SUBGRUPO_CONTROLE  = {$value['subgrupo']}    ";
                   if($pdo->query($query)){
                        $rst = $pdo->query($query);
                        $row = $rst->fetch();
                        if(is_array($row)){
                            # Torna visível
                            $pdo->exec("UPDATE PRODUTOGRUPO SET STATUS = 1 WHERE PRODUTOGRUPO_CONTROLE = {$row['PRODUTOGRUPO_CONTROLE']}");
                        }else{
                            # Insere uma nova relação de produto grupo
                            $pdo->exec("INSERT INTO PRODUTOGRUPO(PRODUTO_CONTROLE, GRUPO_CONTROLE, SUBGRUPO_CONTROLE, STATUS) VALUES({$controle}, {$value['grupo']}, {$value['subgrupo']}, 1)");
                        }
                   }else{
                        # Insere uma nova relação de produto grupo
                        $pdo->exec("INSERT INTO PRODUTOGRUPO(PRODUTO_CONTROLE, GRUPO_CONTROLE, SUBGRUPO_CONTROLE, STATUS) VALUES({$controle}, {$value['grupo']}, {$value['subgrupo']}, 1)");
                   }
               }
    endforeach;
    
}

if($_REQUEST != ""){
    
    if($_REQUEST['action'] == "cadastrar"){
        #debug($_POST,1);
        $nome      = utf8_decode(trataString($_POST['nome'     ]));
        $descricao = utf8_decode(trataString($_POST['descricao']));
        $ofertas   = $_POST['oferta'];
        
        $grupo_controle = array();
        # Define o grupo no array $grupo_controle
        if(isset($_POST['grupo'])){
            foreach ($_POST['grupo'] as $value):
                $arr = explode("|", $value);
                $grupo_controle[$arr[0]]['grupo'] = $arr[1];
            endforeach;
        }
        # Define o subgrupo no array $grupo_controle
        if(isset($_POST['subgrupo'])){
            foreach ($_POST['subgrupo'] as $value):
                $arr = explode("|", $value);
                $grupo_controle[$arr[0]]['subgrupo'] = $arr[1];
            endforeach;
        }
       
        try {
            
            if(!$rst = $pdo->exec("INSERT INTO PRODUTO(NOME, DESCRICAO_LOJA, STATUS) VALUES('{$nome}','{$descricao}', 1)")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               # Recupera o ID do último registro
               $sql = "SELECT TOP 1 PRODUTO_CONTROLE FROM PRODUTO ORDER BY PRODUTO_CONTROLE DESC";
               $result = $pdo->query($sql);
               $total_registros = $result->fetch();
               $controle = $total_registros['PRODUTO_CONTROLE'];
               
               alterar_produto_grupo($pdo, $controle, $grupo_controle);
               alterar_produto_preco($pdo, $controle, $ofertas);
               
               $_SESSION['confirm'] = "Cadastrado";
               header("Location: produto.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
    if($_REQUEST['action'] == "alterar"){
        #debug($_POST,1);
        $controle  = $_POST['controle' ];
        $nome      = utf8_decode(trataString($_POST['nome'     ]));
        $descricao = utf8_decode(trataString($_POST['descricao']));
        $ofertas   = isset($_POST['oferta'  ]) ? $_POST['oferta'  ] : NULL;
        #$grupo     = isset($_POST['grupo'   ]) ? $_POST['grupo'   ] : NULL;
        #$subgrupo  = isset($_POST['subgrupo']) ? $_POST['subgrupo'] : NULL;
        
        $grupo_controle = array();
        # Define o grupo no array $grupo_controle
        if(isset($_POST['grupo'])){
            foreach ($_POST['grupo'] as $value):
                $arr = explode("|", $value);
                $grupo_controle[$arr[0]]['grupo'] = $arr[1];
            endforeach;
        }
        # Define o subgrupo no array $grupo_controle
        if(isset($_POST['subgrupo'])){
            foreach ($_POST['subgrupo'] as $value):
                $arr = explode("|", $value);
                $grupo_controle[$arr[0]]['subgrupo'] = $arr[1];
            endforeach;
        }
        #debug($grupo_controle,1);
        try {
            if(!$pdo->exec("UPDATE PRODUTO SET ".
               " DESCRICAO_LOJA         = '{$descricao}',". 
               " NOME                   = '{$nome}'".
               " WHERE PRODUTO_CONTROLE = {$controle}")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               #alterar_produto_preco($pdo, $controle, $ofertas);
               alterar_produto_grupo($pdo, $controle, $grupo_controle);
               
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
               
               $_SESSION['confirm'] = "Removido";
               header("Location: produto.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
    //restaurar
    if($_REQUEST['action'] == "restaurar"){
        
                
        $controle  = $_GET['controle' ];
        
        try {
            if(!$pdo->exec("UPDATE PRODUTO SET ".
               " STATUS  = '1'".
               " WHERE PRODUTO_CONTROLE = {$controle}")){
                   
                    throw new \Exception('===> Erro de SQL <===');
                    
               }
               
               $_SESSION['confirm'] = "Alterado";
               header("Location: produto_excluido.php");
               
        } catch (PDOException $Exceptio) {
            
            throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            
        }
        
    }
    
    if($_POST['action'] == "upload_imagem"){
        
        if ( isset( $_FILES[ 'arquivo' ][ 'name' ] ) && $_FILES[ 'arquivo' ][ 'error' ] == 0 ) {

        $arquivo_tmp = $_FILES['arquivo'  ][ 'tmp_name'];
        $nome        = $_FILES['arquivo'  ][ 'name'    ];
        $controle    = $_POST ['controle' ];

        $extensao = pathinfo ($nome, PATHINFO_EXTENSION);
        $extensao = strtolower ($extensao);

        if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {

            $name    = uniqid(time()) . '.' . $extensao;
            $destino = '../data/produtos/'  . $name;

            if (@move_uploaded_file($arquivo_tmp, $destino)) {
                
                # Inativa todas as imagens do produto
                $pdo->exec("UPDATE PRODUTOIMAGEM SET STATUS = 0 WHERE PRODUTO_CONTROLE = {$controle}");
                
                # Insere a imagem
                $pdo->exec("INSERT INTO PRODUTOIMAGEM(PRODUTO_CONTROLE, NOME_IMAGEM, STATUS) VALUES({$controle}, '{$name}', 1)");

                $_SESSION['confirm'] = "Imagem salva";
                header("Location: produto.php");
                
            }
            else
                echo 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
        }
        else
            echo 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br />';
        }
        else
            echo 'Você não enviou nenhum arquivo!';
    
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
