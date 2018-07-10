<?php

if(isset($_SESSION['AUTH'])){
    
    if(!is_array($_SESSION['AUTH']) || count($_SESSION['AUTH']) < 4){
        header('Location: area_restrita.php');
    }

}else{
    header('Location: area_restrita.php');
}

?>