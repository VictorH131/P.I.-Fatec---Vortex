document.addEventListener("DOMContentLoaded", function () {
  const alunos = [
    {
      nome: "Victor Hernandez Soares de Almeida",
      imagem: "img/candidato2.png",
      frase: "Vou ser responsável e ser o melhor representante possível para todos da sala. Votem em Mim!!!",
    },
    {
      nome: "Marcos Vinicius Rocha",
      imagem: "img/candidato3.png",
      frase:
        "Vote em mim para representante de sala! Vou ser a voz da turma, defender nossos interesses e ajudar a tornar nosso ambiente mais organizado e unido!",
    },
    {
      nome: "Matheus Reinhart Camargo Martins",
      imagem: "img/candidato1.png",
      frase: "Luto pela justiça dos alunos e quero focar em uma qualidade melhor de ensino",
    },
    {
      nome: "Feliphe Eduardo Silvério Gonçalves de Oliveira",
      imagem: "img/candidato6.png",
      frase:
        "Quero ser um representante ativo, que busca soluções e não apenas aponta problemas, usando honestidade e respeito, representando minha turma",
    },
    {
      nome: "Gian Miguel Oliveira",
      imagem: "img/candidato4.png",
      frase: "Prometo tirar as injustiças presentes e cortar o mal pela raiz",
    },
    {
      nome: "Luis Gustavo Araújo Porfirio",
      imagem: "img/candidato5.png",
      frase: "Por Que Votar em mim?, Porque sou o Melhor.",
    },
  ];

  const votacoesDiv = document.getElementById("votacoes");
  let ordemAtual = 0;
  let votoConfirmado = null; // índice do candidato já votado

  // Carrega 3 cards começando da ordemAtual
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
            // Ainda não votou: expandir/fechar card
            const estaExpandido = card.classList.contains("destaque");
            resetarCards();
            if (!estaExpandido) expandirCard(i);
          } else {
            // Já votou: abrir popup para redirecionar
            abrirPopupRedirecionar();
          }
        }
      });

      const votado = idx === votoConfirmado;

      card.innerHTML = `
        <img src="${aluno.imagem}" alt="${aluno.nome}">
        <div class="nome-candidato"><strong>${aluno.nome}</strong></div>
        <p class="frase" style="display:none;">"${aluno.frase}"</p>
        <button
          ${votado ? 'class="botao-votado"' : ''}
          ${votado ? "disabled" : ""}
          style="${votoConfirmado !== null && !votado ? "display:none;" : ""}"
          onclick="event.stopPropagation(); abrirPopup(${idx}, this)">
          ${votado ? '<img src="img/icones/votando.svg" class="icone-voto">' : "VOTAR"}
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
          btn.innerHTML = '<img src="img/icones/votando.svg" class="icone-voto">';
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