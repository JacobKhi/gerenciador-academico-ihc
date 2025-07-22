<?php
session_start();
require_once 'config/database.php';

// --- AÇÕES PÚBLICAS (NÃO PRECISAM DE LOGIN) ---

// Verifica se a ação é 'register' ANTES de verificar se o utilizador está logado.
if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($nome) && !empty($email) && !empty($senha) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Verifica se o e-mail já existe
        $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmtCheck->execute([$email]);
        if ($stmtCheck->fetch()) {
            // Futuramente, podemos mostrar esta mensagem na página.
            die("Erro: O e-mail já existe.");
        }

        // Hash da senha para segurança
        $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
        $perfil = 'aluno';

        // Insere o novo utilizador
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $hashSenha, $perfil]);

        // Redireciona para o login após o sucesso
        header('Location: index.php?success=registered');
        exit();
    } else {
        // Se os dados forem inválidos, volta para a página de registo
        header('Location: register.php?error=invalid_data');
        exit();
    }
}


// --- BARREIRA DE SEGURANÇA ---
// A partir daqui, todas as ações exigem que o utilizador esteja logado.
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
$usuario_id = $_SESSION['usuario_id'];


// --- AÇÕES PRIVADAS (PRECISAM DE LOGIN) ---

// Processa ações de formulário (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_task') {
        $nova_descricao = trim($_POST['descricao']);
        $nova_disciplina = trim($_POST['disciplina']);
        if (!empty($nova_descricao)) {
            $stmt = $pdo->prepare("INSERT INTO tarefas (descricao, disciplina, usuario_id) VALUES (?, ?, ?)");
            $stmt->execute([$nova_descricao, $nova_disciplina, $usuario_id]);
        }
        header('Location: dashboard.php?page=tarefas');
        exit();
    } 
    elseif ($action === 'update_tasks') {
        $tarefasConcluidasIDs = $_POST['tarefas_concluidas'] ?? [];
        $stmtReset = $pdo->prepare("UPDATE tarefas SET concluida = FALSE WHERE usuario_id = ?");
        $stmtReset->execute([$usuario_id]);
        if (!empty($tarefasConcluidasIDs)) {
            $placeholders = implode(',', array_fill(0, count($tarefasConcluidasIDs), '?'));
            $stmtUpdate = $pdo->prepare("UPDATE tarefas SET concluida = TRUE WHERE usuario_id = ? AND id IN ($placeholders)");
            $params = array_merge([$usuario_id], $tarefasConcluidasIDs);
            $stmtUpdate->execute($params);
        }
        header('Location: dashboard.php?page=tarefas');
        exit();
    }
}

// Processa ações de link (GET)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'] ?? '';

    if ($action === 'delete_task' && isset($_GET['id'])) {
        $task_id_to_delete = $_GET['id'];
        $stmtDelete = $pdo->prepare("DELETE FROM tarefas WHERE id = ? AND usuario_id = ?");
        $stmtDelete->execute([$task_id_to_delete, $usuario_id]);
        header('Location: dashboard.php?page=tarefas');
        exit();
    }
}

// Se nenhuma ação válida for encontrada, apenas redireciona para o dashboard.
header('Location: dashboard.php');
exit();