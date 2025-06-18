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
        frase: "Vote em mim para representante de sala! Vou ser a voz da turma, defender nossos interesses e ajudar a tornar nosso ambiente mais organizado e unido!",
      },
      {
        nome: "Matheus Reinhart Camargo Martins",
        imagem: "img/candidato1.png",
        frase: "Luto pela justiça dos alunos e quero focar em uma qualidade melhor de ensino",
      },
      {
        nome: "Feliphe Eduardo Silvério Gonçalves de Oliveira",
        imagem: "img/candidato1.png",
        frase: "Quero ser um representante ativo, que busca soluções e não apenas aponta problemas, usando honestidade e respeito, representando minha turma",
      },
      {
        nome: "Matheus Reinhart Camargo Martins",
        imagem: "img/candidato1.png",
        frase: "Luto pela justiça dos alunos e quero focar em uma qualidade melhor de ensino",
      },
      {
        nome: "Matheus Reinhart Camargo Martins",
        imagem: "img/candidato1.png",
        frase: "Luto pela justiça dos alunos e quero focar em uma qualidade melhor de ensino",
      },
    ];

    const votacoesDiv = document.getElementById("votacoes");
    let ordemAtual = 0;

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
            const estaExpandido = card.classList.contains("destaque");
            resetarCards();
            if (!estaExpandido) expandirCard(i);
          }
        });

        card.innerHTML = `
          <img src="${aluno.imagem}" alt="${aluno.nome}">
          <p><strong>${aluno.nome}</strong></p>
          <p class="frase">"${aluno.frase}"</p>
          <button onclick="event.stopPropagation(); alert('Você votou em ${aluno.nome}')">VOTAR</button>
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
  });

    