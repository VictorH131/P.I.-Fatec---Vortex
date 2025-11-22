<?php
session_start();
require_once 'dbconnect.php'; 


// VERIFICA MÉTODO
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Acesso inválido.";
    exit;
}


// DADOS DA SESSÃO
$nomeUsuario = $_SESSION['usuario']['nome'];
$class = $_SESSION['usuario']['class'];
$matricula = $_SESSION['usuario']['matricula'];
$curso = $_SESSION['usuario']['curso'];
$semestre = $_SESSION['usuario']['semestre'];


// CAMPOS DO FORMULÁRIO
$descricao = $_POST['descricao'] ?? '';
$email = $_POST['email'] ?? '';


// BUSCAR id_aluno NO BANCO
$stmt = $conn->prepare("SELECT id_aluno FROM aluno WHERE matricula = ?");
$stmt->execute([$matricula]);
$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    echo "Erro: aluno não encontrado no banco.";
    exit;
}

$id_aluno = $aluno['id_aluno'];


// UPLOAD DA FOTO
$foto_caminho = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $pasta = "../uploads/fotos/";
    if (!is_dir($pasta)) mkdir($pasta, 0777, true);

    $nome_arquivo = uniqid() . "_" . basename($_FILES['foto']['name']);
    $destino = $pasta . $nome_arquivo;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
        $foto_caminho = "uploads/fotos/" . $nome_arquivo;
    }
}


// INSERIR CANDIDATO NO BANCO
$sql = "INSERT INTO candidato (id_aluno, descricao, email, foto) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_aluno, $descricao, $email, $foto_caminho]);

$id_cand = $conn->lastInsertId(); // pega o id do candidato recém-criado



// BUSCAR A VOTAÇÃO CORRESPONDENTE
$sql = "SELECT id_votacao 
        FROM votacao 
        WHERE curso = ? 
          AND semestre = ? 
          AND status = 'ativo'
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->execute([$curso, $semestre]); // curso e semestre da sessão
$votacao = $stmt->fetch(PDO::FETCH_ASSOC);

if ($votacao) {
    $id_votacao = $votacao['id_votacao'];

    // INSERIR AUTOMATICAMENTE NA TABELA itens_votacao
    $sql2 = "INSERT INTO itens_votacao (id_votacao, id_cand) VALUES (?, ?)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([$id_votacao, $id_cand]);
}



header("Location: ../Sessao_aluno/home_aluno.php");
exit;

?>
