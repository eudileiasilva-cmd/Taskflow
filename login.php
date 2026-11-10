<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "conexao.php";

$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($email === "" || $senha === "") {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Preencha o e-mail e a senha."
    ]);
    exit;
}

$sql = $conexao->prepare(
    "SELECT id, nome, email, senha FROM usuarios WHERE email = ?"
);

$sql->bind_param("s", $email);
$sql->execute();

$resultado = $sql->get_result();
$usuario = $resultado->fetch_assoc();

if ($usuario && password_verify($senha, $usuario["senha"])) {
    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Login realizado com sucesso!",
        "nome" => $usuario["nome"],
        "email" => $usuario["email"]
    ]);
} else {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "E-mail ou senha incorretos."
    ]);
}
?>
