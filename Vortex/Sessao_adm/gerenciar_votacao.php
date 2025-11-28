<?php
require_once '../includes/dbconnect.php';
include '../includes/session.php';
include '../includes/header_adm.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: votar_adm.php');
    exit();
}

$id_votacao = $_GET['id'];

$sql = "SELECT id_votacao, descricao, data_inicio, data_fim, semestre, curso, status, data_inscricao 
        FROM votacao 
        WHERE id_votacao = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id_votacao]);
$votacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$votacao) {
    die("Votação não encontrada!");
}

$agora = time();
$inicio = strtotime($votacao['data_inicio']);
$fim = strtotime($votacao['data_fim']);

$sqlC = "SELECT c.id_cand AS id_candidato, a.nome, c.foto
         FROM itens_votacao iv
         JOIN candidato c ON iv.id_cand = c.id_cand
         JOIN aluno a ON c.id_aluno = a.id_aluno
         WHERE iv.id_votacao = :id";

$stmtC = $conn->prepare($sqlC);
$stmtC->execute([':id' => $id_votacao]);
$candidatos = $stmtC->fetchAll(PDO::FETCH_ASSOC);

?>

<title>Gerenciar Votação - <?= htmlspecialchars($votacao['descricao']) ?></title>

<main id="maingerenciarvoto">
    <div class="container">
        <h2>Gerenciar Votação</h2>

        <div class="linha-completa">
            <div class="linha-fina"></div>
            <div class="linha-grossa"></div>
            <div class="linha-fina"></div>
        </div>

        <div class="subtitulo">
            <?= htmlspecialchars($votacao['curso']) ?> - <?= htmlspecialchars($votacao['semestre']) ?>º Semestre
        </div>

        <div class="caixa-info">
            <p><strong>Descrição:</strong> <?= htmlspecialchars($votacao['descricao']) ?></p>
            <p><strong>Data de Início:</strong> <?= date('d/m/Y', $inicio) ?></p>
            <p><strong>Data de Término:</strong> <?= date('d/m/Y', $fim) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($votacao['status']) ?></p>
            <p><strong>Período de Inscrição:</strong> <?= date('d/m/Y', strtotime($votacao['data_inscricao'])) ?></p>
        </div>

        <div class="acoes-gerenciamento">

            <?php
            if (count($candidatos) > 0) {
                ?>
                <a href="editar_votacao.php?id=<?= $votacao['id_votacao'] ?>" class="btn-gerenciar">
                    Editar Participantes
                </a>
                <?php
            } else {
                ?>
                <span class="btn-gerenciar" style="opacity:0.5;cursor:not-allowed;">
                    Editar Participantes
                </span>
                <?php
            }
            ?>

            <?php
            if ($agora < $inicio) {
                echo '<span class="btn-gerenciar" style="opacity:0.6;cursor:default;">Aguardando Período</span>';
            } elseif ($agora > $fim) {
                echo '<span class="btn-gerenciar" style="opacity:0.6;cursor:default;">Finalizada</span>';
            } else {
                if ($votacao['status'] === 'pendente') {
                    ?>
                    <form action="iniciar_votacao.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id_votacao" value="<?= $votacao['id_votacao'] ?>">
                        <button type="submit" class="btn-gerenciar">Ativar</button>
                    </form>
                    <?php
                } elseif ($votacao['status'] === 'ativo') {
                    ?>
                    <form action="encerrar_votacao.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id_votacao" value="<?= $votacao['id_votacao'] ?>">
                        <button type="submit" class="btn-gerenciar">Encerrar</button>
                    </form>
                    <?php
                } else {
                    echo '<span class="btn-gerenciar" style="opacity:0.6;cursor:default;">Finalizada</span>';
                }
            }
            ?>

            
            <form action="../includes/excluir_votacao.php" method="POST" style="display:inline;margin-left:10px;">
                <input type="hidden" name="id_votacao" value="<?= $votacao['id_votacao'] ?>">
                <button type="submit" class="btn-exluir" >Excluir Votação</button>
            </form>

            <a href="votar_adm.php?curso=<?= urlencode($votacao['curso']) ?>&semestre=<?= $votacao['semestre'] ?>" class="btn-voltar">
                Voltar
            </a>

        </div>

        <h3 style="margin-top:40px;">Candidatos</h3>

       <?php if (count($candidatos) === 0): ?>

            <div style="margin-top:30px; text-align:center;">
                <img src="https://img.icons8.com/ios-filled/100/000000/conference-call.png"
                    alt="Ícone de grupo"
                    style="opacity:0.7;">

                <p style="margin-top:15px;font-size:18px;color:#555;">
                    Nenhum candidato inscrito nesta votação.
                </p>
            </div>

        <?php else: ?>

            <div class="lista-candidatos">
                <?php foreach ($candidatos as $c): ?>

                    <?php
                    $foto = (!empty($c['foto']) && file_exists("../" . $c['foto']))
                        ? "../" . $c['foto']
                        : "../img/default_user.png";
                    ?>

                    <div class="card-candidato">
                        <img src="<?= $foto ?>" class="foto-cand">
                        <p><?= htmlspecialchars($c['nome']) ?></p>
                    </div>

                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php
include '../includes/footer.php';
?>
