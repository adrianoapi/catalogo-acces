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
                    <div class="panel-heading">Produto Cadastrar</div>
                    <div class="panel-body">
                        
                        <?php
                        # Select grupo
                        $select_grupo = array();
                        $sql_grp = "SELECT * FROM GRUPO WHERE STATUS = 1";
                        $qry_grp = $pdo->query($sql_grp);
                        while ($row_grp = $qry_grp->fetch()){
                          array_push($select_grupo, $row_grp);
                        }

                        # Select subgrupo
                        $select_subgrupo = array();
                        $sql_sub = "SELECT * FROM SUBGRUPO WHERE STATUS = 1";
                        $qry_sub = $pdo->query($sql_sub);
                        while ($row_sub = $qry_sub->fetch()){
                          array_push($select_subgrupo, $row_sub);
                        }
                        ?>
                        
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
                            
                            <div id="group_fileds">
                              <div class="form-group" id="elemento-group-0">
                                  <div class="form-row">
                                      <div class="col-md-5">
                                          <label for="descricao">GRUPO</label>
                                          <select name="grupo[]" id="select-groupo-0" class="form-control" onchange="add_option_group(this.id)" required>
                                              <option>Selecione grupo</option>
                                              <?php foreach($select_grupo as $value){
                                                  echo '<option value="0|'.$value['GRUPO_CONTROLE'].'">'.$value['NOME'].'</option>';
                                              } ?>
                                          </select>
                                      </div>
                                      <div class="col-md-6">
                                          <label for="descricao">SUBGRUPO</label>
                                          <select name="subgrupo[]" id="select-subgroupo-0" class="form-control" required>
                                              <option>Selecione grupo</option>
                                          </select>
                                      </div>
                                      <div class="col-md-1">
                                          <label for="descricao"><br></label>
                                          <button id="0" onclick="del_groups(this.id);" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                            <div class="form-row">
                              <div class="col-md-4">
                                <a class="btn btn-default" href="javascript:void(0)" onclick="add_groups();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
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
        
        // Gera o arrayJS de grupos
        var array_grupo = [];
        <?php
            $k = 0;
            $string = NULL;
            foreach($select_grupo as $value):
                echo 'array_grupo['.$k.'] = {controle: '.$value['GRUPO_CONTROLE'].',nome: \''.utf8_encode(trataStringJS($value['NOME'])).'\'};';
                ++$k;
            endforeach;
        ?>
            
        // Gera o arrayJS de subgrupos
        var array_subgrupo = [];
        <?php
            $k = 0;
            $string = NULL;
            foreach($select_subgrupo as $value):
                echo 'array_subgrupo['.$k.'] = {grupo_controle: '.$value['GRUPO_CONTROLE'].',subgrupo_controle: '.$value['SUBGRUPO_CONTROLE'].',nome: \''.trataStringJS($value['NOME']).'\'};';
                ++$k;
            endforeach;
        ?>
            
        function add_option_group(id)
        {
            // Capiura a opção selecionada
            var option = document.getElementById(id).value;
                option = option.split('|');
            var grupo_controle    = option[1];
            var progrupo_controle = option[0];
            
            // Isola o número do id
            var array  = id.split('-');
            var id     = array[2];
            
            $('#select-subgroupo-' + id).empty();
            
            for(var i = 0; i < array_subgrupo.length; i++){
                if(array_subgrupo[i]['grupo_controle'] == grupo_controle){
                    $('#select-subgroupo-' + id).append($('<option/>', {value: progrupo_controle + '|' + array_subgrupo[i]['subgrupo_controle'], text: array_subgrupo[i]['nome']}));
                }
            }
            
        }
            
        function make_grupo_option(itarator){
            // Gera options para o select de groupos
            var option_grupo = '';
            for(var i = 0; i < array_grupo.length; i++){
                option_grupo += '<option value="' + itarator + '|' + array_grupo[i]['controle'] + '">' + array_grupo[i]['nome'] + '</option>';
            }

            return option_grupo;
        }
        
        var group = 0;
        function add_groups() {
            group++;
            var objTo = document.getElementById('group_fileds')
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "form-group");
            divtest.setAttribute("id", "elemento-group-" + group);
            divtest.innerHTML = '<div class="form-row">' +
                    '    <div class="col-md-5">'+
                    '      <label for="descricao">GRUPO</label>'+
                    '      <select name="grupo[]" id="select-groupo-' + group + '" class="form-control" onchange="add_option_group(this.id)">'+
                    '        <option>Selecione grupo</option>'+
                    '        '+ make_grupo_option(group) +
                    '        </select>'+
                    '    </div>' +
                    '    <div class="col-md-6">'+
                    '      <label for="descricao">SUBGRUPO</label>'+
                    '      <select name="subgrupo[]" id="select-subgroupo-' + group + '" class="form-control">'+
                    '        <option>Selecione subgrupo</option>'+
                    '        </select>'+
                    '    </div>' +
                    '    <div class="col-md-1">' +
                    '        <label for="descricao"><br></label>' +
                    '        <button id="' + group + '" onclick="del_groups(this.id);" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>' +
                    '    </div>' +
                '</div>';
            objTo.appendChild(divtest)
        }
        
        function del_groups(id) {
            var elem = document.getElementById('elemento-group-' + id);
            return elem.parentNode.removeChild(elem);
        }

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