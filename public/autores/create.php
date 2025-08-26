<?php

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $nacionalidade = $_POST['nacionalidade'];
    $ano_nascimento = $_POST['ano_nascimento'];

    $sql = "INSERT INTO autores(nome, nacionalidade, ano_nascimento) VALUES ('$nome', '$nacionalidade', $ano_nascimento)";

    if ($conn->query($sql) === true) {
        echo "Autor registrado criado com sucesso.";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
}

?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Adicionar Autor</title>
</head>

<body>

    <form method="POST" action="create.php">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <label for="nacionalidade">Nacionalidade:</label>
        <input type="text" name="nacionalidade" id="nacionalidade" required>
        <label for="ano_nascimento">Ano de Nascimento:</label>
        <input type="number" name="ano_nascimento" id="ano_nascimento" required>

        <button type="submit">Registrar Autor</button>

    </form>

</body>

</html>