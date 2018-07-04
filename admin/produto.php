<?php require_once '../includes/connect.php'; ?>
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

                <div class="panel panel-default">
                  <div class="panel-heading">Produtos</div>
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

                        <table class="table table-striped table-hover ">
                          <thead>
                              <tr>
                                  <th class="col-lg-1">#</th>
                                  <th class="col-lg-1"></th>
                                  <th class="col-lg-10" colspan="2"> 
                                      <div class="row">
                                        <span class="col-lg-2 pull-right"><a href="produto_cadastrar.php" class="btn btn-success pull-right"> Adicionar</a></span>
                                        <span class="col-lg-1">&nbsp;&nbsp;</span>
                                        <span class="col-lg-9 pull-right"><a href="produto_excluido.php" class="btn btn-default pull-right"> Excluídos</a></span>
                                      </div>
                                  </th>
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

                            $p = isset($_GET["p"]) ? $_GET["p"] : 1;
                            $inicio = ($p * $qnt) - $qnt;
                            $qnt = ($total_registros - $inicio) < $qnt ? $total_registros - $inicio : $qnt;

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

                                # Get imagem
                                $sql_img = "SELECT TOP 1 * FROM PRODUTOIMAGEM WHERE PRODUTO_CONTROLE = {$controle} AND STATUS = 1";
                                if($pdo->query($sql_img)){

                                    $sql_qry = $pdo->query($sql_img);
                                    $img = $sql_qry->fetch();
                                    $img = $img['NOME_IMAGEM'];

                                }else{
                                    $img = FALSE;
                                }

                                # Get oferta
                                $sql_pre = "SELECT COUNT(*) AS total FROM PRODUTOPRECO WHERE PRODUTO_CONTROLE = {$controle}";
                                if($pdo->query($sql_pre)){

                                    $qry_pre = $pdo->query($sql_pre);
                                    $pre     = $qry_pre->fetch();
                                    $pre     = $pre['total'];

                                }else{
                                    $pre = 0;
                                }
                                
                                $grupo_produto = NULL;
                                $sql_grp = "SELECT s.NOME FROM SUBGRUPO AS s".
                                           " INNER JOIN PRODUTOGRUPO AS p ON (p.SUBGRUPO_CONTROLE = s.SUBGRUPO_CONTROLE AND s.STATUS = 1)".
                                           #" INNER JOIN SUBGRUPO     AS s ON (p.PRODUTOGRUPO_CONTROLE = s.SUBGRUPO_CONTROLE AND s.STATUS = 1)".
                                           " WHERE p.PRODUTO_CONTROLE = $controle AND p.STATUS = 1 ";
                                if($pdo->query($sql_grp)){
                                    $qry_grp = $pdo->query($sql_grp);
                                    while($row_grp = $qry_grp->fetch()){
                                        $grupo_produto .= $row_grp['NOME'].",";
                                    }
                                }
                        ?>
                        <tr>
                            <td><input type="checkbox" name="id"></td>
                            <td><?php echo ($img) ? '<a href="./produto_alterar.php?cod='.$row['PRODUTO_CONTROLE'].'"><img src="../data/produtos/'.$img.'" width="60px"></a>' : NULL; ?></td>
                            <td>
                                <strong><?php echo utf8_encode($row['NOME']); ?></strong>
                                <br>
                                <?php echo $pre > 0 ? "ofertas: {$pre}" : "oferta: {$pre}"; ?>
                                <br>
                                <?php echo strlen($grupo_produto) > 0 ? "grupos: {$grupo_produto}" : "grupo: "; ?>
                            </td>
                            <td>
                                <div class="dropdown pull-right">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="./produto_imagem.php?cod=<?php echo $row['PRODUTO_CONTROLE']; ?>"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Imagem</a></li>
                                    <li><a href="<?php echo './produto_alterar.php?cod='.$row['PRODUTO_CONTROLE']; ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</a></li>
                                    <li><a href="./produto_action.php?controle=<?php echo $row['PRODUTO_CONTROLE']; ?>&action=excluir" onclick="if (confirm('Confirmar exclusão do item: \n\n <?php echo utf8_encode($row['NOME']); ?> \n' )) { window.location.href = this.href } return false;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Excluir</a></li>
                                  </ul>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                          </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <a href="<?php echo $row['PRODUTO_CONTROLE']; ?>" class="btn btn-danger"><span class="fa fa-fw fa-trash"></span> Excluir</a>
                                    <span class="pull-right">Total de registros: <?php echo $total_registros; ?></span>
                                </td>
                            </tr>
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
                      
                  </div><!--./panel-body-->
                </div><!--./panel-default-->

            </div><!--./col-md-9-->

        </div><!--./row-->

    </div><!--./container-->
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>