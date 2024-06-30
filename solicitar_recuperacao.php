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
</head>
<body>
    <h1>Recuperar Senha</h1>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <input type="submit" value="Enviar">
    </form>
    <p><?php echo $mensagem; ?></p>
    <a href="index.php">Voltar</a>
</body>
</html>
