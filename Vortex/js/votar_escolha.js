document.addEventListener("DOMContentLoaded", function () {

  const votacoesDiv = document.getElementById("votacoes");
  let ordemAtual = 0;

  // valores vindos do PHP
  let votoConfirmado = votoExistente || null;
  let jaVotou = Boolean(votoExistente);
  let botaoClicado = null;

  function carregarVotacoes() {
    votacoesDiv.innerHTML = "";

    for (let i = 0; i < 3; i++) {
      const idx = (ordemAtual + i) % alunos.length;
      const aluno = alunos[idx];

      const card = document.createElement("div");
      card.className = "card";
      card.setAttribute("data-index", aluno.id);

      const votado = aluno.id === votoConfirmado;

      // ---------- BLUR NOS NÃO VOTADOS ----------
      if (jaVotou && !votado) {
        card.style.filter = "blur(3px)";
        card.style.opacity = "0.6";
      }

      // -------- EVENTO DE EXPANDIR --------
      card.addEventListener("click", (event) => {
        if (event.target.tagName.toLowerCase() !== "button") {
          const estaExpandido = card.classList.contains("destaque");
          resetarCards();
          if (!estaExpandido) expandirCard(i);
        }
      });

      // -------- CONTEÚDO DO CARD --------
      card.innerHTML = `
        <img src="../${aluno.imagem}" alt="${aluno.nome}">
        <div class="nome-candidato"><strong>${aluno.nome}</strong></div>
        <p class="frase" style="display:none;">"${aluno.frase}"</p>

        ${
          jaVotou
            ? (
                votado
                  // BOTÃO VERDE APENAS NO VOTADO
                  ? `<button class="botao-votado" disabled style="background:#19A819;border:none;padding:12px 20px;border-radius:8px;">
                       <img src="../img/icones/votando.svg" class="icone-voto">
                     </button>`
                  : ""
              )
            : `<button onclick="event.stopPropagation(); abrirPopup(${aluno.id}, this)" style="padding:12px 20px;border-radius:8px;border:none;color:#fff;">
                VOTAR
              </button>`
        }
      `;

      votacoesDiv.appendChild(card);
    }
  }

  function expandirCard(indexSelecionado) {
    document.querySelectorAll(".card").forEach((card, index) => {
      const frase = card.querySelector(".frase");
      if (index === indexSelecionado) {
        card.classList.add("destaque");
        frase.style.display = "block";
      } else {
        card.classList.remove("destaque");
        frase.style.display = "none";
      }
    });
  }

  function resetarCards() {
    document.querySelectorAll(".card").forEach(card => {
      card.classList.remove("destaque");
      card.querySelector(".frase").style.display = "none";
    });
  }

  function avancar() {
    ordemAtual = (ordemAtual + 1) % alunos.length;
    resetarCards();
    carregarVotacoes();
  }

  function voltar() {
    ordemAtual = (ordemAtual - 1 + alunos.length) % alunos.length;
    resetarCards();
    carregarVotacoes();
  }

  document.getElementById("seta-direita").addEventListener("click", avancar);
  document.getElementById("seta-esquerda").addEventListener("click", voltar);

  carregarVotacoes();

  // ---------- POPUP ----------
  const popup = document.createElement("div");
  popup.id = "popupvotarestcolha";
  popup.classList.add("popup-container");
  popup.style.display = "none";

  popup.innerHTML = `
  <div class="popup-box">
    <h2>Confirmar Voto</h2>
    <p>Tem certeza que deseja votar neste candidato?</p>
    <div class="popup-buttons">
      <button type="button" class="btn-ok" id="btn-confirmar">SIM</button>
      <button type="button" class="btn-sair">NÃO</button>
    </div>
  </div>
  `;

  document.body.appendChild(popup);

  popup.querySelector(".btn-sair").addEventListener("click", () => {
    popup.style.display = "none";
  });

  let candidatoEscolhido = null;

  window.abrirPopup = function (idCandidato, botao) {
    if (jaVotou) return;

    candidatoEscolhido = idCandidato;
    botaoClicado = botao;

    document.getElementById("btn-confirmar").onclick = () => {

      jaVotou = true;
      votoConfirmado = candidatoEscolhido;

      // -------- BOTÃO VERDE --------
      if (botaoClicado) {
        botaoClicado.style.background = "#19A819";
        botaoClicado.style.pointerEvents = "none";
        botaoClicado.innerHTML = `<img src="../img/icones/votando.svg" class="icone-voto">`;
        botaoClicado.disabled = true;
      }

      popup.style.display = "none";

      // aplicar blur geral
      carregarVotacoes();

      // -------- SALVAR VOTO --------
      setTimeout(() => {
        window.location.href =
          `../includes/votar.php?id_cand=${candidatoEscolhido}&id_votacao=${idVotacao}`;
      }, 200);
    };

    popup.style.display = "flex";
  };

});
