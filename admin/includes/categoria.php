<div class="col-md-3">
    <?php if(isset($page)){ ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12">
                <form method="GET" action="<?php echo $page; ?>">
                <div class="input-group">
                    <input type="text" name="pesquisa" class="form-control" value="<?php echo @isset($_GET['pesquisa']) ? $_GET['pesquisa'] : ""; ?>" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </span>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="col-md-12">
        <br/>
        <div class="list-group">
            <a href="produto.php" class="list-group-item">Produtos</a>
            <a href="#" class="list-group-item">Category 2</a>
            <a href="#" class="list-group-item">Category 3</a>
        </div>
    </div>
    
</div>