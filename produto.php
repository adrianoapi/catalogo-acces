<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>
<?php
    if(@isset($_GET['cod'])){

        $controle = $_GET['cod'];

        $sql  = " SELECT TOP 1 p.*, i.* FROM PRODUTO AS p ".
                " LEFT JOIN PRODUTOIMAGEM AS i ON (i.PRODUTO_CONTROLE = p.PRODUTO_CONTROLE AND i.STATUS=1) ".
                " WHERE p.PRODUTO_CONTROLE = $controle AND p.STATUS=1";
        $result = $pdo->query($sql);
        $row = $result->fetch();
        
        $pre_qry = $pdo->query("SELECT * FROM PRODUTOPRECO WHERE PRODUTO_CONTROLE = {$row['PRODUTO_CONTROLE']} AND STATUS=1");
        
        $grp_sql = "SELECT TOP 1 * FROM PRODUTOGRUPO WHERE PRODUTO_CONTROLE = {$row['PRODUTO_CONTROLE']} AND STATUS = 1";
        if($pdo->query($grp_sql)){
            
            $grp_qry = $pdo->query($grp_sql);
            $grp_row = $grp_qry->fetch();
            $where_grupo = $grp_row['GRUPO_CONTROLE'];
        }else{
            $where_grupo = NULL;
        }

    }else{
        echo utf8_encode("Erro: Referência do produto não foi encontrada!");
    }
?>
<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

        <?php require_once 'includes/categoria.php';     ?>

            <div class="col-lg-9">

                <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo utf8_encode($row['NOME']); ?></h3>
                </div>
                    <div class="panel-body">

                        <form method="POST" action="carrinho.php">
                            <div class="card mt-4">

                                <div class="card-body">
                                    <div class="col-lg-4">
                                        <div class="thumbnail">
                                            <?php echo isset($row['NOME_IMAGEM']) ? '<img src="data/produtos/'.$row['NOME_IMAGEM'].'" width="120" height="120" alt="" style="width:150px;height:200px;padding:5px;">' : '<img src="http://placehold.it/120x120" alt="" style="width:150px;height:200px;padding:5px;">'; ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <h3 class="card-title"><?php echo utf8_encode($row['NOME']); ?></h3>                                    
                                        <p class="card-text"><?php echo utf8_encode($row['DESCRICAO_LOJA']); ?></p>
                                        <?php
                                        $_SESSION['oferta'] = array();
                                        if($pre_qry){
                                            echo '<ul class="list-group">';
                                              while($val = $pre_qry->fetch()){
                                                  $_SESSION['oferta'][$val['PRODUTOPRECO_CONTROLE']] = $val['PRECO'];
                                                  echo '<li class="list-group-item"><label><input type="radio" name="oferta" value="'.$val['PRODUTOPRECO_CONTROLE'].'" checked>R$'.number_format($val['PRECO'],2,',','.').'</label></li>';
                                              }
                                            echo '</ul>';

                                          }
                                        ?>
                                    </div>

                                  <hr>

                                    <input type="hidden" name="action"   value="adicionar">
                                    <input type="hidden" name="controle" value="<?php echo $row['PRODUTO_CONTROLE']; ?>">
                                    <input type="hidden" name="imagem"   value="<?php echo $row['NOME_IMAGEM']; ?>">
                                    <input type="hidden" name="nome"     value="<?php echo utf8_encode($row['NOME']); ?>">
                                    <?php if(count($_SESSION['oferta']) > 0) {?>
                                        <div class="col-lg-4 pull-right"><button type="submit" class="btn btn-success">Adicionar ao carrinho</button></div>
                                        <div class="col-lg-2 pull-right"><input type="number" name="quantidade" value="1" class="form-control" required></div>
                                    <?php }?>
                                </div>
                            </div>

                        </form>

                    </div><!--/.end/panel-body-->
                </div>  <!--/.panel-default--> 

                <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Produtos relacionados</h3>
                </div>
                    <div class="panel-body">

                        <?php
                        
                        # Armazena produtos para não repetir
                        $lista_produtos = array();
                        
                        # Cehca se retornou um grupo
                        if($where_grupo){
                            
                            # SQL que exige um grupo
                            $sql  = " SELECT TOP 5 p.*, i.* FROM (PRODUTO AS p ".
                                    " INNER JOIN PRODUTOGRUPO  AS g ON (g.GRUPO_CONTROLE = {$where_grupo} AND g.PRODUTO_CONTROLE = p.PRODUTO_CONTROLE AND g.STATUS=1)) ".
                                    " LEFT JOIN PRODUTOIMAGEM AS i ON (i.PRODUTO_CONTROLE = p.PRODUTO_CONTROLE AND i.STATUS=1) ".
                                    " WHERE p.STATUS = 1 AND p.PRODUTO_CONTROLE <> {$row['PRODUTO_CONTROLE']} ".
                                    " ORDER BY Rnd(-(100000* p.PRODUTO_CONTROLE )*Time())";
                        }else{
                            
                            # SQL caso não haja grupo
                            $sql  = " SELECT TOP 4 p.*, i.* FROM PRODUTO AS p ".
                                " LEFT JOIN PRODUTOIMAGEM AS i ON (i.PRODUTO_CONTROLE = p.PRODUTO_CONTROLE AND i.STATUS=1) ".
                                " WHERE p.STATUS = 1 AND p.PRODUTO_CONTROLE <> {$row['PRODUTO_CONTROLE']}".
                                " ORDER BY Rnd(-(100000* p.PRODUTO_CONTROLE )*Time())";
                        }
                        $relacao_limit = 4;
                        $relacao_count = 0;
                        $result = $pdo->query($sql);
                        while($row = $result->fetch()){
                            
                            # Confere para ver se não vai repetir
                            if(!in_array($row['PRODUTO_CONTROLE'], $lista_produtos) && $relacao_count < 4){
                                
                                array_push($lista_produtos, $row['PRODUTO_CONTROLE']);
                                ++$relacao_count;
                                
                                $pre_qry = $pdo->query("SELECT TOP 1 * FROM PRODUTOPRECO WHERE PRODUTO_CONTROLE = {$row['PRODUTO_CONTROLE']} AND STATUS=1");
                                if($pre_qry){
                                    $preco = $pre_qry->fetch();  
                                }else{
                                    $preco = NULL;
                                }
                            ?>
                            <div class="col-sm-3 col-lg-3 col-md-6">
                                <div class="row">
                                    <?php echo isset($row['NOME_IMAGEM']) ? '<a href="produto.php?cod=' . $row['PRODUTO_CONTROLE'] . '"><img src="data/produtos/'.$row['NOME_IMAGEM'].'" width="120" height="120" alt="" style="width:150px;height:200px;padding:5px;"></a>' : '<a href="produto.php?cod=' . $row[0] . '"><img src="http://placehold.it/120x120" alt="" style="width:150px;height:200px;padding:5px;"></a>'; ?>
                                    <div class="caption">
                                        <h4><?php echo '<a href="produto.php?cod=' . $row['PRODUTO_CONTROLE'] . '">' . substr(utf8_encode($row['NOME']), 0, 20) . '</a>'; ?></h4>
                                        <div class="col-lg-6 pull-right">
                                        <?php echo isset($preco['PRECO']) ? '<h4 class="pull-right">R$'.$preco['PRECO'].'</h4>' : ''; ?>
                                        </div>
                                        <div class="col-lg-6 pull-left">
                                        <a href="" class="btn btn-default pull-left">Detalhes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        ?>

                    </div><!--/.end/panel-body-->
                </div>  <!--/.panel-default--> 

            </div><!--/.col-lg-9-->
        </div><!--/.row-->

    </div><!--/.container-->
    
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>