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

?>