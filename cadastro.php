<?php require_once 'includes/connect.php'; ?>
<?php require_once 'includes/topo.php';     ?>

<body>

    <?php require_once 'includes/nav.php';     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php require_once 'includes/categoria.php';     ?>

            <div class="col-lg-9">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cadastro</h3>
                    </div>
                    <div class="panel-body">

                        <form class="form-horizontal form-bordered" method="POST" action="cadastro_action.php" onsubmit="return validacao()">
                            <input type="hidden" name="action" value="cadastrar">
                            <input type="hidden" name="check" value="">

                            <h4 class="card-title">Dados Pessoais</h4><hr>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-8">
                                  <label for="exampleInputName">NOME</label>
                                  <input class="form-control" id="nome" name="nome" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">CPF</label>
                                  <input class="form-control" id="cpf" name="cpf" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>

                            <p>&nbsp;</p>
                            <h4 class="card-title">Dados Endereço</h4><hr>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-2">
                                  <label for="exampleInputName">cep</label>
                                  <input class="form-control" id="cep" name="cep" type="number" value="" aria-describedby="nameHelp" placeholder="cep" onKeyDown="limitarCaracteres(this,8);" onKeyUp="limitarCaracteres(this,8);" required>
                                </div>
                                <div class="col-md-6">
                                  <label for="exampleInputName">Logradouro</label>
                                  <input class="form-control" id="logradouro" name="logradouro" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-2">
                                  <label for="exampleInputName">número</label>
                                  <input class="form-control" id="numero" name="numero" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-2">
                                  <label for="exampleInputName">Complemento</label>
                                  <input class="form-control" id="complemento" name="complemento" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                  <label for="exampleInputName">Bairro</label>
                                  <input class="form-control" id="bairro" name="bairro" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">Cidade</label>
                                  <input class="form-control" id="municipio" name="municipio" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">Estado</label>
                                  <input class="form-control" id="uf" name="uf" type="text" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>

                            <p>&nbsp;</p>
                            <h4 class="card-title">Dados Contato</h4><hr>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                  <label for="exampleInputName">Telefone</label>
                                  <input class="form-control" id="telefone" name="telefone" type="text" value="" aria-describedby="nameHelp" placeholder="telefone" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">e-mail</label>
                                  <input class="form-control" id="email" name="email" type="text" value="" aria-describedby="nameHelp" placeholder="e-mail" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">e-mail confirmação</label>
                                  <input class="form-control" id="email_confirmacao" name="email_confirmacao" type="email" value="" aria-describedby="nameHelp" placeholder="e-mail" required>
                                </div>
                              </div>
                            </div>

                            <p>&nbsp;</p>
                            <h4 class="card-title">Dados Acesso</h4><hr>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                  <label for="exampleInputName">senha</label>
                                  <input class="form-control" id="nome" name="nome" type="password" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                                <div class="col-md-4">
                                  <label for="exampleInputName">senha confirmação</label>
                                  <input class="form-control" id="nome" name="nome" type="password" value="" aria-describedby="nameHelp" placeholder="nome" required>
                                </div>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="form-row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                              </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

    </div>
    
    <!-- /.container -->
    <?php require_once 'includes/fim.php';     ?>
    
    <script>
        
        function validacao()
        {
            
            var nome       = document.getElementById('nome'      ).value;
            var cpf        = document.getElementById('cpf'       ).value;
            var email      = document.getElementById('email'     ).value;
            var cep        = document.getElementById('cep'       ).value;
            var logradouro = document.getElementById('logradouro').value;
            var numero     = document.getElementById('numero'    ).value;
            var bairro     = document.getElementById('bairro'    ).value;
            var municipio  = document.getElementById('municipio' ).value;
            var uf         = document.getElementById('uf'        ).value;
            var senha      = document.getElementById('senha'     ).value;
            
            var er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
            if( er.exec(email) )
            {
                return true;
            } else {
                alert('Favor verifique o campo Email');
                return false;
            }
            
        }
        

        
        /**
         * Autocompleta os campos de endereço
         */
        $('#cep').blur(function(){
            
            var cep = document.getElementById('cep').value;
                cep = cep.replace(/[^\d]\+/g,'');
                
            $.getJSON("http://cep.republicavirtual.com.br/web_cep.php?cep=" + cep + "&formato=json", function(data){
                
                if(data['resultado']){
                    
                    document.getElementById("logradouro").value = data['logradouro'];
                    document.getElementById("bairro"    ).value = data['bairro'    ];
                    document.getElementById("municipio" ).value = data['cidade'    ];
                    document.getElementById("uf"        ).value = data['uf'        ];
                    document.getElementById("numero"    ).focus();
                    
                }
                
            });
            
        });
        
        function limitarCaracteres(objeto, limite){
            if (objeto.value.length > limite) {
                objeto.value = objeto.value.substring(0, limite);
            }
        }
        
    </script>
    
</body>

</html>