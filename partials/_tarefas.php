<section class="add-task-section">
    <h2>Adicionar Nova Tarefa</h2>
    <form action="dashboard.php?page=tarefas" method="POST" class="add-task-form">
        <input type="text" name="disciplina" placeholder="Disciplina (ex: Matemática)" class="task-input">
        <input type="text" name="descricao" placeholder="O que precisa ser feito?" required class="task-input-desc">
        <button type="submit" name="add_task">Adicionar</button>
    </form>
</section>

<section class="tasks-section">
    <h2>Minhas Tarefas</h2>
    <form action="dashboard.php?page=tarefas" method="POST">
        <button type="submit" name="update_tasks" class="button-update-tasks">Atualizar Tarefas</button>
        <ul class="tasks-list">
            <?php foreach ($tarefas as $tarefa): ?>
                <li class="task-item <?php echo $tarefa['concluida'] ? 'completed' : ''; ?>">
                    <div class="task-checkbox">
                        <input type="checkbox" name="tarefas_concluidas[]" value="<?php echo $tarefa['id']; ?>" id="task-<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                        <label for="task-<?php echo $tarefa['id']; ?>"></label>
                    </div>
                    <div class="task-info">
                        <span class="task-subject"><?php echo htmlspecialchars($tarefa['disciplina']); ?></span>
                        <p class="task-description"><?php echo htmlspecialchars($tarefa['descricao']); ?></p>
                    </div>
                    <a href="dashboard.php?page=tarefas&delete_task=<?php echo $tarefa['id']; ?>" class="delete-task-link" title="Apagar Tarefa">&#128465;</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </form>
</section>