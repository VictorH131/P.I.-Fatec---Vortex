<?php
require_once '../includes/dbconnect.php';
include '../includes/session.php';
include '../includes/header_adm.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: votar_adm.php');
    exit();
}


$id_votacao = $_GET['id'];

try {
    $sql = "SELECT id_votacao, descricao, data_inicio, data_fim, semestre, curso, status, data_inscricao 
            FROM votacao 
            WHERE id_votacao = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id_votacao]);
    $votacao = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$votacao) {
        die("Votação não encontrada!");
    }

} catch (PDOException $e) {
    die("Erro ao buscar votação: " . $e->getMessage());
}

// Datas em timestamp para comparação
$agora = time();
$inicio = strtotime($votacao['data_inicio']);
$fim = strtotime($votacao['data_fim']);

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

            <a href="editar_votacao.php?id=<?= $votacao['id_votacao'] ?>" class="btn-gerenciar">
                Editar Votação
            </a>

            <?php
            // Lógica do botão dinamicamente:

            // 1. Se ainda não chegou o dia de início → nenhum botão (aguardando)
            if ($agora < $inicio) {
                echo '<span class="btn-gerenciar" style="opacity:0.6;cursor:default;">Aguardando Período</span>';

            // 2. Se já passou do fim → Finalizada
            } elseif ($agora > $fim) {
                echo '<span class="btn-gerenciar" style="opacity:0.6;cursor:default;">Finalizada</span>';

            } else {
                // Estamos dentro do período da votação (entre início e fim)
                
                if ($votacao['status'] === 'pendente') {
                    // 3.1 Mostrar INICIAR
                    ?>
                    <form action="iniciar_votacao.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id_votacao" value="<?= $votacao['id_votacao'] ?>">
                        <button type="submit" class="btn-gerenciar">Iniciar Votação</button>
                    </form>
                    <?php

                } elseif ($votacao['status'] === 'ativo') {
                    // 3.2 Mostrar ENCERRAR
                    ?>
                    <form action="encerrar_votacao.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id_votacao" value="<?= $votacao['id_votacao'] ?>">
                        <button type="submit" class="btn-gerenciar">Encerrar Votação</button>
                    </form>
                    <?php

                } else {
                    // 3.3 Se finalizada no banco mas dentro do período (raro, mas previsto)
                    echo '<span class="btn-gerenciar" style="opacity:0.6;cursor:default;">Finalizada</span>';
                }
            }
            ?>

            <a href="votar_adm.php?curso=<?= urlencode($votacao['curso']) ?>&semestre=<?= $votacao['semestre'] ?>" class="btn-voltar">
                Voltar
            </a>

        </div>
    </div>
</main>

<?php
include '../includes/footer.php';
?>
