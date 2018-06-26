<?php require_once '../includes/connect.php'; ?>
<?php require_once 'includes/topo.php';   

$sql_prod  = "SELECT COUNT(*) FROM PRODUTO WHERE STATUS = 1";
$rst_prod = $pdo->query($sql_prod);
$row_prod = $rst_prod->fetch();
?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">
                
                <div class="row">
                    
                    <div class="col-md-6">
                        
                        <div class="panel panel-default">
                           <div class="panel-heading">
                              <h3 class="panel-title">Pedidos</h3>
                           </div>
                           <div class="panel-body"> Registros: Y </div>
                        </div>

                    </div>
                    
                    <div class="col-md-6">

                        <div class="panel panel-default">
                           <div class="panel-heading">
                              <h3 class="panel-title">Produtos</h3>
                           </div>
                           <div class="panel-body"> Registros: <?php print($row_prod[0]); ?> </div>
                        </div>

                    </div>
                    
                    <div class="col-md-6">

                        <div class="panel panel-default">
                           <div class="panel-heading">
                              <h3 class="panel-title">Cadastros</h3>
                           </div>
                           <div class="panel-body"> Registros: X </div>
                        </div>

                    </div>
                    
                    <div class="col-md-6">

                        <div class="panel panel-default">
                           <div class="panel-heading">
                              <h3 class="panel-title">Catgorias</h3>
                           </div>
                           <div class="panel-body"> Registros: X </div>
                        </div>

                    </div>
                    
                </div>
                
            </div>
            <!--./col-md-9"-->
            
        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>