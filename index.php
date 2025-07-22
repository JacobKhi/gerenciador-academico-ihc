<?php
session_start();

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($email === 'aluno@email.com' && $senha === '12345') {
        
        // Login bem-sucedido!
        // Guardamos uma informação na sessão para identificar o usuário.
        $_SESSION['usuario_logado'] = true;
        // Futuramente, poderíamos guardar o ID do usuário: $_SESSION['usuario_id'] = $id_do_banco;

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
            echo '<p class="error-message">' . $erro . '</p>';
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