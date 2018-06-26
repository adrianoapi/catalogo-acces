<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>

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
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="http://placehold.it/800x300" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="http://placehold.it/800x300" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="http://placehold.it/800x300" alt="">
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
                    $sql  = "SELECT TOP 6 * FROM PRODUTO WHERE STATUS = 1 ORDER BY Rnd(-(100000*PRODUTO_CONTROLE)*Time())";
                    $result = $pdo->query($sql);
                    while($row = $result->fetch()){
                    ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="http://placehold.it/320x150" alt="">
                            <div class="caption">
                                <h4 class="pull-right">$64.99</h4>
                                <h4><?php echo '<a href="produto.php?cod=' . $row['PRODUTO_CONTROLE'] . '">' . substr($row['NOME'], 0, 20) . '</a>'; ?></h4>
                                <p><?php echo $row['DESCRICAO_LOJA']; ?></p>
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