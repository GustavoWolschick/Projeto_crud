<?php
include_once './classes/Usuario.php';
include_once './classes/Noticias.php';

$usuario = new Usuario($db);
$noticias = new Noticia($db);

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);

// Obter dados da notícia
$dados_noticia = $noticias->ler();

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
<br>
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
                <?php if ($usuario_adm || $jornal['id_usu'] == $_SESSION['usuario_id']) : ?>
                    <a href="deletar_noticia.php?id=<?php echo $jornal['id'] ?>">Deletar</a>
                <?php endif; ?>
            </form>
        </div>
    <?php endwhile; ?>
    
</body> </html>