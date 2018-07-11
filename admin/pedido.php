<?php require_once '../includes/connect.php';   ?>
<?php require_once '../includes/functions.php'; ?>
<?php require_once 'includes/topo.php'; 
$page = "pedido.php";
?>



<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">
                
                <div class="panel panel-default">
                  <div class="panel-heading">Pedidos</div>
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

                        // Mensagem de confirmação
                        if(@$_SESSION['confirm']){

                            $html  = NULL;
                            $html .= '<div class="alert alert-success alert-dismissible" role="alert">';
                            $html .= ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                            $html .= ' <strong>' . $_SESSION['confirm'] . '</strong> com sucesso!';
                            $html .= '</div>';

                            echo $html;

                            unset($_SESSION['confirm']);

                        }

                        ?>

                        <table class="table table-striped table-hover">
                          <thead>
                              <tr>
                                  <th class="col-lg-2">#</th>
                                  <th class="col-lg-2">CLIENTE</th>
                                  <th class="col-lg-4">DATA</th>
                                  <th class="col-lg-2"><span class="pull-right">VALOR</span></th>
                                  <th class="col-lg-2"></th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php

                            $qnt = 10;
                            $sql = "SELECT COUNT(*) AS total FROM ECOMMERCE WHERE STATUS = 1";
                            $result = $pdo->query($sql);
                            $total_registros = $result->fetch();
                            $total_registros = $total_registros['total'];
                            $pags = ceil($total_registros / $qnt);

                            $p = isset($_GET["p"]) ? $_GET["p"] : 1;
                            $inicio = ($p * $qnt) - $qnt;
                            $qnt = ($total_registros - $inicio) < $qnt ? $total_registros - $inicio : $qnt;

                            $sql = "SELECT ECOMMERCE.*, PESSOA.NOME
                            FROM (ECOMMERCE
                            INNER JOIN PESSOA ON (PESSOA.PESSOA_CONTROLE = ECOMMERCE.PESSOA_CONTROLE))
                            WHERE ECOMMERCE.STATUS = 1 AND ECOMMERCE.ECOMMERCE_CONTROLE In 
                                  (
                                    SELECT TOP $qnt A.ECOMMERCE_CONTROLE
                                    FROM [
                                           SELECT TOP ".($qnt+$inicio) ." ECOMMERCE.*
                                           FROM ECOMMERCE
                                           WHERE ECOMMERCE.STATUS = 1 ORDER BY ECOMMERCE.ECOMMERCE_CONTROLE DESC
                                         ]. AS A
                                    WHERE A.STATUS = 1 ORDER BY A.ECOMMERCE_CONTROLE DESC
                                  )
                            ORDER BY ECOMMERCE.ECOMMERCE_CONTROLE DESC";
                            $result = $pdo->query($sql);
                            
                            if($result){

                            while ($row = $result->fetch()) {

                                $controle = $row['ECOMMERCE_CONTROLE'];
                            ?>
                            <tr>
                                <td><input type="checkbox" name="id"></td>
                                <td><?php echo utf8_encode($row['NOME']); ?></td>
                                <td><?php echo datetime2Br($row['EMISSAO']); ?></td>
                                <td><span class="pull-right"><?php echo number_format($row['VALORNF'], 2, ',', '.'); ?></span></td>
                                <td><span class="pull-right"><a href="#" class="btn btn-default">+Detalhe</a></span></td>
                            </tr>
                            <?php
                            }
                            ?>
                          </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <a href="<?php echo $row['ECOMMERCE_CONTROLE']; ?>" class="btn btn-danger"><span class="fa fa-fw fa-trash"></span> Excluir</a>
                                    <span class="pull-right">Total de registros: <?php echo $total_registros; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <span class="pull-right"><?php paginacao(3, $p,$pags, $pesquisa); ?></span>
                                </td>
                            </tr>
                        </tfoot>
                        <?php
                        }else{
                        ?>
                            <tr>
                                <td colspan="5">Nenhum registro encontrado!</td>
                            </tr>
                        <?php
                        }
                        ?>
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