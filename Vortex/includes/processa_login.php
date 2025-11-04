<?php
session_start();
require_once 'dbconnect.php'; // usa $conn

// -------------------------------
// GERA TOKEN CSRF SE NÃO EXISTIR
// -------------------------------
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// -------------------------------
// VERIFICA ENVIO DO FORMULÁRIO
// -------------------------------
if (isset($_POST['email'], $_POST['senha'], $_POST['csrf_token'])) {

    // CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $_SESSION['aviso'] = "Erro de validação CSRF.";
        header('Location: ../login_aluno.php');
        exit;
    }

    // -------------------------------
    // LIMITE DE TENTATIVAS
    // -------------------------------
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt'] = time();
    }

    if ($_SESSION['login_attempts'] >= 7) {
        if (time() - $_SESSION['last_attempt'] < 180) { // 3 minutos
            $_SESSION['aviso'] = "Muitas tentativas. Tente novamente em 3 minutos.";
            header('Location: ../login_aluno.php');
            exit;
        } else {
            $_SESSION['login_attempts'] = 0; // Zera tentativas após o tempo
        }
    }

    // -------------------------------
    // SANITIZAÇÃO E VALIDAÇÃO
    // -------------------------------
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['aviso'] = "E-mail inválido!";
        header('Location: ../login_aluno.php');
        exit;
    }

    // -------------------------------
    // VERIFICAÇÃO NO BANCO
    // -------------------------------
    try {
        $sql = "SELECT id_aluno, nome, senha FROM aluno WHERE email_institucional = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Usuário existe, verifica a senha
            if (password_verify($senha, $usuario['senha'])) {
                // Login correto
                $_SESSION['login_attempts'] = 0; // Zera tentativas
                $_SESSION['usuario'] = [
                    'id' => $usuario['id_aluno'],
                    'nome' => $usuario['nome'],
                    'email' => $email
                ];
                $_SESSION['logado'] = true; // guarda sessão
                header('Location: ../home_aluno.php');
                exit;
            } else {
                // Senha incorreta
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt'] = time();
                $_SESSION['aviso'] = "Senha incorreta.";
                header('Location: ../login_aluno.php');
                exit;
            }
        } else {
            // Usuário não encontrado
            $_SESSION['login_attempts']++;
            $_SESSION['last_attempt'] = time();
            $_SESSION['aviso'] = "E-mail não cadastrado.";
            header('Location: ../login_aluno.php');
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['aviso'] = "Erro ao acessar o banco de dados.";
        header('Location: ../login_aluno.php');
        exit;
    }

} else {
    $_SESSION['aviso'] = "Por favor, preencha todos os campos.";
    header('Location: ../login_aluno.php');
    exit;
}
