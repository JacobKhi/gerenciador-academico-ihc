<?php
// Este controlador busca os dados para a página de gestão de uma turma específica.
require_once '../src/core/database.php';

// Proteção: Garante que os IDs da turma e da disciplina foram passados pela URL.
if (!isset($_GET['turma_id']) || !isset($_GET['disciplina_id'])) {
    header('Location: dashboard.php');
    exit();
}

$turma_id = $_GET['turma_id'];
$disciplina_id = $_GET['disciplina_id'];
$professor_id = $_SESSION['usuario_id'];

// Busca os nomes da turma e da disciplina para o título da página.
$stmt_info = $pdo->prepare("SELECT nome_turma, nome_disciplina FROM turmas t, disciplinas d WHERE t.id = ? AND d.id = ?");
$stmt_info->execute([$turma_id, $disciplina_id]);
$info_turma = $stmt_info->fetch(PDO::FETCH_ASSOC);

// Busca a lista de alunos matriculados naquela turma.
$stmt_alunos = $pdo->prepare("
    SELECT u.id, u.nome 
    FROM usuarios u
    JOIN turma_alunos ta ON u.id = ta.aluno_id
    WHERE ta.turma_id = ?
    ORDER BY u.nome
");
$stmt_alunos->execute([$turma_id]);
$alunos_da_turma = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);