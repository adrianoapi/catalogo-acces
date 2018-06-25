<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>

<?php

# Cria a sessão de carrinho
if(@!$_SESSION['carrinho']){
    $_SESSION['carrinho'] = array();
}

# Implementa o carrinho
if(count($_POST) > 0){
    
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
        $_SESSION['carrinho'][$controle]['quantidade'] = $_SESSION['carrinho'][$controle]['quantidade'] + $chack['quantidade'];
        
    }else{
        # Senão, ele insere
        array_push($_SESSION['carrinho'], array(
        'controle'   => $_POST['controle'  ],
        'nome'       => $_POST['nome'      ],
        'quantidade' => $_POST['quantidade']
        ));
    }
    
    
    
}

?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-lg-9">

                <table class="table">
                    <thead>
                        <tr>
                            <th>PRODUTO</th>
                            <th>QTD</th>
                            <th>VALOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['carrinho'] as $value): ?>
                        <tr>
                            <td><?php echo $value['nome']; ?></td>
                            <td><?php echo $value['quantidade']; ?></td>
                            <td><?php echo rand(48,250); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>