<?php
require_once '../includes/dbconnect.php';
include '../includes/session.php';
include '../includes/header_adm.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: votar_adm.php');
    exit();
}

$id_votacao = $_GET['id'];

$sql = "SELECT id_votacao, descricao, data_inicio, data_fim, semestre, curso, status, data_inscricao 
        FROM votacao 
        WHERE id_votacao = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id_votacao]);
$votacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$votacao) {
    die("Votação não encontrada!");
}

$agora      = time();
$inicio     = strtotime($votacao['data_inicio']);
$fim        = strtotime($votacao['data_fim']);
$inscricao  = strtotime($votacao['data_inscricao']);

$sqlC = "SELECT c.id_cand AS id_candidato, a.nome, c.foto
         FROM itens_votacao iv
         JOIN candidato c ON iv.id_cand = c.id_cand
         JOIN aluno a ON c.id_aluno = a.id_aluno
         WHERE iv.id_votacao = :id";

$stmtC = $conn->prepare($sqlC);
$stmtC->execute([':id' => $id_votacao]);
$candidatos = $stmtC->fetchAll(PDO::FETCH_ASSOC);
?>

<title>Gerenciar Votação - <?= htmlspecialchars($votacao['descricao']) ?></title>

<style>
.alerta {
    width: 100%;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 17px;
    font-weight: 600;
    color: #fff;
    animation: aparecer 0.3s ease;
    transition: opacity 0.5s ease;
}
.alerta.ativada { background:#28a745; }
.alerta.encerrada { background:#c0392b; }
.alerta.excluida { background:#8e44ad; }

@keyframes aparecer {
    from { opacity: 0; transform: translateY(-5px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<main id="maingerenciarvoto">
    <div class="container">

        <?php if (isset($_GET['msg'])): ?>
            <div class="alerta <?= $_GET['msg'] ?>">
                <?php if ($_GET['msg'] === 'ativada'): ?>✔ A votação foi ativada!<?php endif; ?>
                <?php if ($_GET['msg'] === 'encerrada'): ?>✔ A votação foi encerrada!<?php endif; ?>
                <?php if ($_GET['msg'] === 'excluida'): ?>✔ Votação excluída com sucesso!<?php endif; ?>
            </div>
            <script>
                setTimeout(()=>{
                    const a=document.querySelector('.alerta');
                    if(a) a.style.opacity='0';
                    setTimeout(()=>{ if(a) a.remove(); },500);
                },3000);
            </script>
        <?php endif; ?>

        <h2>Gerenciar Votação</h2>

        <div class="linha-completa">
            <div class="linha-fina"></div>
            <div class="linha-grossa"></div>
            <div class="linha-fina"></div>
        </div>

        <div class="subtitulo">
            <?= htmlspecialchars($votacao['curso']) ?> - <?= htmlspecialchars($votacao['semestre']) ?>º Semestre
        </div>

        <div class="caixa-info">
            <p><strong>Descrição:</strong> <?= htmlspecialchars($votacao['descricao']) ?></p>
            <p><strong>Data de Início:</strong> <?= date('d/m/Y', $inicio) ?></p>
            <p><strong>Data de Término:</strong> <?= date('d/m/Y', $fim) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($votacao['status']) ?></p>
            <p><strong>Período de Inscrição:</strong> <?= date('d/m/Y', $inscricao) ?></p>
        </div>

        <div class="acoes-gerenciamento">

            <?php
                $bloquearEdicao = false;

                // BLOQUEIA SE:
                // - votação ativa E JÁ INICIOU
                if ($votacao['status'] === 'ativo' && $agora >= $inicio) {
                    $bloquearEdicao = true;
                }
            ?>

            <?php if (count($candidatos) > 0 && !$bloquearEdicao && $votacao['status'] !== 'encerrada'): ?>
                <a href="editar_votacao.php?id=<?= $votacao['id_votacao'] ?>" class="btn-gerenciar">Editar Participantes</a>
            <?php else: ?>
                <span class="btn-gerenciar" style="opacity:0.5;cursor:not-allowed;">Editar Participantes</span>
            <?php endif; ?>


            <!-- BOTÕES PRINCIPAIS -->
            <?php

                if (count($candidatos) == 0) {
                    echo '<span class="btn-gerenciar" style="opacity:0.5;">Cadastre candidatos para iniciar</span>';
                } else {
                    if ($votacao['status'] === 'ativo') {

                        if ($agora < $inicio) {
                            // Antes do início
                           echo '<form action="../includes/iniciar_votacao.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_votacao" value="'.$votacao['id_votacao'].'">
                                    <button type="submit" class="btn-gerenciar">Iniciar Votação</button>
                                </form>';
                        } else {
                            // Após o início → mostrar botão encerrar
                            echo '<form action="../includes/encerrar_votacao.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_votacao" value="'.$votacao['id_votacao'].'">
                                    <button type="submit" class="btn-gerenciar">Encerrar Votação</button>
                                </form>';
                        }

                    } else {
                        
                        echo '<a href="resultados_votacao.php?id='.$votacao['id_votacao'].'" class="btn-gerenciar">Ver Resultados</a>';
                    }
                }
            ?>

            <!-- BOTÃO EXCLUIR (permanece) -->
            <button type="button" class="btn-exluir" onclick="abrirPopupExcluir()">Excluir Votação</button>

            <!-- POPUP (cole logo após o botão) -->
            <div id="popup-excluir" class="popup-fundo" aria-hidden="true" role="dialog" aria-modal="true">
                <div class="popup-caixa" role="document">
                    <button class="popup-close" aria-label="Fechar" onclick="fecharPopupExcluir()">✕</button>

                    <h3>Excluir Votação</h3>
                    <p>Tem certeza que deseja excluir esta votação?<br><strong>Esta ação é permanente e não poderá ser desfeita.</strong></p>

                    <div class="popup-acoes">
                        <button type="button" class="btn-cancelar" onclick="fecharPopupExcluir()">Cancelar</button>

                        <form action="../includes/excluir_votacao.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_votacao" value="<?= htmlspecialchars($votacao['id_votacao']) ?>">
                            <button type="submit" class="btn-confirmar">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>

            



            <!-- VOLTAR -->
            <a href="votar_adm.php?curso=<?= urlencode($votacao['curso']) ?>&semestre=<?= $votacao['semestre'] ?>" class="btn-voltar">Voltar</a>

        </div>

        <h3 style="margin-top:40px;">Candidatos</h3>

        <?php if (count($candidatos) === 0): ?>
            <div style="margin-top:30px; text-align:center;">
                <img src="https://img.icons8.com/ios-filled/100/000000/conference-call.png" style="opacity:0.7;">
                <p style="margin-top:15px;font-size:18px;color:#555;">Nenhum candidato inscrito nesta votação.</p>
            </div>
        <?php else: ?>
            <div class="lista-candidatos">
                <?php foreach ($candidatos as $c):
                    $foto = (!empty($c['foto']) && file_exists("../".$c['foto'])) ? "../".$c['foto'] : "../img/default_user.png";
                ?>
                    <div class="card-candidato">
                        <img src="<?= $foto ?>" class="foto-cand">
                        <p><?= htmlspecialchars($c['nome']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<script>
(function(){
    const popup = document.getElementById('popup-excluir');
    const caixa = popup ? popup.querySelector('.popup-caixa') : null;

    window.abrirPopupExcluir = function() {
        if(!popup) return console.warn('popup-excluir não encontrado no DOM.');
        popup.classList.add('mostrar');
        popup.setAttribute('aria-hidden','false');
        // foco no botão confirmar para teclado (opcional)
        const confirmar = popup.querySelector('.btn-confirmar');
        if(confirmar) confirmar.focus();
        // trava scroll do body
        document.documentElement.style.overflow = 'hidden';
        document.body.style.overflow = 'hidden';
    };

    window.fecharPopupExcluir = function() {
        if(!popup) return;
        popup.classList.remove('mostrar');
        popup.setAttribute('aria-hidden','true');
        document.documentElement.style.overflow = '';
        document.body.style.overflow = '';
    };

    // fechar ao clicar fora da caixa
    if (popup && caixa) {
        popup.addEventListener('mousedown', function(e){
            // se o clique for fora da caixa, fecha
            if (!caixa.contains(e.target)) {
                fecharPopupExcluir();
            }
        });
    }

    // fechar com ESC
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' || e.key === 'Esc') {
            if (popup && popup.classList.contains('mostrar')) fecharPopupExcluir();
        }
    });
})();
</script>


<?php include '../includes/footer.php'; ?>
