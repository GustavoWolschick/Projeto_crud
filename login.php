<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';


$usuario = new Usuario($db);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Processar login
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        if ($dados_usuario = $usuario->login($email, $senha)) {
            $_SESSION['usuario_id'] = $dados_usuario['id'];
            header('Location: portal.php');
            exit();
        } else {
            $mensagem_erro = "Credenciais inválidas!";
        }
    }
}
?>
<!DOCTYPE html>
<html>


<head>
    <title>A U T E N T I C A Ç Ã O</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>

<header>
    <a href="index.php"><h1>Diário Digital</h1></a>
    <div class="acesso">
        <a href="index.php">voltar</a>
    </div>
</header>

<body>


    <div class="container">


        <h1>A U T E N T I C A Ç Ã O</h1>


        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <br><br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>
            <div class="botao">
                <input type="submit" name="login" value="Login">
            </div>
        </form>
        <p><a href="./solicitar_recuperacao.php">redefinir senha</a></p>
        <p>Não tem uma conta? <a href="./registrar.php">Registre-se aqui</a></p>
        <div class="mensagem">
            <?php if (isset($mensagem_erro))
                echo '<p>' . $mensagem_erro . '</p>'; ?>
        </div>
    </div>
</body>
<footer>
    Copyright Gustavo R. Wolschick | 2024
</footer>

</html>