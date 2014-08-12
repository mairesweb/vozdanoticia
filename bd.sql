CREATE TABLE `usuarios` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(50),
    `usuario` VARCHAR(50),
    `senha` VARCHAR(50),
    `tipo` INT(1) COMMENT '0-Usuario, 1-Adm',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `categorias` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(50),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `noticias` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `titulo` VARCHAR(150) NOT NULL,
    `conteudo` TEXT NOT NULL,
    `fonte` VARCHAR(100),
    `palavrasChave` VARCHAR(100),
    `arquivoTitulo` VARCHAR(150) NOT NULL,
    `arquivoConteudo` VARCHAR(150) NOT NULL,
	`categoria` INT(11),
	FOREIGN KEY (`categoria`) REFERENCES `categorias`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;