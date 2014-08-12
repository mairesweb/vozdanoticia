<?php
/*ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);*/
if ( isset($_GET['inicio']) && $_GET['noticias'] == 'njsh3ha5832jgvxhs' ) {
	
	$inicio = (INT)$_GET['inicio'];
	
	include_once 'includes/conexao.php';
	
    if ((INT)$_GET['categoria'] > 0) {
        $select = "SELECT noticias.titulo, noticias.arquivoTitulo, noticias.arquivoConteudo FROM noticias WHERE categoria = '" . $_GET['categoria'] . "' ORDER BY noticias.id DESC LIMIT " . $inicio . ",5";
        $query = $conect->query($select);
    } else {
        $select = "SELECT titulo, arquivoTitulo, arquivoConteudo FROM noticias ORDER BY id DESC LIMIT " . $inicio . ",5";
        $query = $conect->query($select);
    }
	
	$ret = array();
	$i = 0;
	while ($r = mysqli_fetch_array($query)) {
		$ret[$i]['titulo']			= $r['titulo'];
		$ret[$i]['arquivoTitulo']	= $r['arquivoTitulo'];
		$ret[$i]['arquivoConteudo']	= $r['arquivoConteudo'];
		$i++;
	}
	
	echo json_encode($ret);
	
	mysql_close($conect);
	
}