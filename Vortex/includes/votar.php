<?php
session_start();
require_once "dbconnect.php"; // $conn como PDO

// Verifica se está logado
if (!isset($_SESSION['usuario']['id'])) {
    header("Location: ../pages/login.php?erro=nao_logado");
    exit;
}

$id_aluno = $_SESSION['usuario']['id']; // Corrigido para pegar da sessão
$id_cand = isset($_GET['id_cand']) ? intval($_GET['id_cand']) : 0;
$id_votacao = isset($_GET['id_votacao']) ? intval($_GET['id_votacao']) : 0;

// IDs inválidos
if ($id_cand <= 0 || $id_votacao <= 0) {
    header("Location: ../pages/votar.php?erro=ids_invalidos");
    exit;
}

// --- Verificar se já votou ---
$sql = "SELECT id_voto FROM voto WHERE id_aluno = ? AND id_votacao = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_aluno, $id_votacao]); // PDO usa array no execute
$votoExistente = $stmt->fetchColumn();

if ($votoExistente) {
    header("Location: ../pages/votar.php?aviso=ja_votou");
    exit;
}

// --- Registrar voto ---
$sql = "INSERT INTO voto (id_aluno, id_votacao, id_cand) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt->execute([$id_aluno, $id_votacao, $id_cand])) {
    header("Location: ../Sessao_aluno/votar_aluno.php?sucesso=1");
    exit;
} else {
    exit;
}
