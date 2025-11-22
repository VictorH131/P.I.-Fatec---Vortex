// ================================
// POPUP - SUCESSO
// ================================
const popupCadastrado = `
    <div id="popupCadastrado" class="popup-overlay" style="display: none;">
      <div class="popup-box">
        <h2>Cadastrado</h2>
        <p>Ficamos felizes com sua decisão<br>e te desejamos sorte!</p>
        <p><small>Clique OK para continuar</small></p>
        <button id="fecharPopupCadastrado">OK</button>
      </div>
    </div>
`;
document.body.insertAdjacentHTML("beforeend", popupCadastrado);


// ================================
// POPUP - ERRO
// ================================
const popupErro = `
    <div id="popupErro" class="popup-overlay" style="display: none;">
      <div class="popup-box">
        <h2>Erro!</h2>
        <p id="mensagemErro">Preencha os campos corretamente.</p>
        <button id="fecharPopupErro">OK</button>
      </div>
    </div>
`;
document.body.insertAdjacentHTML("beforeend", popupErro);


// ================================
// LÓGICA PRINCIPAL
// ================================
document.addEventListener("DOMContentLoaded", () => {

  const popupSucesso = document.getElementById("popupCadastrado");
  const fecharSucesso = document.getElementById("fecharPopupCadastrado");

  const popupErroBox = document.getElementById("popupErro");
  const fecharErro = document.getElementById("fecharPopupErro");
  const textoErro = document.getElementById("mensagemErro");

  const btnCadastrar = document.getElementById("btnCadastrar");

  // Seleciona o form
  const form = document.querySelector("form");

  btnCadastrar.addEventListener("click", (e) => {
    e.preventDefault();

    // CAMPOS
    const nome = document.getElementById("nome");
    const email = document.getElementById("email");
    const descricao = document.getElementById("descricao");

    // ===============================
    // VALIDAÇÃO
    // ===============================
    if (nome.value.trim() === "") {
      textoErro.textContent = "Digite seu nome.";
      popupErroBox.style.display = "flex";
      return;
    }

    if (email.value.trim() === "") {
      textoErro.textContent = "Digite seu e-mail.";
      popupErroBox.style.display = "flex";
      return;
    }

    // Se tudo OK → abrir popup sucesso
    popupSucesso.style.display = "flex";
  });


  // ===============================
  // BOTÃO OK DO POPUP → SUBMITE O FORMULÁRIO
  // ===============================
  fecharSucesso.addEventListener("click", () => {
    form.submit();
  });

  // Clique fora → também envia o formulário
  window.addEventListener("click", (e) => {
    if (e.target === popupSucesso) {
      form.submit();
    }
  });

  // ===============================
  // FECHAR POPUP DE ERRO
  // ===============================
  fecharErro.addEventListener("click", () => {
    popupErroBox.style.display = "none";
  });

  window.addEventListener("click", (e) => {
    if (e.target === popupErroBox) {
      popupErroBox.style.display = "none";
    }
  });
});


// ================================
// PREVIEW DA IMAGEM
// ================================
const input = document.getElementById('fileInput');
const preview = document.getElementById('preview');

input.addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});
