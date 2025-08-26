CREATE DATABASE db_biblioteca;

USE db_biblioteca;

CREATE TABLE autores (
	id_autor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nacionalidade VARCHAR(45) NOT NULL,
    ano_nascimento INT NOT NULL
);

CREATE TABLE livros (
	id_livro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    genero VARCHAR(45) NOT NULL,
    ano_publicacao INT NOT NULL,
    id_autor INT,
    FOREIGN KEY (id_autor) REFERENCES autores(id_autor)
);

CREATE TABLE leitores (
	id_leitor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(13) NOT NULL
);

CREATE TABLE emprestimos (
	id_emprestimo INT AUTO_INCREMENT PRIMARY KEY,
    data_emprestimo DATE NOT NULL,
    data_devolucao DATE NULL,
	id_livro INT,
    id_leitor INT,
    FOREIGN KEY (id_livro) REFERENCES livros(id_livro),
    FOREIGN KEY (id_leitor) REFERENCES leitores(id_leitor)
);

INSERT INTO autores (nome, nacionalidade, ano_nascimento) VALUES
('Machado de Assis', 'Brasileira', 1839),
('Clarice Lispector', 'Brasileira', 1920),
('Jorge Amado', 'Brasileira', 1912),
('Gabriel García Márquez', 'Colombiana', 1927),
('George Orwell', 'Britânica', 1903),
('Jane Austen', 'Britânica', 1775),
('Fiódor Dostoiévski', 'Russa', 1821),
('Haruki Murakami', 'Japonesa', 1949),
('Chinua Achebe', 'Nigeriana', 1930),
('Isabel Allende', 'Chilena', 1942),
('J.K. Rowling', 'Britânica', 1965),
('Stephen King', 'Americana', 1947),
('Paulo Coelho', 'Brasileira', 1947),
('Agatha Christie', 'Britânica', 1890),
('Cecília Meireles', 'Brasileira', 1901);

INSERT INTO livros (titulo, genero, ano_publicacao, id_autor) VALUES
('Dom Casmurro', 'Romance', 1899, 1),
('A Hora da Estrela', 'Ficção', 1977, 2),
('Gabriela, Cravo e Canela', 'Romance', 1958, 3),
('Cem Anos de Solidão', 'Realismo Mágico', 1967, 4),
('1984', 'Distopia', 1949, 5),
('Orgulho e Preconceito', 'Romance', 1813, 6),
('Crime e Castigo', 'Ficção', 1866, 7),
('Kafka à Beira-Mar', 'Ficção', 2002, 8),
('O Mundo se Despedaça', 'Ficção', 1958, 9),
('A Casa dos Espíritos', 'Realismo Mágico', 1982, 10),
('Harry Potter e a Pedra Filosofal', 'Fantasia', 1997, 11),
('O Iluminado', 'Terror', 1977, 12),
('O Alquimista', 'Ficção', 1988, 13),
('Assassinato no Expresso do Oriente', 'Mistério', 1934, 14),
('Viagem', 'Poesia', 1939, 15);

INSERT INTO leitores (nome, email, telefone) VALUES
('Ana Silva', 'ana.silva@email.com', '11999990001'),
('Bruno Souza', 'bruno.souza@email.com', '21988880002'),
('Carlos Pereira', 'carlos.pereira@email.com', '31977770003'),
('Daniela Costa', 'daniela.costa@email.com', '41966660004'),
('Eduardo Martins', 'eduardo.martins@email.com', '51955550005'),
('Fernanda Lima', 'fernanda.lima@email.com', '61944440006'),
('Gabriel Rocha', 'gabriel.rocha@email.com', '71933330007'),
('Helena Alves', 'helena.alves@email.com', '81922220008'),
('Igor Fernandes', 'igor.fernandes@email.com', '91911110009'),
('Juliana Dias', 'juliana.dias@email.com', '11900000010'),
('Kleber Gomes', 'kleber.gomes@email.com', '21999990011'),
('Larissa Silva', 'larissa.silva@email.com', '31988880012'),
('Marcos Pinto', 'marcos.pinto@email.com', '41977770013'),
('Natália Castro', 'natalia.castro@email.com', '51966660014'),
('Otávio Nunes', 'otavio.nunes@email.com', '61955550015');

INSERT INTO emprestimos (data_emprestimo, data_devolucao, id_livro, id_leitor) VALUES
('2025-08-01', '2025-08-15', 1, 1),
('2025-08-02', '2025-08-16', 2, 2),
('2025-08-03', '2025-08-17', 3, 3),
('2025-08-04', NULL, 4, 4),
('2025-08-05', '2025-08-19', 5, 5),
('2025-08-06', NULL, 6, 6),
('2025-08-07', '2025-08-21', 7, 7),
('2025-08-08', '2025-08-22', 8, 8),
('2025-08-09', NULL, 9, 9),
('2025-08-10', '2025-08-24', 10, 10),
('2025-08-11', '2025-08-25', 11, 11),
('2025-08-12', NULL, 12, 12),
('2025-08-13', '2025-08-27', 13, 13),
('2025-08-14', NULL, 14, 14),
('2025-08-15', '2025-08-29', 15, 15);
