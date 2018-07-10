<?php require_once 'includes/connect.php';   ?>
<?php require_once 'includes/functions.php'; ?>
<?php require_once 'includes/topo.php';      ?>
<?php require_once 'includes/security.php';  ?>
<?php 

    $controle = addslashes($_GET['cod']);
    $controle = is_numeric($controle) ? $controle : 0;

    $consulta = $pdo->query(" SELECT TOP 1 * FROM ECOMMERCE WHERE " .
                                " PESSOA_CONTROLE = {$_SESSION['AUTH']['controle']} AND ECOMMERCE_CONTROLE = {$controle} ".
                                " ORDER BY PESSOA_CONTROLE DESC ");
    $result   = $consulta->fetch();
    
    if(is_array($result)){
        
        $itens_sql = " SELECT IT.*, PR.NOME FROM ECOMMERCE_ITEM AS IT " .
                     " INNER JOIN PRODUTO AS PR ON PR.PRODUTO_CONTROLE = IT.PRODUTO_CONTROLE" .
                     " WHERE ECOMMERCE_CONTROLE = {$controle} ";
        $itens     = $pdo->query($itens_sql);
        
    }
   
?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            
            <div class="col-lg-8 col-md-offset-2">
                
                <?php
                
                if(isset($_SESSION['confirm'])){

                    $html  = NULL;
                    $html .= '<div class="alert alert-success alert-dismissible" role="alert">';
                    $html .= ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    $html .= ' <strong>' . $_SESSION['confirm'] . '</strong> com sucesso!';
                    $html .= '</div>';

                    echo $html;

                    unset($_SESSION['confirm']);

                }
                
                ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Resumo pedido #<?php echo $controle; ?> <span class="pull-right"><?php echo datetime2Br($result['EMISSAO']); ?></span></h3>
                    </div>
                    <div class="panel-body">
                        
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>PRODUTO</th>
                                    <th>QTD</th>
                                    <th>VALOR</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                        <?php
                        
                        while($item = $itens->fetch()){
                            
                            echo null
                                    ."<tr>"
                                    . "<td>".utf8_encode($item['NOME'    ])."</td>"
                                    . "<td>".$item['QUANTIDADE'   ]."</td>"
                                    . "<td><span class=\"pull-right\">".number_format($item['VALORUNITARIO'], 2, ',', '.')."</span></td>"
                                    . "<td><span class=\"pull-right\">".number_format($item['VALORTOTAL'   ], 2, ',', '.')."</span></td>"
                                    . "</tr>";
                        }
                        
                        ?>
                            <tfoot>
                                <tr>
                                    <td colspan="4"><span class="pull-right">Total: R$ <?php echo number_format($result['VALORNF'], 2, ',','.'); ?></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!--end/panel-body-->
                </div><!--end/panel-->
                
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-12">
                        <a href="pedido_listagem.php" class="btn btn-primary pull-right"> Voltar para pedidos</a>
                    </div>
                  </div>
                </div>

            </div><!--./col-lg-8-->

        </div><!--./row-->
     
    </div><!-- /.container -->
    
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>