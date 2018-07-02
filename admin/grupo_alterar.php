<?php require_once '../includes/connect.php'; ?>
<?php require_once 'includes/topo.php'; 
$page = "grupo.php";

/*
Se o sol se por
E a noite chegar
Tu és quem me guia
Se a tempestade me alcançar
Tu és meu abrigo

Se o mar me submergir
A tua mão
Me traz a tona pra respirar
E me faz andar
Sobre as águas
Tu és o Deus da minha salvação
És o meu dono minha paixão
Minha canção e o meu louvor

Aleluia, aleluia
 */
?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-heading">Grupo Alterar</div>
                    <div class="panel-body">

                    <?php

                        # Checa se passou o parâmetro
                        if(@isset($_GET['cod'])){

                            # Checa o parâmetro recebido
                            if(is_numeric($_GET['cod'])){

                              $controle = $_GET['cod'];

                              $sql    = "SELECT TOP 1 * FROM GRUPO WHERE GRUPO_CONTROLE = $controle AND STATUS = 1";
                              $result = $pdo->query($sql);
                              $row    = $result->fetch();

                              $controle  = $row['GRUPO_CONTROLE'];
                              $nome      = utf8_encode($row['NOME']);

                              $sql_sub = "SELECT * FROM SUBGRUPO WHERE GRUPO_CONTROLE = $controle AND STATUS = 1";
                              $rst_sub = $pdo->query($sql_sub);

                            }else{

                                # Se o parâmetro informado não for válido
                                die("Erro: O parâmetro informado é inválido!");
                            }

                          }else{

                              # Se não passou o parâmetro
                              die("Erro: Referência do produto não foi encontrada!");

                          }

                        ?>
                          <form class="form-horizontal form-bordered" method="POST" action="grupo_action.php">
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

                          <div id="room_fileds">
                          <?php 
                          $count = 0;
                          while ($row = $rst_sub->fetch()){
                              $count = $count <= 0 ? $row['SUBGRUPO_CONTROLE'] : $count;
                          ?>
                              <div class="form-group" id="elemento-<?php echo $count; ?>">
                                  <div class="form-row">
                                      <div class="col-md-11">
                                          <label for="descricao">SUBGRUPO</label>
                                          <input type="text" name="subgrupo[<?php echo $count; ?>][nome]" class="form-control" value="<?php echo $row['NOME']; ?>">
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
                                <a class="btn btn-default" href="../admin/grupo.php">Cancelar</a>
                              </div>
                            </div>
                          </div>

                      </form>
                      
                      
                  </div><!--./panel-body-->
                </div><!--./panel-default-->


        </div><!--./col-md-9-->

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
                    '    <div class="col-md-11">' +
                    '        <label for="descricao">SUBGRUPO</label>' +
                    '        <input type="text" name="subgrupo['+ room +'][nome]" class="form-control" value="">' +
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