<?php

$erro = '';

// Verifica se o formulário foi enviado (se o método da requisição é POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Pega os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // --- LÓGICA DE AUTENTICAÇÃO SIMULADA ---
    if ($email === 'aluno@email.com' && $senha === '12345') {
        
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
        // --- Exibe a mensagem de erro aqui, se ela existir ---
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