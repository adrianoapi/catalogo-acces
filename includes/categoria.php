<div class="col-md-3">
    
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12">
                <form method="GET" action="produto_lista.php">
                <div class="input-group">
                    <input type="text" name="pesquisa" class="form-control" value="<?php echo @isset($_GET['pesquisa']) ? $_GET['pesquisa'] : ""; ?>" placeholder="Pesquisar produto">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </span>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
    <br>
        <div class="list-group">
            <a href="./" class="list-group-item">Home</a>
            <a href="./produto_lista.php" class="list-group-item">Produtos</a>
        </div>
    </div>
    
</div>