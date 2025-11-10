<?php
require_once '../includes/dbconnect.php'; // conexão com o banco
include '../includes/session.php'; // verifica se está logado
include '../includes/header_adm.php'; // header

$votacoes = [];

if (isset($_POST['curso'], $_POST['semestre'])) {
    $curso = $_POST['curso'];
    $semestre = $_POST['semestre'];
    $status = 'ativo';

    // Consultando as votações existentes com segurança
    try {
        $sql = "SELECT id_votacao, descricao, data_inicio, data_fim, semestre, curso, status, data_inscricao 
            FROM votacao 
            WHERE curso = :curso 
              AND semestre = :semestre
              AND status = :status
            ORDER BY data_inicio DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':curso' => $curso,
            ':semestre' => $semestre,
            ':status' => $status
        ]);
        $votacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao buscar votações: " . $e->getMessage());
    }

    echo '<title>Votações - ', $curso, ' ', $semestre, 'º Semestre</title>'; // titulo da pagina
} else {
    header('Location: votar_adm.php');
}

?>

<!-- Main criar votações -->
<main id="maincriavoto">
    <div class="container">
        <h2>Votações</h2>
        <div class="linha-completa">
            <div class="linha-fina"></div>
            <div class="linha-grossa"></div>
            <div class="linha-fina"></div>
        </div>

        <?php if (isset($curso, $semestre)): ?>
            <div class="subtitulo"><?= htmlspecialchars($curso) ?> - <?= htmlspecialchars($semestre) ?>º Semestre</div>
            <a href="criacao_votacao.php"><button class="btn-criar">Criar Votação</button></a>
        <?php endif; ?>
    </div>

   <?php if (empty($votacoes)): ?>
    <div class="caixa-info">
        <strong>Parece que não há nenhuma votação disponível!</strong>
        <p>Crie uma votação através do botão acima para poder iniciá-la.</p>
    </div>
  <?php else: ?>

  <div class="tabela-votacoes-container">
      <table class="tabela-votacoes">
          <thead>
              <tr>
                  <th>Curso</th>
                  <th>Descrição</th>
                  <th>Início</th>
                  <th>Término</th>
                  <th>Ações</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach($votacoes as $vot): ?>
                  <tr>
                      <td><?= htmlspecialchars($vot['curso']) ?></td>
                      <td><?= htmlspecialchars($vot['descricao']) ?></td>
                      <td><?= date('d/m/Y', strtotime($vot['data_inicio'])) ?></td>
                      <td><?= date('d/m/Y', strtotime($vot['data_fim'])) ?></td>
                      <td>
                          <a href="gerenciar_votacao.php?id=<?= $vot['id_votacao'] ?>" class="btn-gerenciar-table">
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

<?php
include '../includes/footer.php';
?>
