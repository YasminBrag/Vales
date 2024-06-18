<?php
include'conexao.php';

// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";
// exit;

//capturar os dados digitalizados no form e salva em variaveis
//para facilitar a manipulação dos dados

if($_SERVER['REQUEST_METHOD'] == "POST"){
   $descricao = $_POST['descricao'];
   $data_vale = $_POST['data_vale'];
   $valor = $_POST['valor'];
   

   //vamos abrir a conexao com o banco de dados
   $conexaoComBanco = abrirbanco();


   //vamos criar o SQL para realizar o insert dos dados
   $sql = "INSERT INTO vales
   (descricao,valor,data_do_vale)
   VALUES
   ('$descricao','$valor','$data_vale')"; 

   IF ($conexaoComBanco->query($sql) === TRUE ) {
    echo ":) sucesso ao cadastrar o contato :)";
    header("location:index.php"); 
    } else {
        echo ":( Erro ao cadastrar o contato :(";
    }

    fecharBanco($conexaoComBanco);

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit;

}

/*
excluir vale

*/

if(isset ($_GET['acao']) && $_GET['acao'] == 'excluir') {
   
    $id = $_GET['id'];
  
    if ($id > 0) {
      //abrir a conexão com o banco
      $conexaoComBanco = abrirBanco();
      //preparar um sql de exclusão
      $sql = "DELETE FROM vales WHERE id = $id";
      //executar comando no banco 
      if ($conexaoComBanco->query($sql)=== TRUE){
          echo "<script>alert ('Vale excluido com sucesso!')</script>";  
          header("location:index.php");    
      } else{
          echo "Erro ao tentar  excluido o Vale! :(";
      }
    }
    fecharBanco($conexaoComBanco);
  }

/*

fim excluir vale
*/









?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>agenda</title>
    <link rel="stylesheet" href="cadastrar.css">
</head>

<body>

<section>
    <h1>Gerenciar Vales</h1>

    <hr>
    <h2>Cadastrar Vales</h2>
<!-- action = envio,  method = metodo de envio -->
    <form action="" method="POST" enctype="multipart/form-data">

        <label for = "descricao">Descrição</label>
        <input type="text" id="descricao" name="descricao" required>

        <label for = "data_vale">Data do Vale</label>
        <input type="date" id="data_vale" name="data_vale" required>

        <label for = "valor"> Valor</label>
        <input type="text" id="valor" name="valor" required>

        <button type="submit">Cadastrar</button>

        </form>
    </section>


    <section>
    <table border="1">
            <thead>
                <tr>
                    <td>data de cadastro</td>
                    <td>data do vale</td>
                    <td>Descrição</td>
                    <td>valor</td>
                    <td>ações</td>
                  
                </tr>
            </thead>
            <tbody>
                <?php
                //abrir a conexao com o banco de dados
                $conexaoComBanco = abrirbanco();
                //Preparar a consulta SQL para selecionar dados no BD
                $sql = "SELECT id, descricao, valor, data_do_vale, atualizado_em, criado_em
                From vales";
                
                // executar o query (o SQL do banco)
                $result = $conexaoComBanco->query($sql);

                // echo "<pre>";
                // print_r($registros);
                // echo "</pre>";
                // exit;
                //$registros = $result->fetch_assoc();
                //verificar se a query retornou registros
                if ($result->num_rows > 0) {
                    //ha registro no banco
                    while ($registro = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?= date("d/m/Y", strtotime($registro['atualizado_em'])) ?></td>
                            <td><?= date("d/m/Y", strtotime($registro['data_do_vale'])) ?></td>
                            <td><?= $registro['descricao'] ?></td>
                            <td><?= $registro['valor'] ?></td>
                            <td>
                                <a href="editar.php?acao=editar&id=<?= $registro['id'] ?>"><button>Editar</button></a>
                                <a href="?acao=excluir&id=<?= $registro['id']?>"
                                onclick="return confirm('tem certezaque deseja excluir');"><button>Excluir</button></a>
                            </td>
                        </tr>
                    <?php

                    }
                } else {
                    ?>
                    <!-- nao tem registro no banco -->

                    <tr>
                        <td colspan='7'>Nenhum Resgistro no banco de dados</td>
                    </tr>
                <?php
                }


                //criar um laço de repetição para preencher a tabela
                ?>

            </tbody>
        </table>
    </section>


</body>

</html>