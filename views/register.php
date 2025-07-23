<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registo - Gerenciador Acadêmico</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container-wrapper">
        <div class="login-container">
            <h1>Criar Conta</h1>
            <p>Preencha os seus dados para se registar</p>

            <form action="../processa_acoes.php" method="POST">
                <input type="hidden" name="action" value="register">

                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <button type="submit" class="button-full-width">Registar</button>
            </form>

            <div class="links-uteis">
                <a href="index.php">Já tem uma conta? Faça login</a>
            </div>
        </div>
    </div>
</body>
</html>