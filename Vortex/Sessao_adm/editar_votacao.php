<?php
include '../includes/session.php';
include '../includes/header_adm.php';
require_once '../includes/dbconnect.php';

// Verifica ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: votar_adm.php');
    exit();
}

$id_votacao = $_GET['id'];

// Busca votação
$sql = "SELECT * FROM votacao WHERE id_votacao = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id_votacao]);
$votacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$votacao) {
    die("Votação não encontrada!");
}

$sqlC = "SELECT 
            c.id_cand, 
            a.nome, 
            c.foto AS imagem, 
            c.descricao AS frase
         FROM itens_votacao iv
         JOIN candidato c ON iv.id_cand = c.id_cand
         JOIN aluno a ON c.id_aluno = a.id_aluno
         WHERE iv.id_votacao = :id";

$stmtC = $conn->prepare($sqlC);
$stmtC->execute([':id' => $id_votacao]);
$candidatos = $stmtC->fetchAll(PDO::FETCH_ASSOC);

// Ajustar caminho da imagem (adicionar ../ somente quando necessário)
foreach ($candidatos as &$cand) {
    if ($cand['imagem'] && !str_starts_with($cand['imagem'], 'data:')) {
        $cand['imagem'] = '../' . ltrim($cand['imagem'], '/');
    }
}
unset($cand);


$voltar = $_SERVER['HTTP_REFERER'] ?? 'votar_adm.php';

?>
<title>Gerenciar Votação - <?= htmlspecialchars($votacao['descricao']) ?></title>

<main id="votaradm">
    <h2 class="candidatos-title">Edição de Candidatos</h2>

    <div class="linha-completa">
        <div class="linha-fina"></div>
        <div class="linha-grossa"></div>
        <div class="linha-fina"></div>
    </div>

    <a href="<?= htmlspecialchars($voltar) ?>" class="btn-gerenciar btn-voltar">
        &#8592; Voltar
    </a>



    <div class="container-externa">
        <button class="seta" id="seta-esquerda">&#10094;</button>

        <div class="container-cards" id="votacoes"></div>

        <button class="seta" id="seta-direita">&#10095;</button>
    </div>

    <div class="popup-confirm" id="popup-remover">
        <div class="popup-box">
            <p>Deseja realmente remover este candidato?</p>
            <button class="btn-sim">SIM</button>
            <button class="btn-nao">NÃO</button>
        </div>
    </div>
</main>

<script>
const alunos = <?= json_encode($candidatos) ?>;
</script>

<script src="../js/votar_adm.js"></script>

<?php include '../includes/footer.php'; ?>
