<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gerenciador Acadêmico</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
            <a href="../logout.php" class="logout-link">Sair</a>
        </header>

        <nav class="dashboard-nav">
            <a href="dashboard.php?page=tarefas" class="<?php echo ($_GET['page'] ?? 'tarefas') === 'tarefas' ? 'active' : ''; ?>">Tarefas</a>
            <a href="dashboard.php?page=notas" class="<?php echo ($_GET['page'] ?? '') === 'notas' ? 'active' : ''; ?>">Notas</a>
            <a href="dashboard.php?page=agenda" class="<?php echo ($_GET['page'] ?? '') === 'agenda' ? 'active' : ''; ?>">Agenda</a>
        </nav>

        <main class="dashboard-main">
            <?php
            $page = $_GET['page'] ?? 'tarefas';
            if ($page === 'tarefas') {
                // include 'partials/_tarefas.php'; // Vamos reativar isso depois
                echo "<p>A área de tarefas do aluno está em construção.</p>";
            } elseif ($page === 'notas') {
                include 'partials/_notas.php';
            } elseif ($page === 'agenda') {
                include 'partials/_agenda.php';
            }
            ?>
        </main>
    </div>
</body>
</html>