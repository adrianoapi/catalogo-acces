<?php require_once '../includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">

                <form method="POST" action="produto_action.php">
                    <input type="hidden" name="action" value="cadastrar">

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-12">
                          <label for="exampleInputName">NOME</label>
                          <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-12">
                          <label for="descricao">DESCRIÇÃO</label>
                          <textarea class="form-control" rows="5" id="descricao" name="descricao"></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                          <a class="btn btn-default" href="../admin/produto.php">Cancelar</a>
                        </div>
                      </div>
                    </div>

                </form>


        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>