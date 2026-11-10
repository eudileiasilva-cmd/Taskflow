<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "taskflow";
$socket = "/data/data/com.termux/files/usr/var/run/mysqld.sock";

$conexao = new mysqli($host, $usuario, $senha, $banco, 3306, $socket);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4");
?>
