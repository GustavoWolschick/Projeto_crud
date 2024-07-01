<?php
include_once './classes/Usuario.php';
include_once './classes/Noticias.php';
include_once './config/config.php';

$usuario = new Usuario($db);
$noticias = new Noticia($db);

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Obter dados da notícia com filtro
$dados_noticia = $noticias->ler($search);

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
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>INDEX</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<header>
    <div class="nome">
        <h1>Diário Digital</h1>
    </div>
    <div class="acesso">
        <a href="login.php">Logar</a>
        <a href="./registrar.php">Cadastrar-se</a></p>
    </div>
</header>

<body>
    <h2><?php echo saudacao(); ?>! Seja bem-vindo ao site que te deicha antenado</h2>
    <div class="container">
        <h2>Filtrar notícia</h2>
        <form method="GET">
            <input type="text" name="search" placeholder="Pesquisar notícia por titulo ou descrição"
                value="<?php echo htmlspecialchars($search); ?>">
            <div class="botao">
                <button type="submit">Pesquisar</button>
            </div>
        </form>
    </div>
    <div class="noticias">
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
                </div>
               
            </div>
        <?php endwhile; ?>
    </div>

</body>
<footer>
    Copyright Gustavo R. Wolschick | 2024
</footer>

</html>