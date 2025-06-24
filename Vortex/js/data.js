const inicioInput = document.getElementById("inicio");
const fimInput = document.getElementById("fim");

// Define o mínimo do INÍCIO para hoje
const hoje = new Date();
const hojeFormatado = hoje.toISOString().split('T')[0];
inicioInput.min = hojeFormatado;

// Quando o INÍCIO mudar, define o mínimo do FIM para +7 dias
inicioInput.addEventListener('change', () => {
    if (inicioInput.value) {
    const inicioData = new Date(inicioInput.value);
    inicioData.setDate(inicioData.getDate() + 7);
    const fimMin = inicioData.toISOString().split('T')[0];
    fimInput.min = fimMin;
    } else {
    fimInput.min = "";
    }
});