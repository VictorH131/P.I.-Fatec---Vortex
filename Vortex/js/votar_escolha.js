document.addEventListener("DOMContentLoaded", function () {

  const votacoesDiv = document.getElementById("votacoes");
  let ordemAtual = 0;

  // votoConfirmado pode ser null (não votou), "branco" ou id_cand
  let votoConfirmado = votoExistente; 

  // Bloqueio após votar
  let bloqueioAtual = votoConfirmado !== null;
  let candidatoEscolhido = null;

  const botaoBranco = document.getElementById("btn-voto-branco");

  // Ajusta botão branco conforme voto no banco
  if (votoConfirmado === null) {
    botaoBranco.disabled = false;
    botaoBranco.style.background = "#007bff"; // azul padrão
  } else if (votoConfirmado === "branco") {
    botaoBranco.style.background = "#19A819"; // verde
    botaoBranco.disabled = true;
  } else {
    botaoBranco.style.background = "#007bff"; // azul
    botaoBranco.disabled = true;
  }

function carregarVotacoes() {
  votacoesDiv.innerHTML = "";

  for (let i = 0; i < 3; i++) {
    const idx = (ordemAtual + i) % alunos.length;
    const aluno = alunos[idx];

    const card = document.createElement("div");
    card.className = "card";
    card.setAttribute("data-index", aluno.id);




    
if (votoConfirmado === null) {
    // Não votou: todos visíveis
    card.style.filter = "";
    card.style.opacity = "1";
    card.style.border = "";
} else if (votoConfirmado === "branco") {
    // Votou em branco: todos borrados
    card.style.filter = "blur(3px)";
    card.style.opacity = "0.6";
    card.style.border = "";
    
} else {
    // Votou em candidato específico
    if (aluno.id === votoConfirmado) {
        card.style.border = "2px solid #19A819";
        card.style.filter = "";
        card.style.opacity = "1";
    } else {
        card.style.filter = "blur(3px)";
        card.style.opacity = "0.6";
        card.style.border = "";
    }
}





    card.addEventListener("click", (event) => {
      if (event.target.tagName.toLowerCase() !== "button") {
        const estaExpandido = card.classList.contains("destaque");
        resetarCards();
        if (!estaExpandido) expandirCard(i);
      }
    });

    let botaoHTML = "";

    if (votoConfirmado === null) {
      botaoHTML = `
        <button onclick="event.stopPropagation(); abrirPopup(${aluno.id}, this)"
          style="padding:12px 20px;border-radius:8px;border:none;color:#fff;">
          VOTAR
        </button>`;
    } else if (votoConfirmado === "branco") {
      // Voto em branco: botão bloqueado normal
      botaoHTML = `
        <button disabled style="opacity:0.5; cursor:not-allowed; padding:12px 20px; border-radius:8px;">
          VOTAR
        </button>`;
    } else if (votoConfirmado === aluno.id) {
      // Votou neste candidato: botão bloqueado verde
      botaoHTML = `
        <button class="botao-votado" disabled
          style="background:#19A819;border:none;padding:12px 20px;border-radius:8px;">
            <img src="../img/icones/votando.svg" class="icone-voto" style="width:24px;height:24px;">
        </button>`;
    } else {
      // Demais candidatos: botão bloqueado normal
      botaoHTML = `
        <button disabled style="opacity:0.5; cursor:not-allowed; padding:12px 20px; border-radius:8px;">
          VOTAR
        </button>`;
    }


    card.innerHTML = `
      <img src="../${aluno.imagem}" alt="${aluno.nome}">
      <div class="nome-candidato"><strong>${aluno.nome}</strong></div>
      <p class="frase" style="display:none;">"${aluno.frase}"</p>
      ${botaoHTML}
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

  // POPUP
  const popup = document.createElement("div");
  popup.id = "popupvotarestcolha";
  popup.classList.add("popup-container");
  popup.style.display = "none";
  popup.innerHTML = `
    <div class="popup-box">
      <h2>Confirmar Voto</h2>
      <p>Tem certeza que deseja confirmar seu voto?</p>
      <div class="popup-buttons">
        <button type="button" class="btn-ok" id="btn-confirmar">SIM</button>
        <button type="button" class="btn-sair">NÃO</button>
      </div>
    </div>
  `;
  document.body.appendChild(popup);
  popup.querySelector(".btn-sair").addEventListener("click", () => popup.style.display = "none");

  botaoBranco.addEventListener("click", function () {
    if (bloqueioAtual) return;
    candidatoEscolhido = "branco"; // voto em branco
    popup.style.display = "flex";
  });

  window.abrirPopup = function (idCandidato) {
    if (bloqueioAtual) return;
    candidatoEscolhido = idCandidato;
    popup.style.display = "flex";
  };

  document.getElementById("btn-confirmar").onclick = () => {
    if (candidatoEscolhido === null) return;

    bloqueioAtual = true;
    votoConfirmado = candidatoEscolhido;

    if (candidatoEscolhido === "branco") {
      botaoBranco.style.background = "#19A819";
      botaoBranco.disabled = true;
    } else {
      botaoBranco.style.background = "#0e437cff";
      botaoBranco.disabled = true;
    }

    popup.style.display = "none";
    carregarVotacoes();

    setTimeout(() => {
      window.location.href = `../includes/votar.php?id_cand=${candidatoEscolhido === "branco" ? 0 : candidatoEscolhido}&id_votacao=${idVotacao}`;
    }, 200);
  };

});
