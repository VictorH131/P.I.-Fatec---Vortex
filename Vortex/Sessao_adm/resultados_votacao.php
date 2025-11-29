<?php
include '../includes/session.php'; // Verifica se está logado
include '../includes/header_adm.php'; 
include '../includes/dbconnect.php';

echo '<title>Resultados - Vortex</title>';


if (!function_exists('calcularDadosAluno')) {
    function calcularDadosAluno($matricula) {
        if (strlen($matricula) !== 13) {
            return ['erro' => 'A matrícula deve conter exatamente 13 dígitos.'];
        }

        $codigo_fatec = substr($matricula, 0, 6);
        $ano_inicio = intval(substr($matricula, 6, 2));
        $semestre_inicio = intval(substr($matricula, 8, 1));
        $codigo_curso = intval(substr($matricula, 9, 1));
        $id_aluno = substr($matricula, 10, 3);

        $cursos = [
            1 => "GE",
            2 => "GI",
            3 => "DSM"
        ];

        $curso = $cursos[$codigo_curso] ?? "Curso desconhecido";

        $ano_atual = intval(date("y"));
        $mes = intval(date("n"));
        $semestre_atual = ($mes <= 6) ? 1 : 2;

        $semestres_passados = (($ano_atual - $ano_inicio) * 2) + ($semestre_atual - $semestre_inicio);
        $semestre_do_curso = max(1, $semestres_passados + 1);

        return [
            'curso' => $curso,
            'semestre' => $semestre_do_curso
        ];
    }
}

// ID da votação
$id_votacao = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ----------- CONSULTA — DADOS DA VOTAÇÃO (curso e semestre) -----------
$sql_info = "SELECT curso, semestre FROM votacao WHERE id_votacao = :id";
$stmt_info = $conn->prepare($sql_info);
$stmt_info->bindValue(':id', $id_votacao);
$stmt_info->execute();
$info = $stmt_info->fetch(PDO::FETCH_ASSOC);

$curso = $info['curso'] ?? '';
$semestre = $info['semestre'] ?? '';

// ----------- CONSULTA — CANDIDATOS + VOTOS -----------
$sql_candidatos = "
    SELECT 
        c.id_cand,
        a.nome AS nome,
        c.foto,
        c.descricao,
        COUNT(v.id_voto) AS votos
    FROM candidato c
    INNER JOIN aluno a ON c.id_aluno = a.id_aluno
    INNER JOIN itens_votacao iv ON iv.id_cand = c.id_cand
    LEFT JOIN voto v ON v.id_cand = c.id_cand AND v.id_votacao = :v1
    WHERE iv.id_votacao = :v2
    GROUP BY c.id_cand
    ORDER BY votos DESC
";
$stmt = $conn->prepare($sql_candidatos);
$stmt->bindValue(':v1', $id_votacao);
$stmt->bindValue(':v2', $id_votacao);
$stmt->execute();
$candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ----------- CONSULTA — REGISTRO DE VOTOS -----------
$sql_votos = "
    SELECT 
        a.nome,
        CASE WHEN v.id_voto IS NULL THEN 0 ELSE 1 END AS votou
    FROM aluno a
    LEFT JOIN voto v ON v.id_aluno = a.id_aluno AND v.id_votacao = :idv
    ORDER BY a.nome
";
$stmt2 = $conn->prepare($sql_votos);
$stmt2->bindValue(':idv', $id_votacao);
$stmt2->execute();
$registros = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<main id="mainfinal">
    
    <div id="centro">
        <h2>Resultados</h2>

        <div class="linha-completa">
            <div class="linha-grossa"></div>
            <div class="linha-fina"></div>
        </div>
    </div>
    <div class="info-votacao">
        <button class="btn-voltar" onclick="window.history.back();">Voltar</button>
    </div>
    <div class="info-votacao">
        <h3>
            Resultados da votação
            <?php echo htmlspecialchars($curso); ?> — 
            <?php echo htmlspecialchars($semestre); ?>º semestre
        </h3>
    </div>

    <div class="info-votacao">
        <button class="btn-gerar-ata">Gerar Ata de Votação</button>
    </div>

    <div class="cards-container">

        <?php foreach ($candidatos as $cand): ?>
        <div class="card">
            <img src="../<?php echo htmlspecialchars($cand['foto']); ?>" alt="<?php echo htmlspecialchars($cand['nome']); ?>" />

            <strong><?php echo htmlspecialchars($cand['nome']); ?></strong>

            <p><?php echo htmlspecialchars($cand['descricao']); ?></p>

            <div class="votos">Quantidade de votos: <?php echo $cand['votos']; ?></div>
        </div>
        <?php endforeach; ?>

    </div>

    <div class="container">
        <h2>Registro de votos</h2>
        <table>
    <thead>
        <tr>
            <th>Aluno</th>
            <th>Curso</th>
            <th>Semestre</th>
            <th>Votou?</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($registros as $reg): ?>
        <?php 
            // Busca matrícula do aluno
            $sql_m = "SELECT matricula FROM aluno WHERE nome = :nome LIMIT 1";
            $stm_m = $conn->prepare($sql_m);
            $stm_m->bindValue(':nome', $reg['nome']);
            $stm_m->execute();
            $row_m = $stm_m->fetch(PDO::FETCH_ASSOC);

            $dados = ['curso' => '-', 'semestre' => '-'];

            if ($row_m && !empty($row_m['matricula'])) {
                $dados = calcularDadosAluno($row_m['matricula']);
            }
        ?>

        <tr>
            <td><?php echo htmlspecialchars($reg['nome']); ?></td>

            <td><?php echo htmlspecialchars($dados['curso']); ?></td>

            <td><?php echo htmlspecialchars($dados['semestre']); ?>º</td>

            <td class="<?php echo $reg['votou'] ? 'sim' : 'nao'; ?>">
                <?php echo $reg['votou'] ? 'Sim' : 'Não'; ?>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>

    </div>

</main>

<?php include '../includes/footer.php'; ?>
