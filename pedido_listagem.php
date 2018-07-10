<?php require_once 'includes/connect.php';   ?>
<?php require_once 'includes/functions.php'; ?>
<?php require_once 'includes/topo.php';      ?>
<?php require_once 'includes/security.php';  ?>
<?php 

    $sql = " SELECT * FROM ECOMMERCE " . 
           " WHERE PESSOA_CONTROLE = {$_SESSION['AUTH']['controle']} AND STATUS = 1 " .
           " ORDER BY ECOMMERCE_CONTROLE DESC";
    $qry = $pdo->query($sql);

?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            
            <div class="col-lg-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Pedidos</h3>
                    </div>
                    <div class="panel-body">
                        
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>VALOR</th>
                                    <th>DATA</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

                            while($ped = $qry->fetch()){

                                echo null
                                    ."<tr>"
                                    . "<td>".$ped['ECOMMERCE_CONTROLE']."</td>"
                                    . "<td>R$".number_format($ped['VALORNF'], 2, ',', '.')."</td>"
                                    . "<td>".datetime2Br($ped['EMISSAO'])."</td>"
                                    . "<td><a href=\"pedido_resumo.php?cod=".$ped['ECOMMERCE_CONTROLE']."\" class=\"btn btn-default pull-right\">+Detalhes</a></td>"
                                    . "</tr>";

                            }

                            ?>
                            </tbody>
                        </table>
                        
                    </div><!--end/panel-body-->
                </div><!--end/panel-->

            </div><!--./col-lg-8-->
     

        </div><!-- /.row -->

    </div><!-- /.container -->
    
    
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>