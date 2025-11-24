document.addEventListener("DOMContentLoaded", function () {

  const votacoesDiv = document.getElementById("votacoes");
  let ordemAtual = 0;
  let votoConfirmado = null;

  function carregarVotacoes() {
    votacoesDiv.innerHTML = "";

    for (let i = 0; i < 3; i++) {
      const idx = (ordemAtual + i) % alunos.length;
      const aluno = alunos[idx];

      const card = document.createElement("div");
      card.className = "card";
      card.setAttribute("data-index", idx);

      card.addEventListener("click", (event) => {
        if (event.target.tagName.toLowerCase() !== "button") {
          if (votoConfirmado === null) {
            const estaExpandido = card.classList.contains("destaque");
            resetarCards();
            if (!estaExpandido) expandirCard(i);
          } else {
            abrirPopupRedirecionar();
          }
        }
      });

      const votado = idx === votoConfirmado;

      card.innerHTML = `
        <img src="../${aluno.imagem}" alt="${aluno.nome}">
        <div class="nome-candidato"><strong>${aluno.nome}</strong></div>
        <p class="frase" style="display:none;">"${aluno.frase}"</p>
        <button
          ${votado ? 'class="botao-votado"' : ''}
          ${votado ? "disabled" : ""}
          style="${votoConfirmado !== null && !votado ? "display:none;" : ""}"
          onclick="event.stopPropagation(); abrirPopup(${idx}, this)">
          ${votado ? '<img src="../img/icones/votando.svg" class="icone-voto">' : "VOTAR"}
        </button>
      `;

      votacoesDiv.appendChild(card);
    }
  }

  function expandirCard(indexSelecionado) {
    const cards = document.querySelectorAll(".card");
    cards.forEach((card, index) => {
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
    const cards = document.querySelectorAll(".card");
    cards.forEach((card) => {
      card.classList.remove("destaque");
      const frase = card.querySelector(".frase");
      frase.style.display = "none";
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

  // ---------- POPUP DE VOTO ----------
  const popup = document.createElement("div");
  popup.id = "popupvotarestcolha";
  popup.classList.add("popup-container");
  popup.style.display = "none";
  popup.innerHTML = `
    <div class="popup-box">
      <h2>Confirmar Voto</h2>
      <p>Tem certeza que deseja votar neste candidato?</p>
      <div class="popup-buttons">
        <button class="btn-ok">SIM</button>
        <button class="btn-sair">NÃO</button>
      </div>
    </div>
  `;
  document.body.appendChild(popup);

  let candidatoEscolhido = null;
  let cardEscolhido = null;

  window.abrirPopup = function (index, botao) {
    candidatoEscolhido = index;
    cardEscolhido = botao.closest(".card");
    popup.style.display = "flex";
  };

  popup.querySelector(".btn-ok").addEventListener("click", () => {
    if (cardEscolhido) {
      votoConfirmado = candidatoEscolhido;
      const todosCards = document.querySelectorAll(".card");
      todosCards.forEach((card) => {
        const btn = card.querySelector("button");
        if (parseInt(card.dataset.index) === candidatoEscolhido) {
          btn.innerHTML = '<img src="../img/icones/votando.svg" class="icone-voto">';
          btn.classList.add("botao-votado");
          btn.disabled = true;
          btn.style.display = "";
        } else {
          btn.style.display = "none";
        }
      });
    }
    popup.style.display = "none";
  });

  popup.querySelector(".btn-sair").addEventListener("click", () => {
    popup.style.display = "none";
    candidatoEscolhido = null;
    cardEscolhido = null;
  });

  // --- POPUP DE REDIRECIONAMENTO  ---
  const popupDirecao = document.createElement("div");
  popupDirecao.classList.add("direcaoPopup-container");
  popupDirecao.style.display = "none";
  popupDirecao.innerHTML = `
    <div class="direcaoPopup-box">
      <h2>Você já votou!</h2>
      <p>Deseja ir para a página de resultados agora?</p>
      <div class="direcaoPopup-buttons">
        <button class="btn-ok">SIM</button>
        <button class="btn-sair">NÃO</button>
      </div>
    </div>
  `;
  document.body.appendChild(popupDirecao);

  window.abrirPopupRedirecionar = function () {
    popupDirecao.style.display = "flex";
  };

  popupDirecao.querySelector(".btn-ok").addEventListener("click", () => {
    window.location.href = "votar_finalizada_aluno.html";
  });

  popupDirecao.querySelector(".btn-sair").addEventListener("click", () => {
    popupDirecao.style.display = "none";
  });
});
