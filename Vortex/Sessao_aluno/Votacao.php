<?php
include '../includes/session.php'; // Verifica se está logado
include '../includes/header_aluno.php';
require_once '../includes/dbconnect.php';

echo '<title>Área de Votação - Vortex</title>';

// VERIFICA SE O CURSO E SEMESTRE ESTÃO NA SESSÃO DO ALUNO
if (!isset($_SESSION['usuario']['curso'], $_SESSION['usuario']['semestre'])) {
    die("Erro: curso e semestre do aluno não foram encontrados na sessão.");
}

$curso = $_SESSION['usuario']['curso'];
$semestre = $_SESSION['usuario']['semestre'];
$status = "ativo";

try {
    $sql = "SELECT id_votacao, descricao, data_inicio, data_fim, data_inscricao, curso, semestre
            FROM votacao
            WHERE curso = :curso
              AND semestre = :semestre
              AND status = :status
            ORDER BY data_inicio DESC
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':curso' => $curso,
        ':semestre' => $semestre,
        ':status' => $status
    ]);

    $votacao = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao buscar votação: " . $e->getMessage());
}

?>

<?php

//   REDIRECIONAR SE O PERÍODO DE INSCRIÇÃO JÁ ACABOU
if ($votacao) {

    $agora = time();
    $inicio = strtotime($votacao['data_inicio']); // início da votação oficial

    // Se o horário atual já passou do início → redireciona para votação
    if ($agora >= $inicio) {
        header("Location: ../Sessao_aluno/votar_aluno.php");
        exit;
    }
}

?>

<main id="mainvotarinicio">
<section>

<?php if (!$votacao): ?>
    <h2>Nenhuma votação ativa</h2>
    <div class="linha-completa">
        <div class="linha-grossa"></div>
        <div class="linha-fina"></div>
    </div>
    <p>
        No momento, não há votações abertas para o seu curso (<?= htmlspecialchars($curso) ?>)
        e seu semestre (<?= htmlspecialchars($semestre) ?>º).
    </p>

<?php else: ?>

    <h2>Votação Aberta!</h2>
    <div class="linha-completa">
        <div class="linha-grossa"></div>
        <div class="linha-fina"></div>
    </div>

    <p>
        Você tem até 
        <strong><?= date('d/m/Y H:i', strtotime($votacao['data_inscricao'])) ?></strong>
        para se inscrever como candidato(a).
    </p>

    <p><?= htmlspecialchars($votacao['descricao']) ?></p>

    <div class="card">
        <div class="card-icon">
            <img src="https://img.icons8.com/ios-filled/50/000000/conference-call.png" alt="ícone">
        </div>
        <div class="card-content">
            <p>Candidate-se para ser representante da sua sala!</p>
            <a href="Eleja-se.php?id=<?= $votacao['id_votacao'] ?>">CANDIDATE-SE JÁ</a>
        </div>
    </div>

<?php endif; ?>

</section>
</main>

<?php include '../includes/footer.php'; ?>
