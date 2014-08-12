<?php
include_once 'includes/conexao.php';

// inicia a sessao
session_start();

if ( isset($_POST['usuario']) && isset($_POST['senha']) && empty($_SESSION['login']) ) {
    $erro = false;
    
    // Filtra e guarda os dados de login
    $usuario = addslashes($_POST['usuario']);
    $senha = md5(addslashes($_POST['senha']));

    // Consulta os dados e verifica se existe um usuario com os dados passados
    $sql = "SELECT id, nome FROM `usuarios` WHERE `usuario` = '" . $usuario . "' && senha = '" . $senha . "' LIMIT 1";
    $query = mysql_query($sql);
    $resultado = mysql_fetch_assoc($query);
    // fecha a conexao com o banco de dados
    mysql_close($conect);
    // Verifica se encontrou algum registro
    if ( empty($resultado) ) {
        $erro = true; // mostra erro de usuario ou senha incorretos
        unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['login']);
    } else {
        
        // Definimos dois valores na sessão com os dados do usuário
        $_SESSION['usuarioID'] = $resultado['id'];
        $_SESSION['usuarioNome'] = $resultado['nome'];
        
        // Definimos uma string para identificar o login nas outras paginas
        $_SESSION['login'] = 'mfaldkfadnfhfa70324bf96$%^*82rdnadflkueqo,.0975hjv35g8964#$6';
        
        // Se tudo deu certo, redireciona para a tela principal do administrador
        header("Location: adm.php");
    }
} else {
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['login']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Voz da Notícia</title>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
        <link rel="stylesheet" href="css/mobile.css" />
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
    </script>
</head>
<body>    
    <div data-role="page" data-theme="a" id="index">
        <div data-role="header" data-position="fixed">
            <h1>Login</h1>
        </div><!-- /header -->

        <div role="main" class="ui-content">
            <div class="ui-corner-all" style="max-width: 430px; margin-left: auto; margin-right: auto;">
                <div class="ui-bar ui-bar-a">
                    <h3>Digite nos campos abaixo os seus dados de acesso</h3>
                </div>
                <div class="ui-body ui-body-a">
                    <form method="post" action="login.php" data-ajax="false">
                        <div class="ui-field-contain">
                            <label for="usuario">Usuário:</label>
                            <input type="text" name="usuario" id="usuario" required="required" placeholder="Digite seu usuário" value="">
                        </div>
                        <div class="ui-field-contain">
                            <label for="senha">Senha:</label>
                            <input type="password" name="senha" id="senha" required="required" placeholder="Digite sua senha" value="">
                        </div>
                        <input type="submit" value="Entrar" >
                    </form>
                </div>
                <?php if (!empty($erro)) { ?>
                <div class="ui-bar" style="background-color: #fff; text-shadow: none;color: crimson;text-align: center;">
                    <h5>Ops! Os dados digitados estão incorretos.</h5>
                </div>
                <?php } ?>
            </div>
        </div><!-- /content -->

        <div data-role="footer" data-position="fixed">
            <h4 style="text-align: right;">Desenvolvido por Marcelo Aires Vieira</h4>
        </div><!-- /footer -->
    </div><!-- /page -->
</body>
</html>