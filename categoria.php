<?php require_once 'includes/connect.php';   ?>
<?php require_once 'includes/functions.php'; ?>
<?php require_once 'includes/topo.php';      ?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-md-9">
                
                <div class="row">
                    
                    <?php
                    $sql_grp = "SELECT * FROM GRUPO WHERE STATUS = 1";
                    if($pdo->query($sql_grp)){
                        $qry_grp = $pdo->query($sql_grp);
                        while($row = $qry_grp->fetch()){
                            
                            echo '<div class="col-md-4">'.
                                    '<div class="panel panel-default">'.
                                       '<div class="panel-heading">'.
                                         '<h3 class="panel-title"><a href="produto_grupo.php?grupo='.$row['GRUPO_CONTROLE'].'">'.utf8_encode($row['NOME']).'</a></h3>'.
                                       '</div>'.
                                       '<div class="panel-body">';

                            $sql_sub = "SELECT * FROM SUBGRUPO WHERE GRUPO_CONTROLE = {$row['GRUPO_CONTROLE']} AND STATUS = 1";
                            if($pdo->query($sql_sub)){
                                $qry_sub = $pdo->query($sql_sub);
                                while($sub = $qry_sub->fetch()){
                                    echo "<li><a href=\"produto_subgrupo.php?grupo={$sub['SUBGRUPO_CONTROLE']}\">".$sub['NOME']."</a></li>";
                                }
                            }
                            
                            echo ''.
                                       '</div>'.
                                    '</div>'.
                                '</div>';

                        }
                    }

                    ?>
                </div>

            </div>

        </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
</body>

</html>