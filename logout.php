<?php
// Inicia a sessão para poder manipulá-la.
session_start();

// Remove todas as variáveis da sessão.
session_unset();

// Destrói a sessão por completo.
session_destroy();

// Redireciona o usuário de volta para a página de login.
header('Location: index.php');
exit();
?>