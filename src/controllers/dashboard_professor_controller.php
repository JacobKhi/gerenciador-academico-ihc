<?php
// Este controlador busca os dados necessários para a visão do professor.

// A variável $usuario_id já está definida no dashboard.php
// A variável $pdo também já está disponível, pois o dashboard.php a inclui.
require_once '../src/core/database.php';

// Busca as turmas, disciplinas e nomes associados ao professor logado.
$stmt = $pdo->prepare("
    SELECT 
        t.nome_turma,
        d.nome_disciplina,
        tdp.turma_id,
        tdp.disciplina_id
    FROM 
        turma_disciplinas_professores tdp
    JOIN 
        turmas t ON tdp.turma_id = t.id
    JOIN 
        disciplinas d ON tdp.disciplina_id = d.id
    WHERE 
        tdp.professor_id = ?
    ORDER BY
        t.nome_turma, d.nome_disciplina
");

$stmt->execute([$usuario_id]);
$turmas_do_professor = $stmt->fetchAll(PDO::FETCH_ASSOC);