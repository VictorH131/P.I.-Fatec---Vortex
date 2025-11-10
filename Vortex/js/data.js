const inicioInput = document.getElementById("inicio");
const fimInput = document.getElementById("fim");
const inscricoesSelect = document.getElementById("inscricoes");

// Define o mínimo do INÍCIO para hoje
const hoje = new Date();
const hojeFormatado = hoje.toISOString().split('T')[0];
inicioInput.min = hojeFormatado;

// Quando selecionar o prazo de inscrições
inscricoesSelect.addEventListener("change", () => {
  const dias = parseInt(inscricoesSelect.value);

  if (!isNaN(dias)) {
    const data = new Date();
    data.setDate(data.getDate() + dias);
    const novaDataInicio = data.toISOString().split("T")[0];

    inicioInput.value = novaDataInicio;

    // Bloqueia tudo: digitar, colar, arrastar e abrir calendário
    inicioInput.addEventListener("keydown", (e) => e.preventDefault());
    inicioInput.addEventListener("paste", (e) => e.preventDefault());
    inicioInput.addEventListener("drop", (e) => e.preventDefault());
    inicioInput.addEventListener("click", (e) => e.preventDefault());
    inicioInput.addEventListener("mousedown", (e) => e.preventDefault());

    inicioInput.dispatchEvent(new Event("change")); // Atualiza FIM
  }
});

// Quando o início mudar → o fim deve ser no mínimo +7 dias
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
