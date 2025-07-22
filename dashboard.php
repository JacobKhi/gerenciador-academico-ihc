<?php
session_start();

// Protege a página e inclui a conexão com o banco
require_once 'config/database.php';

if (!isset($_SESSION['usuario_id'])) { // Verificaremos pelo ID do usuário agora
    header('Location: index.php');
    exit();
}

// Pega o ID do usuário que está logado
$usuario_id = $_SESSION['usuario_id'];


// Se o formulário for enviado, atualiza as tarefas no BANCO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tarefasConcluidasIDs = $_POST['tarefas_concluidas'] ?? [];

    // Primeiro, marca TODAS as tarefas deste usuário como NÃO concluídas
    $stmtReset = $pdo->prepare("UPDATE tarefas SET concluida = FALSE WHERE usuario_id = ?");
    $stmtReset->execute([$usuario_id]);

    // Se houver tarefas marcadas, atualiza apenas elas para CONCLUÍDAS
    if (!empty($tarefasConcluidasIDs)) {
        // Cria uma string de '?' para a consulta IN (?, ?, ?)
        $placeholders = implode(',', array_fill(0, count($tarefasConcluidasIDs), '?'));
        
        $stmtUpdate = $pdo->prepare("UPDATE tarefas SET concluida = TRUE WHERE usuario_id = ? AND id IN ($placeholders)");
        
        // Junta o ID do usuário com os IDs das tarefas para a execução
        $params = array_merge([$usuario_id], $tarefasConcluidasIDs);
        $stmtUpdate->execute($params);
    }
}

// Busca no banco de dados TODAS as tarefas do usuário logado
$stmt = $pdo->prepare("SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY disciplina");
$stmt->execute([$usuario_id]);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

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