<?php
// src/controllers/nota_controller.php

function lancar_notas_action($pdo) {
    // A ação de lançar notas será implementada aqui em breve.
    // Por enquanto, apenas redirecionamos de volta.
    
    $turma_id = $_POST['turma_id'] ?? 0;
    $disciplina_id = $_POST['disciplina_id'] ?? 0;
    
    // Redireciona de volta para a página da turma
    header("Location: ../views/gerir_turma.php?turma_id=$turma_id&disciplina_id=$disciplina_id&status=not_implemented");
    exit();
}