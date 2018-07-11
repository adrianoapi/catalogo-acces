<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Catalogo</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./">Catalogo</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="./carrinho.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>&nbsp;Carrinho</a>
                    </li>
                    <?php if(isset($_SESSION['AUTH'])){ ?>
                        <li>
                            <a href="./pedido_listagem.php">Histórico de Pedidos</a>
                        </li>
                        <li>
                            <a href="./cadastro_sair.php">Sair</a>
                        </li>
                    <?php }else{ ?>
                    <li>
                        <a href="./cadastro.php">Cadastre-se</a>
                    </li>
                    <li>
                        <a href="./login.php">Autentique-se</a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="./admin">Admin</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>