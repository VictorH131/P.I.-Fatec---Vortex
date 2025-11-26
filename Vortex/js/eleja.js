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
// POPUP - ERRO GENÉRICO
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
// POPUP - ERRO JÁ CADASTRADO
// ================================
const popupJaCadastrado = `
    <div id="popupJaCadastrado" class="popup-overlay" style="display: none;">
      <div class="popup-box">
        <h2>Você já é candidato!</h2>
        <p>Parece que você já realizou seu cadastro como candidato.</p>
        <p><small>Não é possível cadastrar novamente.</small></p>
        <button id="fecharPopupJaCadastrado">OK</button>
      </div>
    </div>
`;
document.body.insertAdjacentHTML("beforeend", popupJaCadastrado);

// ================================
// LÓGICA PRINCIPAL
// ================================
document.addEventListener("DOMContentLoaded", () => {

  // Elementos dos popups
  const popupSucesso = document.getElementById("popupCadastrado");
  const fecharSucesso = document.getElementById("fecharPopupCadastrado");

  const popupErroBox = document.getElementById("popupErro");
  const fecharErro = document.getElementById("fecharPopupErro");
  const textoErro = document.getElementById("mensagemErro");

  const popupJaCad = document.getElementById("popupJaCadastrado");
  const fecharJaCad = document.getElementById("fecharPopupJaCadastrado");

  // ================================
  // DETECTA ERRO OU SUCESSO NA URL
  // ================================
  const urlParams = new URLSearchParams(window.location.search);

  // Já é candidato
  if (urlParams.get('erro') === 'jacadastrado') {
      popupJaCad.style.display = "flex";
  }

  // Cadastrado com sucesso
  if (urlParams.get('status') === 'ok') {
      popupSucesso.style.display = "flex";
  }

  // Botão para fechar popup "Já cadastrado"
  fecharJaCad.addEventListener("click", () => {
      popupJaCad.style.display = "none";
      window.location.href = "../Sessao_aluno/home_aluno.php";
  });

  window.addEventListener("click", (e) => {
    if (e.target === popupJaCad) {
      popupJaCad.style.display = "none";
      window.location.href = "../Sessao_aluno/home_aluno.php";
    }
  });

  // ================================
  // FORMULÁRIO
  // ================================
  const form = document.querySelector("form");
  const btnCadastrar = document.getElementById("btnCadastrar");

  btnCadastrar.addEventListener("click", (e) => {
    e.preventDefault();

    const nome = document.getElementById("nome");
    const email = document.getElementById("email");

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

    // Envia formulário normalmente para o PHP
    form.submit();
  });

  // Popup sucesso → envia formulário (caso clicado fora da caixa)
  fecharSucesso.addEventListener("click", () => {
    window.location.href = "../Sessao_aluno/home_aluno.php";
  });

  window.addEventListener("click", (e) => {
    if (e.target === popupSucesso) {
      window.location.href = "../Sessao_aluno/home_aluno.php";
    }
  });

  // Fechar popup erro
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
