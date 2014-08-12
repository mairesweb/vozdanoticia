<?php
    include_once 'includes/verificaSessao.php';
    include_once 'includes/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aministrador - Voz da Notícia</title>
        <link rel="stylesheet" href="/css/jquery.mobile.css" />
        <link rel="stylesheet" href="/css/mobile.css" />
        <script src="/js/jquery.min.js"></script>
        <script src="/js/jquery.mobile.js"></script>
    </script>
</head>
<body>    
    <div data-role="page" data-theme="a" id="index">
        <div data-role="header">
            <a href="#painelI" title="Menu" class="ui-shadow-icon ui-btn ui-shadow ui-corner-all ui-icon-bars ui-btn-icon-left ui-btn-icon-notext"></a>
            <h1>Administrador</h1>
            <a href="login.php" data-ajax="false" title="Sair" class="ui-shadow-icon ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-right ui-btn-icon-notext"></a>
            <div data-role="navbar">
                <ul>
                    <li><a href="#index" class="ui-btn-active">Início</a></li>
                    <li><a href="#noticias" class="show-page-loading-msg" data-textonly="false" data-textvisible="true" data-msgtext="" data-inline="true">Notícias</a></li>
                    <li><a href="#usuarios">Usuários</a></li>
                </ul>
            </div><!-- /navbar -->
        </div><!-- /header -->

        <div data-role="panel" id="painelI" data-theme="b" data-display="push">
            <h2 style="text-align: center;margin-top: 0;">Menu</h2>
            <ul data-role="listview">
                <li><a href="#index">Início</a></li>
                <li><a href="#noticias">Notícias</a></li>
                <li><a href="#usuarios">Usuários</a></li>
            </ul>
        </div><!-- /panel -->

        <div role="main" class="ui-content">
            <div class="ui-corner-all custom-corners">
                <div class="ui-bar ui-bar-a">
                    <h3>Acessibilidade do Administrador</h3>
                </div>
                <div class="ui-body ui-body-a">
                    <div class="ui-grid-b">
                        <div class="ui-block-a"><div class="button-wrap"><button class="diminuirFonte ui-shadow ui-btn ui-corner-all">Diminuir Fonte</button></div></div>
                        <div class="ui-block-b"><div class="button-wrap"><button class="fonteNormal ui-shadow ui-btn ui-corner-all">Fonte Normal</button></div></div>
                        <div class="ui-block-c"><div class="button-wrap"><button class="aumentarFonte ui-shadow ui-btn ui-corner-all">Aumentar Fonte</button></div></div>
                    </div>
                    <div class="ui-grid-b">
                        <button class="ui-shadow ui-btn ui-corner-all" id="altoContraste">Alto Contraste</button>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                var tamanhoNormal = [];
                var a = 0;
                $('body *').not('.ui-icon-bars').each(function(i){
                    console.log($(this));
                    tamanhoNormal[a] = $(this).css('font-size');
                    a++;
                });
                
                $('.diminuirFonte').on('click', function(){
                    $('body *').not('script, .ui-icon-bars').each(function(i){
                        var t = $(this).css('font-size');
                        t = t.replace('px', '');
                        t = parseInt(t) - 1.4;
                        $(this).animate({'font-size': t + 'px'});
                    });
                });
                
                $('.aumentarFonte').on('click', function(){
                    $('body *').not('.ui-icon-bars').each(function(i){
                        var t = $(this).css('font-size');
                        t = t.replace('px', '');
                        t = parseInt(t) + 1.4;
                        $(this).animate({'font-size': t + 'px'});
                    });
                });
                
                $('.fonteNormal').on('click', function(){
                    var a = 0;
                    $('body *').each(function(i){
                        var t = tamanhoNormal[a];
                        t = t.replace('px', '');
                        $(this).animate({'font-size': t + 'px'});
                        a++;
                    });
                });
				
				$("#altoContraste").on('click', function(){
					
				});
            </script>
        </div><!-- /content -->

        <div data-role="footer" data-position="fixed">
            <h4 style="text-align: right;">Desenvolvido por Marcelo Aires Vieira</h4>
        </div><!-- /footer -->
    </div><!-- /page -->

    <div data-role="page" data-theme="a" id="noticias">
        <div data-role="header">
            <a href="#painelN" title="Menu" class="ui-shadow-icon ui-btn ui-shadow ui-corner-all ui-icon-bars ui-btn-icon-left ui-btn-icon-notext"></a>
            <h1>Notícias</h1>
            <a href="login.php" title="Sair" class="ui-shadow-icon ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-right ui-btn-icon-notext"></a>
            <div data-role="navbar">
                <ul>
                    <li><a href="#index">Início</a></li>
                    <li><a href="#noticias" class="ui-btn-active">Notícias</a></li>
                    <li><a href="#usuarios">Usuários</a></li>
                </ul>
            </div><!-- /navbar -->
        </div><!-- /header -->

        <div data-role="panel" id="painelN" data-theme="b" data-display="push">
            <h2 style="text-align: center;margin-top: 0;">Menu</h2>
            <ul data-role="listview">
                <li><a href="#index">Início</a></li>
                <li><a href="#noticias">Notícias</a></li>
                <li><a href="#usuarios">Usuários</a></li>
            </ul>
        </div><!-- /panel -->

        <div role="main" class="ui-content">
            <div data-role="collapsible" data-collapsed="false" data-iconpos="right">
                <h4>Cadastrar notícia</h4>
                <h4 class="ui-bar ui-bar-a ui-corner-all" id="cadastroNoticia" style="display: none;background-color: green;color: #fff;text-shadow:none;text-align: center;">Cadastrado com sucesso!</h4>
                <form id="form-noticias" action="#">
                    <div class="ui-field-contain">
                        <label for="titulo">Título:</label>
                        <input type="text" name="titulo" maxlength="150" required="required" id="titulo" placeholder="Digite o título da notícia" value="">
                    </div>
                    <div class="ui-field-contain">
                        <label for="conteudo">Conteúdo:</label>
                        <textarea cols="40" rows="2" maxlength="65536" name="conteudo" required="required" id="conteudo" placeholder="Digite o conteúdo da notícia"></textarea>
                    </div>
                    <div class="ui-field-contain">
                        <label for="fonte">Fonte:</label>
                        <input type="text" name="fonte" maxlength="100" id="fonte" placeholder="Digite a fonte da notícia" value="">
                    </div>
                    <div class="ui-field-contain">
                        <label for="palavras">Palavras-chave:</label>
                        <input type="text" name="palavras" maxlength="100" required="required" id="palavras" placeholder="Digite as palavras-chave da notícia" value="">
                    </div>
					<div class="ui-field-contain">
                        <label for="categoria">Categoria:</label>
                        <select name="categoria" id="categoria" required="required">
							<option value="0">Escolha a categoria</option>
							<option value="1">Esporte</option>
							<option value="2">Educação</option>
							<option value="3">Fofocas</option>
							<option value="0">Outra</option>
						</select>
                    </div>
                    <input type="submit" value="Enviar">
                </form>
            </div><br />
            <div data-role="collapsible" data-iconpos="right">
                <h4>Notícias Cadastradas</h4>
                <ul data-role="listview" id="listaNoticias" data-filter="true" data-filter-placeholder="Procurar notícia..." data-inset="true">
                    <?php
                    $sql = "SELECT noticias.id, noticias.titulo, noticias.arquivoTitulo, categorias.nome FROM noticias INNER JOIN categorias ON categorias.id = noticias.categoria ORDER BY id DESC";
                    $query = $conect->query($sql);
                    while ($res = mysqli_fetch_array($query)) {
                    ?>
                    <li id="n<?=$res['id'];?>">
                        <button style="float: right" class="apagaNoticia ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-delete ui-btn-icon-notext"></button>
                        <h3>Título: <?= $res['titulo'];?></h3>
                        <p><audio controls src="audio/<?= $res['arquivoTitulo'] . '.mp3';?>"></p>
							<p>Categoria: <?= $res['nome'];?></p>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <script type="text/javascript">
                $("#form-noticias").submit(function(){
                    $.ajax({dataType: 'json', type: 'POST', url: 'noticias.php',data: {'titulo':$('#titulo').val(), 'conteudo':$('#conteudo').val(), 'fonte':$('#fonte').val(), 'palavras':$('#palavras').val(), 'categoria':$('#categoria').val()}, success: function(data, status, xhr){
                        if (data.status == 'sucesso') {
                            $('#titulo').val('');
                            $('#conteudo').val('');
                            $('#fonte').val('');
                            $('#palavras').val('');
							$('#categoria').val('0');
                            $('#cadastroNoticia').slideDown(500).focus();
							
							$('#listaNoticias').prepend('<li id="n' + data.id + '">'
                                    + '<h3>Título: ' + data.titulo + '</h3>'
                                    + '<p><audio controls src="audio/' + data.arquivoTitulo + '.mp3"></p>'
                            + '</li>');
                            $('#listaNoticias').listview('refresh');
							
                            setTimeout(function(){
                                $('#cadastroNoticia').slideUp(500);
                            }, 5000);
                        }
                    }});
                    return false;
                });
                
                $('.apagaNoticia').on('click', function(){
                    var li = $(this).parent('li');
                    var id = $(this).parent('li').attr('id').substr(1);
                    
                    $.getJSON('noticias.php', {'apagar':true, 'id':id}, function(data){
                        li.slideUp(500);
                    });
                });
            </script>
        </div><!-- /content -->

        <div data-role="footer" data-position="fixed">
            <h4 style="text-align: right;">Desenvolvido por Marcelo Aires Vieira</h4>
        </div><!-- /footer -->
    </div><!-- /page -->

    <div data-role="page" data-theme="a" id="usuarios">
        <div data-role="header">
            <a href="#painelU" title="Menu" class="ui-shadow-icon ui-btn ui-shadow ui-corner-all ui-icon-bars ui-btn-icon-left ui-btn-icon-notext"></a>
            <h1>Usuários</h1>
            <a href="login.php" title="Sair" class="ui-shadow-icon ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-right ui-btn-icon-notext"></a>
            <div data-role="navbar">
                <ul>
                    <li><a href="#index">Início</a></li>
                    <li><a href="#noticias">Notícias</a></li>
                    <li><a href="#usuarios" class="ui-btn-active">Usuários</a></li>
                </ul>
            </div><!-- /navbar -->
        </div><!-- /header -->

        <div data-role="panel" id="painelU" data-theme="b" data-display="push">
            <h2 style="text-align: center;margin-top: 0;">Menu</h2>
            <ul data-role="listview">
                <li><a href="#index">Início</a></li>
                <li><a href="#noticias">Notícias</a></li>
                <li><a href="#usuarios">Usuários</a></li>
            </ul>
        </div><!-- /panel -->

        <div role="main" class="ui-content">
            <div data-role="collapsible" data-iconpos="right">
                <h4>Cadastrar usuário</h4>
                <h4 class="ui-bar ui-bar-a ui-corner-all" id="cadastroUsuario" style="display: none;background-color: green;color: #fff;text-shadow:none;text-align: center;">Cadastrado com sucesso!</h4>
                <form id="form-usuarios">
                    <div class="ui-field-contain">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" pattern="[a-zA-Z ]*" maxlength="50" required="required" placeholder="Digite o nome do usuário" value="">
                    </div>
                    <div class="ui-field-contain">
                        <label for="usuario">Usuário:</label>
                        <input type="text" name="usuario" id="usuario" maxlength="50" required="required" placeholder="Digite o apelido para acessar o sistema" value="">
                    </div>
                    <div class="ui-field-contain">
                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha" maxlength="50" required="required" placeholder="Digite uma senha para o usuário" value="">
                    </div>
                    <div class="ui-field-contain">
                        <label for="tipo">Administrador:</label>
                        <input type="checkbox" data-role="flipswitch" value="1" data-on-text="Sim" data-off-text="Não" name="tipo" id="tipo">
                    </div>
                    <input type="submit" value="Enviar">
                </form>
            </div><br />
            <div data-role="collapsible" data-collapsed="false" data-iconpos="right">
                <h4>Usuários Cadastrados</h4>
                <ul data-role="listview" id="listaUsuarios" data-filter="true" data-filter-placeholder="Procurar usuário..." data-inset="true">
                    <?php
                    $sql = "SELECT * FROM usuarios ORDER BY id DESC";
                    $query = $conect->query($sql);
                    while ($res = mysqli_fetch_array($query)) {
                    ?>
                    <li id="u<?=$res['id'];?>">
                        <button style="float: right" class="apagaUsuario ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-delete ui-btn-icon-notext"></button>
                        <!--button style="float: right" class="editaUsuario ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-edit ui-btn-icon-notext"></button-->
                        <h3>Nome: <?= $res['nome'];?></h3>
                        <p>Usuário: <?= $res['usuario'];?></p>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <script type="text/javascript">
                $("#form-usuarios").submit(function(){
                    $.getJSON('usuarios.php',{'nome':$('#nome').val(), 'usuario':$('#usuario').val(), 'senha':$('#senha').val(), 'tipo':$('#tipo').val()}, function(data){
                        if (data.status == 'sucesso') {
                            // limpa os campos
                            $('#nome').val('');
                            $('#usuario').val('');
                            $('#tipo').val('');
                            
                            // mostra mensagem de sucesso
                            $('#cadastroUsuario').slideDown(500).focus();
                            
                            $('#listaUsuarios').prepend('<li id="u' + data.id + '">'
                                    + '<h3>Nome: ' + data.nome + '</h3>'
                                    + '<p>Usuário: ' + data.usuario + '</p>'
                            + '</li>');
                            $('#listaUsuarios').listview('refresh');
                            
                            // esconde mensagem de sucesso
                            setTimeout(function(){
                                $('#cadastroUsuario').slideUp(500);
                            }, 5000);
                        }
                    });
                    return false;
                });
                
                $('.apagaUsuario').on('click', function(){
                    var li = $(this).parent('li');
                    var id = $(this).parent('li').attr('id').substr(1);
                    
                    $.getJSON('usuarios.php', {'apagar':true, 'id':id}, function(data){
                        li.slideUp(500);
                    });
                });
            </script>
        </div><!-- /content -->

        <div data-role="footer" data-position="fixed">
            <h4 style="text-align: right;">Desenvolvido por Marcelo Aires Vieira</h4>
        </div><!-- /footer -->
    </div><!-- /page -->
</body>
</html>