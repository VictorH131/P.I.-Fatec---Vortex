
<?php
ob_start(); // inicia buffer para evitar erros de saída

require_once __DIR__ . '/../pdf/fpdf/fpdf.php';
require_once __DIR__ . '/../pdf/fpdi/src/autoload.php';
use setasign\Fpdi\Fpdi;

include 'dbconnect.php';

// Forçar UTF-8 no banco
$conn->exec("SET NAMES 'utf8'");
$conn->exec("SET CHARACTER SET utf8");
$conn->exec("SET COLLATION_CONNECTION = 'utf8_general_ci'");

// ===============================================
// BUSCA DADOS DA VOTAÇÃO
// ===============================================
$id_votacao = intval($_GET['id'] ?? 0);

$sql = "SELECT curso, semestre, DATE_FORMAT(data_fim, '%d/%m/%Y') AS data_eleicao FROM votacao WHERE id_votacao = :id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $id_votacao);
$stmt->execute();
$info = $stmt->fetch(PDO::FETCH_ASSOC);

$curso = $info['curso'] ?? 'N/A';
$semestre = $info['semestre'] ?? 'N/A';

// Mapear código do curso para nome completo
$mapa_cursos = [
    'DSM' => 'Desenvolvimento de Sistemas Multiplataforma',
    'GI' => 'Gestão de Produção Industrial',
    'GE' => 'Gestão Empresarial',
];
if (isset($mapa_cursos[$curso])) {
    $curso_nome = $curso;
    $curso = $mapa_cursos[$curso];
}

$data_eleicao = $info['data_eleicao'] ?? date('d/m/Y');
$data_atual = date('d/m/Y');

$sql2 = "
SELECT a.nome, a.matricula, COUNT(v.id_voto) AS votos
FROM candidato c
JOIN aluno a ON a.id_aluno = c.id_aluno
LEFT JOIN voto v ON v.id_cand = c.id_cand AND v.id_votacao = :id
GROUP BY c.id_cand
ORDER BY votos DESC
";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindValue(':id', $id_votacao);
$stmt2->execute();
$candidatos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$representante = $candidatos[0] ?? ['nome'=>'NÃO HOUVE','matricula'=>'-----'];
$vice = $candidatos[1] ?? ['nome'=>'NÃO HOUVE','matricula'=>'-----'];

$sql3 = "SELECT nome, matricula FROM aluno ORDER BY nome";
$stmt3 = $conn->prepare($sql3);
$stmt3->execute();
$alunos = $stmt3->fetchAll(PDO::FETCH_ASSOC);








// ===============================================
// INICIAR FPDI
// ===============================================
$pdf = new FPDI();
$template_path = "../pdf/modelos/modelo_ata.pdf";
$pageCount = $pdf->setSourceFile($template_path);

// ---------- PÁGINA 1 ----------
$tpl = $pdf->importPage(1);
$size = $pdf->getTemplateSize($tpl);
$pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
$pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height']);

// Fonte compatível com acentos
$pdf->SetFont('Helvetica','',11);// certifique-se de que arial.php está em fpdf/font/
$pdf->SetFont('Arial','',11);

// Substituir aspas especiais por aspas retas
$curso = str_replace(['“','”'], '"', $curso);
$representante_nome = str_replace(['“','”'], '"', $representante['nome']);
$vice_nome = str_replace(['“','”'], '"', $vice['nome']);

// Converter UTF-8 para ISO-8859-1
$curso = iconv('UTF-8', 'ISO-8859-1//IGNORE', $curso);
$semestre = iconv('UTF-8', 'ISO-8859-1//IGNORE', $semestre);
$representante_nome = iconv('UTF-8', 'ISO-8859-1//IGNORE', $representante_nome);
$vice_nome = iconv('UTF-8', 'ISO-8859-1//IGNORE', $vice_nome);

// Converter nomes de alunos
foreach ($alunos as &$a) {
    $a['nome'] = iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace(['“','”'], '"', $a['nome']));
}
unset($a);

// Texto da ata
$pdf->SetXY(10, 60);
$texto_ata = "ATA DE ELEICAO DE REPRESENTANTES DE TURMA DO {$semestre} SEMESTRE DO CURSO DE TECNOLOGIA EM {$curso} DA FACULDADE DE TECNOLOGIA DE ITAPIRA \"OGARI DE CASTRO PACHECO\". Ao {$data_eleicao} foram apurados os votos dos alunos regularmente matriculados no {$semestre} Semestre do curso para eleicao de novos representantes de turma. Os representantes eleitos fazem a representacao dos alunos nos orgaos colegiados da Faculdade, com direito a voz e voto, conforme o disposto no artigo 69 da Deliberacao CEETEPS n- 07, de 15 de dezembro de 2006. Foi eleito(a) como representante o(a) aluno(a) {$representante_nome}, R.A. n- {$representante['matricula']} e eleito como vice o(a) aluno(a) {$vice_nome}, R.A. n- {$vice['matricula']}. A presente ata, apos leitura e concordancia, vai assinada por todos os alunos participantes. Itapira, {$data_atual}.";

$pdf->MultiCell(0, 7, $texto_ata);

// Lista de alunos – primeira página
$y = 161; // posição inicial vertical na página 1
$espaçamento = 6.3; // distância entre linhas (reduzida de 7 para 5)

foreach ($alunos as $index => $a) {

if ($index == 25) break; // limita primeira página
    $pdf->SetXY(25, $y); // posição do nome
    $pdf->Write(0, $a['nome']);

    $pdf->SetXY(119, $y); // posição fixa do RA
    $pdf->Write(0, $a['matricula']);

    $y += $espaçamento;

}

// Segunda página, se houver
if ($pageCount >= 2 && count($alunos) > 24) {
    $tpl2 = $pdf->importPage(2);
    $size2 = $pdf->getTemplateSize($tpl2);
    $pdf->AddPage($size2['orientation'], [$size2['width'], $size2['height']]);
    $pdf->useTemplate($tpl2, 0, 0, $size2['width'], $size2['height']);

    $y = 10;
    for ($i = 24; $i < count($alunos); $i++) {
        $a = $alunos[$i];
        $pdf->SetXY(20, $y); // nome
        $pdf->Write(0, $a['nome']);

        $pdf->SetXY(150, $y); // RA
        $pdf->Write(0, $a['matricula']);

        $y += $espaçamento;
    }

}

ob_end_clean();
$pdf->Output("Ata_Votacao_{$curso_nome}_{$semestre}.pdf", "I");
?>
