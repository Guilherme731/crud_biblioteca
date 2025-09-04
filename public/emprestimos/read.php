<?php

include '../../config/db.php';

function buildQueryString($exclude = [])
{
    $params = $_GET;
    foreach ($exclude as $param) {
        unset($params[$param]);
    }
    return http_build_query($params);
}

$sqlLeitores = "SELECT id_leitor, nome FROM leitores";
$resultLeitores = $conn->query($sqlLeitores);

$sql = "SELECT id_emprestimo, livros.titulo AS nome_livros, leitores.id_leitor, leitores.nome AS nome_leitores, data_emprestimo, data_devolucao FROM emprestimos INNER JOIN livros ON livros.id_livro = emprestimos.id_livro INNER JOIN leitores ON leitores.id_leitor = emprestimos.id_leitor WHERE 1=1";

if (isset($_GET['concluidos'])) {

    $sql .= " AND ( data_devolucao <> '0000-00-00' AND ( data_devolucao IS NOT NULL))";
} else {
    $sql .= " AND ( (data_devolucao = '0000-00-00') OR ( data_devolucao IS NULL))";
}

if (isset($_GET['leitor']) && $_GET['leitor'] != '') {
    $leitor = $_GET['leitor'];
    $sql .= " AND ( leitores.id_leitor = $leitor )";
}

$pagina = 0;
$registroPorPagina = 10;
$resultado = mysqli_query($conn, $sql);
$num_linhas = mysqli_num_rows($resultado);
$total_paginas = $num_linhas / $registroPorPagina;
$total_paginas = ceil($total_paginas);

if ($resultado->num_rows > 0) {
    if (isset($_GET['pagina'])) {
        $pagina = $_GET['pagina'];
    }
    if ($pagina < 0) {
        $pagina = 0;
    }

    if ($pagina >= $total_paginas) {
        $pagina = $total_paginas - 1;
    }

    $paginaAnterior = $pagina - 1;
    $paginaPosterior = $pagina + 1;

    $index = $pagina * $registroPorPagina;

    $sql .= " LIMIT $index, $registroPorPagina";

    $result = $conn->query($sql);
}
?>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Empréstimos</title>
    <?php
    $queryComConcluidos = buildQueryString(['pagina']);
    $linkConcluidos = "read.php?$queryComConcluidos&concluidos=sim";
    ?>
    <a href="<?= $linkConcluidos ?>">Mostrar Concluídos</a><br>
</head>

<body>

    <form method="get">
        <h3>Filtros:</h3>
        <label>Time:</label>
        <select name="leitor">
            <option></option>
            <?php foreach ($resultLeitores as $row): ?>
                <option value="<?= $row['id_leitor'] ?>" <?php if (isset($_GET['leitor'])) {
                                                                if ($_GET['leitor'] == $row['id_leitor']) {
                                                                    echo 'selected';
                                                                }
                                                            } ?>><?= $row['nome'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Atualizar</button>
        <a href="read.php">Remover Filtros</a>
    </form>


    <?php



    if ($resultado->num_rows > 0) {
        $paginaExibida = $pagina + 1;
        $queryBase = buildQueryString(['pagina']);

        $paginaAnteriorLink = "?$queryBase&pagina=$paginaAnterior";
        $paginaPosteriorLink = "?$queryBase&pagina=$paginaPosterior";

        echo "<a href='$paginaAnteriorLink'>Anterior</a> ";
        echo "<a href='$paginaPosteriorLink'>Próxima</a>";
        echo "<br> Página $paginaExibida de $total_paginas";
        echo "<br> Total de $num_linhas resultados";

        echo "<table border = '1'>
        <tr>
            <th> Data de Empréstimo </th>
            <th> Data de Devolução </th>
            <th> Livro </th>
            <th> Leitor </th>
            <th> Ações </th>
        </tr>
    ";
        while ($row = $result->fetch_assoc()) {

            echo "<tr>
                <td> {$row['data_emprestimo']} </td>
                <td> {$row['data_devolucao']} </td>
                <td> {$row['nome_livros']} </td>
                <td> {$row['nome_leitores']} </td>
                <td>
                    <a href='update.php?id={$row['id_emprestimo']}'>Atualizar</a>
                    <a href='delete.php?id={$row['id_emprestimo']}'>Deletar</a>
                </td>
            </tr>
        ";
        }
        echo "</table>";
    } else {
        echo "Nenhum empréstimo encontrado.";
    }
    echo "<a href='create.php'>Registrar novo emprétimo</a>";

    $conn->close();

    ?>
</body>

</html>