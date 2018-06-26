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

                <form class="form-horizontal form-bordered" method="POST" action="produto_action.php">
                    <input type="hidden" name="action" value="cadastrar">

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-12">
                          <label for="exampleInputName">NOME</label>
                          <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-12">
                          <label for="descricao">DESCRIÇÃO</label>
                          <textarea class="form-control" rows="5" id="descricao" name="descricao"></textarea>
                        </div>
                      </div>
                    </div>
                    
                    <?php $count = 0; ?>
                    <div id="room_fileds">
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
                    </div>
                    
                    <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-4">
                          <a class="btn btn-default" href="javascript:void(0)" onclick="add_fields();">Adicionar</a>
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