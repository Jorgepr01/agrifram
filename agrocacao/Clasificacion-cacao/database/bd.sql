CREATE DATABASE agrocacao COLLATE = utf8_unicode_ci;


CREATE TABLE
    tipo_usuario(
        id_tipo_us INT(255) AUTO_INCREMENT NOT NULL,
        nombre_tipo_us VARCHAR(100) NOT NULL,
        CONSTRAINT pk_tipo_usuario PRIMARY KEY(id_tipo_us)
    ) ENGINE = InnoDB;

INSERT INTO
    tipo_usuario (id_tipo_us, nombre_tipo_us)
VALUES  (1, 'Administrador'), (2, 'cliente');



CREATE TABLE
    estado_usuario(
        id_estado_us INT AUTO_INCREMENT NOT NULL,
        nombre_estado_us VARCHAR(70) NOT NULL,
        CONSTRAINT pk_id_estado_us PRIMARY KEY(id_estado_us)
    ) ENGINE = InnoDb;

INSERT INTO
    estado_usuario(nombre_estado_us)
VALUES ("Habilitado"), ("Deshabilitado");


CREATE TABLE
    usuario(
        id_us INT(255) AUTO_INCREMENT NOT NULL,
        nombre_us VARCHAR(50) NOT NULL,
        apellido_us VARCHAR(50) NOT NULL,
        edad_us DATE NOT NULL,
        ci_us VARCHAR(10) NOT NULL,
        telefono VARCHAR(12),
        email_us VARCHAR(100) NOT NULL,
        contrasena_us VARCHAR(100) NOT NULL,
        tipo_us_id INT(255) NOT NULL,
        estado_us_id INT(255) NOT NULL,
        avatar VARCHAR(255),
        creado_en DATETIME,
        actualizado_en DATETIME,
        codigo_recupe VARCHAR(255),
        fecha_recupe DATETIME,
        CONSTRAINT pk_usuario PRIMARY KEY(id_us),
        CONSTRAINT uq_email_us UNIQUE(email_us),
        CONSTRAINT fk_usuario_tipo_usuario FOREIGN KEY(tipo_us_id) REFERENCES tipo_usuario(id_tipo_us),
        CONSTRAINT fk_usuario_estado_usuario FOREIGN KEY(estado_us_id) REFERENCES estado_usuario(id_estado_us)
    ) ENGINE = InnoDb;

INSERT INTO usuario (id_us, nombre_us, apellido_us, edad_us, ci_us, telefono, email_us, contrasena_us, tipo_us_id, estado_us_id, avatar, creado_en, actualizado_en) VALUES
(1, 'Manuel Armando', 'Santamaria Chico', '1997-09-20', '99999', '952681419', '1', '$2y$04$iKl.OQVFX3Kef.ZLkRvDYeNgdg7cKh7hhjeSRKWNahR37QnYq09U2', 1, 1, 'imgavatar.png', '2024-03-31 00:32:36', NULL);

	
    CREATE TABLE
    estado_lote(
        id_estado_lote INT AUTO_INCREMENT NOT NULL,
        nombre VARCHAR(70) NOT NULL,
        CONSTRAINT pk_id_estado_lote PRIMARY KEY(id_estado_lote)
    ) ENGINE = InnoDb;

	INSERT INTO
    	estado_lote(nombre)
	VALUES ("Habilitado"), ("Deshabilitado");
    
    CREATE TABLE lote(
    	id_lote INT AUTO_INCREMENT NOT NULL,
        nombre VARCHAR(255) NOT NULL,
        descripcion VARCHAR(255) NOT NULL,
        latitud decimal(10,8),
        longitud decimal(11,8),
        estado_lote_id INT NOT NULL,
        PRIMARY KEY (id_lote),
        CONSTRAINT fk_lote_estado_lote FOREIGN KEY (estado_lote_id) REFERENCES estado_lote (id_estado_lote)
    )ENGINE = InnoDb;
    
    
   
     CREATE TABLE
 			estado_cacao(
            	id_estado_cacao INT AUTO_INCREMENT NOT NULL,
            	nombre VARCHAR(255) NOT NULL,
                aplicar VARCHAR(255) NOT NULL,
                dosis  VARCHAR(255) NOT NULL,
                tiempo VARCHAR(255) NOT NULL,
                aplicacion VARCHAR(255) NOT NULL,
                medida_manejo TEXT NULL, 
            	CONSTRAINT id_estado_cacao PRIMARY KEY(id_estado_cacao)
            )ENGINE = InnoDb;
            
     INSERT INTO estado_cacao (nombre) values("SANO"),("FITO 1"), ("FITO 2"), ("ELIMINADO");
    
    CREATE TABLE escaneo_cacao (
    	id_escaneo int NOT NULL AUTO_INCREMENT,
        escaneo varchar(255) NOT NULL,
        estado_cacao_id INT NOT NULL,
        porcentaje_escaneo int NOT NULL,
        fecha_escaneo datetime NOT NULL,
        imgen_escaneo varchar(255) NOT NULL,
        lote_id INT NOT NULL,
        us_id int NOT NULL,
  		PRIMARY KEY (`id_escaneo`),
  		CONSTRAINT fk_escaneo_usuario FOREIGN KEY (us_id) REFERENCES usuario (id_us),
        CONSTRAINT fk_escaneo_lote FOREIGN KEY (lote_id) REFERENCES lote (id_lote),
        CONSTRAINT fk_escaneo_cacao_estado_cacao FOREIGN KEY(estado_cacao_id) REFERENCES estado_cacao(id_estado_cacao)
	) ENGINE=InnoDB;
    
    
    
    
   
   
   	CREATE TABLE trazabilidad (
    id_trazabilidad INT NOT NULL AUTO_INCREMENT,
    escaneo_id INT NOT NULL,
    trazabilidad TEXT,
    estado_cacao_id INT NOT NULL,
    porcentaje_trazabilidad INT NOT NULL,
    fecha_trazabilidad DATETIME NOT NULL,
    imagen_trazabilidad VARCHAR(255) NOT NULL,
    observacion TEXT,
    PRIMARY KEY (id_trazabilidad),
    CONSTRAINT fk_escaneo_trazabilidad FOREIGN KEY (escaneo_id) REFERENCES escaneo_cacao (id_escaneo),
    CONSTRAINT fk_estado_cacao_trazabilidad FOREIGN KEY (estado_cacao_id) REFERENCES estado_cacao (id_estado_cacao)
) ENGINE=InnoDB;


    
    
    

            
            
            
            
            
            
            