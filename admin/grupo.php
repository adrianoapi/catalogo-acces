<?php require_once '../includes/connect.php';   ?>
<?php require_once '../includes/functions.php'; ?>
<?php require_once 'includes/topo.php'; 
$page = "grupo.php";
?>



<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">
                
                <div class="panel panel-default">
                  <div class="panel-heading">Grupos</div>
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
                                  <th class="col-lg-2">#</th>
                                  <th class="col-lg-10" colspan="2"> 
                                      <div class="row">
                                        <span class="col-lg-2 pull-right"><a href="grupo_cadastrar.php" class="btn btn-success pull-right"> Adicionar</a></span>
                                      </div>
                                  </th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php

                            $qnt = 10;
                            $sql = "SELECT COUNT(*) AS total FROM GRUPO WHERE STATUS = 1 $where_and";
                            $result = $pdo->query($sql);
                            $total_registros = $result->fetch();
                            $total_registros = $total_registros['total'];
                            $pags = ceil($total_registros / $qnt);

                            $p = isset($_GET["p"]) ? $_GET["p"] : 1;
                            $inicio = ($p * $qnt) - $qnt;
                            $qnt = ($total_registros - $inicio) < $qnt ? $total_registros - $inicio : $qnt;

                            $sql = "SELECT GRUPO.*
                            FROM GRUPO
                            WHERE STATUS = 1 AND GRUPO.GRUPO_CONTROLE In 
                                  (
                                    SELECT TOP $qnt A.GRUPO_CONTROLE
                                    FROM [
                                           SELECT TOP ".($qnt+$inicio) ." GRUPO.NOME, GRUPO.GRUPO_CONTROLE
                                           FROM GRUPO
                                           WHERE STATUS = 1 $where_and ORDER BY GRUPO.NOME, GRUPO.GRUPO_CONTROLE
                                         ]. AS A
                                    WHERE STATUS = 1 $where_and ORDER BY A.NOME DESC, A.GRUPO_CONTROLE
                                  )
                            $where_and ORDER BY GRUPO.NOME, GRUPO.GRUPO_CONTROLE";
                            $result = $pdo->query($sql);
                            if($result){

                            while ($row = $result->fetch()) {

                                $controle = $row['GRUPO_CONTROLE'];
                        ?>
                        <tr>
                            <td><input type="checkbox" name="id"></td>
                            <td>
                                <?php echo utf8_encode($row['NOME']); ?>
                            </td>
                            <td>
                                <div class="dropdown pull-right">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                    <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="<?php echo './grupo_alterar.php?cod='.$row['GRUPO_CONTROLE']; ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</a></li>
                                    <li><a href="./grupo_action.php?controle=<?php echo $row['GRUPO_CONTROLE']; ?>&action=excluir" onclick="if (confirm('Confirmar exclusão do item__: \n\n <?php echo utf8_encode(trataStringJS($row['NOME'])); ?> \n' )) { window.location.href = this.href } return false;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Excluir</a></li>
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
                                    <a href="<?php echo $row['GRUPO_CONTROLE']; ?>" class="btn btn-danger"><span class="fa fa-fw fa-trash"></span> Excluir</a>
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

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>