<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>
<?php
    if(@isset($_GET['cod'])){

        $controle = $_GET['cod'];

        $sql  = "SELECT TOP 1 * FROM PRODUTO WHERE PRODUTO_CONTROLE = $controle";
        $result = $pdo->query($sql);
        $row = $result->fetch();

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

                <div class="card mt-4">
                    <div class="card-body">
                      <h3 class="card-title"><?php echo $row['NOME']; ?></h3>
                      <h4>$24.99</h4>
                      <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente dicta fugit fugiat hic aliquam itaque facere, soluta. Totam id dolores, sint aperiam sequi pariatur praesentium animi perspiciatis molestias iure, ducimus!</p>
                      <hr>

                    </div>
                </div>
                <form method="POST" action="carrinho.php">
                    <input type="hidden" name="action" value="adicionar">
                    <input type="hidden" name="controle" value="<?php echo $row['PRODUTO_CONTROLE']; ?>">
                    <input type="hidden" name="nome" value="<?php echo $row['NOME']; ?>">
                    <div class="col-lg-2"><input type="number" name="quantidade" value="1" class="form-control" required></div>
                    <div class="col-lg-4"><button type="submit" class="btn btn-success">Adicionar ao carrinho</button></div>
                </form>
                

            </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>