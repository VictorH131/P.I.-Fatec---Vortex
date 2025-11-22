<?php
    session_start();

   // Verifica se a sessão 'logado' existe e está verdadeira
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        header('Location: ../index.html');
        exit;
    }
 
    //pega o nome do usuario
    $nomeUsuario = $_SESSION['usuario']['nome'];
    $class = $_SESSION['usuario']['class'];
    $matricula = $_SESSION['usuario']['matricula'];

    function calcularDadosAluno($matricula) {

        // Matrícula deve ter sempre 13 dígitos
        if (strlen($matricula) !== 13) {
            return ['erro' => 'A matrícula deve conter exatamente 13 dígitos.'];
        }

        // Estrutura da matrícula
        $codigo_fatec = substr($matricula, 0, 6);   // 6 dígitos
        $ano_inicio = intval(substr($matricula, 6, 2)); // 2 dígitos
        $semestre_inicio = intval(substr($matricula, 8, 1)); // 1 dígito
        $codigo_curso = intval(substr($matricula, 9, 1)); // 1 dígito
        $id_aluno = substr($matricula, 10, 3); // 3 dígitos

        // Converter código do curso
        $cursos = [
            1 => "GE",
            2 => "GI",
            3 => "DSM"
        ];

        $curso = $cursos[$codigo_curso] ?? "Curso desconhecido";

        // Ano/Semestre atual
        $ano_atual = intval(date("y"));
        $mes = intval(date("n"));
        $semestre_atual = ($mes <= 6) ? 1 : 2;

        // Cálculo do semestre do curso
        $semestres_passados = (($ano_atual - $ano_inicio) * 2) + ($semestre_atual - $semestre_inicio);
        $semestre_do_curso = max(1, $semestres_passados + 1);

        return [
            'fatec' => $codigo_fatec,
            'ano_inicio' => $ano_inicio,
            'semestre_inicio' => $semestre_inicio,
            'curso' => $curso,
            'id_aluno' => $id_aluno,
            'semestre' => $semestre_do_curso
        ];
    }

    if ($class == 'aluno') {
        $dados = calcularDadosAluno($matricula);

        $_SESSION['usuario']['semestre'] = $dados['semestre'];
        $_SESSION['usuario']['curso'] = $dados['curso'];

    }            



?>