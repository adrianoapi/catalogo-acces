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
                              $select_grupo = array();
                              $sql_grp = "SELECT * FROM GRUPO WHERE STATUS = 1";
                              $qry_grp = $pdo->query($sql_grp);
                              while ($row_grp = $qry_grp->fetch()){
                                  array_push($select_grupo, $row_grp);
                              }
                              
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
                              #debug($select_subgrupo,1);
                              
                              # Seleciona relação dos grupos e subgrupos
                              $sql_pgrp = " SELECT pg.* FROM (PRODUTOGRUPO AS pg " .
                                         " INNER JOIN GRUPO    AS g ON (g.GRUPO_CONTROLE    = pg.GRUPO_CONTROLE    AND g.STATUS = 1)) ".
                                         " INNER JOIN SUBGRUPO AS s ON (s.SUBGRUPO_CONTROLE = pg.SUBGRUPO_CONTROLE AND s.STATUS = 1)  ".
                                         " WHERE pg.STATUS = 1 AND pg.PRODUTO_CONTROLE = $controle ";
                             
                              $array_grp = array();
                              $array_sub = array();
                              
                              if($pdo->query($sql_pgrp)){
                                  
                                  $rst_grp = $pdo->query($sql_pgrp);
                                  while($line = $rst_grp->fetch()){
                                      array_push($array_grp, array('PRODUTOGRUPO_CONTROLE' => $line['PRODUTOGRUPO_CONTROLE'],'GRUPO_CONTROLE' => $line['GRUPO_CONTROLE']));
                                      array_push($array_sub, $line['SUBGRUPO_CONTROLE']);
                                  }
                                  
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
                             <?php
                          $array_sub_usado = array();
                          $c_grp = count($array_grp);
                          if($c_grp > 0){
                            for($i = 0; $i < $c_grp; $i++){
                                #debug($array_grp,1);
                          ?>
                              <div class="form-group" id="elemento-group-<?php echo $i; ?>">
                                  <div class="form-row">
                                      <div class="col-md-5">
                                          <label for="descricao">GRUPO</label>
                                          <select name="grupo[]" id="select-groupo-<?php echo $i; ?>" class="form-control" onchange="add_option_group(this.id)">
                                              <option>Selecione grupo</option>
                                              <?php foreach($select_grupo as $value){
                                                  $selected = $value['GRUPO_CONTROLE'] == $array_grp[$i]['GRUPO_CONTROLE'] ? "selected" : NULL;
                                                  echo '<option value="'.$array_grp[$i]['PRODUTOGRUPO_CONTROLE'].'|'.$value['GRUPO_CONTROLE'].'" '.$selected.'>'.$value['NOME'].'</option>';
                                              } ?>
                                          </select>
                                      </div>
                                      <div class="col-md-6">
                                          <label for="descricao">SUBGRUPO</label>
                                          <select name="subgrupo[]" id="select-subgroupo-<?php echo $i; ?>" class="form-control">
                                              <option>Selecione grupo</option>
                                              <?php
                                              $selected = NULL;
                                              $j=0;
                                              foreach($select_subgrupo as $value){
                                                  
                                                  # Se pertence ao grupo atual
                                                  if( $value['GRUPO_CONTROLE'] == $array_grp[$i]['GRUPO_CONTROLE']){
                                                      
                                                      if(in_array($value['SUBGRUPO_CONTROLE'], $array_sub) && !in_array($value['SUBGRUPO_CONTROLE'], $array_sub_usado) && $selected == NULL){
                                                          $array_sub_usado[$value['SUBGRUPO_CONTROLE']] = $value['SUBGRUPO_CONTROLE'];
                                                          $selected = "selected";
                                                          echo '<option value="'.$array_grp[$i]['PRODUTOGRUPO_CONTROLE'].'|'.$value['SUBGRUPO_CONTROLE'].'" '.$selected.'>'.$value['NOME'].'</option>';
                                                      }else{
                                                          echo '<option value="'.$array_grp[$i]['PRODUTOGRUPO_CONTROLE'].'|'.$value['SUBGRUPO_CONTROLE'].'" >'.$value['NOME'].'</option>';
                                                      }
                                                      
                                                          
                                                  }
                                                  
                                              } 
                                              ?>
                                          </select>
                                      </div>
                                      <div class="col-md-1">
                                          <label for="descricao"><br></label>
                                          <button id="<?php echo $i; ?>" onclick="del_groups(this.id);" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                                      </div>
                                  </div>
                              </div>
                          <?php
                            }
                          }
                          ?>
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
            
            // Gera options para o select de groupos
            var option_grupo = '';
            var itarator     = <?php echo $c_grp; ?>;
            for(var i = 0; i < array_grupo.length; i++){
                option_grupo += '<option value="'+itarator+'|' + array_grupo[i]['controle'] + '">' + array_grupo[i]['nome'] + '</option>';
                itarator++;
            }
        
        var group = <?php echo $c_grp; ?>;
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
                    '        '+ option_grupo +
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