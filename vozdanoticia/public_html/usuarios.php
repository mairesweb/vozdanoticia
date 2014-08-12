<?php

include_once 'includes/verificaSessao.php';

if ( isset($_GET['nome']) && isset($_GET['usuario']) && isset($_GET['senha']) ) {
    
    include_once 'includes/conexao.php';
    
    // trata os dados
    $nome = trim(addslashes(strip_tags($_GET['nome'])));
    $usuario = trim(addslashes(strip_tags($_GET['usuario'])));
    $senha = md5($_GET['senha']);
    $tipo = (INT)$_GET['tipo'];
    
    // insere o usuario
    $sql = "INSERT INTO usuarios (nome, usuario, senha, tipo) VALUES ('" . $nome . "','" . $usuario . "','" . $senha . "', '" . $tipo . "')";
    $query = $conect->query($sql);
    
    $retorno = array();
    if ( $query ) {
        $retorno['nome'] = $nome;
        $retorno['usuario'] = $usuario;
        $retorno['tipo'] = $tipo;
        $retorno['id'] = $conect->insert_id();
        $retorno['status'] = 'sucesso';
    } else {
        $retorno['status'] = 'falha';
    }
    echo json_encode($retorno);
    
    // fecha a conexao
    mysqli_close($conect);
    
} else if ( isset($_GET['apagar']) && isset($_GET['id']) ) {
    
    include_once 'includes/conexao.php';
    
    if ( (INT)$_GET['id'] > 0 ) {
        $sql = "DELETE FROM usuarios WHERE id = '{$_GET['id']}'";
        $query = $conect->query($sql);
        
        if ( $query ) {
            echo json_encode('sucesso');
        } else {
            echo json_encode('falha');
        }
    } else {
        echo json_encode('falha');
    }
    
}