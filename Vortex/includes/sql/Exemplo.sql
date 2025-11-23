-- Inserindo alguns alunos de exemplo

-- valores Aluno
INSERT INTO Vortexdb.aluno (nome, matricula, email_institucional, senha)
VALUES
('Victor Hernandez Soares De Almeida', '2781392513029', 'victor.almeida28@fatec.sp.gov.br', '$2y$10$9OQvDx8Rk3XcfwzCjq4l0.Ng8RcQHj0ufF3GJp5YKv9pZxLJkS7cy'),
('Matheus Reinhart Camargo Martins Catarino', '2781392513027', 'matheus.catarino@fatec.sp.gov.br', '$2y$10$9OQvDx8Rk3XcfwzCjq4l0.Ng8RcQHj0ufF3GJp5YKv9pZxLJkS7cy'),
('Feliphe Eduardo Silvério Gonçalves de Oliveira', '2781392513020', 'feliphe.oliveira@fatec.sp.gov.br', '$2y$10$9OQvDx8Rk3XcfwzCjq4l0.Ng8RcQHj0ufF3GJp5YKv9pZxLJkS7cy'),
('Marcos Vinícius Rocha', '2781392513032', 'marcos.rocha@fatec.sp.gov.br', '$2y$10$9OQvDx8Rk3XcfwzCjq4l0.Ng8RcQHj0ufF3GJp5YKv9pZxLJkS7cy');


-- Valores adm
INSERT INTO Vortexdb.adm (nome, matricula_docente, email, senha)
VALUES
('Victor Hernandez Soares De Almeida', '2781392513029', 'victor.almeida28@fatec.sp.gov.br', '$2y$10$9OQvDx8Rk3XcfwzCjq4l0.Ng8RcQHj0ufF3GJp5YKv9pZxLJkS7cy'),
('Matheus Reinhart Camargo Martins Catarino', '2781392513027', 'matheus.catarino@fatec.sp.gov.br', '$2y$10$9OQvDx8Rk3XcfwzCjq4l0.Ng8RcQHj0ufF3GJp5YKv9pZxLJkS7cy'),
('Feliphe Eduardo Silvério Gonçalves de Oliveira', '2781392513020', 'feliphe.oliveira@fatec.sp.gov.br', '$2y$10$9OQvDx8Rk3XcfwzCjq4l0.Ng8RcQHj0ufF3GJp5YKv9pZxLJkS7cy'),
('Marcos Vinícius Rocha', '2781392513032', 'marcos.rocha@fatec.sp.gov.br', '$2y$10$9OQvDx8Rk3XcfwzCjq4l0.Ng8RcQHj0ufF3GJp5YKv9pZxLJkS7cy');

-- Valores votacao
INSERT INTO votacao 
(data_inicio, data_fim, data_inscricao, semestre, curso, descricao, status, id_adm)
VALUES
('2025-12-12 08:00:00', '2025-12-20 18:00:00', '2025-12-11 12:00:00', '2', 'DSM', 'Votação para escolha de representante de turma', 'ativo', 2),
('2025-11-10 08:00:00', '2025-12-20 18:00:00', '2025-11-9 12:00:00', '1', 'DSM', 'Votação para escolha de representante de turma', 'ativo', 1);


--  candidatos de exemplo
INSERT INTO candidato (id_aluno, descricao, email, foto)
VALUES
(1, 'Aluno ativo na turma, candidato a representante', 'victor.almeida28@fatec.sp.gov.br', 'img/uploads/fotos/candidato2.png'),
(2, 'Aluno engajado, deseja representar a turma', 'matheus.catarino@fatec.sp.gov.br', 'img/uploads/fotos/candidato1.png'),
(3, 'Aluno participativo, candidato a representante', 'feliphe.oliveira@fatec.sp.gov.br', 'img/uploads/fotos/candidato6.png'),
(4, 'Aluno exemplar, candidato a representante', 'marcos.rocha@fatec.sp.gov.br', 'img/uploads/fotos/candidato3.png');


-- candidatos nas votações 
INSERT INTO itens_votacao (id_votacao, id_cand)
VALUES
(1, 1), -- Votação 1 (DSM 2º semestre) -> Victor
(1, 2), -- Votação 1 (DSM 2º semestre) -> Matheus
(1, 3), -- Votação 1 (DSM 2º semestre) -> Feliphe
(1, 4); -- Votação 1 (DSM 2º semestre) -> Marcos


