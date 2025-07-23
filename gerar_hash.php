<?php

$senha_para_converter = 'pai123';

$hash_gerado = password_hash($senha_para_converter, PASSWORD_DEFAULT);

echo "<h1>Gerador de Hash de Senha</h1>";
echo "<p><b>Senha em texto plano:</b> " . htmlspecialchars($senha_para_converter) . "</p>";
echo "<p><b>Hash seguro gerado:</b></p>";
echo "<textarea rows='3' cols='80' readonly>" . htmlspecialchars($hash_gerado) . "</textarea>";
echo "<h3>Copie o hash acima para usar nos comandos UPDATE.</h3>";
?>