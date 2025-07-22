<?php
session_start();
require_once 'config/database.php';

// A única responsabilidade agora é proteger a página e buscar dados para exibição.
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// --- BUSCA DE DADOS ---
// Tarefas
$stmt_tarefas = $pdo->prepare("SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY disciplina, id DESC");
$stmt_tarefas->execute([$usuario_id]);
$tarefas = $stmt_tarefas->fetchAll(PDO::FETCH_ASSOC);

// Notas
$stmt_notas = $pdo->prepare("SELECT disciplina, tipo_avaliacao, nota FROM notas WHERE usuario_id = ? ORDER BY disciplina");
$stmt_notas->execute([$usuario_id]);
$notas_raw = $stmt_notas->fetchAll(PDO::FETCH_ASSOC);
$notas_agrupadas = [];
foreach ($notas_raw as $nota) {
    $notas_agrupadas[$nota['disciplina']][] = $nota;
}

// Eventos
$stmt_eventos = $pdo->prepare("SELECT titulo, data_evento, tipo, disciplina FROM eventos ORDER BY data_evento ASC");
$stmt_eventos->execute();
$eventos = $stmt_eventos->fetchAll(PDO::FETCH_ASSOC);

// --- ROTEAMENTO SIMPLES ---
$page = $_GET['page'] ?? 'tarefas';

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

        <nav class="dashboard-nav">
            <a href="dashboard.php?page=tarefas" class="<?php echo $page === 'tarefas' ? 'active' : ''; ?>">Tarefas</a>
            <a href="dashboard.php?page=notas" class="<?php echo $page === 'notas' ? 'active' : ''; ?>">Notas</a>
            <a href="dashboard.php?page=agenda" class="<?php echo $page === 'agenda' ? 'active' : ''; ?>">Agenda</a>
            </nav>

        <main class="dashboard-main">
            <?php
            // Carrega o conteúdo da aba selecionada
            if ($page === 'tarefas') {
                include 'partials/_tarefas.php';
            } elseif ($page === 'notas') {
                include 'partials/_notas.php';
            } elseif ($page === 'agenda') {
                include 'partials/_agenda.php';
            }
            else {
                // Se uma página inválida for solicitada, carrega as tarefas por padrão
                include 'partials/_tarefas.php';
            }
            ?>
        </main>
    </div>

</body>
</html>