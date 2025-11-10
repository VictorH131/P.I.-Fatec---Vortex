<?php
  include '../includes/session.php'; // Verifica se esta logado
  include '../includes/header_adm.php'; // header 
  echo '<title>Gerenciamento Administrativo - Vortex</title>'; // titulo da pagina
  
?>

   <main id="mainVer">   
        <div class="content">
            <div class="title-section">Gerenciamento das Votações</div>
                <!-- Filtro -->
                <form action="criar_votacao.php" method="post">
                    <div class="filtro-container">
                        <select class="filtro-select" name="curso" id="curso">
                            <option value="" disabled selected>Selecione o Curso</option>
                            <option value="DSM">DSM - Desenvolvimento de Software Multiplataforma</option>
                            <option value="GI">GI - Gestão Industrial</option>
                            <option value="GE">GE - Gestão Empresarial</option>
                        </select>

                        <select class="filtro-select" name="semestre" id="semestre" >
                            <option value="" disabled selected>Selecione o Semestre</option>
                            <option value="1">1º Semestre</option>
                            <option value="2">2º Semestre</option>
                            <option value="3">3º Semestre</option>
                            <option value="4">4º Semestre</option>
                            <option value="5">5º Semestre</option>
                            <option value="6">6º Semestre</option>
                        </select>

                        <button class="filtro-btn">Filtrar</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </main>
 
<?php
  include '../includes/footer.php';
?>