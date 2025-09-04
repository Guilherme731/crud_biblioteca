<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Excluir Emprestimo</title>
</head>
<body>
    <h2>Excluir Empréstimo</h2>
    <p>Deseja realmente excluir o empréstimo?</p>
    <form action="" method="post">
        <button type="submit">Excluir</button>
    </form>
    <a href="read.php">Voltar</a>
    
</body>
</html>
    <?php
        include '../../config/db.php';

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $stmt = $conn->prepare("DELETE FROM emprestimos WHERE id_emprestimo = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                header("Location: read.php");
            }
        }else{
            header("Location: read.php");
        }
        
    ?>