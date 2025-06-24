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
    nome: "Matheus Reinhart Camargo Martins Catarino",
    imagem: "img/candidato1.png",
    frase: "Luto pela justiça dos alunos e quero focar em uma qualidade melhor de ensino",
  },
  {
    nome: "Feliphe Eduardo Silvério Gonçalves de Oliveira",
    imagem: "img/candidato6.png",
    frase: "Quero ser um representante ativo, que busca soluções e não apenas aponta problemas, usando honestidade e respeito, representando minha turma",
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
let removerIndex = null;
let editandoIndex = null;

function carregarVotacoes() {
  votacoesDiv.innerHTML = "";

  for (let i = 0; i < 3 && i < alunos.length; i++) {
    const idx = (ordemAtual + i) % alunos.length;
    const aluno = alunos[idx];

    const card = document.createElement("div");
    card.className = "card";

    if (editandoIndex === idx) {
  card.innerHTML = `
    <img src="${aluno.imagem}" alt="${aluno.nome}" id="previewEditar${idx}" style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:10px; cursor:pointer;">
    <input type="file" id="fileInputEditar${idx}" accept="image/*" style="display:none;">
    <form class="form-editar">
      <label>Nome:</label>
      <input type="text" id="input-nome-${idx}" value="${aluno.nome}">
      <label>Descrição:</label>
      <textarea id="input-frase-${idx}">${aluno.frase}</textarea>
      <div class="botoes">
        <button type="button" class="btn-cancelar">Cancelar</button>
        <button type="button" class="btn-confirmar">Alterar</button>
      </div>
    </form>
  `;

  const imgPreview = card.querySelector(`#previewEditar${idx}`);
  const inputFile = card.querySelector(`#fileInputEditar${idx}`);
  const inputNome = card.querySelector(`#input-nome-${idx}`);
  const inputFrase = card.querySelector(`#input-frase-${idx}`);

  // Clique na imagem abre o seletor de arquivo
  imgPreview.addEventListener('click', () => {
    inputFile.click();
  });

  // Atualiza preview ao escolher imagem
  inputFile.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        imgPreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  // Botão Cancelar
  card.querySelector(".btn-cancelar").addEventListener("click", () => {
    editandoIndex = null;
    carregarVotacoes();
  });

  // Botão Alterar
  card.querySelector(".btn-confirmar").addEventListener("click", () => {
    const novoNome = inputNome.value.trim();
    const novaFrase = inputFrase.value.trim();

    if (novoNome !== "" && novaFrase !== "") {
      alunos[idx].nome = novoNome;
      alunos[idx].frase = novaFrase;

      // Se uma imagem nova foi escolhida, atualiza também
      if (inputFile.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          alunos[idx].imagem = e.target.result;
          editandoIndex = null;
          carregarVotacoes();
        };
        reader.readAsDataURL(inputFile.files[0]);
      } else {
        editandoIndex = null;
        carregarVotacoes();
      }

    } else {
      alert("Preencha todos os campos!");
    }
  });




    } else {
      // Modo visualização normal
      
      card.innerHTML = `
        <img src="${aluno.imagem}" alt="${aluno.nome}">
        <div class="nome"><strong>${aluno.nome}</strong></div>
        <div class="descricao">${aluno.frase}</div>
        <div class="botoes">
          <button class="btn-editar">Editar</button>
          <button class="btn-remover">Remover</button>
        </div>
      `;


      card.querySelector(".btn-editar").addEventListener("click", () => {
        editandoIndex = idx;
        carregarVotacoes();
      });

      card.querySelector(".btn-remover").addEventListener("click", () => {
        removerIndex = idx;
        document.getElementById("popup-remover").style.display = "flex";
      });
    }

    votacoesDiv.appendChild(card);
  }
}

document.getElementById("seta-direita").addEventListener("click", () => {
  ordemAtual = (ordemAtual + 1) % alunos.length;
  carregarVotacoes();
});

document.getElementById("seta-esquerda").addEventListener("click", () => {
  ordemAtual = (ordemAtual - 1 + alunos.length) % alunos.length;
  carregarVotacoes();
});

document.querySelector(".btn-sim").addEventListener("click", () => {
  alunos.splice(removerIndex, 1);
  removerIndex = null;
  document.getElementById("popup-remover").style.display = "none";
  ordemAtual = 0;
  carregarVotacoes();
});

document.querySelector(".btn-nao").addEventListener("click", () => {
  document.getElementById("popup-remover").style.display = "none";
  removerIndex = null;
});

carregarVotacoes();
