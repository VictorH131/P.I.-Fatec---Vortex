<?php
  include '../includes/session.php'; // Verifica se esta logado
  include '../includes/header_adm.php'; // header 
  echo '<title>Votações - Vortex</title>'; // titulo da pagina
  

  
  $voltar = $_SERVER['HTTP_REFERER'] ?? 'criar_votacao.php';
?>



<?php if (isset($_SESSION['aviso'])): ?>
<script>
    
</script>
<?php unset($_SESSION['aviso']); endif; ?>

<main id="maincriavot">
    
    <a href="<?= htmlspecialchars($voltar) ?>" class="btn-voltar">
        &#8592; Voltar
    </a>

    <div class="container">
      <h2>CRIAÇÃO DE VOTAÇÕES</h2>

      <div class="linha-completa">
        <div class="linha-fina"></div>
        <div class="linha-grossa"></div>
        <div class="linha-fina"></div>
      </div>


      
      <div class="form-box">
        <div class="form-header">CRIAR UMA VOTAÇÃO</div>

        <div class="form-content">
          <p>Preencha as informações abaixo para cadastrar uma votação de representante.</p>

          <form action="../includes/processa_criacao.php" method="post">
            <div class="duas-colunas">
              <div class="campo">
                <label for="curso">CURSO:</label>
                <select id="curso" name="curso" required>
                  <option value="" disabled selected>Selecione o  Curso</option>
                  <option value="DSM">DSM - Desenvolvimento de Software Multiplataforma</option>
                  <option value="GE">GE - Gestão Empresarial</option>
                  <option value="GI">GI - Gestão Industrial</option>
                </select>
              </div>

              <div class="campo">
                <label for="semestre"> SEMESTRE:</label>
                <select id="semestre" name="semestre" required>
                  <option value="" disabled selected>Selecione o Semestre</option>
                  <option value="1">1º Semestre</option>
                  <option value="2">2º Semestre</option>
                  <option value="3">3º Semestre</option>
                  <option value="4">4º Semestre</option>
                  <option value="5">5º Semestre</option>
                  <option value="6">6º Semestre</option>
                </select>
              </div>
            </div>

            <div class="linha-inscricoes">
              <div class="campo-inscricao">
                <label for="inscricoes">CANDIDATURA:</label>
                <select id="inscricoes" name="inscricoes" required>
                  <option value="" disabled selected>Selecione o prazo</option>
                  <option value="1">1 Dia(s)</option>
                  <option value="2">2 Dia(s)</option>
                  <option value="3">3 Dia(s)</option>
                  <option value="4">4 Dia(s)</option>
                  <option value="5">5 Dia(s)</option>
                  <option value="6">6 Dia(s)</option>
                  <option value="7">1 Semana(s)</option>
                  <option value="14">2 Semana(s)</option>
                  <option value="21">3 Semana(s)</option>
                </select>
              </div>

              <span class="texto-observacao-inscricoes">
                 Define o tempo que os alunos poderão se candidatar, antes do início da votação.
              </span>
            </div>

            <label for="inscricoes">PERÍODO DE VOTAÇÃO:</label> <br>
            <div class="duas-colunas">
              <div class="campo">
                <label for="inicio"> INÍCIO:</label>
                <input type="date" id="inicio" name="inicio"  required>
              </div>

              <div class="campo">
                <label for="fim"> FIM:</label>
                <input type="date" id="fim" name="fim" required>
              </div>
            </div>

            <label for="descricao">DESCRIÇÃO:</label>
            <textarea id="descricao" name="descricao" placeholder="Descreva brevemente sobre a votação..."></textarea>

            <button type="submit" class="btn-confirmar">CONFIRMAR</button>
          </form>
        </div>
      </div>
    </div>
</main>

    <script src="../js/data.js"></script>
<?php
  include '../includes/footer.php';
?>