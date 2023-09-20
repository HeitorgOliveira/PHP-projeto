<?php
include("bd.php");
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
     // 2 Mb
    define('MAX_SIZE', (2 * 1024 * 1024));
    $nome = $_POST["nome"];
    $imagem = $_FILES["imagem"];
    $imagem_nome = $imagem["name"];
    $imagem_tmp = $imagem["tmp_name"];
    $imagem_tamanho = $imagem["size"];
    $tipo_imagem = $imagem["type"];

    if (empty($nome))
    {
        echo "<span>Campo nome não pode estar vazio</span><br>";
    }
    if ($imagem_tamanho > MAX_SIZE)
    {
        echo "<span>Tamanho máximo: 2Mb</span><br>";
    }
    if (!preg_match('/^image\/(jpg|jpeg|png|gif)$/', $tipo_imagem))
    {
        echo "<span>Formato inválido</span><br>";
    }
    else{
        cadastrarRoedor($nome, $imagem_nome, $imagem_tmp);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Roedores</title>
    <style>
    </style>
</head>
<body>
    <h1>Cadastro de Roedores</h1>
    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <label for="Nome">Nome:</label>
            <input type="text" name="nome">
            <label for="Imagem:">Imagem:</label>
            <input type="file" id="imagem" name="imagem" accept="image/gif, image/png, image/jpeg, image/jpg"><br><br>
            <hr>
            <input type="submit" value="Cadastrar Roedor">
        </form>

        <?php
        if (isset($resultado)) {
            echo "<p>$resultado</p>";
        }
        ?>
    </div>
    <a href="index.html">Voltar para a Página Inicial</a>
</body>
</html>
