<?php
include '../includes/session.php';
include '../includes/header_aluno.php';
require_once '../includes/dbconnect.php';

echo '<title>Eleja-se - Vortex</title>';

$required_fields = ['nome', 'email', 'matricula', 'curso', 'semestre'];

foreach ($required_fields as $field) {
    if (!isset($_SESSION['usuario'][$field]) || empty($_SESSION['usuario'][$field])) {
        header("Location: ../Sessao_aluno/home_aluno.php");
        exit;
    }
}

$nome = $_SESSION['usuario']['nome'];
$matricula = $_SESSION['usuario']['matricula'];
$email = $_SESSION['usuario']['email'];
$curso = $_SESSION['usuario']['curso'];
$semestre = $_SESSION['usuario']['semestre'];

if ($curso == "DSM") {
    $curso = "Desenvolvimento de Sistemas Multiplataforma";
} elseif ($curso == "GI") {
    $curso = "Gestão Industrial";
} elseif ($curso == "GE") {
    $curso = "Gestão Empresarial";
}

?>
    
<main id="mainelenao">
    <h2>Cadastro de Candidato</h2>
    <div class="form-container">
      <form method="POST" action="../includes/processa_candidato.php" enctype="multipart/form-data">
          <div class="foto-usuario">
              <div class="foto-container">
                  <label for="fileInput" class="foto-label">
                      <img id="preview" src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Foto do usuário">
                      <img src="../img/icones/eleja.svg" alt="Adicionar" class="icone-upload">
                  </label>
                  <input type="file" id="fileInput" name="foto" accept="image/*">
              </div>
          </div>

          <div id="linha">
              <label for="nome">Nome:</label>
              <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>">
          </div>

          <div id="linha">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
          </div>

          <div class="row">
              <div id="linha">
                  <label for="matricula">Matrícula:</label>
                  <input type="text" id="matricula" readonly value="<?= htmlspecialchars($matricula) ?>">
              </div>

              <div id="linha">
                  <label for="semestre">Semestre:</label>
                  <input type="text" id="semestre" readonly value="<?= htmlspecialchars($semestre) ?>º Semestre">
              </div>
          </div>

          <div id="linha">
              <label for="curso">Curso:</label>
              <input type="text" id="curso" readonly value="<?= htmlspecialchars($curso) ?>">
          </div>

          <div id="linha">
              <label for="descricao">Descrição:</label>
              <textarea id="descricao" name="descricao" rows="3"></textarea>
          </div>

          <button id="btnCadastrar" class="btn-submit" type="submit">Cadastrar-se</button>
      </form>
    </div>
</main>

<script src="../js/eleja.js"></script>

<?php
include '../includes/footer.php';
?>
