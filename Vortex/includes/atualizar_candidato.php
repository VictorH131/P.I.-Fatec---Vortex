<?php
include 'session.php';
require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cand = $_POST['id_cand'] ?? null;
    $nome = $_POST['nome'] ?? '';
    $frase = $_POST['frase'] ?? '';
    $imagem = $_POST['imagem'] ?? '';

    if (!$id_cand || !$nome || !$frase) {
        echo json_encode(['success' => false, 'message' => 'Campos obrigatórios!']);
        exit();
    }

    // Atualiza o candidato no banco
    $sql = "UPDATE candidato SET descricao = :frase WHERE id_cand = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':frase' => $frase, ':id' => $id_cand]);

    $sqlAluno = "UPDATE aluno SET nome = :nome WHERE id_aluno = (SELECT id_aluno FROM candidato WHERE id_cand = :id)";
    $stmtAluno = $conn->prepare($sqlAluno);
    $stmtAluno->execute([':nome' => $nome, ':id' => $id_cand]);

    // Atualiza a imagem, se enviada
    if ($imagem) {
        $base64 = explode(',', $imagem)[1]; // remove data:image/png;base64,
        $data = base64_decode($base64);
        $pasta = '../img/uploads/';
        if (!is_dir($pasta)) mkdir($pasta, 0755, true);
        $nomeArquivo = uniqid('cand_') . '.png';
        file_put_contents($pasta . $nomeArquivo, $data);

        $sqlImg = "UPDATE candidato SET foto = :foto WHERE id_cand = :id";
        $stmtImg = $conn->prepare($sqlImg);
        $stmtImg->execute([':foto' => 'img/uploads/' . $nomeArquivo, ':id' => $id_cand]);
    }

    echo json_encode(['success' => true]);
}
?>