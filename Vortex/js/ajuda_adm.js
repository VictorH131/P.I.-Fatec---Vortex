
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

document.body.insertAdjacentHTML("beforeend", popupSugestao);


document.addEventListener("DOMContentLoaded", () => {
        const btnEnviar = document.querySelector(".sugestoes button");
        const popup = document.getElementById("popupSugestao");
        const fechar = document.getElementById("fecharPopupSugestao");
        const textarea = document.querySelector(".sugestoes textarea");

        // Abre popup 
        btnEnviar.addEventListener("click", () => {
                popup.style.display = "flex";
            }
        );

        // Fecha popup
        fechar.addEventListener("click", () => {
                popup.style.display = "none";
                textarea.value = ""; // Limpa o conteúdo do textarea
            }
        );

        // Fecha ao clicar fora 
        window.addEventListener("click", function (e) {
                if (e.target === popup) {
                    popup.style.display = "none";
                    textarea.value = ""; 
                }
            }
        );
    }
);



document.addEventListener("DOMContentLoaded", function () {
const perguntas = document.querySelectorAll(".faq-pergunta");

perguntas.forEach(pergunta => {
    pergunta.addEventListener("click", function () {
    const item = this.parentElement;
    item.classList.toggle("ativo");
    });
});
});



