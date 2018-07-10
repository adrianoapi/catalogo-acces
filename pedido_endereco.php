<?php require_once 'includes/connect.php';   ?>
<?php require_once 'includes/topo.php';      ?>
<?php require_once 'includes/security.php';  ?>
<?php 

    if(isset($_POST['action'])){
        
        if($_POST['action'] == "update"){
            
            $cep               = $_POST['cep'              ];
            $logradouro        = $_POST['logradouro'       ];
            $numero            = $_POST['numero'           ];
            $complemento       = $_POST['complemento'      ];
            $bairro            = $_POST['bairro'           ];
            $municipio         = $_POST['municipio'        ];
            $uf                = $_POST['uf'               ];
            
            # Atualiza os daso do endereço
            try{
                
                $sql = " UPDATE PESSOA_ENDERECO SET " .
                       " CEP         = '{$cep}'," .
                       " LOGRADOURO  = '{$logradouro}'," .
                       " NUMERO      = '{$numero}'," .
                       " COMPLEMENTO = '{$complemento}'," .
                       " BAIRRO      = '{$bairro}'," .
                       " MUNICIPIO   = '{$municipio}'," .
                       " UF          = '{$uf}'" .
                       " WHERE PESSOA_CONTROLE = {$_SESSION['AUTH']['controle']}";
                if($pdo->exec($sql)){
                    header("Location: pedido_confirmacao.php");
                }
                        
            } catch (Exception $Exception) {
                throw new MyDatabaseException($Exception->getMessage(), (int)$Exception->getCode());
            }
        }
        
    }
    
    $sql = "SELECT TOP 1 * FROM PESSOA_ENDERECO WHERE PESSOA_CONTROLE = {$_SESSION['AUTH']['controle']}";
    $qry = $pdo->query($sql);
    $rst = $qry->fetch();

?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            
            <div class="col-lg-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Confirmação de endereço</h3>
                    </div>
                    <div class="panel-body">
                        
                        
                        <form class="form-horizontal form-bordered" method="POST" action="pedido_endereco.php" onsubmit="return validaconfirmacao.phpcao()">
                            <input type="hidden" name="action" value="update">
                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-2">
                                  <label for="exampleInputName">cep</label>
                                  <input class="form-control" id="cep" name="cep" value="<?php echo $rst['CEP'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="cep" onKeyDown="limitarCaracteres(this,8);" onKeyUp="limitarCaracteres(this,8);" required>
                                </div>
                                <div class="col-md-6">
                                  <label for="exampleInputName">Logradouro</label>
                                  <input class="form-control" id="logradouro" name="logradouro" value="<?php echo $rst['LOGRADOURO'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-2">
                                  <label for="exampleInputName">número</label>
                                  <input class="form-control" id="numero" name="numero" value="<?php echo $rst['NUMERO'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-2">
                                  <label for="exampleInputName">Complemento</label>
                                  <input class="form-control" id="complemento" name="complemento" value="<?php echo $rst['COMPLEMENTO'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                  <label for="exampleInputName">Bairro</label>
                                  <input class="form-control" id="bairro" name="bairro" type="text" value="<?php echo $rst['BAIRRO'];?>" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">Cidade</label>
                                  <input class="form-control" id="municipio" name="municipio" value="<?php echo $rst['MUNICIPIO'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">Estado</label>
                                  <input class="form-control" id="uf" name="uf" type="text" value="<?php echo $rst['UF'];?>" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success pull-right"> Continuar</button>
                                    <a href="carrinho.php" class="btn btn-default pull-left"><span class="glyphicon glyphicon-chevron-left pull-left" aria-hidden="true"></span> Voltar</a>
                                </div>
                              </div>
                            </div>

                        </form>


                        </div<!--end/panel-body-->
                    </div><!--end/panel-->

                </div>

            </div><!--./col-lg-9-->
     

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>