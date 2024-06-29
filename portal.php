<?php
session_start();
include_once './config/config.php';
include_once './classes/Noticias.php';
include_once './classes/Usuario.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
$usuario = new Usuario($db);
$noticias = new Noticia($db);

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
$adm = $dados_usuario['adm'];

// Obter dados da notícia
if ($adm == 1) {
    $dados_noticia = $noticias->ler(($search));
} else {
    $dados_noticia = $noticias->lerPorId($_SESSION['usuario_id']);
}
// Função para determinar a saudação
function saudacao()
{
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}

// Registrar a noticia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usu = $dados_usuario['id'];
    $data = date('Y-m-d');
    $titulo = $_POST['titulo'];
    $noticia = $_POST['noticia'];
    $noticias->criar($id_usu, $data, $titulo, $noticia);
    header('Location: portal.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Crie sua notícia</title>
</head>

<body>
    <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
    <?php if ($adm == 1) : ?>
        <a href="crudUsuario.php">Gerenciar Usuários</a>
    <?php endif; ?>
    <a href="index.php">Ir para a pagina de notícias</a>
    <a href="editar.php?id=<?php echo $dados_usuario['id']; ?>">Editar Perfil</a>
    <a href="logout.php">Logout</a>
    <br>

    <h2>Criar Notícia</h2>
    <form method='POST'>
        <label for='titulo'> titulo:</label>
        <input type='text' name='titulo' required>
        <br><br>
        <label for='noticia'>Noticia:</label>
        <br><br>
        <textarea type='text' name='noticia' required></textarea>
        <br><br>
        <input type='submit' value='Criar Noticia'>
    </form>
    <?php if ($adm == 1) : ?>
        <form method="GET">
            <input type="text" name="search" placeholder="Pesquisar por titulo ou descrição" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Pesquisar</button>
        </form>
    <?php endif; ?>
    <?php while ($jornal = $dados_noticia->fetch(PDO::FETCH_ASSOC)) : ?>
        <div class="noticia">
            <h3><?php echo $jornal['titulo']; ?></h3>
            <p><?php echo $jornal['noticia']; ?></p>
            <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($jornal['data'])); ?></p>
            <?php

            $autor = $usuario->lerPorId($jornal['id_usu']);
            if ($autor) {
                echo "<p><strong>Autor:</strong> " . $autor['nome'] . "</p>";
            }
            ?>
            <?php if ($adm || $jornal['id_usu'] == $_SESSION['usuario_id']) : ?>
                <a href="deletar_noticia.php?id=<?php echo $jornal['id'] ?>">Deletar</a>
                <a href="editar_noticia.php?id=<?php echo $jornal['id'] ?>">Editar</a>
            <?php endif; ?>
            </form>
        </div>
    <?php endwhile; ?>
</body>

</html>