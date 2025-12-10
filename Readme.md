
                                                                                                        
# **Projeto Integrador – Fatec Itapira (2025) - Vortex**                             
                                                                                                        
                                                                                                        
## Tema Sistema de Votação Online.                                                                                                                            
 > Parceria entre os alunos e a Fatec, visando modernizar processos internos de votação acadêmica.   
                                                                                                        
---

## Acesse o Projeto Vortex  
Explore o site oficial do **Vortex**, desenvolvido com foco em organização, transparência e tecnologia:

🔗 **[Clique aqui para visitar o Site do Vortex](https://vortexweb.page.gd/)**  

Sinta-se à vontade para navegar, testar as funcionalidades e acompanhar a evolução do projeto!



---


## Integrantes da Equipe

| Nome Completo Dos Participantes
|-------------------------------------------------------|
| **Victor Hernandez Soares de Almeida**                | 
| **Matheus Reinhart Camargo Martins Catarino**         | 
| **Feliphe Eduardo Silvério Gonçalves de Oliveira**    | 
| **Marcos Vinícius Rocha**                             | 
|-------------------------------------------------------|
---


##  Motivação do Projeto

O projeto **Sistema de Votação Online** foi iniciado em 28/10/2025 como solução para a necessidade de um sistema digital seguro, padronizado e acessível para realização de eleições acadêmicas.

Seu objetivo é permitir que alunos, docentes e gestão institucional possam participar e administrar votações de forma clara, organizada e rastreável. Toda a aplicação foi desenvolvida considerando boas práticas de **usabilidade, segurança, autenticação e integridade de dados**.

---

##  Funcionalidades

- Login seguro com controle de sessão (Aluno / Administrador).
- Criação de votações com datas e restrições.
- Inscrição e gerenciamento de candidatos.
- Votação online (com restrição de 1 voto por eleitor).
- Contagem automática e exibição dos resultados.
- Página Sobre, Ajuda e Políticas do Sistema.
- Geração de Ata e Documentação Completa.

---

##  Tecnologias Utilizadas

| Tecnologia | Descrição |
|----------|-----------|
| **PHP** | Lógica de servidor e autenticação |
| **MySQL (Vortexdb)** | Armazenamento relacional seguro |
| **HTML / CSS / JavaScript** | Interface e experiência do usuário |
| **XAMPP / Apache** | Servidor de desenvolvimento |
| **Figma** | Prototipação visual inicial |

---

##  Estrutura do Banco de Dados (Vortexdb)

| Tabela | Função |
|-------|--------|
| **aluno** | Armazena eleitores, com autenticação segura |
| **administrador** | Controla permissões de criação/gestão de votações |
| **votacao** | Dados gerais de cada eleição |
| **candidato** | Informações dos candidatos inscritos |
| **voto** | Registro de votos (com restrição de duplicidade) |
| **itens_votacao** | Relação entre voto e candidatos |

 **Integridade garantida** por:
- Chaves primárias e estrangeiras.
- Senhas criptografadas.
- Restrição `UNIQUE` impedindo voto duplicado.

---

##  Capturas de Tela

Página Index
<img width="1814" height="865" alt="image" src="https://github.com/user-attachments/assets/a55e5dec-30b9-4792-97ea-34b1e0bd9576" />

<br>

# Sessão Aluno:

<br>

Página Login (Aluno)
<img width="1860" height="854" alt="image" src="https://github.com/user-attachments/assets/a9f7a1a7-e043-4c2e-acda-bb72a4f6d86d" />

<br>

Página Home (Aluno)
<img width="1823" height="873" alt="image" src="https://github.com/user-attachments/assets/0ea5f935-681f-4816-bfa2-0c2ce4e86eaf" />

<br>

Página Votação Aberta (Aluno)
<img width="1785" height="805" alt="image" src="https://github.com/user-attachments/assets/3aba87d9-7726-4b06-b708-77145feb025e" />

<br>

Página Candidatura
<img width="1646" height="842" alt="image" src="https://github.com/user-attachments/assets/f060e170-8a25-4e3b-aef4-74a762696ae7" />

<br>


---

# Sessão ADM:

Página Login (ADM)
<img width="1860" height="862" alt="image" src="https://github.com/user-attachments/assets/265d9947-2a44-41ed-ab2f-62c5fc03cefd" />


<br>

Página Home (ADM)
<img width="1807" height="872" alt="image" src="https://github.com/user-attachments/assets/2a99d447-e801-405e-86cf-c802200a117e" />

<br>

Página

