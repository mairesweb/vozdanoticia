<?php

//conexão com o servidor
$conect = mysqli_connect("localhost", "mairesco_vdn", "PfUGeqtg3bxY", "maires_vozdanoticia");
 
// Caso a conexão seja reprovada, exibe na tela uma mensagem de erro
if (!$conect) die ("<h1>Falha na conexao com o Banco de Dados!</h1>");