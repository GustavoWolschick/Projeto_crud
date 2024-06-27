<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';


// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
$usuario = new Usuario($db);

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
// Obter dados dos usuários
$dados = $usuario->ler();
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
    <title>Portal</title>
</head>
<body>
    <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
    <a href="crudUsuario.php">Gerenciar Usuários</a>
    <a href="crudNoticias.php">Lançar Notícias</a>
    <a href="logout.php">Sair</a>
<br>
    
</body> </html>
