<?php

include_once 'includes/verificaSessao.php';

if ( isset($_POST['titulo']) && isset($_POST['conteudo']) && isset($_POST['fonte']) && isset($_POST['palavras']) ) {
    
    include_once 'includes/funcoes.php';
    include_once 'includes/conexao.php';
    
    // trata os dados
    $titulo = trim(addslashes(strip_tags($_POST['titulo'])));
    $conteudo = trim(addslashes(strip_tags($_POST['conteudo'])));
    $fonte = trim(addslashes(strip_tags($_POST['fonte'])));
    $palavras = trim(addslashes(strip_tags($_POST['palavras'])));
    
    // tratar arquivos
    $arquivoTitulo = remover_caracter($titulo);
    $arquivoConteudo = remover_caracter($titulo) . '_c';
    
    // insere o usuario
    $sql = "INSERT INTO noticias (titulo, conteudo, fonte, palavrasChave, arquivoTitulo, arquivoConteudo) VALUES ('" . $titulo . "','" . $conteudo . "','" . $fonte . "','" . $palavras . "','" . $arquivoTitulo . "','" . $arquivoConteudo . "')";
    $query = mysql_query($sql);
    
	$retorno = array();
    if ( $query ) {
        include_once 'tts2.php';
        
        tts($titulo, $arquivoTitulo);
        tts($conteudo, $arquivoConteudo);
		tts('Fonte: ' . $fonte, $arquivoConteudo);
        
		$retorno['titulo'] = $titulo;
		$retorno['arquivoTitulo'] = $arquivoTitulo;
		$retorno['id'] = mysql_insert_id();
		$retorno['status'] = 'sucesso';
    } else {
        $retorno['status'] = 'falha';
    }
	echo json_encode($retorno);
    
    // fecha a conexao
    mysql_close($conect);
    
} else if ( isset($_GET['apagar']) && isset($_GET['id']) ) {
    
    include_once 'includes/conexao.php';
    
    if ( (INT)$_GET['id'] > 0 ) {
        $sql = "SELECT arquivoTitulo, arquivoConteudo FROM noticias WHERE id = '{$_GET['id']}'";
        $result = mysql_fetch_array(mysql_query($sql));
        
        // apaga os arquivos de audio
        unlink($_SERVER['DOCUMENT_ROOT'] . '/audio/' . $result['arquivoTitulo'] . '.mp3');
        unlink($_SERVER['DOCUMENT_ROOT'] . '/audio/' . $result['arquivoConteudo'] . '.mp3');
        
        $sql = "DELETE FROM noticias WHERE id = '{$_GET['id']}'";
        $query = mysql_query($sql);
        
        if ( $query ) {
            echo json_encode('sucesso');
        } else {
            echo json_encode('falha');
        }
    } else {
        echo json_encode('falha');
    }
    
}

