<?php

require_once '../includes/connect.php';
require_once '../includes/functions.php'; 
require_once 'includes/topo.php';   

$sql_prod = "SELECT COUNT(*) FROM PRODUTO   WHERE STATUS = 1";
$rst_prod = $pdo->query($sql_prod);
$row_prod = $rst_prod->fetch();

$sql_grup = "SELECT COUNT(*) FROM GRUPO     WHERE STATUS = 1";
$rst_grup = $pdo->query($sql_grup);
$row_grup = $rst_grup->fetch();

$sql_sub  = "SELECT COUNT(*) FROM SUBGRUPO  WHERE STATUS = 1";
$rst_sub  = $pdo->query($sql_sub);
$row_sub  = $rst_sub->fetch();

$sql_pes  = "SELECT COUNT(*) FROM PESSOA    WHERE STATUS = 1";
$rst_pes  = $pdo->query($sql_pes);
$row_pes  = $rst_pes->fetch();

$sql_ped  = "SELECT COUNT(*) FROM ECOMMERCE WHERE STATUS = 1";
$rst_ped  = $pdo->query($sql_ped);
$row_ped  = $rst_ped->fetch();

?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">
                
                <h3>Dashboard</h3>
                
                <div class="row">
                    
                    <div class="col-md-6">
                        
                        <div class="panel panel-default">
                           <div class="panel-heading">
                              <h3 class="panel-title">Pedidos</h3>
                           </div>
                            <div class="panel-body"> Quantidade: <strong><?php print($row_ped[0]); ?></strong> </div>
                        </div>

                    </div>
                    
                    <div class="col-md-6">

                        <div class="panel panel-default">
                           <div class="panel-heading">
                              <h3 class="panel-title">Produtos</h3>
                           </div>
                            <div class="panel-body"> Quantidade: <strong><?php print($row_prod[0]); ?></strong> </div>
                        </div>

                    </div>
                    
                    <div class="col-md-6">

                        <div class="panel panel-default">
                           <div class="panel-heading">
                              <h3 class="panel-title">Cadastros</h3>
                           </div>
                            <div class="panel-body"> Quantidade: <strong><?php print($row_pes[0]); ?></strong> </div>
                        </div>

                    </div>
                    
                    <div class="col-md-6">

                        <div class="panel panel-default">
                           <div class="panel-heading">
                              <h3 class="panel-title">Grupos & Subgrupos</h3>
                           </div>
                            <div class="panel-body"> Quantidade: <strong><?php echo $row_grup[0] + $row_sub[0]; ?></strong> </div>
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