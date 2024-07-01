<?php
include_once './config/config.php';
include_once './classes/Usuario.php';


$mensagem = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $usuario = new Usuario($db);
    $codigo = $usuario->gerarCodigoVerificacao($email);


    if ($codigo) {
        $mensagem = "Seu código de verificação é: $codigo. Por favor, anote o código e <a href='redefinir_senha.php'>clique aqui</a> para redefinir sua senha.";
    } else {
        $mensagem = 'E-mail não encontrado.';
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
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
        <h1>Recuperar Senha</h1>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <div class="botao">
                <input type="submit" value="Enviar">
            </div>
        </form>
        <p><?php echo $mensagem; ?></p>
        <a href="login.php">Voltar</a>
    </div>
</body>
<footer>
    Copyright Gustavo R. Wolschick | 2024
</footer>

</html>