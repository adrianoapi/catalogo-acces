<?php


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

function error($msg, $col = 4, $offset = 4)
{
    echo '<div class="col-lg-'.$col.' col-md-offset-'.$offset.'">
            <div class="panel panel-danger">
               <div class="panel-heading">ERRO</div>
               <div class="panel-body"> '.$msg.' </div>
            </div>
         </div>';
}

/**
 * Registra uma sessão com dados do cliente
 * @param array $data
 * @return boolean
 */
function registra_login(array $data)
{
    
    if(is_numeric($data['PESSOA_CONTROLE']) && isset($data['NOME']) && isset($data['VALOR'])){
        
        // Cria a sessão do cliente
        $_SESSION['AUTH'] = array(
            'controle' => $data['PESSOA_CONTROLE'],
            'nome'     => $data['NOME'           ],
            'emai'     => $data['VALOR'          ],
            'time'     => date('Y-m-d H:i:s')
        );
        
        return TRUE;
        
    }else{
        
        return FALSE;
        
    }
    
}

function datetime2Br($valor)
{
    $arr  = explode(" ", $valor);
    $date = explode("-", $arr[0]);
    return $date[2]."/".$date[1]."/".$date[0]." ".$arr[1];
}

function datetime2SQL($valor)
{
    $arr  = explode(" ", $valor);
    $date = explode("/", $arr[0]);
    return $date[2]."-".$date[1]."-".$date[0]." ".$arr[1];
}

?>