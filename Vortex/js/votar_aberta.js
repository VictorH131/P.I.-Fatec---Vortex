document.addEventListener("DOMContentLoaded", function () {
  const alunos = [
    {
      nome: "Victor Hernandez Soares de Almeida",
      imagem: "img/candidato2.png",
      frase: "Vou ser responsável e ser o melhor representante possível para todos da sala. Votem em Mim!!!",
      votos: 35,
    },
    {
      nome: "Marcos Vinicius Rocha",
      imagem: "img/candidato3.png",
      frase: "Vote em mim para representante de sala! Vou ser a voz da turma, defender nossos interesses e ajudar a tornar nosso ambiente mais organizado e unido!",
      votos: 21,
    },
    {
      nome: "Matheus Reinhart Camargo Martins",
      imagem: "img/candidato1.png",
      frase: "Luto pela justiça dos alunos e quero focar em uma qualidade melhor de ensino",
      votos: 12,
    },
    {
      nome: "Feliphe Eduardo Silvério Gonçalves de Oliveira",
      imagem: "img/candidato6.png",
      frase: "Quero ser um representante ativo, que busca soluções e não apenas aponta problemas, usando honestidade e respeito, representando minha turma",
      votos: 28,
    },
    {
      nome: "Gian Miguel Oliveira",
      imagem: "img/candidato4.png",
      frase: "Prometo tirar as injustiças presentes e cortar o mal pela raiz",
      votos: 14,
    },
    {
      nome: "Luis Gustavo Araújo Porfirio",
      imagem: "img/candidato5.png",
      frase: "Por Que Votar em mim?, Porque sou o Melhor.",
      votos: 9,
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

      card.innerHTML = `
        <img src="${aluno.imagem}" alt="${aluno.nome}">
        <div class="nome-candidato"><strong>${aluno.nome}</strong></div>
        <p class="frase">"${aluno.frase}"</p>
        <p class="total-votos">Total de votos: ${aluno.votos}</p>
      `;

      card.addEventListener("click", () => {
        const estaExpandido = card.classList.contains("destaque");
        resetarCards();
        if (!estaExpandido) card.classList.add("destaque");
      });

      votacoesDiv.appendChild(card);
    }
  }

  function resetarCards() {
    document.querySelectorAll(".card").forEach(card => {
      card.classList.remove("destaque");
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