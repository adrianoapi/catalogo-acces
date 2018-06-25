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
          
          // Mensagem de confirmação
          if(@$_SESSION['confirm']){
              
              $html  = NULL;
              $html .= '<div class="alert alert-success">';
              $html .= ' <strong>' . $_SESSION['confirm'] . '</strong> com sucesso!';
              $html .= '</div>';
              
              echo $html;
              
              unset($_SESSION['confirm']);
              
          }
              
          ?>
          
                <table class="table table-striped table-hover">
                  <thead>
                      <tr class="row">
                          <th class="col-lg-2">#</th>
                          <th class="col-lg-8">NOME</th>
                          <th class="col-lg-2"><a href="produto_cadastrar.php" class="btn btn-primary pull-right"> Adicionar</a></th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php 
                $sql  = "SELECT * FROM PRODUTO";
                $result = $pdo->query($sql);
                while($row = $result->fetch()){
                ?>
                <tr class="row">
                    <td><input type="checkbox" name="id"></td>
                    <td><?php echo '<a href="./produto_alterar.php?cod='.$row['PRODUTO_CONTROLE'].'">'.$row['NOME'].'</a>'; ?></td>
                    <td>
                        <a href="<?php echo $row['PRODUTO_CONTROLE']; ?>" class="btn btn-secondary"><span class="fa fa-fw fa-picture-o"></span></a>
                        <a href="./produto_action.php?controle=<?php echo $row['PRODUTO_CONTROLE']; ?>&action=excluir" onclick="if (confirm('Confirmar exclusão do item: \n\n <?php echo $row['NOME']; ?>' )) { window.location.href = this.href } return false;"  class="btn btn-danger pull-right">Excluir</a>
                    </td>
                </tr>
                <?php
                }
                ?>
                  </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <a href="<?php echo $row['PRODUTO_CONTROLE']; ?>" class="btn btn-danger"><span class="fa fa-fw fa-trash"></span> Excluir</a>
                        </td>
                    </tr>
                </tfoot>
                </table>

            </div>

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>