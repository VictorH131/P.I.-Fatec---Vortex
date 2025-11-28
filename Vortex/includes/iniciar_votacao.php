<?php
require_once 'dbconnect.php';
include 'session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_votacao'])) {
    header('Location: ../admin/votar_adm.php');
    exit();
}

$id = $_POST['id_votacao'];

// Data e hora atual do servidor
$dataAtual = date("Y-m-d H:i:s");

// Atualiza SOMENTE a data de início
$sql = "UPDATE votacao SET data_inicio = :dataAtual WHERE id_votacao = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':dataAtual' => $dataAtual,
    ':id' => $id
]);

header("Location: ../Sessao_adm/gerenciar_votacao.php?id=" . $id);
exit();
