CREATE DATABASE Vortexdb;

use Vortexdb;

CREATE TABLE aluno (
    id_aluno INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    matricula VARCHAR(20) NOT NULL UNIQUE,
    email_institucional VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE adm (
    id_adm INT AUTO_INCREMENT PRIMARY KEY,
    matricula_docente VARCHAR(20) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE votacao (
    id_votacao INT AUTO_INCREMENT PRIMARY KEY,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NOT NULL,
    data_inscricao DATETIME NOT NULL,
    semestre VARCHAR(10) NOT NULL,
    curso VARCHAR(100) NOT NULL,
    descricao VARCHAR(255),
    status VARCHAR(20) NOT NULL DEFAULT 'ativo',
    id_adm INT NOT NULL,
    FOREIGN KEY (id_adm) REFERENCES adm(id_adm)  
);


CREATE TABLE candidato (
    id_cand INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    descricao TEXT,
    email VARCHAR(100),
    foto VARCHAR(255),
    status VARCHAR(20) NOT NULL DEFAULT 'ativo',
    FOREIGN KEY (id_aluno) REFERENCES aluno(id_aluno)
);



CREATE TABLE itens_votacao (
    id_votacao INT NOT NULL,
    id_cand INT NOT NULL,
    PRIMARY KEY (id_votacao, id_cand),
    FOREIGN KEY (id_votacao) REFERENCES votacao(id_votacao)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_cand) REFERENCES candidato(id_cand)
);


CREATE TABLE voto (
    id_voto INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    id_votacao INT NOT NULL,
    id_cand INT NOT NULL,
    data_voto DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_aluno) REFERENCES aluno(id_aluno),
    FOREIGN KEY (id_votacao) REFERENCES votacao(id_votacao),
    FOREIGN KEY (id_cand) REFERENCES candidato(id_cand),
    UNIQUE (id_aluno, id_votacao)
);
