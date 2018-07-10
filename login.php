<?php require_once 'includes/connect.php';   ?>
<?php require_once 'includes/functions.php'; ?>
<?php require_once 'includes/topo.php';      ?>

<?php


?>

    <?php require_once 'includes/nav.php'; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

        <div class="col-lg-9">
            
        <div class="col-lg-6 col-md-offset-3">
                <div class="row">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Autenticação</h3>
                        </div>
                        <div class="panel-body">

                              <form id="form-login" method="POST" onsubmit="return false">
                                    <input type="hidden" name="action" value="autenticar">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Email</label>
                                      <input class="form-control" id="exampleInputEmail1" type="text" name="email" aria-describedby="emailHelp" placeholder="usuário" required="true">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleInputPassword1">Senha</label>
                                      <input class="form-control" id="exampleInputPassword1" type="password" name="senha" placeholder="senha" required="true">
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-block" value="Autenticar">
                              </form>
                                <hr>
                                <p><a href="./cadastro.php">Não possui cadastro?</a></p>
                                <p><a href="#">Esqueceu sua senha?</a></p>

                            </div<!--end/panel-body-->
                        </div><!--end/panel-->

                    </div>

                </div><!--/.row-->
            </div><!--/.col-lg-4-->

        </div><!--./col-lg-9-->
     
    
    <?php require_once 'includes/fim.php';     ?>
    
    </div>

</div><!-- /.container -->

<script>
    
    $("#form-login").submit(function(event){
        
        event.preventDefault();
        
        var send = $.post("login_action.php", $(this).serialize(), function(data){
            
            //return
            
        }).done(function(){
           //alert('done: success'); 
        }).fail(function(){
            alert('Falha na conexão com o servidor. \n Verifique seu sinal de internet.');
        }).always(function(){
            //alert('finishid');
        });
        
    });

    
</script>
    
</body>
</html>