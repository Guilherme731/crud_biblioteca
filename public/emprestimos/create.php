<?php

include '../../config/db.php';

$sqlLivros = "SELECT id_livro, titulo FROM livros";
$resultLivros = $conn->query($sqlLivros);

$sqlLeitores = "SELECT id_leitor, nome FROM leitores";
$resultLeitores = $conn->query($sqlLeitores);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data_emprestimo = $_POST['data_emprestimo'];
    $data_devolucao = $_POST['data_devolucao'];
    $livro = $_POST['livro'];
    $leitor = $_POST['leitor'];

    $sqlCheckLivro = "SELECT COUNT(*) as total FROM emprestimos WHERE id_livro = $livro AND data_devolucao IS NULL";
    $resultCheckLivro = $conn->query($sqlCheckLivro);
    $rowCheckLivro = $resultCheckLivro->fetch_assoc();

    if ($rowCheckLivro['total'] > 0) { 
        echo "Erro: Este livro já está emprestado.";
        exit;
    }

    if (!empty($data_devolucao) && $data_devolucao < $data_emprestimo) {
        echo "Erro: A data de devolução não pode ser anterior à data de empréstimo.";
        exit;
    }

    $sqlCheckLeitor = "SELECT COUNT(*) as total FROM emprestimos WHERE id_leitor = $leitor AND data_devolucao IS NULL";
    $resultCheckLeitor = $conn->query($sqlCheckLeitor);
    $rowCheckLeitor = $resultCheckLeitor->fetch_assoc();

    if ($rowCheckLeitor['total'] >= 3) {
        echo "Erro: Este leitor já possui 3 empréstimos ativos.";
        exit;
    }

    $sql = " INSERT INTO emprestimos (data_emprestimo, data_devolucao, id_livro, id_leitor) VALUE ('$data_emprestimo','$data_devolucao',$livro, $leitor)";


    if ($conn->query($sql) === true) {
        echo "Novo empréstimo registrado com sucesso.";
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
    <title>Registrar empréstimo</title>
    <link rel="stylesheet" href="../styles.css">

</head>

<body>



    <div class="centro">
        <h1>Registrar empréstimo</h1>
        <form method="POST" action="create.php">
            <div class="flex">
                <label for="data_emprestimo">Data de Empréstimo:</label>
                <input type="date" name="data_emprestimo" required>
                <label for="data_devolucao">Data de Devolução:</label>
                <input type="date" name="data_devolucao">
                <label for="livro">Livro:</label>
                <select name="livro">
                    <?php while ($row = $resultLivros->fetch_assoc()): ?>
                        <option value="<?= $row['id_livro'] ?>"><?= $row['titulo'] ?></option>
                    <?php endwhile; ?>
                </select>
                <label for="leitor">Leitor:</label>
                <select name="leitor">
                    <?php while ($row = $resultLeitores->fetch_assoc()): ?>
                        <option value="<?= $row['id_leitor'] ?>"><?= $row['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit">Registrar Empréstimo</button>
        </form>
    </div>

    


</body>


</html>