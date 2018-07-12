<?php

require_once '../includes/connect.php';
require_once '../includes/functions.php'; 
require_once 'includes/topo.php';   
?>

<body>

    <!-- Page Content -->
    <div class="container">

        <div class="row">


            <div class="col-md-12">

                <?php
                
                error("<h4>Área restrita</h4>Você tentou acessar uma área que requer autenticação!<br/><a href=\"login.php\">Clique aqui</a> para autenticar-se.", 8, 2);
               
                ?>

            </div>

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>