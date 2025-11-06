<?php
  include '../includes/session.php'; // Verifica se esta logado
  include '../includes/header_aluno.php'; // header do aluno
  echo '<title>Boas Vindas - Vortex</title>'; // totilo da pagina
  
?>

    <!--Main index-->
    <main  id="mainhome">
      <section class="votacoes">
        <h2>Votações</h2>
        <div class="linha-completa">
          <div class="linha-grossa"></div>
          <div class="linha-fina"></div>
        </div>

        <div class="caixa-votacao">
          <div class="carousel">
          <img src="../img/eleicao1.png" class="carousel-img active" alt="Eleição 1">
          <img src="../img/eleicao2.png" class="carousel-img" alt="Eleição 2">
          

          <button class="carousel-btn prev">&#10094;</button>
          <button class="carousel-btn next">&#10095;</button>
        </div>
          <div class="texto-voto">
            <h3>Vote Já para os Representantes de DSM</h3>
            <p>Os alunos de Desenvolvimento de Software Multiplataforma, estão decidindo seus representantes. Clique e veja mais.</p>
            <a href="candidatarse.php" class="botao-leia">Leia +</a>
          </div>
        </div>
      </section>  
    </main>
    <script src="../js/home.js"></script>
<?php
  include '../includes/footer.php';

?>

