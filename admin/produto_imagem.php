<?php require_once '../includes/connect.php';   ?>
<?php require_once '../includes/functions.php'; ?>
<?php require_once 'includes/security.php';     ?>
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

                 <?php
          
          # Checa se passou o parâmetro
          if(@isset($_GET['cod'])){
              
              # Checa o parâmetro recebido
              if(is_numeric($_GET['cod'])){
                  
                $controle = $_GET['cod'];

                $sql  = "SELECT TOP 1 * FROM PRODUTOIMAGEM WHERE PRODUTO_CONTROLE = $controle";
                if($pdo->query($sql)){
                    
                    $result = $pdo->query($sql);
                    $row = $result->fetch();

                    $imagem      = $row['NOME_IMAGEM'];
                    
                }else{
                    
                    $imagem      = NULL;
                    
                }
                
              }else{
                  
                  # Se o parâmetro informado não for válido
                  die("Erro: O parâmetro informado é inválido!");
              }
              
            }else{
                
                # Se não passou o parâmetro
                die("Erro: Referência do produto não foi encontrada!");
                
            }
          
          ?>

            <form class="form-horizontal form-bordered" method="POST"  enctype="multipart/form-data" action="produto_action.php">
            <input type="hidden" name="action" value="upload_imagem">
            <input type="hidden" name="controle" value="<?php echo $controle; ?>">
            
            <div class="col-md-3 col-xs-6">
                <a href="#" class="thumbnail">
                    <?php if($imagem) {?>
                        <img src="../data/produtos/<?php echo $imagem; ?>" style="width:120px;height:180px;">
                    <?php }else{?>
                        <img alt="100%x180" data-src="holder.js/100%x180" style="height: 180px; width: 100%; display: block;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTYwIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE2MCAxODAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MTgwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTY0Mzg3OGMyYmMgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNjQzODc4YzJiYyI+PHJlY3Qgd2lkdGg9IjE2MCIgaGVpZ2h0PSIxODAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI1NC4wMTU2MjUiIHk9Ijk0LjUiPjE2MHgxODA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
                    <?php }?>
                </a>
            </div>
            
            Selecione uma imagem: <input name="arquivo" type="file" />
            <br />
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Salvar Imagem</button>
                  <a class="btn btn-default" href="../admin/produto.php">Cancelar</a>
                </div>
              </div>
            </div>

        </form>


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