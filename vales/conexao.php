<?php

// criar constante para amarzenar as informações de acesso ao banco de dados//
define ("DB_HOST","localhost");
define ("DB_USER","root");
define ("DB_PASS","");
define ("DB_NAME","cadastro");
define ("DB_PORT",3306);

/**
 * Abre uma conexao com o banco de dados e retornaum objeto de conexao 
 * @return mysqli que é o objeto de conexao 
 */
function abrirbanco(){
    $conexaoComBanco = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT );

    //verificar se ocorreu algum erro durante a conexao
    if ($conexaoComBanco->connect_error) {
        die("falha na conexão: ". $conexaoComBanco->connect_error);

    }

    return $conexaoComBanco;
}
function fecharBanco($conexaoComBanco) {
    $conexaoComBanco->close();
}

?>
