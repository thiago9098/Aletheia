<?php
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['email']) && isset($_SESSION['senha'])) {
    echo json_encode(['logado' => true]);
} else {
    echo json_encode(['logado' => false]);
}
?>