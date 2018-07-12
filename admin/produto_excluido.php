<?php require_once '../includes/connect.php';   ?>
<?php require_once '../includes/functions.php'; ?>
<?php require_once 'includes/security.php';     ?>
<?php require_once 'includes/topo.php';
$page = "produto.php";
?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">

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
                          <th class="col-lg-10">#</th>
                          <th class="col-lg-2" colspan="2"></th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $qnt = 10;
                    
                    // Contagem de itens
                    $sql = "SELECT COUNT(*) AS total FROM PRODUTO WHERE STATUS = 0 $where_and";
                    $result = $pdo->query($sql);
                    $total_registros = $result->fetch();
                    $total_registros = $total_registros['total'];
                    $pags = ceil($total_registros / $qnt);
                  
                    $p = isset($_GET["p"]) ? $_GET["p"] : 1;
                    $inicio = ($p * $qnt) - $qnt;
                    $qnt = ($total_registros - $inicio) < $qnt ? $total_registros - $inicio : $qnt;
                $sql = "SELECT PRODUTO.*
                FROM PRODUTO
                WHERE STATUS = 0 AND PRODUTO.PRODUTO_CONTROLE In 
                      (
                        SELECT TOP $qnt A.PRODUTO_CONTROLE
                        FROM [
                               SELECT TOP ".($qnt+$inicio) ." PRODUTO.NOME, PRODUTO.PRODUTO_CONTROLE
                               FROM PRODUTO
                               WHERE STATUS = 0 $where_and ORDER BY PRODUTO.NOME, PRODUTO.PRODUTO_CONTROLE
                             ]. AS A
                        WHERE STATUS = 0 $where_and ORDER BY A.NOME DESC, A.PRODUTO_CONTROLE
                      )
                $where_and ORDER BY PRODUTO.NOME, PRODUTO.PRODUTO_CONTROLE";
                $result = $pdo->query($sql);
                if($result){
                    while ($row = $result->fetch()) {
                    ?>
                    <tr>
                        <td><?php echo utf8_encode($row['NOME']); ?></td>
                        <td>
                            <a href="./produto_action.php?controle=<?php echo $row['PRODUTO_CONTROLE']; ?>&action=restaurar" class="btn btn-default pull-right" onclick="if (confirm('Confirmar restauração do item: \n\n <?php echo utf8_encode($row['NOME']); ?> \n' )) { window.location.href = this.href } return false;"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Restaurar</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <span class="pull-right">Total de registros: <?php echo $total_registros; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <span class="pull-right"><?php paginacao(3, $p,$pags, $pesquisa); ?></span>
                            </td>
                        </tr>
                    </tfoot>
                <?php
                }else{
                ?>
                <tr>
                    <td colspan="2">Nenhum registro encontrado!</td>
                </tr>
                <?php
                }
                ?>
            </table>

            </div>

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>