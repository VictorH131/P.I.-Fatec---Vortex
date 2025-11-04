<?php
  include 'includes/session.php'; // Verifica se esta logado
  include 'includes/header_aluno.php'; // header do aluno
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
          <img src="img/eleicao1.png" class="carousel-img active" alt="Eleição 1">
          <img src="img/eleicao2.png" class="carousel-img" alt="Eleição 2">
          

          <button class="carousel-btn prev">&#10094;</button>
          <button class="carousel-btn next">&#10095;</button>
        </div>
          <div class="texto-voto">
            <h3>Vote Já para os Representantes de DSM</h3>
            <p>Os alunos de Desenvolvimento de Software Multiplataforma, estão decidindo seus representantes. Clique e veja mais.</p>
            <a href="candidatarse_aluno.html" class="botao-leia">Leia +</a>
          </div>
        </div>
      </section>  
    </main>

    <!--Footer-->
    <hr id="hrfoot1">
    <footer id="footerII">
      <div class="footer-container">
        <div id="logoVor">
            <img src="img/LOGO_VORTEX.png" class="logo-vortex" alt="Logo Vortex">
        </div>
        
        
        <div class="texto-sistema">
          <div id="colunaas">
            <div>
              <h2>Uma parceria Vortex e Fatec</h2>
              <p>Fornecendo um futuro melhor na educação.</p>
            </div>
          </div>

          <div class="Telefonee"></div>
          
          <div id="colunaas">
            <div >
              <h2>Telefone:</h2> 
              <p><img src="img/icones/phone.svg" >(19) 3843-1996 </p>
              <p><img src="img/icones/whats.svg">(19) 3863-5210</p>
            </div>
          </div>

          <div class="Telefonee"></div>
          <br>
          <div id="colunaas">
            <div>
              <h2>Fatec Ogari de Castro Pacheco</h2>
              <p>Rua Tereza Lera Paoletti, 570/590 - Jardim Bela Vista<br>
                  CEP: 13974-080 </p>
            </div>
          </div>
        </div>
        

        <div class="direita">
          <img src="img/logo_cps_branca.png" alt="Logo CPS">
        </div>
      </div>

      <div class="politica">
        <a href="Politicas_alunos.html">Políticas e Privacidade</a>
        <p>© 2002 - Centro Paula Souza - Desenvolvido por Vortex Inc - Todos os direitos reservados.</p>
      </div>
    </footer>
    <script src="js/home.js"></script>
  </body>
</html>
    

