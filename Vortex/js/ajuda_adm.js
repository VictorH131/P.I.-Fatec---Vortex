
const popupSugestao = `
<div id="popupSugestao" class="popup-overlay">
    <div class="popup-conteudo">
    <span class="fechar" id="fecharPopupSugestao">&times;</span>
    <h2>Sugestão Enviada!</h2>
    <p>Agradecemos por compartilhar sua ideia conosco. Sua sugestão foi registrada com sucesso e será analisada por nossa equipe com carinho.</p>
    <p>Prezamos pela sua opinião e acreditamos que ela pode contribuir para tornar nosso ambiente acadêmico ainda melhor.</p>
    <p>Lembramos que nenhuma informação pessoal é vinculada a esse envio. Tudo é tratado de forma anônima e segura, conforme nossa <a href="Politicas_adm.html" target="_blank">Política de Privacidade</a>.</p>
    </div>
</div>
`;

// Popup de erro
const popupErro = `
<div id="popupErroMensagem" class="popup-overlay">
    <div class="popup-box">
        <h2>Error!</h2>
        <p>Por favor, escreva uma sugestão antes de enviar.</p>
        <button id="fecharPopupErroMensagem">OK</button>
    </div>
</div>
`;

document.body.insertAdjacentHTML("beforeend", popupSugestao);
document.body.insertAdjacentHTML("beforeend", popupErro);

document.addEventListener("DOMContentLoaded", () => {
    const btnEnviar = document.querySelector(".sugestoes button");
    const popup = document.getElementById("popupSugestao");
    const fechar = document.getElementById("fecharPopupSugestao");
    const textarea = document.querySelector(".sugestoes textarea");

    const popupErro = document.getElementById("popupErroMensagem");
    const fecharPopupErro = document.getElementById("fecharPopupErroMensagem");

    // Abre popup de sucesso ou erro
    btnEnviar.addEventListener("click", () => {
        if (textarea.value.trim() !== "") {
            popup.style.display = "flex";
        } else {
            popupErro.style.display = "flex";
        }
    });

    // Fecha popup de sucesso
    fechar.addEventListener("click", () => {
        popup.style.display = "none";
        textarea.value = "";
    });

    // Fecha popup de erro
    fecharPopupErro.addEventListener("click", () => {
        popupErro.style.display = "none";
    });

    // Fecha ao clicar fora
    window.addEventListener("click", function (e) {
        if (e.target === popup) {
            popup.style.display = "none";
            textarea.value = "";
        } else if (e.target === popupErro) {
            popupErro.style.display = "none";
        }
    });
});



document.addEventListener("DOMContentLoaded", () => {
  const faqItems = document.querySelectorAll("#mainajuda .faq-item");

  faqItems.forEach(item => {
    const pergunta = item.querySelector(".faq-pergunta");

    pergunta.addEventListener("click", () => {
      
      item.classList.toggle("ativo");
    });
  });
});
