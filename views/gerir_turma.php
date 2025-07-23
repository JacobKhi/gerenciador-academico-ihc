<?php
session_start();
// Carrega a lógica do controlador para buscar os dados
require_once '../src/controllers/gerir_turma_controller.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Turma - <?php echo htmlspecialchars($info_turma['nome_turma']); ?></title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <header class="page-header">
            <div>
                <h1><?php echo htmlspecialchars($info_turma['nome_turma']); ?></h1>
                <p class="subtitle"><?php echo htmlspecialchars($info_turma['nome_disciplina']); ?></p>
            </div>
            <a href="dashboard.php" class="back-link">Voltar ao Painel</a>
        </header>

        <main class="dashboard-main">
            <section class="student-list-section">
                <h2>Alunos da Turma</h2>
                <table class="student-table">
                    <thead>
                        <tr>
                            <th>Nome do Aluno</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos_da_turma as $aluno): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                                <td class="actions-cell">
                                    <a href="#" class="action-button">Lançar Nota</a>
                                    <a href="#" class="action-button">Ver Presenças</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>