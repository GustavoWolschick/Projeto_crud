<?php
session_start();
include_once './config/config.php';
include_once './classes/Noticias.php';
include_once './classes/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

//dados da noticia
$noticias = new Noticia($db);
$dados_noticia = $noticias->lerPorIdNoticia($_GET['id']);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $noticia = $_POST['noticia'];
    $noticias->atualizar($titulo, $noticia, $id);
    header('Location: portal.php');
    exit();
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $row = $noticias->lerPorIdNoticia($id);
    echo $row['titulo'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar notícia</title>
</head>

<body>
    <a href="portal.php">Ir para o Portal</a>
    <a href="logout.php">Logout</a>
    <br>

    <h2>Alterar Notícia</h2>
    <form method='POST'>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for='titulo'> titulo:</label>
        <input type='text' name='titulo' value="<?php echo $row['titulo'] ?>" required>
        <br><br>
        <label for='noticia'>Noticia:</label>
        <br><br>
        <textarea type='text' name='noticia'  required> <?php echo $row['noticia'] ?></textarea>
        <br><br>
        <input type='submit' value='Editar Noticia'>
    </form>

</body>

</html>