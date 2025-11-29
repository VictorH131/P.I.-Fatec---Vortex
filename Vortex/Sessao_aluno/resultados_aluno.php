<?php
include '../includes/session.php';
include '../includes/header_aluno.php';
require_once '../includes/dbconnect.php';

echo '<title>Resultados - Vortex</title>';

// Verifica se o ID da votação foi passado
if (!isset($_GET['id'])) {
    die("Erro: votação não especificada.");
}

$id_votacao = $_GET['id'];

// Pega a votação
$sql = "SELECT * FROM votacao WHERE id_votacao = :id AND status = 'encerrada'";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id_votacao]);
$votacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$votacao) {
    die("Votação não encontrada ou ainda não encerrada.");
}

// Pega os candidatos e seus votos
$sqlC = "SELECT c.id_cand, a.nome, c.foto, COUNT(v.id_voto) AS total_votos
         FROM candidato c
         JOIN aluno a ON c.id_aluno = a.id_aluno
         LEFT JOIN voto v ON v.id_cand = c.id_cand AND v.id_votacao = :id_voto
         WHERE c.id_cand IN (SELECT id_cand FROM itens_votacao WHERE id_votacao = :id_itens)
         GROUP BY c.id_cand
         ORDER BY total_votos DESC";

$stmtC = $conn->prepare($sqlC);
$stmtC->execute([
    ':id_voto'  => $id_votacao,
    ':id_itens' => $id_votacao
]);

$candidatos = $stmtC->fetchAll(PDO::FETCH_ASSOC);

// Pega apenas os dois primeiros
$candidatos = array_slice($candidatos, 0, 2);
?>

<main id="maindex">
<h2>Votações Encerradas</h2>
<div class="linha-completa">
    <div class="linha-grossa"></div>
    <div class="linha-fina"></div>
</div>

<?php if(count($candidatos) === 0): ?>
    <p>Nenhum candidato participou desta votação.</p>
<?php else: ?>
    <?php foreach($candidatos as $i => $c): 
        $foto = (!empty($c['foto']) && file_exists("../".$c['foto'])) ? "../".$c['foto'] : "../img/default_user.png";
        $posição = $i + 1;
        $texto_posição = $posição === 1 ? "VOCÊ FOI O ESCOLHIDO!!!" : "VOCÊ FOI O 2º ESCOLHIDO!!!";
        $papel = $posição === 1 ? "representante" : "suplente";
    ?>
    <div class="candidate">
        <div class="candidate-info">
            <img src="<?= $foto ?>" alt="<?= htmlspecialchars($c['nome']) ?>" />
            <h3><?= htmlspecialchars($c['nome']) ?></h3>
            <p>Fazendo assim você é o <?= $papel ?> da turma <?= htmlspecialchars($votacao['curso']) ?> do <?= htmlspecialchars($votacao['semestre']) ?>º Semestre.</p>
        </div>

        <div class="result-info">
            <p>Parabéns <?= htmlspecialchars($c['nome']) ?></p>
            <strong><?= $texto_posição ?></strong>
            <p>Esse é o seu total de votos Parabéns!! </p>
            <div class="result-circle"><?= $c['total_votos'] ?></div>
            <div class="icon-footer">
                <img src="../img/fatec_mini.png" alt="Icone 1" style="margin-top: -6px">
                <img src="../img/logo_vortex_Nome.PNG" alt="Icone 3">
                <img src="../img/cps_mini.png" alt="Icone 2">
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</main>

<?php
include '../includes/footer.php';
?>
