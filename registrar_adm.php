<?php
include_once './config/config.php';
include_once './classes/Usuario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $adm = isset($_POST['adm']) ? 1 : 0;
    $usuario->registrar($nome, $sexo, $fone, $email, $senha, $adm);
    header('Location: portal.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <title>Adicionar Usuário</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="registrar.css">
</head>
<header>
    <a href="index.php">
        <h1>Diário Digital</h1>
    </a>
</header>

<body>
    <div class="container">
        <h1>Adicionar Usuário</h1>
        <form method='POST'>
            <div class="adm">
                <label for="adm">Administrador</label>
                <input type="checkbox" id="adm" name="adm" value="1"; ?>
            </div>
            <label for='nome'> Nome:</label>
            <input type='text' name='nome' required>
            <label>Sexo:</label>
            <div class="sexo">
                <label for='masculino'>
                    <input type='radio' id='masculino' name='sexo' value='M' required> Masculino
                </label>
                <label for='feminino'>
                    <input type='radio' id='feminino' name='sexo' value='F' required> Feminino
                </label>
            </div>
            <label for='fone'>Fone:</label>
            <input type='text' name='fone' required>
            <br><br>
            <label for='email'>Email:</label>
            <input type='email' name='email' required>
            <br><br>
            <label for='senha'>Senha:</label>
            <input type='password' name='senha' required>
            <div class="botao">
                <input type='submit' value='Adicionar'>
            </div>
        </form>
    </div>
</body>
<footer>
    Copyright Gustavo R. Wolschick | 2024
</footer>

</html>