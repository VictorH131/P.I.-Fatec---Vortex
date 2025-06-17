const alunos = [
        {
          nome: "Victor Hernandez Soares de Almeida",
          imagem: "img/candidato2.png",
          frase:
            "Vou ser responsável e ser o melhor representante possível para todos da sala. Votem em Mim!!!",
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
          frase:
            "Luto pela justiça dos alunos e quero focar em uma qualidade melhor de ensino",
        },
      ];

      const votacoesDiv = document.getElementById("votacoes");

      function carregarVotacoes() {
        votacoesDiv.innerHTML = "";

        alunos.forEach((aluno, index) => {
          const card = document.createElement("div");
          card.className = "card";
          card.setAttribute("data-index", index);

          card.addEventListener("click", (event) => {
            if (event.target.tagName.toLowerCase() !== "button") {
              const cardClicado = event.currentTarget;
              const estaExpandido = cardClicado.classList.contains("destaque");

              if (estaExpandido) {
                resetarCards();
              } else {
                expandirCard(index);
              }
            }
          });

          card.innerHTML = `
            <img src="${aluno.imagem}" alt="${aluno.nome}">
            <p><strong>${aluno.nome}</strong></p>
            <p class="frase" style="display: none;">"${aluno.frase}"</p>
            <button class="votar-btn" onclick="event.stopPropagation(); votar(${index})">VOTAR</button>
          `;

          votacoesDiv.appendChild(card);
        });
      }

      function expandirCard(indexSelecionado) {
        const cards = document.querySelectorAll(".card");
        cards.forEach((card, index) => {
          const frase = card.querySelector(".frase");
          if (index === indexSelecionado) {
            card.classList.add("destaque");
            if (frase && frase.textContent.trim() !== '""') {
              frase.style.display = "block";
            }
          } else {
            card.classList.remove("destaque");
            if (frase) frase.style.display = "none";
          }
        });
      }

      function resetarCards() {
        const cards = document.querySelectorAll(".card");
        cards.forEach((card) => {
          card.classList.remove("destaque");
          const frase = card.querySelector(".frase");
          if (frase) frase.style.display = "none";
        });
      }

      document.addEventListener("click", (event) => {
        const clicouNoCard = event.target.closest(".card");
        if (!clicouNoCard) {
          resetarCards();
        }
      });

      function votar(index) {
        alert(`Você votou em ${alunos[index].nome}`);
      }

      carregarVotacoes();