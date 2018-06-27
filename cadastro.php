<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-lg-9">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cadastro</h3>
                    </div>
                    <div class="panel-body">

                        <form class="form-horizontal form-bordered" method="POST" action="produto_action.php">
                            <input type="hidden" name="action" value="cadastrar">

                            <h4 class="card-title">Dados Pessoais</h4><hr>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-8">
                                  <label for="exampleInputName">NOME</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">CPF</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>

                            <p>&nbsp;</p>
                            <h4 class="card-title">Dados Endereço</h4><hr>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-2">
                                  <label for="exampleInputName">cep</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-6">
                                  <label for="exampleInputName">Logradouro</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-2">
                                  <label for="exampleInputName">número</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-2">
                                  <label for="exampleInputName">Complemento</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                  <label for="exampleInputName">Bairro</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">Cidade</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">Estado</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>

                            <p>&nbsp;</p>
                            <h4 class="card-title">Dados Contato</h4><hr>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                  <label for="exampleInputName">Telefone</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">e-mail</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">e-mail confirmação</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>

                            <p>&nbsp;</p>
                            <h4 class="card-title">Dados Acesso</h4><hr>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                  <label for="exampleInputName">senha</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">senha confirmação</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                              </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>