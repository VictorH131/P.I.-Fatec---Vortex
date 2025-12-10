
                                                                                                        
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

Página Votar (Aluno)
<img width="1857" height="801" alt="image" src="https://github.com/user-attachments/assets/3ffb9827-99f2-4851-85cf-03d4ba9fb0b0" />


<br>

Página Votar Concluido (Aluno)
<img width="1870" height="809" alt="image" src="https://github.com/user-attachments/assets/7d26e815-9669-4f6b-9d22-c93a49e7f1d5" />

<br>

Página Concluido (Aluno)
<img width="1858" height="859" alt="image" src="https://github.com/user-attachments/assets/f940a528-f788-4070-a044-7e1dd70c5573" />

<br>

---

# Sessão ADM:

Página Login (ADM)
<img width="1860" height="862" alt="image" src="https://github.com/user-attachments/assets/265d9947-2a44-41ed-ab2f-62c5fc03cefd" />


<br>

Página Home (ADM)
<img width="1807" height="872" alt="image" src="https://github.com/user-attachments/assets/2a99d447-e801-405e-86cf-c802200a117e" />

<br>

Página Gerenciar votações (ADM)
<img width="1752" height="898" alt="image" src="https://github.com/user-attachments/assets/af68a115-52a1-4c86-b1b9-ada639d5d8b8" />

<br>

Página Pesquisar (ADM)
<img width="1554" height="483" alt="image" src="https://github.com/user-attachments/assets/204a2e71-4417-4198-a159-ff604016a14e" />

<br>

Página Criar Votações(ADM)
<img width="1803" height="870" alt="image" src="https://github.com/user-attachments/assets/8a881f73-4673-4412-b497-dfff7e9c4083" />

<br>

Pagína Incrição iniciada (ADM)
<img width="1831" height="888" alt="image" src="https://github.com/user-attachments/assets/9c933e14-431a-46ed-934e-2f36efda9ed8" />


<br>

Página Editar Candidatos (ADM)
<img width="1882" height="896" alt="image" src="https://github.com/user-attachments/assets/3017016b-a69a-4827-9c54-3e1e53666c2e" />

<br>

Pagína Votação iniciada (ADM)
<img width="1764" height="883" alt="image" src="https://github.com/user-attachments/assets/8c3352d6-6fdf-4a25-bbd1-c6ec4f980c4b" />

<br>

Pagína Votação Encerrada (ADM)
<img width="1442" height="863" alt="image" src="https://github.com/user-attachments/assets/c2958742-32e6-4e5a-ae4f-5e6751ea1ee6" />

<br>

Pagína Ver Resultados da votação (ADM)
<img width="1810" height="809" alt="image" src="https://github.com/user-attachments/assets/55b97633-9eec-40d4-a2bc-61b15b19461d" />
<img width="1530" height="713" alt="image" src="https://github.com/user-attachments/assets/c235686e-5af8-4217-8956-7d97eb919c0e" />

<br>

Pagína Ata da Votação(ADM)
<img width="855" height="540" alt="image" src="https://github.com/user-attachments/assets/cf1ab44a-194e-48f0-971b-12de5897afa7" />
<img width="857" height="634" alt="image" src="https://github.com/user-attachments/assets/0b0adc06-c8e8-4fcb-bd71-05365d543f33" />



