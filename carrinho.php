<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>

<?php

# Cria a sessão de carrinho
if(@!$_SESSION['carrinho']){
    $_SESSION['carrinho'] = array();
}

# Implementa o carrinho
if(count($_POST) > 0){
    
    
        
        if($_POST['action'] == "adicionar"){
            
            if(!isset($_POST['controle']) || !isset($_POST['oferta']) || $_POST['quantidade'] < 1){
                die("Produto, oferta e/ou quantidade indefinida! <a href=\"./produto_lista.php\"><br>Clique aqui para voltar!</>");
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
                    # Senão, ele insere
                    array_push($_SESSION['carrinho'], array(
                    'controle'     => $_POST['controle'],
                    'imagem'       => $_POST['imagem'],
                    'nome'         => $_POST['nome'],
                    'quantidade'   => $_POST['quantidade'],
                    'oferta'       => $_POST['oferta'],
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
                    # Senão remove do carrinho
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

<body>

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
                                    <td>Total: <?php echo number_format($soma, 2, ',','.'); ?></td>
                                    <td colspan="5">
                                        <button type="submit" class="btn btn-success pull-right">Finalizar</button>
                                        <button type="submit" class="btn btn-default pull-right" style="margin-right: 5px;">Atualizar</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>

                </div>
            </div>
                
        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>