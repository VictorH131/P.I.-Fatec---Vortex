<?php
  session_start();
  $class = '';
  if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
    if ($_SESSION['usuario']['class'] == 'adm')  {
      header("Location: Sessao_adm/home_adm.php");
      exit;
    } 
  }

  // Gera CSRF token (proteção contra falsificação de requisições)
  if (!isset($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }

  // Mensagem de erro (caso o login falhe)
  $aviso = $_SESSION['aviso'] ?? null;
  unset($_SESSION['aviso']);

  $_SESSION['class'] = "adm";


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Administrativo - Vortex</title>
  <link rel="stylesheet" href="style/style.css">
  <link rel="icon" href="img/icones/favicon.ico">
</head>

<body>
  <!--header-->
  <header id="headerI">
    <div class="top-bar">
      <img src="img/logo_fatec_branca.png" alt="Fatec" id="logo_fatec">
      <img src="img/logo_cps_branca.png" alt="Centro Paula Souza" id="logo_cps">
    </div>
    <hr id="hrhead1">
  </header>

  <!--Main-->
  <a href="index.html" class="voltar">
    <img src="img/icones/exit.svg">
    Voltar
  </a>

  <main id="mainlogin">
    <div class="login-box">
      <h2>LOGIN</h2>
      <h3>COORDENAÇÃO</h3>

      <form action="includes/processa_login.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div id="linha">
          <label for="usuario">USUÁRIO</label>
          <input type="text" id="usuario" name="email" placeholder="Nº da Matrícula" required autofocus>
        </div>

        <div id="linha">
          <label for="senha">SENHA</label>
          <input type="password" id="senha" name="senha" placeholder="Sua Senha" required>
        </div>

        <button type="submit">ACESSAR</button>
      </form>
    </div>
  </main>


  <!--Footer-->
  <hr id="hrfoot1">
  <footer id="footerI">
    <div class="footer-container">
      <div class="coluna">
        <img src="img/logo_vortex_shuri.PNG" alt="simbolo da Logo Vortex" id="logo_vortex_s">
        <div>
          <p><strong>Powered By</strong></p>
          <img src="img/logo_vortex_Nome.PNG" alt="escrita da Logo Vortex" id="logo_vortex_n">
        </div>
      </div>

      <div class="texto-sistema">
        <p>
          Este sistema é destinado aos alunos <strong>FATEC</strong>. Para ingressar utilize sua Matrícula.
          Em caso de dificuldades, recomendamos que consulte a Secretaria Acadêmica de sua Unidade de Ensino clicando no
          link de ajuda ou presencialmente.
        </p>
      </div>
      <div class="direita">
        <p><strong>Uma parceria</strong><br><img src="img/logo_fatec_branca.png" alt=""></p>
      </div>
    </div>
  </footer>
</body>
</html>

    