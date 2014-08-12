<?php

function tts($conteudo, $nome) {
    // pega o texto para transformar em audio
    $text = $conteudo;

    // quebra o texto em frases
    $frases = explode('.', $text);

    // Nome do arquivo, título da notícia
    $file = $nome;

    // Salvar em MP3 no diretório especificado
    $file = "audio/" . $file . ".mp3";

    // Percorre cada frase
    foreach ($frases AS $frase) {
        // Verifica se tem algum texto para evitar erros
        if (strlen($frase) > 1 && $frase != ' ' && $frase != ', ') {

            // Verifica se o texto tem mais de 100 caracteres, pois a api só aceita esse tamanho
            if (strlen($frase) > 100) {
                $virgulas = explode(',', $frase); // quebra a frase entre virgulas
                // Percorre todo o texto quebrado por virgulas
                foreach ($virgulas AS $virgula) {
					if (strlen($virgula) > 100) {
						$str = wordwrap($virgula, 90, '|');
						$str_r = explode('|', $str);
						
						foreach ($str_r AS $str_f) {
							gravaAudio($str_f, $file);
						}
					} else {
						gravaAudio($virgula, $file);
					}
				}

                // Se o texto tiver menos de 100 caracteres grava a narração
            } else {
                gravaAudio($frase, $file);
            }
        }
    }
}
	
function gravaAudio($texto, $file) {
	
	if (strlen($texto) > 2) {
		// Gera o arquivo de narrativa no servidor
		$url = 'http://translate.google.com/translate_tts?ie=UTF-8&tl=pt-br&q=' . urlencode($texto);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$mp3 = curl_exec($ch);
		curl_close($ch);

		// Verifica se o arquivo já existe ou é necessário cria-lo
		if (file_exists($file)) {
			file_put_contents($file, $mp3, LOCK_EX | FILE_APPEND);
		} else {
			file_put_contents($file, $mp3, LOCK_EX);
		}
		sleep(0.5);
	}
	
}
