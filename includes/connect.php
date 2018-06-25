<?php

// Inicia a sessão para todo o sistema
session_start();

/**
 * Conexão com PDO ao Access DB
 */
try { $pdo = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=C:\database.mdb;Uid=;"); 

} catch (PDOException $e) {
    die("<h1>Erro de banco</h1>". $e->getMessage());
}

function debug($data, $stop = false){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if($stop){
        die();
    }
}

function paginacao($max_links, $p, $pags, $pesquisa = NULL){
    
    $pesquisa = $pesquisa != NULL ? "&pesquisa=$pesquisa" : NULL;
    echo "<ul class=\"pagination\" style=\"margin:0;padding:0;\">";
    
    echo "<li><a href=\"?p=1$pesquisa\" class=\"pagination\" target=\"_self\">&laquo;</a></li>";

    for ($i = $p - $max_links; $i <= $p - 1; $i++) {

        if ($i <= 0) {
        } else {
            echo "<li><a href=\"?p=" . $i.$pesquisa . "\" class=\"pagination\" target=\"_self\">" . $i . "</a></li>";
        }
    }

    echo "<li class=\"active\"><a href=\"#\" class=\"pagination\">".$p."</a></li>";
    // Cria outro for(), desta vez para exibir 3 links após a página atual
    for ($i = $p + 1; $i <= $p + $max_links; $i++) {
        if ($i > $pags) {
        }
        // Se tiver tudo Ok gera os links.
        else {
            echo "<li><a href=\"?p=" . $i.$pesquisa . "\" class=\"pagination\" target=\"_self\">" . $i . "</a></li>";
        }
    }
    echo "<li><a href=\"?p=" . $pags.$pesquisa . "\" class=\"pagination\" target=\"_self\">&raquo;</a></li>";
    
    echo "</ul>";

}
?>