<?php
// Arquivo de configuração e conexão com o banco de dados.

$host = 'localhost';
$dbname = 'gerenciador_academico_db'; 
$user = 'root';                   
$pass = 'toor';                      

try {
    // Usamos PDO (PHP Data Objects) por ser uma forma moderna e segura de conectar.
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    // Configura o PDO para lançar exceções em caso de erro.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Em caso de falha na conexão, o script é interrompido e exibe uma mensagem.
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}