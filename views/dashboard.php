<?php
session_start();

// Proteção geral da página
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

// Pega os dados da sessão
$usuario_id = $_SESSION['usuario_id'];
$usuario_perfil = $_SESSION['usuario_perfil'];

// --- Roteador de Perfil ---
if ($usuario_perfil === 'aluno') {
    // Carrega a lógica e depois a visão do aluno
    require_once '../src/controllers/dashboard_aluno_controller.php';
    require_once 'dashboard_aluno.php';

} elseif ($usuario_perfil === 'professor') {
    // Carrega a lógica e depois a visão do professor
    require_once '../src/controllers/dashboard_professor_controller.php';
    require_once 'dashboard_professor.php';

} else {
    // Se o perfil não for reconhecido, mostra uma mensagem e encerra.
    echo "Erro: Perfil de utilizador desconhecido.";
    exit();
}