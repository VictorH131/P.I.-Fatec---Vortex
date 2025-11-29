<?php
include '../includes/session.php'; 
include '../includes/header_aluno.php';
require_once '../includes/dbconnect.php';

echo '<title>Área de Votação - Vortex</title>';

if (!isset($_SESSION['usuario']['curso'], $_SESSION['usuario']['semestre'])) {
    die("Erro: curso e semestre do aluno não foram encontrados na sessão.");
}

$curso = $_SESSION['usuario']['curso'];
$semestre = $_SESSION['usuario']['semestre'];

try {
    // Pega a votação mais recente do curso/semestre
    $sql = "SELECT id_votacao, descricao, data_inicio, data_fim, data_inscricao, curso, semestre, status
            FROM votacao
            WHERE curso = :curso AND semestre = :semestre
            ORDER BY data_inicio DESC
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':curso' => $curso,
        ':semestre' => $semestre
    ]);
    $votacao = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar votação: " . $e->getMessage());
}

if ($votacao) {
    $agora  = time();
    $inicio = strtotime($votacao['data_inicio']);
    $fim    = strtotime($votacao['data_fim']);

    if ($votacao['status'] === 'encerrada' || $agora > $fim) {
        // Encerrada → redireciona para resultados
        header("Location: ../Sessao_aluno/resultados_aluno.php?id=" . $votacao['id_votacao']);
        exit;
    } elseif ($agora >= $inicio && $agora <= $fim) {
        // Em andamento → redireciona para votar
        header("Location: ../Sessao_aluno/votar_aluno.php");
        exit;
    } else {
        // Antes do início → inscrição
        $estado_votacao = 'inscricao';
    }
} else {
    $estado_votacao = 'nenhuma';
}
?>

<main id="mainvotarinicio">
<section>

<?php if ($estado_votacao === 'inscricao'): ?>
    <h2>Votação Aberta!</h2>
    <div class="linha-completa">
        <div class="linha-grossa"></div>
        <div class="linha-fina"></div>
    </div>
    <p>Você tem até <strong><?= date('d/m/Y H:i', strtotime($votacao['data_inscricao'])) ?></strong>
       para se inscrever como candidato(a).</p>
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

<?php elseif ($estado_votacao === 'nenhuma'): ?>
    <h2>Nenhuma votação encontrada</h2>
    <div class="linha-completa">
        <div class="linha-grossa"></div>
        <div class="linha-fina"></div>
    </div><br><br><br>
    <p>No momento, não há votações para o seu curso (<?= htmlspecialchars($curso) ?>)
       e semestre (<?= htmlspecialchars($semestre) ?>º).</p>
       <br><br><br><br><br><br><br>
<?php endif; ?>

</section>
</main>

<?php include '../includes/footer.php'; ?>
