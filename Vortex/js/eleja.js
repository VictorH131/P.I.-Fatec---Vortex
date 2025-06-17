const popupCadastrado = `
      <div id="popupCadastrado" class="popup-overlay">
        <div class="popup-box">
          <h2>Cadastrado</h2>
          <p>Ficamos felizes com sua decisão<br>e te desejamos sorte!</p>
          <p><small>Clique OK para sair</small></p>
          <button id="fecharPopupCadastrado">OK</button>
        </div>
      </div>
    `;

    // Insere o popup no body
    document.body.insertAdjacentHTML("beforeend", popupCadastrado);

    // Espera o DOM carregar
    document.addEventListener("DOMContentLoaded", () => {
      const popup = document.getElementById("popupCadastrado");
      const botaoFechar = document.getElementById("fecharPopupCadastrado");
      const botaoAbrir = document.getElementById("btnCadastrar");

      // Abre o popup
      botaoAbrir.addEventListener("click", (e) => {
        e.preventDefault();
        popup.style.display = "flex";
      });

      // Fecha ao clicar em "OK"
      botaoFechar.addEventListener("click", () => {
        popup.style.display = "none";
      });

      // Fecha ao clicar fora do popup
      window.addEventListener("click", (e) => {
        if (e.target === popup) {
          popup.style.display = "none";
        }
      });
    });




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