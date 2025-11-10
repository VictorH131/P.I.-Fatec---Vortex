<?php
session_start();
require_once 'dbconnect.php'; // CONEXÃO

// Garante que veio via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Pega dados do formulário
    $curso = $_POST['curso'];
    $semestre = $_POST['semestre'];
    $inscricoes = $_POST['inscricoes'];
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];
    $descricao = $_POST['descricao'];

    // ID do administrador logado
    $id_adm = $_SESSION['usuario']['id'];

    // Data de abertura das inscrições = hoje
    $data_inscricao = date("Y-m-d");

    // Verificação básica
    if (empty($curso) || empty($semestre) || empty($inscricoes) || empty($inicio) || empty($fim)) {
        $_SESSION['aviso'] = "Preencha todos os campos!";
        header("Location: ../Sessao_adm/criacao_votacao.php");
        exit;
    }

    try {
        // INSERIR NO BANCO
        $stmt = $conn->prepare("
            INSERT INTO votacao 
            (curso, semestre, data_inscricao, data_inicio, data_fim, descricao, id_adm) 
            VALUES 
            (:curso, :semestre, :data_inscricao, :data_inicio, :data_fim, :descricao, :id_adm)
        ");

        $stmt->execute([
            ':curso' => $curso,
            ':semestre' => $semestre,
            ':data_inscricao' => $data_inscricao,
            ':data_inicio' => $inicio,
            ':data_fim' => $fim,
            ':descricao' => $descricao,
            ':id_adm' => $id_adm
        ]);

        // volta para a página após criar
        $_SESSION['aviso'] = "Votação criada com sucesso!";
        header("Location: ../Sessao_adm/votar_adm.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['aviso'] = "Erro ao criar votação: " . $e->getMessage();
        header("Location: ../Sessao_adm/criacao_votacao.php");
        exit;
    }
}
