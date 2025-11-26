<?php
include '../includes/session.php';
include '../includes/header_adm.php';
require_once '../includes/dbconnect.php';

echo '<title>Gerenciamento Administrativo - Vortex</title>';

$status = 'ativo';
$votacoes = [];

try {
    if (!empty($_POST['curso']) && !empty($_POST['semestre'])) {

        $sql = "SELECT * FROM votacao 
                WHERE curso = :curso 
                  AND semestre = :semestre
                  AND status = :status
                ORDER BY curso ASC, semestre ASC, data_inicio DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':curso' => $_POST['curso'],
            ':semestre' => $_POST['semestre'],
            ':status' => $status
        ]);

    } else {

        // Lista TODAS as votações
        $sql = "SELECT * FROM votacao 
                WHERE status = :status
                ORDER BY curso ASC, semestre ASC, data_inicio DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':status' => $status]);
    }

    $votacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao buscar votações: " . $e->getMessage());
}
?>

<main id="mainVer">   
    <div class="content">
        <div class="title-section">Gerenciamento das Votações</div>

        
        <form action="criar_votacao.php" method="post">
            <div class="filtro-container">

                <select class="filtro-select" name="curso" id="curso">
                    <option value="" disabled selected>Selecione o Curso</option>
                    <option value="DSM">DSM - Desenvolvimento de Software Multiplataforma</option>
                    <option value="GI">GI - Gestão Industrial</option>
                    <option value="GE">GE - Gestão Empresarial</option>
                </select>

                <select class="filtro-select" name="semestre" id="semestre">
                    <option value="" disaabled selected>Selecione o Semestre</option>
                    <option value="1">1º Semestre</option>
                    <option value="2">2º Semestre</option>
                    <option value="3">3º Semestre</option>
                    <option value="4">4º Semestre</option>
                    <option value="5">5º Semestre</option>
                    <option value="6">6º Semestre</option>
                </select>

                <button class="filtro-btn">Filtrar</button>
            </div>
        </form>
    </div>
</main>

<main id="maincriavoto">
    <div class="container">
        <h2>Votações</h2>
    </div>

    <?php if (empty($votacoes)): ?>
        <div class="caixa-info">
            <strong>Nenhuma votação encontrada!</strong>
            <p>Use o filtro acima para localizar votações.</p>
        </div>

    <?php else: ?>
        <div class="tabela-votacoes-container">
            <table class="tabela-votacoes">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Semestre</th>
                        <th>Descrição</th>
                        <th>Início</th>
                        <th>Término</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($votacoes as $v): ?>
                        <tr>
                            <td><?= htmlspecialchars($v['curso']) ?></td>
                            <td><?= htmlspecialchars($v['semestre']) ?>º</td>
                            <td><?= htmlspecialchars($v['descricao']) ?></td>
                            <td><?= date('d/m/Y', strtotime($v['data_inicio'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($v['data_fim'])) ?></td>
                            <td>
                                <a href="gerenciar_votacao.php?id=<?= $v['id_votacao'] ?>" class="btn-gerenciar-table">
                                    Gerenciar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>
