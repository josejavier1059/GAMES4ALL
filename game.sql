CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    alias VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL UNIQUE,
    rol VARCHAR(255) NOT NULL
);

INSERT INTO usuario (alias, password, correo, rol) VALUES 
('adminUser', 'password123', 'admin@correo.com', 'Administrador'),
('normalUser', 'password456', 'usuario@correo.com', 'Usuario');
