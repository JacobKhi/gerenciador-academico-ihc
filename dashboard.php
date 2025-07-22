<?php
session_start();

require_once 'config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// --- LÓGICA PARA APAGAR TAREFA (usando GET) ---
// Verificamos se um ID de tarefa foi passado pela URL para ser apagado
if (isset($_GET['delete_task'])) {
    $task_id_to_delete = $_GET['delete_task'];

    // Prepara a query para apagar, garantindo que o utilizador só pode apagar as suas próprias tarefas
    $stmtDelete = $pdo->prepare("DELETE FROM tarefas WHERE id = ? AND usuario_id = ?");
    $stmtDelete->execute([$task_id_to_delete, $usuario_id]);

    // Redireciona para o próprio dashboard para limpar a URL e evitar re-apagar ao atualizar
    header('Location: dashboard.php');
    exit();
}

// Se o formulário for enviado, processa a ação correspondente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Verifica se é o formulário de ADICIONAR tarefa
    if (isset($_POST['add_task'])) {
        $nova_descricao = trim($_POST['descricao']);
        $nova_disciplina = trim($_POST['disciplina']);

        if (!empty($nova_descricao)) {
            $stmt = $pdo->prepare("INSERT INTO tarefas (descricao, disciplina, usuario_id) VALUES (?, ?, ?)");
            $stmt->execute([$nova_descricao, $nova_disciplina, $usuario_id]);
        }
    } 
    // Verifica se é o formulário de ATUALIZAR tarefas existentes
    elseif (isset($_POST['update_tasks'])) {
        $tarefasConcluidasIDs = $_POST['tarefas_concluidas'] ?? [];

        $stmtReset = $pdo->prepare("UPDATE tarefas SET concluida = FALSE WHERE usuario_id = ?");
        $stmtReset->execute([$usuario_id]);

        if (!empty($tarefasConcluidasIDs)) {
            $placeholders = implode(',', array_fill(0, count($tarefasConcluidasIDs), '?'));
            $stmtUpdate = $pdo->prepare("UPDATE tarefas SET concluida = TRUE WHERE usuario_id = ? AND id IN ($placeholders)");
            $params = array_merge([$usuario_id], $tarefasConcluidasIDs);
            $stmtUpdate->execute($params);
        }
    }
}

// Busca no banco de dados TODAS as tarefas do utilizador logado
$stmt = $pdo->prepare("SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY disciplina, id DESC");
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
            <h1>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
            <a href="logout.php" class="logout-link">Sair</a>
        </header>

        <main class="dashboard-main">
            <section class="add-task-section">
                <h2>Adicionar Nova Tarefa</h2>
                <form action="dashboard.php" method="POST" class="add-task-form">
                    <input type="text" name="disciplina" placeholder="Disciplina (ex: Matemática)" class="task-input">
                    <input type="text" name="descricao" placeholder="O que precisa ser feito?" required class="task-input-desc">
                    <button type="submit" name="add_task">Adicionar</button>
                </form>
            </section>

            <section class="tasks-section">
                <h2>Minhas Tarefas</h2>
                
                <form action="dashboard.php" method="POST">
                    <button type="submit" name="update_tasks" class="button-update-tasks">Atualizar Tarefas</button>
                    
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
                                <a href="dashboard.php?delete_task=<?php echo $tarefa['id']; ?>" class="delete-task-link" title="Apagar Tarefa">
                                    &#128465; </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </form>
            </section>
        </main>
    </div>

</body>
</html>