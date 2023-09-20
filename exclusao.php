<?php
function conectaBD() {
    $pdo = new PDO("mysql:host=143.106.241.3;dbname=cl201240;charset=utf8", "cl201240", "cl*06112005");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function listarRoedores() {
    try {
        $pdo = conectaBD();
        $stmt = $pdo->query("SELECT id, nome FROM Roedores");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function excluirRoedor($id) {
    try {
        $pdo = conectaBD();
        $stmt = $pdo->prepare("DELETE FROM Roedores WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['excluir'])) {
    $roedor_id = $_POST['excluir'];
    if (excluirRoedor($roedor_id)) {
        $mensagem = "Roedor excluído com sucesso!";
    } else {
        $mensagem = "Falha ao excluir o roedor.";
    }
}

$roedores = listarRoedores();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusão de Roedores</title>
    <style>
    </style>
</head>
<body>
    <h1>Exclusão de Roedores</h1>
    <div class="container">
        <?php if ($roedores) : ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Excluir</th>
                </tr>
                <?php foreach ($roedores as $roedor) : ?>
                    <tr>
                        <td><?php echo $roedor['id']; ?></td>
                        <td><?php echo $roedor['nome']; ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="excluir" value="<?php echo $roedor['id']; ?>">
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>Nenhum roedor cadastrado.</p>
        <?php endif; ?>

        <?php if (isset($mensagem)) : ?>
            <p><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <br>
        <a href="index.php">Voltar para a Página Inicial</a>
    </div>
</body>
</html>
