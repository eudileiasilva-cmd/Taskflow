<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "conexao.php";

$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($nome === "" || $email === "" || $senha === "") {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Preencha todos os campos."
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "E-mail inválido."
    ]);
    exit;
}

if (strlen($senha) < 6) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "A senha deve ter pelo menos 6 caracteres."
    ]);
    exit;
}

$verificar = $conexao->prepare(
    "SELECT id FROM usuarios WHERE email = ?"
);
$verificar->bind_param("s", $email);
$verificar->execute();
$resultado = $verificar->get_result();

if ($resultado->num_rows > 0) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Este e-mail já está cadastrado."
    ]);
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = $conexao->prepare(
    "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)"
);
$sql->bind_param("sss", $nome, $email, $senhaHash);

if ($sql->execute()) {
    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Cadastro realizado com sucesso!"
    ]);
} else {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Não foi possível realizar o cadastro."
    ]);
}
?>
