<?php
require_once 'dbconnect.php';
include 'session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_votacao'])) {
    header('Location: ../admin/votar_adm.php');
    exit();
}

$id = $_POST['id_votacao'];

// Pega data/hora atual
$data_fim_atual = date('Y-m-d H:i:s');

$sql = "UPDATE votacao 
        SET status = 'encerrada', data_fim = :data_fim 
        WHERE id_votacao = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':id' => $id,
    ':data_fim' => $data_fim_atual
]);

header("Location: ../Sessao_adm/gerenciar_votacao.php?id=".$id);
exit();
?>
