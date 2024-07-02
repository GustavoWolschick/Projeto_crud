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


// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: portal.php');
    exit();
}

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// if para evitar que ocorra erro na pesquisa por digitarem e pesquisarem por order_by
if ($order_by) {
    $search = '';
}

// Obter dados dos usuários com filtros
$dados = $usuario->ler($search, $order_by);

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];

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
    <title>Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="usuario.css">
</head>
<header>
    <div class="nome">
        <h1>Diário Digital</h1>
    </div>
    <div class="acesso">
        <a href="portal.php">Voltar para o portal</a>
        <a href="registrar_adm.php">Adicionar Usuário</a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<body>
    <h2><?php echo saudacao() . ", " . $nome_usuario; ?>!</h2>
    <br>
    <div class="container">
        <form method="GET">
            <input type="text" name="search" placeholder="Pesquisar por nome ou email"
                value="<?php echo htmlspecialchars($search); ?>">
            <div class="filtro">
                <label>
                    <input type="radio" name="order_by" value="" <?php if ($order_by == '')
                        echo 'checked'; ?>> Normal
                </label>
                <label>
                    <input type="radio" name="order_by" value="nome" <?php if ($order_by == 'nome')
                        echo 'checked'; ?>> Ordem
                    Alfabética
                </label>
                <label>
                    <input type="radio" name="order_by" value="sexo" <?php if ($order_by == 'sexo')
                        echo 'checked'; ?>> Sexo
                </label>
            </div>
            <div class="botao">
                <button type="submit">Pesquisar</button>
            </div>

        </form>
    </div>
    <table border="2">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Fone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                <td><?php echo $row['fone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <div class="edicao">
                        <div class="editar">
                            <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                        </div>
                        <div class="deletar">
                            <a href="deletar.php?id=<?php echo $row['id']; ?>">Deletar</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>

<footer>
    Copyright Gustavo R. Wolschick | 2024
</footer>

</html>