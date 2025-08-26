<?php

include '../../config/db.php';

function buildQueryString($exclude = []) {
    $params = $_GET;
    foreach ($exclude as $param) {
        unset($params[$param]);
    }
    return http_build_query($params);
}

$sql = "SELECT * FROM autores WHERE 1=1";

if (isset($_GET['nome_autor']) && $_GET['nome_autor'] != '') {
    $nome_autor = $_GET['nome_autor'];
    $sql .= " AND ( nome = '$nome_autor' )";
}
if (isset($_GET['nacionalidade_autor']) && $_GET['nacionalidade_autor'] != '') {
    $nacionalidade_autor = $_GET['nacionalidade_autor'];
    $sql .= " AND ( nacionalidade = '$nacionalidade_autor' )";
}
if (isset($_GET['ano_nascimento_autor']) && $_GET['ano_nascimento_autor'] != '') {
    $ano_nascimento_autor = $_GET['ano_nascimento_autor'];
    $sql .= " AND ( ano_nascimento = $ano_nascimento_autor )";
}

$pagina = 0;
$registroPorPagina = 10;
$resultado = mysqli_query($conn, $sql);
$num_linhas = mysqli_num_rows($resultado);
$total_paginas = $num_linhas / $registroPorPagina;
$total_paginas = ceil($total_paginas);

if($resultado->num_rows > 0){
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
}
if($pagina < 0){
    $pagina = 0;
}

if($pagina >= $total_paginas){
    $pagina = $total_paginas - 1;
}

$paginaAnterior = $pagina -1;
$paginaPosterior = $pagina +1;

$index = $pagina * $registroPorPagina;

$sql .= " LIMIT $index, $registroPorPagina";

$result = $conn->query($sql);
}
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Autores</title>
</head>
<body>
    <form method="get">
        <h3>Filtros:</h3>
        <label>Nome:</label>
        <input type="text" value="" name="nome_autor" id="nome_autor"><br>
        <label>Nacionalidade:</label>
        <input type="text" value="" name="nacionalidade_autor" id="nacionalidade_autor"><br>
        <label>Ano de Nascimento:</label>
        <input type="number" value="" name="ano_nascimento_autor" id="ano_nascimento_autor"><br>
        <button type="submit">Atualizar</button>
    <a href="read.php">Remover Filtros</a>
</form>

<?php



if($resultado->num_rows > 0){
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
            <th> Nome </th>
            <th> Nacionalidade </th>
            <th> Ano de Nascimento </th>
            <th> Ações </th>
        </tr>
    ";
    while($row = $result->fetch_assoc()){

        echo "<tr>
                <td> {$row['nome']} </td>
                <td> {$row['nacionalidade']} </td>
                <td> {$row['ano_nascimento']} </td>
                <td>
                    <a href='update.php?id={$row['id_autor']}'>Atualizar</a>
                    <a href='delete.php?id={$row['id_autor']}'>Deletar</a>
                </td>
            </tr>
        ";
    }
    echo "</table>";
}else{
    echo "Nenhum autor encontrado.";    
}
echo "<a href='create.php'>Registrar autor</a>";

$conn -> close();

?>
</body>
</html>