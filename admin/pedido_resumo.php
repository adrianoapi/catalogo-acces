<?php require_once '../includes/connect.php';   ?>
<?php require_once '../includes/functions.php'; ?>
<?php require_once 'includes/topo.php'; 
$page = "pedido.php";

$controle = addslashes($_GET['cod']);
$controle = is_numeric($controle) ? $controle : 0;

$consulta = $pdo->query(" SELECT TOP 1 * FROM ECOMMERCE WHERE " .
                        " ECOMMERCE_CONTROLE = {$controle} AND ECOMMERCE_CONTROLE = {$controle} ".
                        " ORDER BY PESSOA_CONTROLE DESC ");
$result   = $consulta->fetch();

$itens_sql = " SELECT IT.*, PR.NOME FROM ECOMMERCE_ITEM AS IT " .
             " INNER JOIN PRODUTO AS PR ON PR.PRODUTO_CONTROLE = IT.PRODUTO_CONTROLE" .
             " WHERE ECOMMERCE_CONTROLE = {$controle} ";
$itens     = $pdo->query($itens_sql);

?>


<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">
                
                <div class="panel panel-default">
                  <div class="panel-heading">Pedido Resumo</div>
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
                      
                  </div><!--./panel-body-->
                </div><!--./panel-default-->


                

            </div><!--./col-md-9-->

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>