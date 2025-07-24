<?php
// Este controlador busca todos os dados necessários para a visão do aluno.
require_once '../src/core/database.php';

// A variável $usuario_id já está definida no dashboard.php

// --- BUSCA DE DADOS DO ALUNO ---

// Notas
$stmt_notas = $pdo->prepare("SELECT disciplina, tipo_avaliacao, nota FROM notas WHERE aluno_id = ? ORDER BY disciplina");
$stmt_notas->execute([$usuario_id]);
$notas_raw = $stmt_notas->fetchAll(PDO::FETCH_ASSOC);
$notas_agrupadas = [];
foreach ($notas_raw as $nota) {
    $notas_agrupadas[$nota['disciplina']][] = $nota;
}

// Eventos da Agenda
$stmt_eventos = $pdo->prepare("SELECT titulo, data_evento, tipo, disciplina FROM eventos ORDER BY data_evento ASC");
$stmt_eventos->execute();
$eventos = $stmt_eventos->fetchAll(PDO::FETCH_ASSOC);

// Futuramente, adicionaremos a busca de tarefas do aluno aqui.
$tarefas = [];