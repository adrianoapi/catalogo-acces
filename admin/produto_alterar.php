<?php require_once '../includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">

                 <?php
          
          # Checa se passou o parâmetro
          if(@isset($_GET['cod'])){
              
              # Checa o parâmetro recebido
              if(is_numeric($_GET['cod'])){
                  
                $controle = $_GET['cod'];

                $sql  = "SELECT TOP 1 * FROM PRODUTO WHERE PRODUTO_CONTROLE = $controle";
                $result = $pdo->query($sql);
                $row = $result->fetch();

                $controle  = $row['PRODUTO_CONTROLE'];
                $nome      = utf8_encode($row['NOME']);
                $descricao = utf8_encode($row['DESCRICAO_LOJA']);
                
              }else{
                  
                  # Se o parâmetro informado não for válido
                  die("Erro: O parâmetro informado é inválido!");
              }
              
            }else{
                
                # Se não passou o parâmetro
                die("Erro: Referência do produto não foi encontrada!");
                
            }
          
          ?>
        <form method="POST" action="produto_action.php">
            <input type="hidden" name="action" value="alterar">
            <input type="hidden" name="controle" value="<?php echo $controle; ?>">
            
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-2">
                  <label for="exampleInputLastName">CÓDIGO</label>
                  <input class="form-control" type="text" value="<?php echo $controle; ?>" disabled="true">
                </div>
                <div class="col-md-10">
                  <label for="exampleInputName">NOME</label>
                  <input class="form-control" id="nome" name="nome" type="text" value="<?php echo $nome; ?>" aria-describedby="nameHelp" placeholder="nome" required>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <label for="descricao">DESCRIÇÃO</label>
                  <textarea class="form-control" rows="5" id="descricao" name="descricao"><?php echo $descricao; ?></textarea>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="form-row">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                  <a class="btn btn-default" href="../admin/produto.php">Cancelar</a>
                </div>
              </div>
            </div>

        </form>


        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>