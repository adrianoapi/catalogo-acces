<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">


            <div class="col-md-12">

                
                <?php
                
                error("<h4>Área restrita</h4>Você tentou acessar uma área que requer autenticação!", 8, 2);
                
                ?>

            </div>

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>