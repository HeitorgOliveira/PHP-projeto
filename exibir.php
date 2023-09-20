<?php
function conectaBD() {
    $pdo = new PDO("mysql:host=143.106.241.3;dbname=cl201240;charset=utf8", "cl201240", "cl*06112005");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function listarRoedores($filtro = "") {
    try {
        $pdo = conectaBD();

        // Consultar roedores com base no filtro de nome
        $sql = "SELECT nome, imagem FROM Roedores";
        if (!empty($filtro)) {
            $sql .= " WHERE nome LIKE :filtro";
        }

        $stmt = $pdo->prepare($sql);

        if (!empty($filtro)) {
            $filtro = '%' . $filtro . '%';
            $stmt->bindParam(':filtro', $filtro);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

$roedores = listarRoedores();

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $filtro = $_POST["filtro"];
    $roedores = listarRoedores($filtro);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibição de Roedores</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Estilos CSS semelhantes aos usados anteriormente */
    </style>
</head>
<body>
    <a href="index.html">Início</a>
    <h1>Exibição de Roedores</h1>
    <div class="container">
        <form method="POST" id="formBusca">
            <label for="filtro">Buscar Roedor por Nome:</label>
            <input type="text" name="filtro" id="filtro">
        </form>

        <div class="roedores">
            <?php if ($roedores) : ?>
                <?php foreach ($roedores as $roedor) : ?>
                    <div class="roedor">
                        <img src="data:image;base64,<?= base64_encode($roedor['imagem']); ?>" alt="<?= $roedor['nome']; ?>" width="100">
                        <p><?php echo $roedor['nome']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Nenhum roedor encontrado.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#filtro").on("input", function() {
                var filtro = $(this).val();

                $.ajax({
                    type: "POST",
                    url: "exibicao.php",
                    data: { filtro: filtro },
                    success: function(response) {
                        $(".roedores").html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
