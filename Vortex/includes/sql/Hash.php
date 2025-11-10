<?php
session_start();
    require_once '../dbconnect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            if (isset($_POST['reset_aluno'])) {
                $hash1 = password_hash('senha123', PASSWORD_DEFAULT);
                $hash2 = password_hash('Catarino@123', PASSWORD_DEFAULT);
                $hash3 = password_hash('feoli0805', PASSWORD_DEFAULT);
                $hash4 = password_hash('25862210', PASSWORD_DEFAULT);

                $sql = "UPDATE aluno SET senha = :senha WHERE id_aluno = :id";
                $stmt = $conn->prepare($sql);

                $stmt->execute([':senha' => $hash1, ':id' => 1]);
                $stmt->execute([':senha' => $hash2, ':id' => 2]);
                $stmt->execute([':senha' => $hash3, ':id' => 3]);
                $stmt->execute([':senha' => $hash4, ':id' => 4]);

                $mensagem = "Senhas dos alunos redefinidas.";
            }

            if (isset($_POST['reset_adm'])) {
                $hash1 = password_hash('senha123', PASSWORD_DEFAULT);
                $hash2 = password_hash('Catarino@123', PASSWORD_DEFAULT);
                $hash3 = password_hash('feoli0805', PASSWORD_DEFAULT);
                $hash4 = password_hash('25862210', PASSWORD_DEFAULT);

                $sql = "UPDATE adm SET senha = :senha WHERE id_adm = :id";
                $stmt = $conn->prepare($sql);

                $stmt->execute([':senha' => $hash1, ':id' => 1]);
                $stmt->execute([':senha' => $hash2, ':id' => 2]);
                $stmt->execute([':senha' => $hash3, ':id' => 3]);
                $stmt->execute([':senha' => $hash4, ':id' => 4]);

                $mensagem = "Senhas dos alunos redefinidas.";
                
            }






        } catch (PDOException $e) {
            $mensagem = "Erro: " . htmlspecialchars($e->getMessage());
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Resetar Senhas</title>
    </head>
    <body>
        <?php if (isset($mensagem)) : ?>
        <p><?= $mensagem ?></p>
        <?php endif; ?>

        <form method="POST">
            <button type="submit" name="reset_aluno">Resetar Senhas dos Alunos</button>
            <button type="submit" name="reset_adm">Resetar Senhas dos Administradores</button>
        </form>

    </body>
</html>
