<?php

include '../../config/db.php';

function buildQueryString($exclude = []) {
    $params = $_GET;
    foreach ($exclude as $param) {
        unset($params[$param]);
    }
    return http_build_query($params);
}

$sql = "SELECT * FROM leitores WHERE 1=1";

if (isset($_GET['nome_leitor']) && $_GET['nome_leitor'] != '') {
    $nome_leitor = $_GET['nome_leitor'];
    $sql .= " AND ( nome = '$nome_leitor' )";
}
if (isset($_GET['email_leitor']) && $_GET['email_leitor'] != '') {
    $email_leitor = $_GET['email_leitor'];
    $sql .= " AND ( email = '$email_leitor' )";
}
if (isset($_GET['telefone_autor']) && $_GET['telefone_autor'] != '') {
    $telefone_autor = $_GET['telefone_autor'];
    $sql .= " AND ( telefone = $telefone_autor )";
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
    <title>Leitores</title>
</head>
<body>
    <form method="get">
        <h3>Filtros:</h3>
        <label>Nome:</label>
        <input type="text" value="" name="nome_leitor" id="nome_leitor"><br>
        <label>E-mail:</label>
        <input type="email" value="" name="email_leitor" id="email_leitor"><br>
        <label>Telefone:</label>
        <input type="text" value="" name="telefone_leitor" id="telefone_leitor"><br>
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
            <th> E-mail </th>
            <th> Telefone </th>
            <th> Ações </th>
        </tr>
    ";
    while($row = $result->fetch_assoc()){

        echo "<tr>
                <td> {$row['nome']} </td>
                <td> {$row['email']} </td>
                <td> {$row['telefone']} </td>
                <td>
                    <a href='update.php?id={$row['id_leitor']}'>Atualizar</a>
                    <a href='delete.php?id={$row['id_leitor']}'>Deletar</a>
                </td>
            </tr>
        ";
    }
    echo "</table>";
}else{
    echo "Nenhum leitor encontrado.";    
}
echo "<a href='create.php'>Registrar leitor</a>";

$conn -> close();

?>
</body>
</html>