<?php require_once '../includes/connect.php';   ?>
<?php require_once '../includes/functions.php'; ?>
<?php require_once 'includes/topo.php'; 
$page = "pessoa.php";

$controle = addslashes($_GET['cod']);

$sql_pes = "SELECT TOP 1 * FROM PESSOA WHERE PESSOA_CONTROLE = {$controle}";
$qry_pes = $pdo->query($sql_pes);
$row_pes = $qry_pes->fetch();

$sql_end = " SELECT PM.*, TC.NOME AS CONTATO FROM PESSOA_MEIOCONTATO AS PM " .
           " INNER JOIN TIPOMEIOCONTATO AS TC ON (TC.TIPOMEIOCONTATO_CONTROLE = PM.TIPOMEIOCONTATO_CONTROLE) " .
           " WHERE PM.PESSOA_CONTROLE = {$controle} AND PM.STATUS = 1 ";
$qry_end = $pdo->query($sql_end);

function form_input($type, $name, $label, $id = null, $value = null)
{
    return ''.
           '<div class="form-group">' .
           ' <div class="form-row">' .
           '  <div class="col-md-12">' .
           '   <label for="descricao">'.$label.'</label>' .
           '   <input type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'" class="form-control">' .
           '  </div>' .
           ' </div>' .
           '</div>';
}

?>



<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">

                <div class="panel panel-default">
                  <div class="panel-heading">Informação: <?php echo $row_pes['NOME']; ?></div>
                  <div class="panel-body">
                      
                      <form class="form-horizontal form-bordered" method="POST" action="pessoa_action.php">
                          <input type="hidden" name="action" value="informacao"> 
                      <?php
                        while($row = $qry_end->fetch()){
                            
                           echo form_input('text', "grupo[".$row['PESSOA_MEIOCONTATO_CONTROLE']."]", $row['CONTATO'], null, $row['VALOR']);
                            
                        }

                        ?>
                          
                      <div class="form-group">
                          <div class="form-row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success pull-right"> Salvar</button>
                                <a href="pessoa.php" class="btn btn-default pull-left"> Cancelar</a>
                            </div>
                          </div>
                        </div>
                          
                      </form>
                    

                      
                  </div><!--./panel-body-->
                </div><!--./panel-default-->

            </div><!--./col-md-9-->

        </div><!--./row-->

    </div><!--./container-->
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
        
</body>

</html>