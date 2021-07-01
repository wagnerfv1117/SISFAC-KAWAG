/*Esta es una tabla adicional, para que se puedan meter dentro de la misma base de datos, los documentos de Gestión Documental ene el rol de administrador.*/
/* toca agragar una columna con el tipo de dato datetime, para guardar la fecha de carga*/

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;