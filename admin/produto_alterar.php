<?php require_once '../includes/connect.php'; ?>
<?php require_once 'includes/topo.php'; 
$page = "produto.php";
?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">
                
                <div class="panel panel-default">
                    <div class="panel-heading">Produto Alterar</div>
                    <div class="panel-body">
                        
                        <?php
          
                        # Checa se passou o parâmetro
                        if(@isset($_GET['cod'])){

                            # Checa o parâmetro recebido
                            if(is_numeric($_GET['cod'])){

                              $controle = $_GET['cod'];

                              $sql    = "SELECT TOP 1 * FROM PRODUTO WHERE PRODUTO_CONTROLE = $controle";
                              $result = $pdo->query($sql);
                              $row    = $result->fetch();

                              $controle  = $row['PRODUTO_CONTROLE'];
                              $nome      = utf8_encode($row['NOME']);
                              $descricao = utf8_encode($row['DESCRICAO_LOJA']);

                              # Select de preco
                              $sql_pp = "SELECT * FROM PRODUTOPRECO WHERE PRODUTO_CONTROLE = $controle AND STATUS = 1";
                              $rst_pp = $pdo->query($sql_pp);
                              
                              # Select grupo
                              $sql_grp = " SELECT s.NOME AS subgrupo_nome, g.NOME AS grupo_nome FROM SUBGRUPO AS s " .
                                         " INNER JOIN GRUPO AS g ON (g.GRUPO_CONTROLE = s.GRUPO_CONTROLE AND g.STATUS = 1)".
                                         " WHERE s.STATUS = 1 " .
                                         " ORDER BY g.NOME, s.NOME ASC";
                              $rst_grp = $pdo->query($sql_grp);

                            }else{

                                # Se o parâmetro informado não for válido
                                die("Erro: O parâmetro informado é inválido!");
                            }

                          }else{

                              # Se não passou o parâmetro
                              die("Erro: Referência do produto não foi encontrada!");

                          }

                        ?>
                          <form class="form-horizontal form-bordered" method="POST" action="produto_action.php">
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

                          <div id="group_fileds">
                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-11">
                                  <label for="descricao">GRUPO</label>
                                  <select name="" class="form-control">
                                     <option value="">Selecionar grupo</option>
                                  <?php 
                                  $count = 0;
                                  while ($row = $rst_grp->fetch()){
                                  ?>
                                     <option value=""><?php echo $row['grupo_nome'] . ' \ ' . $row['subgrupo_nome']; ?></option>
                                  <?php 
                                  }
                                  ?>
                                  </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="descricao"><br></label>
                                    <button id="<?php echo $count; ?>" onclick="del_fields(this.id);" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                                </div>
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

                          <div id="room_fileds">
                          <?php 
                          $count = 0;
                          while ($row = $rst_pp->fetch()){
                              $count = $count <= 0 ? $row['PRODUTOPRECO_CONTROLE'] : $count;
                          ?>
                              <div class="form-group" id="elemento-<?php echo $count; ?>">
                                  <div class="form-row">
                                      <div class="col-md-3">
                                          <label for="descricao">PREÇO</label>
                                          <input type="number" name="oferta[<?php echo $count; ?>][preco]" class="form-control" value="<?php echo $row['PRECO']; ?>">
                                      </div>
                                      <div class="col-md-4">
                                          <label for="descricao">INICIO</label>
                                          <input type="datetime" name="oferta[<?php echo $count; ?>][dt_inicio]" class="form-control" value="" placeholder="__/__/__">
                                      </div>
                                      <div class="col-md-4">
                                          <label for="descricao">FIM</label>
                                          <input type="datetime" name="oferta[<?php echo $count; ?>][dt_fim]" class="form-control" value="" placeholder="__/__/__">
                                      </div>
                                      <div class="col-md-1">
                                          <label for="descricao"><br></label>
                                          <button id="<?php echo $count; ?>" onclick="del_fields(this.id);" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                                      </div>
                                  </div>
                              </div>
                          <?php ++$count;}?>
                          </div>
                          <div class="form-group">
                            <div class="form-row">
                              <div class="col-md-4">
                                <a class="btn btn-default" href="javascript:void(0)" onclick="add_fields();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
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
                        
                    </div><!--./panel-body-->
                </div><!--./panel-default-->        
                 


        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    <script>
        var room = <?php echo $count; ?>;
        function add_fields() {
            room++;
            var objTo = document.getElementById('room_fileds')
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "form-group");
            divtest.setAttribute("id", "elemento-" + room);
            divtest.innerHTML = '<div class="form-row">' +
                    '    <div class="col-md-3">' +
                    '        <label for="descricao">PREÇO</label>' +
                    '        <input type="number" name="oferta['+ room +'][preco]" class="form-control" value="">' +
                    '    </div>' +
                    '    <div class="col-md-4">' +
                    '        <label for="descricao">INICIO</label>' +
                    '        <input type="datetime" name="oferta['+ room +'][dt_inicio]" class="form-control" value="" placeholder="__/__/__">' +
                    '    </div>' +
                    '    <div class="col-md-4">' +
                    '        <label for="descricao">FIM</label>' +
                    '        <input type="datetime" name="oferta['+ room +'][dt_fim]" class="form-control" value="" placeholder="__/__/__">' +
                    '    </div>' +
                    '    <div class="col-md-1">' +
                    '        <label for="descricao"><br></label>' +
                    '        <button id="' + room + '" onclick="del_fields(this.id);" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>' +
                    '    </div>' +
                '</div>';
            objTo.appendChild(divtest)
        }
        
        function del_fields(id) {
            var elem = document.getElementById('elemento-' + id);
            return elem.parentNode.removeChild(elem);
        }
    </script>
    
</body>

</html>