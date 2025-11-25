document.addEventListener("DOMContentLoaded", function () {

  const votacoesDiv = document.getElementById("votacoes");
  let ordemAtual = 0;
  let votoConfirmado = votoExistente || null;
  let jaVotou = Boolean(votoExistente);

  function carregarVotacoes() {
    votacoesDiv.innerHTML = "";

    for (let i = 0; i < 3; i++) {
      const idx = (ordemAtual + i) % alunos.length;
      const aluno = alunos[idx];

      const card = document.createElement("div");
      card.className = "card";
      card.setAttribute("data-index", aluno.id);

      card.addEventListener("click", (event) => {
        if (event.target.tagName.toLowerCase() !== "button") {
          const estaExpandido = card.classList.contains("destaque");
          resetarCards();
          if (!estaExpandido) expandirCard(i);
        }
      });

      const votado = aluno.id === votoConfirmado;

      card.innerHTML = `
        <img src="../${aluno.imagem}" alt="${aluno.nome}">
        <div class="nome-candidato"><strong>${aluno.nome}</strong></div>
        <p class="frase" style="display:none;">"${aluno.frase}"</p>
        <button
          ${votado || jaVotou ? 'class="botao-votado"' : ''}
          ${votado || jaVotou ? "disabled" : ""}
          onclick="event.stopPropagation(); abrirPopup(${aluno.id}, this)">
          ${votado ? '<img src="../img/icones/votando.svg" class="icone-voto">' : "VOTAR"}
        </button>
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

  // ---------- POPUP DE CONFIRMAÇÃO ----------
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

  // Adicionar evento para fechar popup (BOTÃO NÃO)
  popup.querySelector(".btn-sair").addEventListener("click", () => {
    popup.style.display = "none";
  });

  let candidatoEscolhido = null;

  window.abrirPopup = function (idCandidato, botao) {
    if (jaVotou) return;
    candidatoEscolhido = idCandidato;

    document.getElementById("btn-confirmar").onclick = () => {
     window.location.href =
      `../includes/votar.php?id_cand=${idCandidato}&id_votacao=${idVotacao}`;

    };

    popup.style.display = "flex";
  };

});
