<div class="col-md-3">
    
    <?php if(isset($page)){ ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12">
                <form method="GET" action="<?php echo $page; ?>">
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
    <?php } ?>

    <?php if(!isset($page)){ $page = "dashboard";} ?>
    <div class="col-md-12">
        <br/>
        <div class="list-group">
            <a href="./"          class="list-group-item <?php echo $page == "dashboard" ? 'active' : NULL; ?>"><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard</a>
            <a href="produto.php" class="list-group-item <?php echo $page == "produto.php"  ? 'active' : NULL; ?>"><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> Produtos</a>
            <a href="grupo.php"   class="list-group-item <?php echo $page == "grupo.php"  ? 'active' : NULL; ?>"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> Grupos</a>
            <a href="#"           class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Usuários</a>
        </div>
    </div>
    
</div>