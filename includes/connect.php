<?php

#header("Content-type: text/html; charset=iso-8859-1"); 

// Inicia a sessão para todo o sistema
session_start();

/**
 * Conexão com PDO ao Access DB
 */
try { $pdo = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=C:\database.mdb;Uid=;"); 

} catch (PDOException $e) {
    die("<h1>Erro de banco</h1>". $e->getMessage());
}

function debug($data, $stop = false)
{
    echo "<pre>";
    if(is_array($data) || is_object($data)){
        print_r($data);
    }else{
        echo $data;
    }
    echo "</pre>";
    if($stop)
        die();
}

function paginacao($max_links, $p, $pags, $pesquisa = NULL, $grupo = NULL){
    
    $pesquisa = $pesquisa != NULL ? "&pesquisa=$pesquisa" : NULL;
    $grupo    = $grupo    != NULL ? "&grupo=$grupo"       : NULL;
    echo "<ul class=\"pagination\" style=\"margin:0;padding:0;\">";
    
    echo "<li><a href=\"?p=1{$pesquisa}{$grupo}\" class=\"pagination\" target=\"_self\">&laquo;</a></li>";

    for ($i = $p - $max_links; $i <= $p - 1; $i++) {

        if ($i <= 0) {
        } else {
            echo "<li><a href=\"?p=" . $i.$pesquisa.$grupo . "\" class=\"pagination\" target=\"_self\">" . $i . "</a></li>";
        }
    }

    echo "<li class=\"active\"><a href=\"#\" class=\"pagination\">".$p."</a></li>";
    // Cria outro for(), desta vez para exibir 3 links após a página atual
    for ($i = $p + 1; $i <= $p + $max_links; $i++) {
        if ($i > $pags) {
        }
        // Se tiver tudo Ok gera os links.
        else {
            echo "<li><a href=\"?p=" . $i.$pesquisa.$grupo . "\" class=\"pagination\" target=\"_self\">" . $i . "</a></li>";
        }
    }
    echo "<li><a href=\"?p=" . $pags.$pesquisa.$grupo . "\" class=\"pagination\" target=\"_self\">&raquo;</a></li>";
    
    echo "</ul>";

}


/**
 * Remove letras acentuadas
 * @param type $str
 * @return type
 */
function trataString($str)
{
    $str = preg_replace('/["]/ui', "&quot;", $str);
    $str = preg_replace('/[“]/ui', "&quot;", $str);
    $str = preg_replace('/[”]/ui', "&quot;", $str);
    $str = preg_replace("/[']/ui", "&apos;", $str);
    $str = preg_replace('/[`]/ui', "&apos;", $str);
    $str = preg_replace('/[´]/ui', "&apos;", $str);
    return addslashes($str);
}

function trataStringJS($str)
{
    $str = str_replace('\'', '', $str);
    $str = str_replace("'",  "", $str);
    $str = str_replace("&quot;", "", $str);
    $str = str_replace("&apos;", "", $str);
    return $str;
}

?>