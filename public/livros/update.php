<?php
include '../../config/db.php';

$sqlAutores = "SELECT id_autor, nome FROM autores";
$resultAutores = $conn->query($sqlAutores);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id_livro, autores.id_autor AS id_autor, livros.titulo AS nome_livros, autores.nome AS nome_autores, titulo, genero, ano_publicacao FROM livros INNER JOIN autores ON autores.id_autor = livros.id_autor WHERE livros.id_livro = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $dado = mysqli_fetch_assoc($res);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $autor = $_POST['autor'];

    $id = $_GET['id'];
    $sql = "UPDATE livros SET titulo = '$titulo', genero = '$genero', ano_publicacao  = $ano_publicacao, id_autor = $autor WHERE id_livro = $id";
    if ($conn->query($sql) === true) {
        echo "Livro editado com sucesso.";
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
    <title>Atualizar Livro</title>
</head>

<body>
    <h2>Atualizar Livro:</h2>
    <form action="" method="post">
        <div class="flex">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo"  value="<?= $dado['titulo'] ?>" required>
                <label for="genero">Gênero:</label>
                <input type="text" name="genero"  value="<?= $dado['genero'] ?>">
                <label for="ano_publicacao">Ano de publicação:</label>
                <input type="number" name="ano_publicacao"  value="<?= $dado['ano_publicacao'] ?>">
                <label for="autor">Autor:</label>
                <select name="autor">
                    <?php while ($row = $resultAutores->fetch_assoc()): ?>
                        <option value="<?= $row['id_autor'] ?>" <?php if($dado['id_autor'] == $row['id_autor']){echo 'selected';} ?>><?= $row['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        <button type="submit">Atualizar Livro</button>
    </form>

</body>

</html>