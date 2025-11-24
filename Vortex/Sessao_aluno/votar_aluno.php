<?php
include '../includes/session.php';
include '../includes/header_aluno.php';

echo '<title>Área de Votação - Vortex</title>';

require '../includes/dbconnect.php'; // usa $conn (PDO)

// Pegando o ID da votação via GET (ou defina fixo se quiser)
$id_votacao = $_GET['id'] ?? 1;

// --- PEGAR CANDIDATOS DO BANCO ---
$sql = "SELECT 
          c.id_cand,
          a.nome,
          c.foto,
          c.descricao
        FROM itens_votacao iv
        INNER JOIN candidato c ON iv.id_cand = c.id_cand
        INNER JOIN aluno a ON c.id_aluno = a.id_aluno
        WHERE iv.id_votacao = ?
        AND c.status = 'ativo'";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_votacao]);

$candidatos = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $candidatos[] = [
    "id" => $row['id_cand'],
    "nome" => $row['nome'],
    "imagem" => $row['foto'], // Apenas adiciona ../ antes do caminho do banco
    "frase" => $row['descricao']
    ];
}

?>

<!-- Main -->
<main id="mainvotar">
  <div id="centro">
    <h2 id="h23">Votações Abertas</h2>
    <div class="linha-completa">
      <div class="linha-grossa"></div>
      <div class="linha-fina"></div>
    </div>
  </div>
  
  <div class="votacao-completo">
    <button id="seta-esquerda">←</button>
    <div class="votacoes-container">
       <div id="votacoes" class="votacoes-container"></div>
    </div>
    <button id="seta-direita">→</button>
  </div>
</main>

<script>
  const alunos = <?php echo json_encode($candidatos, JSON_UNESCAPED_UNICODE); ?>;
</script>
<script src="../js/votar_escolha.js"></script>

<?php
include '../includes/footer.php';
?>
