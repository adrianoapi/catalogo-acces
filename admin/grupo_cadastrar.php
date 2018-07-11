<?php require_once '../includes/connect.php';   ?>
<?php require_once '../includes/functions.php'; ?>
<?php require_once 'includes/topo.php';
$page = "grupo.php";
?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">
                
                <div class="panel panel-default">
                    <div class="panel-heading">Grupo Cadastrar</div>
                    <div class="panel-body">

                <form class="form-horizontal form-bordered" method="POST" action="grupo_action.php">
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
                            <button type="submit" class="btn btn-success pull-right">Salvar</button>
                          <a class="btn btn-default pull-left" href="../admin/grupo.php">Cancelar</a>
                        </div>
                      </div>
                    </div>

                </form>
                        
                    </div><!--./panel-body-->
            </div><!--./panel-default-->


        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>