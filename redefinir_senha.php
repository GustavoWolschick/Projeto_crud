<?php
include_once './config/config.php';
include_once './classes/Usuario.php';


$mensagem = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nova_senha = $_POST['nova_senha'];
    $usuario = new Usuario($db);


    if ($usuario->redefinirSenha($codigo, $nova_senha)) {
        $mensagem = 'Senha redefinida com sucesso. Você pode <a href="index.php">entrar</a> agora.';
    } else {
        $mensagem = 'Código de verificação inválido.';
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="recuperacao.css">
</head>
<header>
    <a href="index.php">
        <h1>Diário Digital</h1>
    </a>
</header>

<body>
    <div class="container">
        <h1>Redefinir Senha</h1>
        <form method="POST">
            <label for="codigo">Código de Verificação:</label>
            <input type="text" name="codigo" placeholder="Seu código aqui" required><br><br>
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" name="nova_senha" required>
            <div class="botao">
                <input type="submit" value="Redefinir Senha">
            </div>
            <p><?php echo $mensagem; ?></p>
        </form>
    </div>

</body>
<footer>
    Copyright Gustavo R. Wolschick | 2024
</footer>

</html>