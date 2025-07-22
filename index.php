<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Inclui nosso arquivo de conexão com o banco de dados
require_once 'config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // É uma boa prática sempre limpar os dados do formulário
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Prepara uma consulta SQL para buscar o usuário pelo email
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário foi encontrado e se a senha confere
    if ($usuario && $senha === $usuario['senha']) {
        
        // Login bem-sucedido! Guarda os dados na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_logado'] = true; 
        
        // Redireciona para o dashboard
        header('Location: dashboard.php');
        exit();

    } else {
        $erro = 'Email ou senha inválidos. Tente novamente.';
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gerenciador Acadêmico</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <h1>Gerenciador Acadêmico</h1>
        <p>Acesse sua conta</p>

        <?php
        if (!empty($erro)) {
            echo '<p class="error-message">' . htmlspecialchars($erro) . '</p>';
        }
        ?>

        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="email">Email ou Usuário</label>
                <input type="text" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <button type="submit">Entrar</button>
        </form>

        <div class="links-uteis">
            <a href="#">Esqueceu sua senha?</a>
        </div>
    </div>

</body>
</html>