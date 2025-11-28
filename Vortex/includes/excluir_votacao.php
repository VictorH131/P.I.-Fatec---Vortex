<?php
require_once 'dbconnect.php';
include 'session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_votacao'])) {
    header('Location: ../admin/votar_adm.php');
    exit();
}

$id = $_POST['id_votacao'];

// Exclui votos
$sql1 = "DELETE FROM voto WHERE id_votacao = :id";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute([':id' => $id]);

// Pega candidatos associados
$sqlCand = "SELECT id_cand FROM itens_votacao WHERE id_votacao = :id";
$stmtCand = $conn->prepare($sqlCand);
$stmtCand->execute([':id' => $id]);
$cands = $stmtCand->fetchAll(PDO::FETCH_COLUMN);

// Exclui itens da votação
$sql2 = "DELETE FROM itens_votacao WHERE id_votacao = :id";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([':id' => $id]);

// Exclui candidatos relacionados 
if (!empty($cands)) {
    $sql3 = "DELETE FROM candidato WHERE id_cand IN (" . implode(',', $cands) . ")";
    $conn->prepare($sql3)->execute();
}

// Exclui a votação
$sql4 = "DELETE FROM votacao WHERE id_votacao = :id";
$stmt4 = $conn->prepare($sql4);
$stmt4->execute([':id' => $id]);

header("Location: ../Sessao_adm/votar_adm.php?msg=excluida");
exit();
