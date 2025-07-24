<?php
session_start();

// Caminhos corrigidos a partir da raiz do projeto
require_once 'src/core/database.php';
require_once 'src/controllers/nota_controller.php';

// --- AÇÕES PÚBLICAS (NÃO PRECISAM DE LOGIN) ---

if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($nome) && !empty($email) && !empty($senha) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmtCheck->execute([$email]);
        if ($stmtCheck->fetch()) {
            header('Location: views/register.php?error=email_exists');
            exit();
        }

        $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
        $perfil = 'aluno';

        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $hashSenha, $perfil]);

        header('Location: views/index.php?success=registered');
        exit();
    } else {
        header('Location: views/register.php?error=invalid_data');
        exit();
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_perfil'] = $usuario['perfil'];

        header('Location: views/dashboard.php');
        exit();
    } else {
        header('Location: views/index.php?error=invalid_credentials');
        exit();
    }
}


// --- BARREIRA DE SEGURANÇA ---
// A partir daqui, todas as ações exigem que o utilizador esteja logado.
if (!isset($_SESSION['usuario_id'])) {
    header('Location: views/index.php');
    exit();
}
$usuario_id = $_SESSION['usuario_id'];


// --- AÇÕES PRIVADAS (PRECISAM DE LOGIN) ---

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'lancar_notas') {
        lancar_notas_action($pdo);
    } 
    elseif ($action === 'add_task') {
        $nova_descricao = trim($_POST['descricao']);
        $nova_disciplina = trim($_POST['disciplina']);
        if (!empty($nova_descricao)) {
            $stmt = $pdo->prepare("INSERT INTO tarefas (descricao, disciplina, usuario_id) VALUES (?, ?, ?)");
            $stmt->execute([$nova_descricao, $nova_disciplina, $usuario_id]);
        }
        header('Location: views/dashboard.php?page=tarefas');
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
        header('Location: views/dashboard.php?page=tarefas');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'] ?? '';

    if ($action === 'delete_task' && isset($_GET['id'])) {
        $task_id_to_delete = $_GET['id'];
        $stmtDelete = $pdo->prepare("DELETE FROM tarefas WHERE id = ? AND usuario_id = ?");
        $stmtDelete->execute([$task_id_to_delete, $usuario_id]);
        
        header('Location: views/dashboard.php?page=tarefas');
        exit();
    }
}

header('Location: views/dashboard.php');
exit();