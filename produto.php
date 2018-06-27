<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>
<?php
    if(@isset($_GET['cod'])){

        $controle = $_GET['cod'];

        $sql  = " SELECT TOP 1 p.*, i.* FROM PRODUTO AS p ".
                " LEFT JOIN PRODUTOIMAGEM AS i ON (i.PRODUTO_CONTROLE = p.PRODUTO_CONTROLE AND i.STATUS=1) ".
                " WHERE p.PRODUTO_CONTROLE = $controle AND p.STATUS=1";
        $result = $pdo->query($sql);
        $row = $result->fetch();
        
        $pre_qry = $pdo->query("SELECT * FROM PRODUTOPRECO WHERE PRODUTO_CONTROLE = {$row['PRODUTO_CONTROLE']} AND STATUS=1");
        

    }else{
        echo utf8_encode("Erro: Referência do produto não foi encontrada!");
    }
?>
<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-lg-9">
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo utf8_encode($row['NOME']); ?></h3>
                    </div>
                    <div class="panel-body">
                        
                        <form method="POST" action="carrinho.php">
                            <div class="card mt-4">

                                <div class="card-body">
                                    <?php echo isset($row['NOME_IMAGEM']) ? '<img src="data/produtos/'.$row['NOME_IMAGEM'].'" width="120" height="120" alt="" style="width:150px;height:200px;padding:5px;">' : '<img src="http://placehold.it/120x120" alt="" style="width:150px;height:200px;padding:5px;">'; ?>
                                  <h3 class="card-title"><?php echo utf8_encode($row['NOME']); ?></h3>
                                  <p class="card-text"><?php echo utf8_encode($row['DESCRICAO_LOJA']); ?></p>
                                  <?php
                                  $_SESSION['oferta'] = array();
                                  if($pre_qry){
                                      echo '<ul class="list-group">';
                                        while($val = $pre_qry->fetch()){
                                            $_SESSION['oferta'][$val['PRODUTOPRECO_CONTROLE']] = $val['PRECO'];
                                            echo '<li class="list-group-item"><label><input type="radio" name="oferta" value="'.$val['PRODUTOPRECO_CONTROLE'].'" checked>R$'.number_format($val['PRECO'],2,',','.').'</label></li>';
                                        }
                                      echo '</ul>';

                                    }
                                  ?>
                                  <hr>

                                </div>
                            </div>

                                <input type="hidden" name="action" value="adicionar">
                                <input type="hidden" name="controle" value="<?php echo $row['PRODUTO_CONTROLE']; ?>">
                                <input type="hidden" name="imagem" value="<?php echo $row['NOME_IMAGEM']; ?>">
                                <input type="hidden" name="nome" value="<?php echo utf8_encode($row['NOME']); ?>">
                                <?php if(count($_SESSION['oferta']) > 0) {?>
                                <div class="col-lg-2"><input type="number" name="quantidade" value="1" class="form-control" required></div>
                                <div class="col-lg-4"><button type="submit" class="btn btn-success">Adicionar ao carrinho</button></div>
                                <?php }?>
                            </form>
                        
                    </div>
                </div>
                
                
                

            </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>