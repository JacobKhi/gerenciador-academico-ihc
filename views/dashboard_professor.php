<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Professor</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Painel do Professor</h1>
            <a href="../logout.php" class="logout-link">Sair</a>
        </header>

        <main class="dashboard-main">
            <section class="teacher-classes-section">
                <h2>Minhas Turmas e Disciplinas</h2>
                <?php if (empty($turmas_do_professor)): ?>
                    <p>Você ainda não foi atribuído a nenhuma turma.</p>
                <?php else: ?>
                    <div class="class-cards-grid">
                        <?php foreach ($turmas_do_professor as $turma): ?>
                            <div class="class-card">
                                <h3><?php echo htmlspecialchars($turma['nome_turma']); ?></h3>
                                <p><?php echo htmlspecialchars($turma['nome_disciplina']); ?></p>
                                <a href="gerir_turma.php?turma_id=<?php echo $turma['turma_id']; ?>&disciplina_id=<?php echo $turma['disciplina_id']; ?>" class="class-card-link">Gerir Turma</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>