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
                $virgulas2 = array(); // array que recebera as strings quebradas
                $i = 0; // variavel para modificar o array temporario
                foreach ($virgulas AS $virgula) { // percorre o array criado ao quebrar a frase pelas virgulas
                    $temp = (string) $virgulas2[$i]; // guarda o trecho da string em uma variavel temporaria
                    if (strlen($temp) < 1) { // verifica se temp é vazia
                        $virgulas2[$i] = $virgula; // guarda o trecho quebrado no array
                    } else { // se temp não for vazia
                        $virgulas2[$i] = $virgulas2[$i] . ',' . $virgula; // concatena as strings
                    }
                    // verifica se a string tem a quantidade de caracteres validas
                    if (strlen($virgulas2[$i]) > 100) {
                        if (strlen($temp) < 1) { // se temp for vazia
                            $count = strlen($virgulas2[$i]); // pega a quantidade de caracteres da string
                            $temp = wordwrap($virgulas2[$i], ($count / 2), ','); // insere uma virgula no meio da string
                            $temp2 = explode(',', $temp); // quebra a string novamente
                            $virgulas2[$i] = $temp2[0]; // guarda o primeiro pedaço da string
                            $i++; // incrementa a variavel de controle
                            $virgulas2[$i] = $temp2[1] . $temp2[2]; // guarda o segundo pedaço da string
                        } else { // se temp tiver alguma string
                            $virgulas2[$i] = $temp; // retorna o valor de temp para o array
                            if (strlen($virgulas2[$i]) > 100) {
                                $count = strlen($virgulas2[$i]); // pega a quantidade de caracteres da string
                                $temp = wordwrap($virgulas2[$i], (($count + 1) / 2), ','); // insere uma virgula no meio da string
                                $temp2 = explode(',', $temp); // quebra a string novamente
                                $virgulas2[$i] = $temp2[0]; // guarda o primeiro pedaço da string
                                $i++; // incrementa a variavel de controle
                                $virgulas2[$i] = $temp2[1] . $temp2[2]; // guarda o segundo pedaço da string
                            }
                            $i++; // incrementa a variavel de controle
                            if (strlen($virgula) < 100) { // verifica se o pedaço do texto é aceito no script
                                $virgulas2[$i] = $virgula; // guarda a string atual no array
                            } else { // se não for aceito, quebra a string
                                $count = strlen($virgula); // pega a quantidade de caracteres da string
                                $temp = wordwrap($virgula, (($count + 1) / 2), ','); // insere uma virgula no meio da string
                                $temp2 = explode(',', $temp); // quebra a string novamente
                                $virgulas2[$i] = $temp2[0]; // guarda o primeiro pedaço da string
                                $i++; // incrementa a variavel de controle
                                $virgulas2[$i] = $temp2[1] . $temp2[2]; // guarda o segundo pedaço da string
                            }
                        }
                    }
                }
                // Percorre o texto quebrado nas virgulas
                foreach ($virgulas2 AS $virgula) {
                    // Verifica se tem algum texto para evitar erros
                    if (strlen($virgula) > 1) {
                        // Gera o arquivo de narrativa no servidor
                        $url = 'http://translate.google.com/translate_tts?ie=UTF-8&tl=pt-br&q=' . urlencode($virgula);
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

                // Se o texto tiver menos de 100 caracteres grava a narração
            } else {
                // Gera o arquivo de narrativa no servidor
                $url = 'http://translate.google.com/translate_tts?ie=UTF-8&tl=pt-br&q=' . urlencode($frase);
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
    }
    // Imprime o player na tela.
    /*echo ('
        <audio autoplay="autoplay" controls="controls">
        <source src="' . $file . '" type="audio/mp3" />
        </audio>'
    );*/
}
