DROP DATABASE IF EXISTS mtvawards;
CREATE DATABASE IF NOT EXISTS mtvawards DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE mtvawards;

-- ===================================
-- 1. Tabla roles
-- ===================================
CREATE TABLE roles (
    id_rol INT NOT NULL PRIMARY KEY,
    rol VARCHAR(30) NOT NULL
) ENGINE=InnoDB;

INSERT INTO roles (id_rol, rol) VALUES 
    (749, 'Administrador'),
    (249, 'Manager'),
    (379, 'Artista'),
    (599, 'Audiencia');

-- ===================================
-- 2. Tabla usuarios
-- ===================================
CREATE TABLE usuarios (
    estatus_usuario TINYINT(1) DEFAULT -1 COMMENT '2=Habilitado, -1=Deshabilitado',
    id_usuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(50) NOT NULL,
    ap_usuario VARCHAR(50) NOT NULL,
    am_usuario VARCHAR(50) NULL,
    sexo_usuario TINYINT(1) NOT NULL COMMENT '2=Masculino, 1=Femenino',
    email_usuario VARCHAR(70) NOT NULL,
    password_usuario VARCHAR(64) NOT NULL,
    imagen_usuario VARCHAR(100) DEFAULT NULL,
    id_rol INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO usuarios (nombre_usuario, ap_usuario, am_usuario, sexo_usuario, email_usuario, password_usuario, imagen_usuario, id_rol) VALUES
    ('Admin', 'Paterno', 'Materno', 2, 'admin@mtvawards.com', SHA2('adminmtv123',0), NULL, 749),
    ('Romeo', 'Santos', 'Infante', 1, 'romeo.santos@bachata.com', SHA2('adminmtv123',0), 'romeo_santos.jpg', 379),
    ('Shakira', 'Mebarak', 'Ripoll', 0, 'shakira@latina.com', SHA2('adminmtv123',0), 'shakira.jpg', 379),
    ('Abel', 'Tesfaye', 'Makkonen', 1, 'theweeknd@xo.com', SHA2('adminmtv123',0), 'the_weeknd.jpg', 379),
    ('Selena', 'Gomez', 'Marie', 0, 'selena.gomez@revival.com', SHA2('adminmtv123',0), 'selena_gomez.jpg', 379),

    ('Benito', 'Martínez', 'Ocasio', 1, 'badbunny@music.com', SHA2('adminmtv123',0), 'badbunny.jpg', 379),
    ('Jesús', 'Ortiz', 'Paz', 0, 'fuerzaregida@music.com', SHA2('adminmtv123',0), 'fuerzaregida.jpg', 379),
    ('Hassan', 'Kabande', 'Laija', 1, 'pesopluma@music.com', SHA2('adminmtv123',0), 'pesopluma.jpg', 379),
    ('Roberto', 'Laija', 'García', 1, 'titodoublep@music.com', SHA2('adminmtv123',0), 'titodoublep.jpg', 379),
    ('Dan', 'Reynolds', 'Smith', 1, 'imaginedragons@music.com', SHA2('adminmtv123',0), 'imaginedragons.jpg', 379);

-- ===================================
-- 3. Tabla generos
-- ===================================
CREATE TABLE generos (
    estatus_genero TINYINT(1) DEFAULT 2 COMMENT '2=Habilitado, -1=Deshabilitado',
    id_genero INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_genero VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

INSERT INTO generos (nombre_genero) VALUES
    ('Pop'),('Rock'),('Hip Hop'),('Rap'),('Reguetón'),('Salsa'),('Merengue'),('Bachata'),('Cumbia'),('Ranchera'),
    ('Mariachi'),('Norteño'),('Corridos'),('Trap'),('R&B'),('Jazz'),('Blues'),('Soul'),('Funk'),('Electrónica'),
    ('House'),('Techno'),('Reggae'),('Ska'),('K-pop'),('J-pop'),('Música clásica'),('Ópera'),('Metal'),('Punk'),
    ('Gospel'),('Flamenco'),('Bolero'),('Bossa Nova'),('Country'),('Disco'),('Grunge'),('Indie'),('Ambient'),('New Age');

-- ===================================
-- 4. Tabla artistas
-- ===================================
CREATE TABLE artistas (
    estatus_artista TINYINT(1) DEFAULT 2,
    id_artista INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pseudonimo_artista VARCHAR(50),
    nacionalidad_artista VARCHAR(50) NOT NULL,
    biografia_artista TEXT,
    id_usuario INT NOT NULL,
    id_genero INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO artistas (pseudonimo_artista, nacionalidad_artista, biografia_artista, id_usuario, id_genero) VALUES
    ('Romeo Santos', 'Estadounidense', 'Rey de la bachata', 2, 8),
    ('Shakira', 'Colombiana', 'Ícono del pop latino', 3, 1),
    ('The Weeknd', 'Canadiense', 'Estilo oscuro y melódico', 4, 15),
    ('Selena Gomez', 'Estadounidense', 'Actriz y cantante pop', 5, 1),
    ('Bad Bunny', 'Puertorriqueño', 'Ícono global del trap y reguetón', 1, 5),
    ('Fuerza Regida', 'México-Estados Unidos', 'Grupo líder en corridos tumbados y sierreño urbano', 2, 13),
    ('Peso Pluma', 'Mexicano', 'Fenómeno internacional del regional mexicano moderno', 3, 13),
    ('Tito Double P', 'Mexicano', 'Cantante emergente de corridos tumbados', 4, 13),
    ('Imagine Dragons', 'Estadounidense', 'Banda de pop rock alternativo con impacto global', 5, 2);

-- ===================================
-- 5. Tabla albumes
-- ===================================
CREATE TABLE albumes (
    estatus_album TINYINT(1) DEFAULT 2,
    id_album INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha_lanzamiento_album DATE NOT NULL,
    titulo_album VARCHAR(100) NOT NULL,
    descripcion_album TEXT,
    imagen_album VARCHAR(250) DEFAULT NULL,
    id_artista INT NOT NULL,
    id_genero INT NOT NULL,
    FOREIGN KEY (id_artista) REFERENCES artistas(id_artista) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO albumes (id_album, fecha_lanzamiento_album, titulo_album, descripcion_album, imagen_album, id_artista, id_genero) VALUES
    -- Romeo Santos
    (1, '2014-02-25', 'Fórmula Vol. 2', 'Segundo álbum con éxitos como “Propuesta Indecente”.', 'formula_vol2.jpg', 1, 8),
    (2, '2019-04-05', 'Utopía', 'Colaboraciones clásicas de bachata.', 'utopia.jpg', 1, 8),
    (3, '2022-09-01', 'Fórmula Vol. 3', 'Regreso triunfal de la bachata moderna.', 'formula_vol3.jpg', 1, 8),
    
    -- Shakira
    (4, '2001-08-27', 'Laundry Service', 'Primer álbum en inglés con “Whenever, Wherever”.', 'laundry_service.jpg', 2, 1),
    (5, '2005-06-03', 'Fijación Oral Vol. 1', 'Álbum en español con “La Tortura”.', 'fijacion_oral_vol1.jpg', 2, 1),
    (6, '2009-10-19', 'She Wolf', 'Exploración electrónica y dance.', 'she_wolf.jpg', 2, 1),
    
    -- The weeknd
    (7, '2013-09-10', 'Kiss Land', 'Debut oficial con atmósfera oscura.', 'kiss_land.jpg', 3, 15),
    (8, '2015-08-28', 'Beauty Behind the Madness', 'Éxitos globales como “The Hills”.', 'beauty_madness.jpg', 3, 15),
    (9, '2020-03-20', 'After Hours', 'Estética retro con “Blinding Lights”.', 'after_hours.jpg', 3, 15),
    
    -- Selena Gomez
    (10, '2009-09-29', 'Kiss & Tell', 'Debut con The Scene.', 'kiss_tell.jpg', 4, 1),
    (11, '2013-07-19', 'Stars Dance', 'Primer álbum solista.', 'stars_dance.jpg', 4, 1),
    (12, '2015-10-09', 'Revival', 'Transformación artística madura.', 'revival.jpg', 4, 1),

    -- Bad Bunny
    (13, '2022-05-06', 'Un Verano Sin Ti', 'Fusión de reguetón, pop y sonidos caribeños', 'verano.jpg', 5, 5),
    (14,'2020-02-29', 'YHLQMDLG', 'Reguetón clásico con colaboraciones icónicas', 'yhlqmdlg.jpg', 5, 5),
    (15, '2023-10-13', 'Nadie Sabe Lo Que Va a Pasar Mañana', 'Explora temas personales y sociales con sonidos urbanos', 'nadiesabe.jpg', 5, 5),

    -- Fuerza Regida
    (16, '2023-07-14', "Pa Las Baby’s y Belikeada", 'Corridos tumbados con estilo urbano', 'baby_belikeada.jpg', 6, 13),
    (17, '2022-11-18', 'Del Barrio Hasta Aquí Vol. 2', 'Narrativas callejeras y colaboraciones', 'barrio_vol2.jpg', 6, 13),
    (18, '2021-06-25', 'Otro Pedo, Otro Nivel', 'Fusión de banda y trap', 'otro_nivel.jpg', 6, 13),

    -- Peso Pluma
    (19, '2023-06-22', 'Génesis', 'Álbum que lo consolidó como fenómeno global', 'genesis.jpg', 7, 13),
    (20, '2022-08-15', 'Efectos Secundarios', 'Corridos con tintes melódicos y urbanos', 'efectos_secundarios.jpg', 7, 13),
    (21, '2021-01-10', 'Ah y Qué?', 'Primeros éxitos del artista', 'ahyque.jpg', 7, 13),

    -- Tito Double P
    (22, '2024-08-01', 'Los Cuadros', 'Debut con estilo callejero y letras crudas', 'los_cuadros.jpg', 8, 13),
    (23, '2023-03-15', 'Puro Pa La Raza', 'Corridos tumbados con flow urbano', 'puro_raza.jpg', 8, 13),
    (24, '2022-10-10', 'La Vida Es Una', 'Reflexiones y colaboraciones con Peso Pluma', 'vida_una.jpg', 8, 13),

    -- Imagine Dragons
    (25, '2012-09-04', 'Night Visions', 'Debut con éxitos como “Radioactive”', 'night_visions.jpg', 9, 2),
    (26, '2017-06-23', 'Evolve', 'Sonidos electrónicos y rock alternativo', 'evolve.jpg', 9, 2),
    (27, '2021-09-03', 'Mercury – Act 1', 'Exploración emocional y sonora', 'mercury_act1.jpg', 9, 2);

-- ===================================
-- 6. Tabla canciones
-- ===================================
CREATE TABLE canciones (
    estatus_cancion TINYINT(1) DEFAULT 2,
    id_cancion INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha_lanzamiento_cancion DATE NOT NULL,
    nombre_cancion VARCHAR(100) NOT NULL,
    duracion_cancion TIME NOT NULL,
    url_cancion VARCHAR(200),
    url_video_cancion VARCHAR(200),
    id_album INT NOT NULL,
    id_genero INT NOT NULL,
    FOREIGN KEY (id_album) REFERENCES albumes(id_album) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO canciones (fecha_lanzamiento_cancion, nombre_cancion, duracion_cancion, url_cancion, url_video_cancion, id_album, id_genero) VALUES
    ('2013-07-29', 'Propuesta Indecente', '00:03:55', 'https://open.spotify.com/track/3vVffZGH4D7Kk9SddegKrw', 'https://www.youtube.com/watch?v=QFs3PIZb3js', 1, 8),
    ('2014-01-27', 'Odio', '00:03:45', 'https://open.spotify.com/track/2oO5j0cQ2iY2u1Nikosv0W', 'https://www.youtube.com/watch?v=0', 1, 8),
    ('2014-06-25', 'Eres Mía', '00:04:10', 'https://open.spotify.com/track/4KX6R9q3t4c9cY1n0wK9mA', 'https://www.youtube.com/watch?v=0', 1, 8),
    
    ('2001-08-27', 'Suerte (Whenever, Wherever)', '00:03:15', 'https://open.spotify.com/track/0Wwskl9zR8i6Zi6cU9s0Z6', 'https://www.youtube.com/watch?v=weRHyjj34ZE', 4, 1),
    
    ('2015-05-27', 'The Hills', '00:04:02', 'https://open.spotify.com/track/2Yi7vD1O5cJ8w0w', 'https://www.youtube.com/watch?v=yzTuBuRdAyA', 8, 15),
    ('2015-06-08', "Can’t Feel My Face", '00:03:35', 'https://open.spotify.com/track/5aAx2yR3tk7K0', 'https://www.youtube.com/watch?v=KEI4qSrkPAs', 8, 15),
    
    ('2015-06-22', 'Good for You', '00:03:41', 'https://open.spotify.com/track/0lO7Q7i2w1q0', 'https://www.youtube.com/watch?v=DXKHCgNFk1I', 12, 1),
    ('2015-09-09', 'Same Old Love', '00:03:49', 'https://open.spotify.com/track/3s5f6y8i2w3r4t5y', 'https://www.youtube.com/watch?v=9h30Bx4Klxg', 12, 1), 

    ('2022-05-06', 'Moscow Mule', '00:04:05', 'https://open.spotify.com/track/moscowmule', 'https://youtube.com/watch?v=moscowmule', 13, 5),
    ('2022-05-06', 'Me Porto Bonito', '00:02:58', 'https://open.spotify.com/track/meportobonito', 'https://youtube.com/watch?v=meportobonito', 13, 5),
    ('2022-05-06', 'Tití Me Preguntó', '00:04:02', 'https://open.spotify.com/track/titi', 'https://youtube.com/watch?v=titi', 13, 5),

    ('2020-02-29', 'Yo Perreo Sola', '00:02:52', 'https://open.spotify.com/track/yoperreosola', 'https://youtube.com/watch?v=yoperreosola', 14, 5),
    ('2020-02-29', 'Safaera', '00:04:55', 'https://open.spotify.com/track/safaera', 'https://youtube.com/watch?v=safaera', 14, 5),
    ('2020-02-29', 'La Difícil', '00:03:50', 'https://open.spotify.com/track/ladificil', 'https://youtube.com/watch?v=ladificil', 14, 5),

    ('2023-10-13', 'MONACO', '00:03:30', 'https://open.spotify.com/track/monaco', 'https://youtube.com/watch?v=monaco', 15, 5),
    ('2023-10-13', 'No Me Quiero Casar', '00:03:45', 'https://open.spotify.com/track/nomequierocasar', 'https://youtube.com/watch?v=nomequierocasar', 15, 5),
    ('2023-10-13', 'Thunder y Lightning', '00:03:40', 'https://open.spotify.com/track/thunderlightning', 'https://youtube.com/watch?v=thunderlightning', 15, 5),

    ('2023-07-14', 'TQM', '00:03:20', 'https://open.spotify.com/track/tqm', 'https://youtube.com/watch?v=tqm', 16, 13),
    ('2023-07-14', 'Sabor Fresa', '00:03:10', 'https://open.spotify.com/track/saborfresa', 'https://youtube.com/watch?v=saborfresa', 16, 13),
    ('2023-07-14', 'Sobras y Mujeres', '00:03:35', 'https://open.spotify.com/track/sobras', 'https://youtube.com/watch?v=sobras', 16, 13),

    ('2022-11-18', 'Me Acostumbré a Lo Bueno', '00:03:45', 'https://open.spotify.com/track/acostumbre', 'https://youtube.com/watch?v=acostumbre', 17, 13),
    ('2022-11-18', 'Descansando', '00:03:30', 'https://open.spotify.com/track/descansando', 'https://youtube.com/watch?v=descansando', 17, 13),
    ('2022-11-18', 'Qué Está Pasando', '00:03:50', 'https://open.spotify.com/track/queestapasando', 'https://youtube.com/watch?v=queestapasando', 17, 13),

    ('2023-06-22', 'Lady Gaga', '00:03:25', 'https://open.spotify.com/track/ladygaga', 'https://youtube.com/watch?v=ladygaga', 19, 13),
    ('2023-06-22', 'PRC', '00:03:15', 'https://open.spotify.com/track/prc', 'https://youtube.com/watch?v=prc', 19, 13),
    ('2023-06-22', 'Bye', '00:03:10', 'https://open.spotify.com/track/bye', 'https://youtube.com/watch?v=bye', 19, 13),

    ('2024-08-01', 'Los Cuadros', '00:03:40', 'https://open.spotify.com/track/loscuadros', 'https://youtube.com/watch?v=loscuadros', 22, 13),
    ('2024-08-01', 'El Lokerón', '00:03:50', 'https://open.spotify.com/track/ellokeron', 'https://youtube.com/watch?v=ellokeron', 22, 13),
    ('2024-08-01', 'Blanca, Rosita y María', '00:03:30', 'https://open.spotify.com/track/blanca', 'https://youtube.com/watch?v=blanca', 22, 13),

    ('2012-09-04', 'Radioactive', '00:03:06', 'https://open.spotify.com/track/radioactive', 'https://youtube.com/watch?v=radioactive', 25, 2),
    ('2012-09-04', 'Demons', '00:02:57', 'https://open.spotify.com/track/demons', 'https://youtube.com/watch?v=demons', 25, 2),
    ('2012-09-04', 'On Top of the World', '00:03:12', 'https://open.spotify.com/track/ontop', 'https://youtube.com/watch?v=ontop', 25, 2);

-- ===================================
-- 7. Categorías de nominaciones
-- ===================================
CREATE TABLE categorias_nominaciones (
    estatus_categoria_nominacion TINYINT(1) DEFAULT 2,
    id_categoria_nominacion INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha_categoria_nominacion DATE NOT NULL DEFAULT '2025-12-08',
    nombre_categoria_nominacion VARCHAR(100) NOT NULL,
    descripcion_categoria_nominacion TEXT NOT NULL,
    contador_nominacion INT DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO categorias_nominaciones (nombre_categoria_nominacion, descripcion_categoria_nominacion) VALUES
    ('Álbum del Año', 'Reconocimiento al mejor álbum musical del año por su excelencia artística y técnica.'),
    ('Canción del Año', 'Premio a la mejor composición musical lanzada durante el año.'),
    ('Artista Revelación', 'Otorgado al artista emergente con mayor impacto y proyección internacional.'),
    ('Mejor Colaboración', 'Reconoce la mejor canción realizada en conjunto entre dos o más artistas.'),
    ('Video Musical del Año', 'Premio al video musical más destacado por su creatividad y producción.');

-- ===================================
-- 8. Nominaciones
-- ===================================
CREATE TABLE nominaciones (
    id_nominacion INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha_nominacion DATE NOT NULL DEFAULT '2025-12-08',
    id_categoria_nominacion INT NOT NULL,
    id_album INT NOT NULL,
    id_artista INT NOT NULL,
    FOREIGN KEY (id_categoria_nominacion) REFERENCES categorias_nominaciones(id_categoria_nominacion) ON DELETE CASCADE,
    FOREIGN KEY (id_album) REFERENCES albumes(id_album) ON DELETE CASCADE,
    FOREIGN KEY (id_artista) REFERENCES artistas(id_artista) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO nominaciones (id_categoria_nominacion, id_album, id_artista) VALUES
    (1, 1, 1), (1, 4, 2), (1, 8, 3), (1, 3, 1),
    (2, 5, 2), (2, 11, 4),
    (3, 12, 4),
    (4, 2, 1),
    (5, 9, 3), (5, 6, 2);

-- ===================================
-- 9. Usuarios audiencia
-- ===================================
INSERT INTO usuarios (estatus_usuario, nombre_usuario, ap_usuario, am_usuario, sexo_usuario, email_usuario, password_usuario, imagen_usuario, id_rol) VALUES
    (2, 'Luis', 'Ramírez', 'González', 1, 'luis.ramirez@mtvawards.com', SHA2('audienciamtv123',0), 'luis.jpg', 599),
    (2, 'María', 'Fernández', 'López', 0, 'maria.fernandez@mtvawards.com', SHA2('audienciamtv123',0), 'maria.jpg', 599),
    (2, 'Carlos', 'Hernández', 'Torres', 1, 'carlos.hernandez@mtvawards.com', SHA2('audienciamtv123',0), 'carlos.jpg', 599),
    (2, 'Ana', 'Martínez', 'Sánchez', 0, 'ana.martinez@mtvawards.com', SHA2('audienciamtv123',0), 'ana.jpg', 599),
    (2, 'Jorge', 'Gómez', 'Ruiz', 1, 'jorge.gomez@mtvawards.com', SHA2('audienciamtv123',0), 'jorge.jpg', 599);

-- ===================================
-- 10. Tabla votaciones 
-- ===================================
CREATE TABLE votaciones (
    id_votacion INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha_votacion DATE NOT NULL DEFAULT '2025-12-10',
    id_nominacion INT NOT NULL,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_nominacion) REFERENCES nominaciones(id_nominacion) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO votaciones (id_nominacion, id_usuario) VALUES
    (1,6),(2,6),(3,6),(4,6),(5,6),(6,6),(7,6),(8,6),(9,6),(10,6),
    (1,7),(2,7),(3,7),(4,7),(5,7),(6,7),(7,7),(8,7),(9,7),(10,7),
    (1,8),(2,8),(3,8),(4,8),(5,8),(6,8),(7,8),(8,8),(9,8),(10,8),
    (1,9),(2,9),(3,9),(4,9),(5,9),(6,9),(7,9),(8,9),(9,9),(10,9),
    (1,10),(2,10),(3,10),(4,10),(5,10),(6,10),(7,10),(8,10),(9,10),(10,10);