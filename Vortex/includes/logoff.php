<?php
    session_start();
    session_destroy();  // Desloga
    header('Location: ../index.html');  // volta para o inicio
    exit;
?>