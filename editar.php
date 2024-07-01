<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once './config/config.php';
include_once './classes/Usuario.php';


$usuario = new Usuario($db);
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$usuario_adm = $dados_usuario['adm'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $adm = isset($_POST['adm']) ? 1 : 0; // 1 = verdadeiro, 0 = falso

    $usuario->atualizar($id, $nome, $sexo, $fone, $email, $adm);
    header('Location: portal.php');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="registrar.css">
</head>

<header>
    <a href="index.php">
        <h1>Diário Digital</h1>
    </a>
    <a href="portal.php" class="acesso">Voltar</a>
</header>

<body>
    <div class="container">
        <h1>Editar Usuário</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <?php if ($usuario_adm == 1): ?>
                <div class="adm">
                    <label for="adm">Administrador</label>
                    <input type="checkbox" id="adm" name="adm" value="1" <?php echo ($row['adm'] == 1) ? 'checked' : ''; ?>>
                </div>
                <br><br>
            <?php endif; ?>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required>
            <br><br>
            <label>Sexo:</label>
            <div class="sexo">
                <label for="masculino_editar">
                    <input type="radio" id="masculino_editar" name="sexo" value="M" <?php echo ($row['sexo'] === 'M') ? 'checked' : ''; ?> required> Masculino
                </label>
                <label for="feminino_editar">
                    <input type="radio" id="feminino_editar" name="sexo" value="F" <?php echo ($row['sexo'] === 'F') ? 'checked' : ''; ?> required> Feminino
                </label>
            </div>
            <br><br>
            <label for="fone">Fone:</label>
            <input type="text" name="fone" value="<?php echo $row['fone']; ?>" required>
            <br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
            <br><br>
            <div class="botao">
                <input type="submit" value="Atualizar">
            </div>
        </form>
    </div>
</body>
<footer>
    Copyright Gustavo R. Wolschick | 2024
</footer>

</html>