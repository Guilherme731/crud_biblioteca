<?php

include '../../config/db.php';

function buildQueryString($exclude = []) {
    $params = $_GET;
    foreach ($exclude as $param) {
        unset($params[$param]);
    }
    return http_build_query($params);
}


$sql = "SELECT id_livro, livros.titulo AS nome_livros, autores.nome AS nome_autores, titulo, genero, ano_publicacao FROM livros INNER JOIN autores ON autores.id_autor = livros.id_autor WHERE 1=1";


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
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Jogadores</title>
</head>
<body>
    

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
            <th> Título </th>
            <th> Gênero </th>
            <th> Ano de Publicacao </th>
            <th> Autor </th>
            <th> Ações </th>
        </tr>
    ";
    while($row = $result->fetch_assoc()){

        echo "<tr>
                <td> {$row['nome_livros']} </td>
                <td> {$row['genero']} </td>
                <td> {$row['ano_publicacao']} </td>
                <td> {$row['nome_autores']} </td>
                <td>
                    <a href='update.php?id={$row['id_livro']}'>Atualizar</a>
                    <a href='delete.php?id={$row['id_livro']}'>Deletar</a>
                </td>
            </tr>
        ";
    }
    echo "</table>";
}else{
    echo "Nenhum livro encontrado.";    
}
echo "<a href='create.php'>Registrar livro</a>";

$conn -> close();

?>
</body>
</html>