<?php
function conectaBD() {
    $pdo = new PDO("mysql:host=143.106.241.3;dbname=cl201240;charset=utf8", "cl201240", "cl*06112005");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function cadastrarRoedor($nome, $imagem_nome, $imagem_tmp) {
    try {
        $pdo = conectaBD();

        $stmt = $pdo->prepare("SELECT * FROM Roedores WHERE nome = :nome");
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Roedor com o mesmo nome já existe no banco de dados.";
        }

        $stmt = $pdo->prepare("INSERT INTO Roedores (nome, imagem) VALUES (:nome, :imagem)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':imagem', $imagem_nome);
        $stmt->execute();

        $upload_dir = 'uploads/';
        $imagem_destino = $upload_dir . $imagem_nome;

        if (move_uploaded_file($imagem_tmp, $imagem_destino)) {
            return "Roedor cadastrado com sucesso!";
        } else {
            return "Falha ao mover a imagem para o servidor.";
        }
    } catch (PDOException $e) {
        return "ERRO: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $nome = $_POST["nome"];
    $imagem_nome = $_FILES["imagem"]["name"];
    $imagem_tmp = $_FILES["imagem"]["tmp_name"];

    $resultado = cadastrarRoedor($nome, $imagem_nome, $imagem_tmp);
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
</body>
</html>
