<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Voz da Notícia</title>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
        <link rel="stylesheet" href="css/mobile.css" />
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
    </script>
</head>
<body>
    <div data-role="page">
        <div data-role="header" data-position="fixed">
            <h1>Voz da Notícia</h1>
        </div><!-- /header -->

        <div role="main" class="ui-content" style="text-align: center">
            <img src="vozdanoticia.png" class="img-responsive img-center" />
            <div class="ui-body ui-body-a ui-corner-all" style="max-width: 1024px;margin: 35px auto auto auto;">
                <h2>Bem-vindo ao Voz da Notícia.</h2>
                <p style="text-align: left">Este sistema foi desenvolvido para ajudar pessoas com deficiência visual a ficarem atualizadas sobre tudo que acontece ao seu redor e por todo o mundo.</p>
                <p style="text-align: left">Para começar, é obrigatório que se utilize um microfone para interagir com o sistema. Além disso, para escutar o que o sistema fala, é obrigatório a utilização de uma saída de áudio, como uma caixa de som ou um fone de ouvido.</p>
                <button class="ui-btn iniciar">Para iniciar aperte qualquer tecla ou aperte aqui.</button>
            </div>
            <div class="ui-body ui-body-a ui-corner-all" style="max-width: 1024px;margin: 35px auto auto auto;">
                <h4>Log de comandos falados</h4>
                <p id="resultado" style="max-height: 100px; overflow: auto;"></p>
            </div>
            <div id="audio" style="display: none;">

            </div>
        </div><!-- /content -->

        <?php
        //require_once 'tts.php';
        //tts('Iniciar o Voz da Notícia', 'iniciar');
        ?>

        <div data-role="footer" data-position="fixed">
            <h2>Desenvolvido por Marcelo Aires Vieira</h2>
        </div><!-- /footer -->
    </div><!-- /page -->
    <script type="text/javascript">
        if (!('webkitSpeechRecognition' in window)) { // se nao eh compativel
			$('#audio').html('<audio style="display:none" autoplay="autoplay" controls="controls"><source src="/audio/nao_suportado.mp3" type="audio/mp3" /></audio>');
        } else { // se eh compativel
            $('#audio').html('<audio style="display:none" autoplay="autoplay" controls="controls"><source src="/audio/bem_vindo.mp3" type="audio/mp3" /></audio>');
        }

        var inicio = true; // controle do inicio
        var categoria = 0;
        var qtd = 0; // quantidade de noticias no array
		var controle = 0; // variavel de controle de qual noticia esta
		var noticias = new Array(); // array de noticias
        var recognition = new webkitSpeechRecognition(); // api Speech

        recognition.continuous = true; // seta para ser continuo
        recognition.interimResults = true; // seta para formar palavras inteiras
        recognition.lang = 'pt-BR'; // seta a lingua (portugues-brasileira)

		// funcao da api Speech
        recognition.onresult = function(event) {
            var interim_transcript = '';
            var final_transcript = '';

            for (var i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    final_transcript += event.results[i][0].transcript;
                    reconhecimento(final_transcript); // metodo que reconhece o que fala com as palavras padroes

                    $('#resultado').append(final_transcript + '<br />');
                }
            }
        };

        function reconhecimento(text) {
            // falou para escutar
            if (
                    text.indexOf('escut') >= 0 ||
                    text.indexOf('li') >= 0 ||
                    text.indexOf('le') >= 0 ||
                    text.indexOf('lê') >= 0
                    ) {
                escolha = 'escutar';
            }
            // falou proxima
            else if (
                    text.indexOf('prox') >= 0 ||
                    text.indexOf('próx') >= 0 ||
                    text.indexOf('outra') >= 0
                    ) {
                escolha = 'proxima';
            }
            // falou menu
            else if (
                    text.indexOf('menu') >= 0 ||
                    text.indexOf('principal') >= 0
                    ) {
                escolha = 'menu';
            }
            // falou inicio
            else if (
                    text.indexOf('inici') >= 0 ||
                    text.indexOf('iníci') >= 0
                    ) {
                escolha = 'inicio';
            }
            // falou a categoria esporte
            else if (
                    text.indexOf('esport') >= 0 ||
                    text.indexOf('sport') >= 0
                    ) {
                escolha = 'esporte';
            }
            // falou a categoria fofoca
            else if (
                    text.indexOf('fofoca') >= 0 ||
                    text.indexOf('celebridades') >= 0
                    ) {
                escolha = 'fofoca';
            }
            // falou a categoria educacao
            else if (
                    text.indexOf('educac') >= 0
                    ) {
                escolha = 'educacao';
            }
            // falou todas
            else if (
                    text.indexOf('todas') >= 0 ||
                    text.indexOf('tudo') >= 0 ||
                    text.indexOf('todos') >= 0
                    ) {
                escolha = 'todas';
            }
            // falou repita
            else if (
                    text.indexOf('repita') >= 0 ||
                    text.indexOf('repete') >= 0 ||
                    text.indexOf('novamente') >= 0
                    ) {
                escolha = 'repita';
            }
            // falou para parar
            else if (
                    text.indexOf('para') >= 0 ||
					text.indexOf('pará') >= 0 ||
					text.indexOf('pare') >= 0 ||
					text.indexOf('pausar') >= 0 ||
					text.indexOf('stop') >= 0 ||
					text.indexOf('pause') >= 0
                    ) {
                escolha = 'parar';
            }
            // falou para continuar
            else if (
                    text.indexOf('conti') >= 0 ||
					text.indexOf('play') >= 0
                    ) {
                escolha = 'continuar';
            }

			switch (escolha) {
                // categorias
                case 'esporte':
                    categoria = 1;
                    pegaNoticias(categoria);
                    lerTitulo();
                    break;
                case 'educacao':
                    categoria = 2;
                    pegaNoticias(categoria);
                    lerTitulo();
                    break;
                case 'fofoca':
                    categoria = 3;
                    pegaNoticias(categoria);
                    lerTitulo();
                    break;
                case 'todas':
                    categoria = 0;
                    pegaNoticias(categoria);
                    lerTitulo();
                    break;
                    
                // comandos
				case 'escutar':
					lerNoticia();
					break;
                case 'proxima':
					controle++;
					if (controle >= qtd) {
						pegaNoticias();
					}
					menu();
					break;
				case 'repita':
					lerTitulo();
					break;

                // extras
				case 'parar':
					$('#audio audio').trigger('pause'); // pausa o audio
					recognition.stop();
					break;
				case 'continuar':
					$('#audio audio').trigger('play'); // pausa o audio
					recognition.stop();
					break;
				case 'menu':
					menu();
					break;
				case 'inicio':
					controle = 0;
					menu();
					break;


				default:
					$('#audio').html('<audio style="display:none" onended="menu()" autoplay="autoplay" controls="controls"><source src="/audio/nao_entendi.mp3" type="audio/mp3" /></audio>');
					break;
			}

        }

        // inicio da aplicacao
        $(window).on('keyup', function(){
            if (inicio) {
                $('#audio').html('<audio style="display:none" onended="menu();" autoplay="autoplay" controls="controls"><source src="/audio/dica1.mp3" type="audio/mp3" /></audio>');
                inicio = false;
            } else {
				recognition.start();
			}
        });
        $('.iniciar').on('click',function(){
            if (inicio) {
                $('#audio').html('<audio style="display:none" onended="menu()" autoplay="autoplay" controls="controls"><source src="/audio/dica1.mp3" type="audio/mp3" /></audio>');
                inicio = false;
            } else {
				recognition.start();
			}
        });

		// no menu vai ler os titulos da noticia, por isso chama o primeiro titulo
		function menu() {
			categorias();
		}

        function categorias() {
            // zera a quantidade de noticias e o array
            qtd = 0;
            noticias = [];
            
            setTimeout(function(){
				$('#audio').html('<audio style="display:none" autoplay="autoplay" controls="controls"><source src="/audio/esportes.mp3" type="audio/mp3" /></audio>');
			}, 500);
            setTimeout(function(){
				$('#audio').html('<audio style="display:none" autoplay="autoplay" controls="controls"><source src="/audio/educacao.mp3" type="audio/mp3" /></audio>');
			}, 9500);
            setTimeout(function(){
				$('#audio').html('<audio style="display:none" autoplay="autoplay" controls="controls"><source src="/audio/fofocas.mp3" type="audio/mp3" /></audio>');
			}, 18500);
            setTimeout(function(){
				$('#audio').html('<audio style="display:none" autoplay="autoplay" controls="controls"><source src="/audio/todas.mp3" type="audio/mp3" /></audio>');
			}, 27500);
        }

		// escolha se quer ler ou proxima
		function escolhaNoticia() {
			setTimeout(function(){
				$('#audio').html('<audio style="display:none" autoplay="autoplay" controls="controls"><source src="/audio/titulo_fim.mp3" type="audio/mp3" /></audio>');
			}, 500);
		}

		// escolha se quer ler novamente, proxima ou voltar ao inicio
		function escolhaTerminoNoticia() {
			setTimeout(function(){
				$('#audio').html('<audio style="display:none" autoplay="autoplay" controls="controls"><source src="/audio/noticia_fim.mp3" type="audio/mp3" /></audio>');
			}, 500);
		}

		// pega as noticias no banco e adiciona
		function pegaNoticias(categoria) {
			$.getJSON('pegaNoticias.php', {'inicio':qtd, 'noticias':'njsh3ha5^8$32jgvxhs', 'categoria':categoria}, function(data){ // trazer no data: titulo, arquivoTitulo e arquivoConteudo
				$.each(data, function(chave, valor){
					noticias.push([valor.titulo, valor.arquivoTitulo, valor.arquivoConteudo]);
					qtd++;
				});
			});
		}

		// ler o titulo da noticia atual
		function lerTitulo() {
			recognition.stop();
			setTimeout(function(){
				$('#audio').html('<audio style="display:none" onended="escolhaNoticia()" autoplay="autoplay" controls="controls"><source src="/audio/' + noticias[controle][1] + '.mp3" type="audio/mp3" /></audio>');
			}, 500);
		}

		// ler o conteudo da noticia atual
		function lerNoticia() {
			recognition.stop();
			$('#audio').html('<audio style="display:none" onended="escolhaTerminoNoticia()" autoplay="autoplay" controls="controls"><source src="/audio/' + noticias[controle][2] + '.mp3" type="audio/mp3" /></audio>');
		}
    </script>
</body>
</html>
