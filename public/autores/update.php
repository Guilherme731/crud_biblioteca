<?php
include '../../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM autores WHERE id_autor = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $dado = mysqli_fetch_assoc($res);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $nacionalidade = $_POST['nacionalidade'];
    $ano_nascimento = $_POST['ano_nascimento'];

    $id = $_GET['id'];
    $stmt = $conn->prepare("UPDATE autores SET nome = ?, nacionalidade = ?, ano_nascimento = ? WHERE id_autor = ?");
    $stmt->bind_param("ssii", $nome, $nacionalidade, $ano_nascimento, $id);
    if ($stmt->execute()) {
        header("Location: read.php");
    } else {
        echo "Erro ao editar!";
    }
}
?>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Atualizar Autor</title>
</head>

<body>
    <h2>Atualizar Autor:</h2>
    <form action="" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= $dado['nome'] ?>" required>
        <label for="nacionalidade">Nacionalidade:</label>
        <input type="text" name="nacionalidade" id="nacionalidade" value="<?= $dado['nacionalidade'] ?>" required>
        <label for="ano_nascimento">Ano de Nascimento:</label>
        <input type="number" name="ano_nascimento" id="ano_nascimento" value="<?= $dado['ano_nascimento'] ?>" required>
        <button type="submit">Atualizar Autor</button>
    </form>

</body>

</html>