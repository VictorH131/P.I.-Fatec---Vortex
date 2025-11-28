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
        <img src="${aluno.imagem}" alt="${aluno.nome}" id="previewEditar${idx}" 
             style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-bottom:10px; cursor:pointer;">
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

      imgPreview.addEventListener('click', () => inputFile.click());

      inputFile.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = e => imgPreview.src = e.target.result;
          reader.readAsDataURL(file);
        }
      });

      card.querySelector(".btn-cancelar").addEventListener("click", () => {
        editandoIndex = null;
        carregarVotacoes();
      });

      card.querySelector(".btn-confirmar").addEventListener("click", () => {
        const novoNome = inputNome.value.trim();
        const novaFrase = inputFrase.value.trim();

        if (novoNome !== "" && novaFrase !== "") {
          let imagemData = null;
          if (inputFile.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
              imagemData = e.target.result;
              salvarCandidato(idx, novoNome, novaFrase, imagemData);
            };
            reader.readAsDataURL(inputFile.files[0]);
          } else {
            salvarCandidato(idx, novoNome, novaFrase, null);
          }

        } else {
          alert("Preencha todos os campos!");
        }
      });

    } else {

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

// Função para salvar no servidor
function salvarCandidato(idx, nome, frase, imagem) {
  const candidato = alunos[idx];

  const formData = new FormData();
  formData.append('id_cand', candidato.id_cand);
  formData.append('nome', nome);
  formData.append('frase', frase);
  if (imagem) formData.append('imagem', imagem);

  fetch('../includes/atualizar_candidato.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(res => {
    if (res.success) {
      alunos[idx].nome = nome;
      alunos[idx].frase = frase;
      if (imagem) alunos[idx].imagem = imagem;

      editandoIndex = null;
      carregarVotacoes();
    } else {
      alert('Erro ao salvar: ' + res.msg);
    }
  })
  .catch(err => {
    console.error(err);
    alert('Erro de conexão ao salvar candidato');
  });
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
  const candidato = alunos[removerIndex];

  const formData = new FormData();
  formData.append('id_cand', candidato.id_cand);

  fetch('../includes/remover_candidato.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(res => {
    if (res.success) {
      alunos.splice(removerIndex, 1);
      removerIndex = null;
      document.getElementById("popup-remover").style.display = "none";
      ordemAtual = 0;
      carregarVotacoes();
    } else {
      alert('Erro ao remover: ' + res.msg);
    }
  })
  .catch(err => {
    console.error(err);
    alert('Erro de conexão ao remover candidato');
  });
});


document.querySelector(".btn-nao").addEventListener("click", () => {
  document.getElementById("popup-remover").style.display = "none";
  removerIndex = null;
});

carregarVotacoes();
