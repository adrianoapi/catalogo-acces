<?php

if(isset($_SESSION['USER'])){
    
    if(!is_array($_SESSION['USER']) || count($_SESSION['USER']) < 2){
        header('Location: area_restrita.php');
    }

}else{
    header('Location: area_restrita.php');
}

?>