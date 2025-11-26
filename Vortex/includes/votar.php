<?php
session_start();
require_once "dbconnect.php"; 

if (!isset($_SESSION['usuario']['id'])) {
    header("Location: ../pages/login.php?erro=nao_logado");
    exit;
}

$id_aluno = $_SESSION['usuario']['id'];
$id_cand = isset($_GET['id_cand']) ? intval($_GET['id_cand']) : null;
$id_votacao = isset($_GET['id_votacao']) ? intval($_GET['id_votacao']) : 0;

if ($id_votacao <= 0) {
    header("Location: ../Sessao_aluno/votar.php?erro=ids_invalidos");
    exit;
}

// verifica se já votou
$sql = "SELECT id_voto FROM voto WHERE id_aluno = ? AND id_votacao = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_aluno, $id_votacao]);
$votoExistente = $stmt->fetchColumn();

if ($votoExistente) {
    header("Location: ../Sessao_aluno/votar_aluno.php?aviso=ja_votou");
    exit;
}

// transforma voto em branco (0) em NULL
if ($id_cand === 0) {
    $id_cand = null;
}

// registra o voto (mesmo sendo NULL)
$sql = "INSERT INTO voto (id_aluno, id_votacao, id_cand) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt->execute([$id_aluno, $id_votacao, $id_cand])) {
    // aqui o registro existe, então o bloqueio de voto funciona
    header("Location: ../Sessao_aluno/votar_aluno.php?id=$id_votacao");
    exit;
} else {
    exit("Erro ao registrar voto.");
}
?>
