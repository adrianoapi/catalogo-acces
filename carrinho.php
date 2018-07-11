<?php require_once 'includes/connect.php';   ?>
<?php require_once 'includes/functions.php'; ?>
<?php require_once 'includes/topo.php';      ?>

<?php

# Cria a sessão de carrinho
if(@!$_SESSION['carrinho']){
    $_SESSION['carrinho'] = array();
}

# Implementa o carrinho
if(count($_POST) > 0){
        
        if($_POST['action'] == "adicionar"){
            
            if(!isset($_POST['controle']) || !isset($_POST['oferta']) || $_POST['quantidade'] < 1){
                error("<h4>Produto, oferta e/ou quantidade indefinida!</h4><a href=\"./produto_lista.php\" class=\"btn btn-info\">Clique aqui para voltar!</a>");
                die();
            }
            
            # Verifica se selecionou a oferta correspondente ao produto
            if($_SESSION['oferta'][$_POST['oferta']]){

                # Checa se existe no array
                $chack = array();
                foreach($_SESSION['carrinho'] as $key => $value):

                    if($value['controle'] == $_POST['controle']){
                        $chack = array(
                            'key'        => $key,
                            'controle'   => $_POST['controle'  ],
                            'nome'       => $_POST['nome'      ],
                            'quantidade' => $_POST['quantidade']
                            );
                        break;
                    }
                endforeach;

                if(count($chack) > 0){
                    # Se existir o produto no carrinho ele atualiza
                    $controle = $chack['key'];
                    $_SESSION['carrinho'][$controle]['quantidade'  ] = $_SESSION['carrinho'][$controle]['quantidade'] + $chack['quantidade'];
                    $_SESSION['carrinho'][$controle]['oferta'      ] = $_POST['oferta'];
                    $_SESSION['carrinho'][$controle]['oferta_valor'] = $_SESSION['oferta'][$_POST['oferta']];

                }else{
                    # Se não, insere
                    array_push($_SESSION['carrinho'], array(
                    'controle'     => $_POST['controle'  ],
                    'imagem'       => $_POST['imagem'    ],
                    'nome'         => $_POST['nome'      ],
                    'quantidade'   => $_POST['quantidade'],
                    'oferta'       => $_POST['oferta'    ],
                    'oferta_valor' => $_SESSION['oferta'][$_POST['oferta']]
                    ));
                }

            }
        
        }

        if($_POST['action'] == "alterar"){
            
            foreach($_SESSION['carrinho'] as $key => $value):
                # Se a quantidade for > 0, atualiza
                if($_POST['quantidade'][$value['controle']] > 0){
                    $_SESSION['carrinho'][$key]['quantidade'] = $_POST['quantidade'][$value['controle']];
                }else{
                    # Se não, remove do carrinho
                    unset($_SESSION['carrinho'][$key]);
                }
            endforeach;

        }
        
}



if(isset($_GET['action'])){
    
    if($_GET['action'] == "remover"){
        
        foreach($_SESSION['carrinho'] as $key => $value):

            if($value['controle'] == $_GET['controle']){
                unset($_SESSION['carrinho'][$key]);
                break;
            }
            
        endforeach;
        
    }
    
}

?>

    <?php require_once 'includes/nav.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

        <div class="col-lg-9">
                
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Carrinho</h3>
                </div>
                <div class="panel-body">

                    <form method="POST" action="carrinho.php">
                        <input type="hidden" name="action" value="alterar">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="col-lg-2 col-sm-1 col-xs-1"></th>
                                    <th class="col-lg-6 col-sm-1 col-xs-1"></th>
                                    <th class="col-lg-2 col-sm-6 col-xs-6">QTD</th>
                                    <th class="col-lg-1">VALOR</th>
                                    <th class="col-lg-1">Total</th>
                                    <th class="col-lg-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $soma = 0;
                                foreach ($_SESSION['carrinho'] as $value):
                                $valor = $value['oferta_valor'];
                                ?>
                                <tr>
                                    <td><?php echo isset($value['imagem']) ? '<a href="./produto.php?cod='.$value['controle'].'"><img src="data/produtos/'.$value['imagem'].'" alt="" style="width:90px;height:120px;padding:5px;"></a>' : '<a href="./produto.php?cod='.$value['controle'].'"><img src="http://placehold.it/120x120" alt="" style="width:150px;height:200px;padding:5px;"></a>'; ?></td>
                                    <td><?php echo $value['nome']; ?></td>
                                    <td>
                                        <input type="number" name="quantidade[<?php echo $value['controle']; ?>]" class="form-control" value="<?php echo $value['quantidade']; ?>">
                                    </td>
                                    <td><?php echo number_format($valor, 2, ',', '.'); ?></td>
                                    <td><?php echo number_format($valor * $value['quantidade'], 2, ',', '.'); ?></td>
                                    <td>
                                        <!--<a href="?action=remover&controle=<?php echo $value['controle']; ?>" class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span></a>-->
                                        <a href="?action=remover&controle=<?php echo $value['controle']; ?>" class="btn btn-default pull-right"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                                <?php 
                                $soma += $valor * $value['quantidade'];
                                endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><h4>Total: <?php echo number_format($soma, 2, ',','.'); ?></h4></td>
                                    <td colspan="5">
                                        <?php 
                                        if(isset($_SESSION['AUTH'])){
                                        ?>
                                            <a href="pedido_endereco.php" class="btn btn-success pull-right">Continuar</a>
                                        <?php 
                                        }else{
                                        ?>
                                            <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target=".bs-example-modal-sm">Continuar</button>
                                        <?php 
                                        }
                                        ?>
                                        <button type="submit" class="btn btn-default pull-right" style="margin-right: 5px;">Atualizar</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                    
                    <!-- Small modal -->
                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Autenticação</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class="col-lg-8 col-md-offset-2">
                                    <div class="alert alert-danger" role="alert" id="msg-erro" style="display:none;">
                                        <strong>Erro</strong> <br/> Os dados informados estão incorretos!
                                    </div>
                                    <form id="form-login" method="POST" onsubmit="return false">
                                        <input type="hidden" name="action" value="autenticar">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Email</label>
                                          <input class="form-control" id="exampleInputEmail1" type="text" name="email" aria-describedby="emailHelp" placeholder="usuário" required="true">
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputPassword1">Senha</label>
                                          <input class="form-control" id="exampleInputPassword1" type="password" name="senha" placeholder="senha" required="true">
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-block" value="Autenticar">
                                  </form>
                                    <hr>
                                    <p><a href="./cadastro.php">Não possui cadastro?</a></p>
                                    <p><a href="#">Esqueceu sua senha?</a></p>
                                </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div><!-- /.modal-content -->
                      </div>
                    </div><!-- /.modal -->

                    </div<!--end/panel-body-->
                </div><!--end/panel-->

            </div>

        </div><!--./col-lg-9-->
     
    
    <?php require_once 'includes/fim.php';     ?>
    
    </div>

</div><!-- /.container -->

<script>
    
    $("#form-login").submit(function(event){
        
        document.getElementById("msg-erro").style.display = "none";
        event.preventDefault();
        
        var send = $.post("login_action.php", $(this).serialize(), function(data){
            
            if(data > 0){
                window.location = 'pedido_endereco.php';
            }else{
                document.getElementById("msg-erro").style.display = "block";
            }

        }).done(function(){
           //alert('done: success'); 
        }).fail(function(){
            alert('Falha na conexão com o servidor. \n Verifique seu sinal de internet.');
        }).always(function(){
            //alert('finishid');
        });
        
    });

    
</script>
    
</body>
</html>