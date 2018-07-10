<?php require_once 'includes/connect.php';   ?>
<?php require_once 'includes/functions.php'; ?>
<?php require_once 'includes/topo.php';      ?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="data/banner/banner1.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="data/banner/banner2.jpg" alt="">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <?php 
//                    $sql  = " SELECT TOP 6 p.*, i.*, pr.* FROM (PRODUTO AS p ".
//                            " LEFT JOIN PRODUTOIMAGEM AS i ON (i.PRODUTO_CONTROLE = p.PRODUTO_CONTROLE AND i.STATUS=1)) ".
//                            " LEFT JOIN PRODUTOPRECO AS pr ON (pr.PRODUTO_CONTROLE = p.PRODUTO_CONTROLE AND pr.STATUS=1) ".
//                            " WHERE p.STATUS = 1".
//                            " ORDER BY Rnd(-(100000* p.PRODUTO_CONTROLE )*Time())";
                    $sql  = " SELECT TOP 6 p.*, i.* FROM PRODUTO AS p ".
                            " LEFT JOIN PRODUTOIMAGEM AS i ON (i.PRODUTO_CONTROLE = p.PRODUTO_CONTROLE AND i.STATUS=1) ".
                            " WHERE p.STATUS = 1".
                            " ORDER BY Rnd(-(100000* p.PRODUTO_CONTROLE )*Time())";
                    $result = $pdo->query($sql);
                    while($row = $result->fetch()){
                        
                        $pre_qry = $pdo->query("SELECT TOP 1 * FROM PRODUTOPRECO WHERE PRODUTO_CONTROLE = {$row['PRODUTO_CONTROLE']} AND STATUS=1");
                        if($pre_qry){
                            $preco = $pre_qry->fetch();  
                        }else{
                            $preco = NULL;
                        }
                    ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <?php echo isset($row['NOME_IMAGEM']) ? '<a href="produto.php?cod=' . $row['PRODUTO_CONTROLE'] . '"><img src="data/produtos/'.$row['NOME_IMAGEM'].'" width="120" height="120" alt="" style="width:150px;height:200px;padding:5px;"></a>' : '<a href="produto.php?cod=' . $row[0] . '"><img src="http://placehold.it/120x120" alt="" style="width:150px;height:200px;padding:5px;"></a>'; ?>
                            <div class="caption">
                                <?php echo isset($preco['PRECO']) ? '<h4 class="pull-right">R$'.$preco['PRECO'].'</h4>' : ''; ?>
                                <h4><?php echo '<a href="produto.php?cod=' . $row['PRODUTO_CONTROLE'] . '">' . substr(utf8_encode($row['NOME']), 0, 20) . '</a>'; ?></h4>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>

                </div>

            </div>

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>