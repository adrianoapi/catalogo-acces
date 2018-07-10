<?php require_once 'includes/connect.php';   ?>
<?php require_once 'includes/functions.php'; ?>
<?php require_once 'includes/topo.php';      ?>
<?php require_once 'includes/security.php';  ?>
<?php

function registrar_pedido($pdo, array $data)
{
    # Registra o pedido
    $sql = " INSERT INTO ECOMMERCE (PESSOA_CONTROLE,EMISSAO,VALORNF,STATUS) ".
           " VALUES ({$data['PESSOA_CONTROLE']},'{$data['EMISSAO']}', '{$data['VALORNF']}', 1)";
    if($pdo->exec($sql)){
        
        # Retorna os dados do último pedido registrado
        $consulta = $pdo->query(" SELECT TOP 1 * FROM ECOMMERCE WHERE " .
                                " PESSOA_CONTROLE = {$data['PESSOA_CONTROLE']} ".
                                " ORDER BY PESSOA_CONTROLE DESC ");
        $result   = $consulta->fetch();
        return $result['ECOMMERCE_CONTROLE'];
        
    }else{
        return FALSE;
    }
    return $pdo->exec($sql);
}

function registrar_pedido_item($pdo, $eccomerce_controle, array $data)
{
    foreach ($data as $value) {
        $total = $value['oferta_valor'] * $value['quantidade'];
        $sql = " INSERT INTO ECOMMERCE_ITEM (ECOMMERCE_CONTROLE, PRODUTO_CONTROLE, QUANTIDADE, VALORUNITARIO, VALORTOTAL, STATUS) ".
               " VALUES ({$eccomerce_controle}, {$value['controle']}, {$value['quantidade']}, '{$value['oferta_valor']}', '{$total}', 1)";
        $pdo->exec($sql);
    }
    
    return TRUE;
}

    if(isset($_POST['action'])){
        
        if($_POST['action'] = "finalizar"){
            
            $soma = 0;
            foreach ($_SESSION['carrinho'] as $value):
                
                $valor = $value['oferta_valor'];
                $soma += $valor * $value['quantidade'];
                
            endforeach;
            
            $dados_pedido = array(
                'PESSOA_CONTROLE' => $_SESSION['AUTH']['controle'],
                'VALORNF'         => $soma,
                'EMISSAO'         => date('Y-m-d H:i:s')
            );
            
            # Popula a tabela ECOMMERCE 
            $ecommerce_controle = registrar_pedido($pdo, $dados_pedido);
            
            if($ecommerce_controle){
                
                # Popula a tabela ECOMMERCE_ITEM
                if(registrar_pedido_item($pdo, $ecommerce_controle, $_SESSION['carrinho'])){
                    
                    unset($_SESSION['carrinho']);
                    
                    # Redireciona para o extrato
                    $_SESSION['confirm'] = "Pedido";
                    header("Location: pedido_resumo.php?cod=".$ecommerce_controle);
                    
                }
                
            }
            
                       
            
            
        }
        
    }

    $sql = "SELECT TOP 1 * FROM PESSOA_ENDERECO WHERE PESSOA_CONTROLE = {$_SESSION['AUTH']['controle']}";
    $qry = $pdo->query($sql);
    $rst = $qry->fetch();
    
?>
<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            
            <div class="col-lg-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo count($_SESSION['carrinho']) > 1 ? "Produtos" : "Produto"; ?></h3>
                    </div>
                    <div class="panel-body">
                        
                          <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="col-lg-2 col-sm-1 col-xs-1"></th>
                                    <th class="col-lg-6 col-sm-1 col-xs-1"></th>
                                    <th class="col-lg-2 col-sm-6 col-xs-6">QTD</th>
                                    <th class="col-lg-1">VALOR</th>
                                    <th class="col-lg-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $soma = 0;
                                foreach ($_SESSION['carrinho'] as $value):
                                $valor = $value['oferta_valor'];
                                ?>
                                <tr>
                                    <td><?php echo isset($value['imagem']) ? '<img src="data/produtos/'.$value['imagem'].'" alt="" style="width:90px;height:120px;padding:5px;">' : '<img src="http://placehold.it/120x120" alt="" style="width:150px;height:200px;padding:5px;">'; ?></td>
                                    <td><?php echo $value['nome']; ?></td>
                                    <td><?php echo $value['quantidade']; ?></td>
                                    <td><?php echo number_format($valor, 2, ',', '.'); ?></td>
                                    <td><?php echo number_format($valor * $value['quantidade'], 2, ',', '.'); ?></td>
                                </tr>
                                <?php 
                                $soma += $valor * $value['quantidade'];
                                endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="5">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div><!--end/panel-body-->
                  </div><!--end/panel-->
     
            </div>
            <div class="col-lg-4">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Fatura</h3>
                    </div>
                    <div class="panel-body">

                        <?php echo $rst['CEP'];?>
                        <br/>
                        <?php echo $rst['LOGRADOURO'];?>, <?php echo $rst['NUMERO'];?> <?php echo $rst['COMPLEMENTO'];?>
                        <br/>
                        <?php echo $rst['BAIRRO'];?> - <?php echo $rst['MUNICIPIO'];?> / <?php echo $rst['UF'];?>
                        <hr>
                        Total: R$ <?php echo number_format($soma, 2, ',','.'); ?>
                    </div><!--end/panel-body-->
                  </div><!--end/panel-->

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-12">
                        <form action="pedido_confirmacao.php" method="POST">
                            <input type="hidden" name="action" value="finalizar">
                            <button type="submit" class="btn btn-success col-lg-12">FINALIZAR PEDIDO</button>
                        </form>
                    </div>
                  </div>
                </div>     
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-12">
                        <a href="pedido_endereco.php" class="btn btn-default col-lg-12"><span class="glyphicon glyphicon-chevron-left pull-left" aria-hidden="true"></span> Voltar</a>
                    </div>
                  </div>
                </div>     
            </div>
        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>