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
        
        # Checa se existe no array
        $chack = array();
        foreach($_SESSION['carrinho'] as $key => $value):

            if($value['controle'] == $_POST['controle']){
                $chack = array(
                    'key'        => $key,
                    'controle'   => $_POST['controle'  ],
                    'nome'       => utf8_encode($_POST['nome'      ]),
                    'quantidade' => $_POST['quantidade']
                    );
                break;
            }
        endforeach;

        if(count($chack) > 0){
            # Se existir o produto no carrinho ele atualiza
            $controle = $chack['key'];
            $_SESSION['carrinho'][$controle]['quantidade'] = $_SESSION['carrinho'][$controle]['quantidade'] + $chack['quantidade'];

        }else{
            # Senão, ele insere
            array_push($_SESSION['carrinho'], array(
            'controle'   => $_POST['controle'],
            'nome'       => utf8_decode($_POST['nome']),
            'quantidade' => $_POST['quantidade']
            ));
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
                <form method="POST" action="carrinho.php">
                    <input type="hidden" name="action" value="alterar">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="col-lg-8">PRODUTO</th>
                                <th class="col-lg-1">QTD</th>
                                <th class="col-lg-1">VALOR</th>
                                <th class="col-lg-1">Total</th>
                                <th class="col-lg-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $soma = 0;
                            foreach ($_SESSION['carrinho'] as $value):
                            $valor = rand(10,50);
                            ?>
                            <tr>
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
                                <td colspan="4">
                                    <button type="submit" class="btn btn-success pull-right">Finalizar</button>
                                    <button type="submit" class="btn btn-default pull-right" style="margin-right: 5px;">Atualizar</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>