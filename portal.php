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

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="portal.css">
</head>
<header>
    <div class="nome">
        <h1>Diário Digital</h1>
    </div>
    <div class="acesso">
        <?php if ($adm == 1): ?>
            <a href="crudUsuario.php">Gerenciar Usuários</a>
        <?php endif; ?>
        <a href="editar.php?id=<?php echo $dados_usuario['id']; ?>">Editar Perfil</a>
        <a href="logout.php">Logout</a>

    </div>
</header>

<body>
    <h2><?php echo saudacao() . ", " . $nome_usuario; ?>!</h2>
    <div class="container">
        <h2>Criar Notícia</h2>
        <form method='POST'>
            <label for='titulo'> titulo:</label>
            <br><br>
            <input type='text' name='titulo' required>
            <br><br>
            <label for='noticia'>Noticia:</label>
            <br><br>
            <textarea type='text' name='noticia' required></textarea>
            <div class="botao">
                <input type='submit' value='Criar Noticia'>
            </div>
        </form>
    </div>

    <div class="filtrar">
        <h2>Filtrar notícia</h2>
        <form method="GET">
            <input type="text" name="search" placeholder="Pesquisar por titulo ou descrição"
                value="<?php echo htmlspecialchars($search); ?>">
            <div class="botao">
                <button type="submit">Pesquisar</button>
            </div>
        </form>
    </div>

    <?php while ($jornal = $dados_noticia->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="noticia">

            <div class="titulo">
                <h3><?php echo $jornal['titulo']; ?></h3>
            </div>
            <p><?php echo $jornal['noticia']; ?></p>

            <div class="dados">

                <?php
                $autor = $usuario->lerPorId($jornal['id_usu']);
                if ($autor) {
                    echo "<p><strong>Autor:</strong> " . $autor['nome'] . "</p>";
                }
                ?>
                <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($jornal['data'])); ?></p>

                <div class="edicao">
                    <?php if ($adm || $jornal['id_usu'] == $_SESSION['usuario_id']): ?>
                        <div class="editar">
                            <a href="editar_noticia.php?id=<?php echo $jornal['id'] ?>">Editar</a>
                        </div>
                        <div class="deletar">
                            <a href="deletar_noticia.php?id=<?php echo $jornal['id'] ?>">Deletar</a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        </div>

    <?php endwhile; ?>

</body>

<footer>
    Copyright Gustavo R. Wolschick | 2024
</footer>

</html>