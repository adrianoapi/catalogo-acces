<?php require_once '../includes/connect.php';   ?>
<?php require_once '../includes/functions.php'; ?>
<?php require_once 'includes/topo.php'; 
$page = "pessoa.php";

$controle = addslashes($_GET['cod']);

$sql_pes = "SELECT TOP 1 * FROM PESSOA WHERE PESSOA_CONTROLE = {$controle}";
$qry_pes = $pdo->query($sql_pes);
$row_pes = $qry_pes->fetch();

$sql_end = "SELECT TOP 1 * FROM PESSOA_ENDERECO WHERE PESSOA_CONTROLE = {$controle}";
$qry_end = $pdo->query($sql_end);
$rst_end = $qry_end->fetch();

?>



<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">

                <div class="panel panel-default">
                  <div class="panel-heading">Endereço: <?php echo $row_pes['NOME']; ?></div>
                  <div class="panel-body">
                    
                      <?php

                        // Parâmetro de busca
                        if(@$_GET['pesquisa']){
                            $where_and = "AND NOME LIKE '%".utf8_decode($_GET['pesquisa'])."%'";
                            $pesquisa  = $_GET['pesquisa'];
                        }else{
                            $where_and = NULL;
                            $pesquisa  = NULL;
                        }

                        // Mensagem de confirmação
                        if(@$_SESSION['confirm']){

                            $html  = NULL;
                            $html .= '<div class="alert alert-success alert-dismissible" role="alert">';
                            $html .= ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                            $html .= ' <strong>' . $_SESSION['confirm'] . '</strong> com sucesso!';
                            $html .= '</div>';

                            echo $html;

                            unset($_SESSION['confirm']);

                        }

                        ?>

                        
                      <form class="form-horizontal form-bordered" method="POST" action="pessoa_action.php" onsubmit="return validaconfirmacao.phpcao()">
                            <input type="hidden" name="action" value="endereco">
                            <input type="hidden" name="controle" value="<?php echo $rst_end['PESSOA_ENDERECO_CONTROLE'];?>">
                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-2">
                                  <label for="exampleInputName">cep</label>
                                  <input class="form-control" id="cep" name="cep" value="<?php echo $rst_end['CEP'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="cep" onKeyDown="limitarCaracteres(this,8);" onKeyUp="limitarCaracteres(this,8);" required>
                                </div>
                                <div class="col-md-6">
                                  <label for="exampleInputName">Logradouro</label>
                                  <input class="form-control" id="logradouro" name="logradouro" value="<?php echo $rst_end['LOGRADOURO'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-2">
                                  <label for="exampleInputName">número</label>
                                  <input class="form-control" id="numero" name="numero" value="<?php echo $rst_end['NUMERO'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-2">
                                  <label for="exampleInputName">Complemento</label>
                                  <input class="form-control" id="complemento" name="complemento" value="<?php echo $rst_end['COMPLEMENTO'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="comp">
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                  <label for="exampleInputName">Bairro</label>
                                  <input class="form-control" id="bairro" name="bairro" type="text" value="<?php echo $rst_end['BAIRRO'];?>" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">Cidade</label>
                                  <input class="form-control" id="municipio" name="municipio" value="<?php echo $rst_end['MUNICIPIO'];?>" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">Estado</label>
                                  <input class="form-control" id="uf" name="uf" type="text" value="<?php echo $rst_end['UF'];?>" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success pull-right"> Salvar</button>
                                    <a href="pessoa.php" class="btn btn-default pull-left"> Cancelar</a>
                                </div>
                              </div>
                            </div>

                        </form>


                      
                  </div><!--./panel-body-->
                </div><!--./panel-default-->

            </div><!--./col-md-9-->

        </div><!--./row-->

    </div><!--./container-->
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
    <script>
        
        /**
         * Autocompleta os campos de endereço
         */
        $('#cep').blur(function(){
            
            var cep = document.getElementById('cep').value;
                cep = cep.replace(/[^\d]\+/g,'');
                
            $.getJSON("http://cep.republicavirtual.com.br/web_cep.php?cep=" + cep + "&formato=json", function(data){
                
                if(data['resultado']){
                    
                    document.getElementById("logradouro" ).value = data['logradouro'];
                    document.getElementById("bairro"     ).value = data['bairro'    ];
                    document.getElementById("municipio"  ).value = data['cidade'    ];
                    document.getElementById("uf"         ).value = data['uf'        ];
                    document.getElementById("numero"     ).value = '';
                    document.getElementById("complemento").value = '';
                    document.getElementById("numero"     ).focus();
                    
                }
                
            });
            
        });
        
        function limitarCaracteres(objeto, limite){
            if (objeto.value.length > limite) {
                objeto.value = objeto.value.substring(0, limite);
            }
        }
        
    </script>
    
</body>

</html>