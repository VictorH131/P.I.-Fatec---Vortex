<?php
  include '../includes/session.php'; // Verifica se esta logado
  include '../includes/header_adm.php'; // header 
  echo '<title>Boas Vindas - Vortex</title>'; // titulo da pagina
  
?>

    <!--Main index-->
    <main  id="mainhome">
      <section class="votacoes">
        <h2>Gerenciar</h2>
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
            <h3>Gerenciar votações</h3>
            <p>Como administrador, gerencie as votações em andamento em todos os cursos presentes em sua instituição de ensino.</p>
            <a href="votar_adm.php" class="botao-leia">Ver Cursos</a>
          </div>
        </div>
        
      </section>
    </main>
    <script src="../js/home.js"></script>
<?php
  include '../includes/footer.php';
?>
    



