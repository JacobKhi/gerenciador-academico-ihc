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
                <h2>Lançar / Editar Notas</h2>
                <form action="../processa_acoes.php" method="POST">
                    <input type="hidden" name="action" value="lancar_notas">
                    <input type="hidden" name="turma_id" value="<?php echo $turma_id; ?>">
                    <input type="hidden" name="disciplina_id" value="<?php echo $disciplina_id; ?>">

                    <div class="form-group">
                        <label for="tipo_avaliacao">Nome da Avaliação (ex: Prova 1, Trabalho Final)</label>
                        <input type="text" id="tipo_avaliacao" name="tipo_avaliacao" required>
                    </div>

                    <table class="student-table">
                        <thead>
                            <tr>
                                <th>Nome do Aluno</th>
                                <th style="width: 150px;">Nota (0.00 a 10.00)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alunos_da_turma as $aluno): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                                    <td>
                                        <input type="hidden" name="aluno_id[]" value="<?php echo $aluno['id']; ?>">
                                        <input type="number" name="notas[]" class="grade-input" step="0.01" min="0" max="10">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="button-update-tasks" style="float: right; margin-top: 20px;">Salvar Notas</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>