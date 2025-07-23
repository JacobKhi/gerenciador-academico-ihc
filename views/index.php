<?php
session_start();

// Se o utilizador já estiver logado, redireciona para o dashboard
if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gerenciador Acadêmico</title>
    <link rel="stylesheet" href="../public/css/style.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container-wrapper">
        <div class="login-container">
            <h1>Gerenciador Acadêmico</h1>
            <p>Acesse sua conta</p>

            <form action="../processa_acoes.php" method="POST">
                <input type="hidden" name="action" value="login">
                
                <div class="form-group">
                    <label for="email">Email ou Usuário</label>
                    <input type="text" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <button type="submit" class="button-full-width">Entrar</button>
            </form>

            <div class="links-uteis">
                <a href="register.php">Não tem uma conta? Registe-se</a>
                <a href="#">Esqueceu sua senha?</a>
            </div>
        </div>
    </div>
</body>
</html>