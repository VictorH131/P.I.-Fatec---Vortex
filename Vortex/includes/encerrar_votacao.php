<?php
require_once 'dbconnect.php';
include 'session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_votacao'])) {
    header('Location: ../admin/votar_adm.php');
    exit();
}

$id = $_POST['id_votacao'];

$sql = "UPDATE votacao SET status = 'encerrada' WHERE id_votacao = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);

header("Location: ../Sessao_adm/gerenciar_votacao.php?id=".$id);
exit();
