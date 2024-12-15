<?php
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['email'])) {
    echo json_encode([
        'logado' => true,
        'email' => $_SESSION['email']
]);
} else if (isset($_SESSION['admin_email'])) {
    echo json_encode([
        'logado' => true,
        'email' => $_SESSION['admin_email']
]);
} else {
    echo json_encode(['logado' => false]);
}
?>