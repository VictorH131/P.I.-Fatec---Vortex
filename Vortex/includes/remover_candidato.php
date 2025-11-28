<?php
include 'dbconnect.php'; // conexão com o banco

header('Content-Type: application/json');

$id_cand = $_POST['id_cand'] ?? null;

if (!$id_cand) {
    echo json_encode(['success' => false, 'msg' => 'ID do candidato não informado']);
    exit;
}

try {
    // Deleta candidato
    $stmt = $conn->prepare("DELETE FROM itens_votacao WHERE id_cand = :id");
    $stmt->execute([':id' => $id_cand]);

    $stmt2 = $conn->prepare("DELETE FROM candidato WHERE id_cand = :id");
    $stmt2->execute([':id' => $id_cand]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
}
