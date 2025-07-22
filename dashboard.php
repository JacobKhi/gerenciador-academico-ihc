<?php
session_start();

// Esta é a nossa barreira de proteção.
// Se a variável de sessão 'usuario_logado' não existir, significa que não houve login.
if (!isset($_SESSION['usuario_logado'])) {
    // Redireciona de volta para a tela de login.
    header('Location: index.php');
    exit();
}


$tarefas = [
    ['id' => 1, 'disciplina' => 'Matemática', 'descricao' => 'Resolver exercícios da página 42.', 'concluida' => true],
    ['id' => 2, 'disciplina' => 'História', 'descricao' => 'Ler o capítulo 5 sobre a Grécia Antiga.', 'concluida' => false],
    ['id' => 3, 'disciplina' => 'Ciências', 'descricao' => 'Entregar o relatório do laboratório até sexta-feira.', 'concluida' => false],
    ['id' => 4, 'disciplina' => 'Português', 'descricao' => 'Fazer a redação sobre o tema "Tecnologia e Sociedade".', 'concluida' => false]
];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tarefasConcluidasIDs = $_POST['tarefas_concluidas'] ?? [];

    foreach ($tarefas as $index => $tarefa) {
        if (in_array($tarefa['id'], $tarefasConcluidasIDs)) {
            $tarefas[$index]['concluida'] = true;
        } else {
            $tarefas[$index]['concluida'] = false;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gerenciador Acadêmico</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Meu Dashboard</h1>
            <a href="logout.php" class="logout-link">Sair</a>
        </header>

        <main class="dashboard-main">
            <section class="tasks-section">
                <h2>Minhas Tarefas Pendentes</h2>
                
                <form action="dashboard.php" method="POST">
                    <ul class="tasks-list">
                        <?php foreach ($tarefas as $tarefa): ?>
                            <li class="task-item <?php echo $tarefa['concluida'] ? 'completed' : ''; ?>">
                                <div class="task-checkbox">
                                    <input 
                                        type="checkbox" 
                                        name="tarefas_concluidas[]" 
                                        value="<?php echo $tarefa['id']; ?>"
                                        id="task-<?php echo $tarefa['id']; ?>" 
                                        <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                                    <label for="task-<?php echo $tarefa['id']; ?>"></label>
                                </div>
                                <div class="task-info">
                                    <span class="task-subject"><?php echo htmlspecialchars($tarefa['disciplina']); ?></span>
                                    <p class="task-description"><?php echo htmlspecialchars($tarefa['descricao']); ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <button type="submit" class="button-update-tasks">Atualizar Tarefas</button>
                </form>

            </section>
        </main>
    </div>

</body>
</html>