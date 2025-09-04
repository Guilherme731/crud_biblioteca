<?php
include '../../config/db.php';

$sqlLivros = "SELECT id_livro, titulo FROM livros";
$resultLivros = $conn->query($sqlLivros);

$sqlLeitores = "SELECT id_leitor, nome FROM leitores";
$resultLeitores = $conn->query($sqlLeitores);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id_emprestimo, livros.id_livro AS id_livro, leitores.id_leitor AS id_leitor, livros.titulo AS nome_livros, leitores.nome AS nome_leitores, data_emprestimo, data_devolucao FROM emprestimos INNER JOIN livros ON livros.id_livro = emprestimos.id_livro INNER JOIN leitores ON leitores.id_leitor = emprestimos.id_leitor WHERE emprestimos.id_emprestimo = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $dado = mysqli_fetch_assoc($res);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $livro = $_POST['livro'];
    $leitor = $_POST['leitor'];
    $data_emprestimo = $_POST['data_emprestimo'];
    $data_devolucao = $_POST['data_devolucao'];

    $id = $_GET['id'];
    $sql = "UPDATE emprestimos SET id_livro = $livro, id_leitor = $leitor, data_emprestimo  = '$data_emprestimo', data_devolucao = '$data_devolucao' WHERE id_emprestimo = $id";
    if ($conn->query($sql) === true) {
        echo "Emprestimo editado com sucesso.";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
}
?>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Atualizar Empréstimo</title>
</head>

<body>
    <div class="centro">
        <h1>Atualizar empréstimo</h1>
        <form method="POST" action="">
            <div class="flex">
                <label for="data_emprestimo">Data de Empréstimo:</label>
                <input type="date" name="data_emprestimo" value="<?= $dado['data_emprestimo'] ?>" required>
                <label for="data_devolucao">Data de Devolução:</label>
                <input type="date" name="data_devolucao" value="<?= $dado['data_devolucao'] ?>">
                <label for="livro">Livro:</label>
                <select name="livro">
                    <?php while ($row = $resultLivros->fetch_assoc()): ?>
                        <option value="<?= $row['id_livro'] ?>" <?php if($dado['id_livro'] == $row['id_livro']){echo 'selected';} ?>><?= $row['titulo'] ?></option>
                    <?php endwhile; ?>
                </select>
                <label for="leitor">Leitor:</label>
                <select name="leitor">
                    <?php while ($row = $resultLeitores->fetch_assoc()): ?>
                        <option value="<?= $row['id_leitor'] ?>" <?php if($dado['id_leitor'] == $row['id_leitor']){echo 'selected';} ?>><?= $row['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit">Atualizar Empréstimo</button>
        </form>
    </div>

</body>

</html>