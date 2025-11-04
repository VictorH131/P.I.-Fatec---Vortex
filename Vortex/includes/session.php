<?php
    session_start();

   // Verifica se a sessão 'logado' existe e está verdadeira
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        header('Location: index.html');
        exit;
    }
 
    //pega o nome do usuario
   $nomeUsuario = $_SESSION['usuario']['nome'];
?>