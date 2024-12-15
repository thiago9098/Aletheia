<?php
include("configA.php");

session_start();

// Ativar relatório de erros para depuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Garantir que o cabeçalho seja JSON
header('Content-Type: application/json');

// Verificar se o usuário está logado
if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit();
}

// Ler o conteúdo da requisição JSON
$data = json_decode(file_get_contents('php://input'), true);
// Verificar se os dados foram recebidos corretamente
if ($data === null) {
    echo json_encode(['status' => 'error', 'message' => 'Dados JSON inválidos.']);
    exit();
}

$titulo = $_POST['title'] ?? '';
$texto = $_POST['text'] ?? '';
$horario = date('Y-m-d H:i:s'); // Data atual
$aluno_email = $_SESSION['email']; // Email da sessão ativa

if (empty($titulo) || empty($texto)) {
    echo json_encode(['status' => 'error', 'message' => 'Título e texto são obrigatórios.']);
    exit();
}

$sql = "INSERT INTO comentario (titulo, texto, data, email_aluno) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Erro na preparação da consulta.']);
    exit();
}

$stmt->bind_param("ssss", $titulo, $texto, $horario, $aluno_email);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Comentário salvo com sucesso!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar comentário.']);
}

$stmt->close();
$conn->close();
?>