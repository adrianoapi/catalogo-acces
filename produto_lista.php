<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>
<?php

?>
<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de produtos</h3>
                    </div>
                    <div class="panel-body">

                        <?php

                        // Parâmetro de busca
                        if(@$_GET['pesquisa']){
                            $where_and = "AND NOME LIKE '%".utf8_decode($_GET['pesquisa'])."%'";
                            $pesquisa  = $_GET['pesquisa'];
                        }else{
                            $where_and = NULL;
                            $pesquisa  = NULL;
                        }

                        ?>

                        <table class="table table-striped table-hover ">
                          <thead>
                              <tr>
                                  <th class="col-lg-1"></th>
                                  <th class="col-lg-10" colspan="2"></th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php

                            $qnt = 10;
                            $sql = "SELECT COUNT(*) AS total FROM PRODUTO WHERE STATUS = 1 $where_and";
                            $result = $pdo->query($sql);
                            $total_registros = $result->fetch();
                            $total_registros = $total_registros['total'];
                            $pags = ceil($total_registros / $qnt);

                            $p      = isset($_GET["p"]) ? $_GET["p"] : 1;
                            $inicio = ($p * $qnt) - $qnt;
                            $qnt    = ($total_registros - $inicio) < $qnt ? $total_registros - $inicio : $qnt;

                            $sql = "SELECT PRODUTO.*
                            FROM PRODUTO
                            WHERE STATUS = 1 AND PRODUTO.PRODUTO_CONTROLE In 
                                  (
                                    SELECT TOP $qnt A.PRODUTO_CONTROLE
                                    FROM [
                                           SELECT TOP ".($qnt+$inicio) ." PRODUTO.NOME, PRODUTO.PRODUTO_CONTROLE
                                           FROM PRODUTO
                                           WHERE STATUS = 1 $where_and ORDER BY PRODUTO.NOME, PRODUTO.PRODUTO_CONTROLE
                                         ]. AS A
                                    WHERE STATUS = 1 $where_and ORDER BY A.NOME DESC, A.PRODUTO_CONTROLE
                                  )
                            $where_and ORDER BY PRODUTO.NOME, PRODUTO.PRODUTO_CONTROLE";
                            $result = $pdo->query($sql);
                            if($result){

                            while ($row = $result->fetch()) {

                                $controle = $row['PRODUTO_CONTROLE'];
                                $sql_img  = "SELECT TOP 1 * FROM PRODUTOIMAGEM WHERE PRODUTO_CONTROLE = {$controle} AND STATUS = 1";

                                if($pdo->query($sql_img)){

                                    $sql_qry = $pdo->query($sql_img);
                                    $img     = $sql_qry->fetch();
                                    $img     = $img['NOME_IMAGEM'];

                                }else{
                                    $img = FALSE;
                                }
                                
                                # Preço
                                $pre_qry = $pdo->query("SELECT TOP 1 * FROM PRODUTOPRECO WHERE PRODUTO_CONTROLE = {$controle} AND STATUS=1");
                                if($pre_qry){
                                    $preco = $pre_qry->fetch();  
                                }else{
                                    $preco = NULL;
                                }
                        ?>
                        <tr>
                            <td><?php echo ($img) ? '<a href="./produto.php?cod='.$row['PRODUTO_CONTROLE'].'"><img src="data/produtos/'.$img.'" width="60px"></a>' : NULL; ?></td>
                            <td>
                                <?php 
                                    echo "<strong>".utf8_encode($row['NOME'])."</strong>"; 
                                    echo "<p style=\"text-align: justify;\">".utf8_encode($row['DESCRICAO_LOJA'])."</p>"; 
                                ?>
                                <?php echo isset($preco['PRECO']) ? '<h4>R$ '.number_format($preco['PRECO'], 2, ',', '.').'</h4>' : ''; ?>
                            </td>
                            <td>
                                <a href="./produto.php?cod=<?php echo $row['PRODUTO_CONTROLE']; ?>" class="btn btn-default pull-right">Detalhes</a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                          </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <span class="pull-right"><?php paginacao(3, $p,$pags, $pesquisa); ?></span>
                                </td>
                            </tr>
                        </tfoot>
                        <?php
                        }else{
                        ?>
                            <tr>
                                <td colspan="4">Nenhum registro encontrado!</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                        
                    </div<!--end/panel-body-->
                </div><!--end/panel-->

            </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
        
</body>

</html>