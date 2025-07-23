<?php
session_start();

// O caminho para a base de dados agora entra na pasta 'src'
require_once 'src/core/database.php';

// --- AÇÕES PÚBLICAS (NÃO PRECISAM DE LOGIN) ---

if (isset($_POST['action']) && $_POST['action'] === 'register') {
    // ... (a lógica de registo continua a mesma)
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($nome) && !empty($email) && !empty($senha) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmtCheck->execute([$email]);
        if ($stmtCheck->fetch()) {
            // Redireciona de volta para a pasta 'views'
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

        // Redireciona para o dashboard dentro da pasta 'views'
        header('Location: views/dashboard.php');
        exit();
    } else {
        header('Location: views/index.php?error=invalid_credentials');
        exit();
    }
}


// --- BARREIRA DE SEGURANÇA ---
if (!isset($_SESSION['usuario_id'])) {
    header('Location: views/index.php');
    exit();
}
$usuario_id = $_SESSION['usuario_id'];


// --- AÇÕES PRIVADAS (PRECISAM DE LOGIN) ---

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_task') {
        // ... (lógica de adicionar tarefa)
        header('Location: views/dashboard.php?page=tarefas');
        exit();
    } 
    elseif ($action === 'update_tasks') {
        // ... (lógica de atualizar tarefas)
        header('Location: views/dashboard.php?page=tarefas');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'] ?? '';

    if ($action === 'delete_task' && isset($_GET['id'])) {
        // ... (lógica de apagar tarefa)
        header('Location: views/dashboard.php?page=tarefas');
        exit();
    }
}

header('Location: views/dashboard.php');
exit();