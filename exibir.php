<?php
function conectaBD() {
    $pdo = new PDO("mysql:host=143.106.241.3;dbname=cl201240;charset=utf8", "cl201240", "cl*06112005");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function listarRoedores() {
    try {
        $pdo = conectaBD();

        $stmt = $pdo->query("SELECT nome, imagem FROM Roedores");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

$roedores = listarRoedores();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibição de Roedores</title>
    <style>
    </style>
</head>
<body>
    <h1>Exibição de Roedores</h1>
    <div class="container">
        <?php if ($roedores) : ?>
            <div class="roedores">
                <?php foreach ($roedores as $roedor) : ?>
                    <div class="roedor">
                        <img src="uploads/<?php echo $roedor['imagem']; ?>" alt="<?php echo $roedor['nome']; ?>" width="100">
                        <p><?php echo $roedor['nome']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>Nenhum roedor cadastrado.</p>
        <?php endif; ?>

        <br>
        <a href="index.php">Voltar para a Página Inicial</a>
    </div>
</body>
</html>
