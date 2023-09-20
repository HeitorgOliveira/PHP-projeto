<?php

function conectaBD() {
    $pdo = new PDO("mysql:host=143.106.241.3;dbname=cl201240;charset=utf8", "cl201240", "cl*06112005");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function cadastrarRoedor($nome, $imagem_nome, $imagem_tmp) {


    try {

        if (empty($nome))
        {
            return "ERRO: O campo nome não pode ser vazio";
        }

        if (empty($imagem_tmp))
        {
            return "ERRO: Deve haver um arquivo com a imagem";
        }


        $pdo = conectaBD();

        $stmt = $pdo->prepare("SELECT * FROM Roedores WHERE nome = :nome");
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Roedor com o mesmo nome já existe no banco de dados.";
        }

        $img_binario = file_get_contents($imagem_tmp);
        $stmt = $pdo->prepare("INSERT INTO Roedores (nome, imagem) VALUES (:nome, :imagem)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':imagem', $img_binario);
        $stmt->execute();
    } catch (PDOException $e) {
        return "ERRO: " . $e->getMessage();
    }
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

function atualizarRoedor($id, $novoNome) {
    try {
        $pdo = conectaBD();

        $stmt = $pdo->prepare("UPDATE Roedores SET nome = :novoNome WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':novoNome', $novoNome);
        $stmt->execute();

        return true;
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

?>
