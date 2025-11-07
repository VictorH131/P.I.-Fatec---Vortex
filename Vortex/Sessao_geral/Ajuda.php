<?php
  include '../includes/session.php'; // Verifica se esta logado
  include '../includes/header_' . $_SESSION['usuario']['class'] . '.php'; // header 
  echo '<title>Ajudas - Vortex</title>'; // titulo da pagina
  
?>
    


    <!--Main aJUDA-->
    <main id="mainajuda">
      <section class="sugestoes">
        <h2>Sugestões</h2>
        <p>Deixe suas sugestões e comentários para que possamos sempre melhorar e tornar cada vez mais dinâmico o ambiente acadêmico!</p>
        <textarea placeholder="Escreva sua sugestão aqui..."></textarea>
        <br />
        <button id="abrirPopup" class="botao-popup">ENVIAR</button>
      </section>

      <?php
      if ($class == 'adm'){
        echo
        '<section class="faq">
          <h2>Dúvidas Frequentes</h2>

          <div class="faq-item">
            <strong class="faq-pergunta">Consigo visualizar os resultados parciais da votação?</strong>
            <p class="faq-resposta">Sim, os administradores têm acesso ao painel com estatísticas e contagem parcial dos votos, sem violar o sigilo do eleitor.</p>
          </div>

          <div class="faq-item">
            <strong class="faq-pergunta">Posso editar informações de um candidato depois do cadastro?</strong>
            <p class="faq-resposta">Sim, é possível editar nome, descrição e imagem do candidato através do painel administrativo antes do encerramento da votação.</p>
          </div>

          <div class="faq-item">
            <strong class="faq-pergunta">Como garanto que os alunos não votem mais de uma vez?</strong>
            <p class="faq-resposta">O sistema bloqueia múltiplos votos utilizando matrícula e autenticação individual. Cada usuário só consegue votar uma única vez.</p>
          </div>

          <div class="faq-item">
            <strong class="faq-pergunta">Posso adiar uma votação?</strong>
            <p class="faq-resposta">Sim, o administrador pode reagendar a data de início da votação desde que isso seja feito antes do início oficial. Após iniciada, não é possível adiar.</p>
          </div>
        </section>';
      }else{
        echo
        '<section class="faq">
          <h2>Dúvidas Frequentes</h2>

          <div class="faq-item">
            <strong class="faq-pergunta">É possível ver as votações de outras pessoas?</strong>
            <p class="faq-resposta">Não, no caso o intuito deste site seria apenas votar no seu semestre assim mantendo a privacidade de todos os semestres da Fatec.</p>
          </div>

          <div class="faq-item">
            <strong class="faq-pergunta">Meu voto realmente é secreto?</strong>
            <p class="faq-resposta">Claro, pois como desenvolvedores, temos como obrigação manter a privacidade de todos.</p>
          </div>

          <div class="faq-item">
            <strong class="faq-pergunta">Posso votar mais de uma vez?</strong>
            <p class="faq-resposta">Não, pois estamos mantendo um sistema de forma justa, todos têm apenas o direito de votar uma vez para que não gere equívocos.</p>
          </div>

          <div class="faq-item">
            <strong class="faq-pergunta">Tem como mudar o voto depois de confirmar?</strong>
            <p class="faq-resposta">Não, pois se houvesse essa opção, poderia haver enganos no resultado, havendo a opção de alterar votos para que determinada pessoa vença.</p>
          </div>
        </section>';
      }
    ?>
    </main>
    <script src="../js/ajuda.js"></script>

<?php
  include '../includes/footer.php';
?>


 
    

