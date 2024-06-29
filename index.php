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
function saudacao() {
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
</head>
<body>
    <h1><?php echo saudacao(); ?>!</h1>
    <a href="login.php">logar</a>
    <a href="./registrar.php">Registre-se aqui</a></p>
<br>
<form method="GET">
            <input type="text" name="search" placeholder="Pesquisar por titulo ou descrição" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Pesquisar</button>
        </form>
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
               
            </form>
        </div>
    <?php endwhile; ?>
    
</body> </html>