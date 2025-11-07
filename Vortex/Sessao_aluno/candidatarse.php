<?php
  include '../includes/session.php'; // Verifica se esta logado
  include '../includes/header_aluno.php'; // header 
  echo '<title>Boas Vindas - Vortex</title>'; // titulo da pagina
  
  $data = "a";
?>
    <!--Main index-->
    <main id="mainvotarinicio">
      <section>
        <h2>Votação Aberta!</h2>
        <div class="linha-completa">
          <div class="linha-grossa"></div>
          <div class="linha-fina"></div>
        </div>
        <p>
          Você tem até o dia <?php echo $data; ?> para se inscrever como candidato(a) a representante de turma.
          Após esse prazo, não serão aceitas inscrições atrasadas.
          Assim que o período de inscrição for encerrado, será feita a seleção de um representante e um vice.
          Participe, seja a voz da sua turma e ajude a construir a história da sua sala!
        </p>

        <div class="card">
          <div class="card-icon">
            <img src="https://img.icons8.com/ios-filled/50/000000/conference-call.png" alt="Ícone de grupo">
          </div>
          <div class="card-content">
            <p>
              Eleja-se para se tornar representante da sua sala! As inscrições estão abertas a todos os alunos.
            </p>
            <a href="Eleja-se.html">CANDIDATE-SE JÁ</a>
          </div>
        </div>
      </section>
    </main>
<?php
  include '../includes/footer.php';

?>