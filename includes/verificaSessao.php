<?php
// Inicia a sessao
session_start();

// Verifica se o usuario fez login no sistema
if ( !isset($_SESSION['usuarioID']) ||
     !isset($_SESSION['usuarioNome']) ||
     $_SESSION['login'] != 'mfaldkfadnfhfa70324bf96$%^*82rdnadflkueqo,.0975hjv35g8964#$6' ) {
    
    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['login']);
    
    // Manda o usuario para a tela de login
    header("Location: login.php");
}

