/*********************************************************/
/*         INSERTS PARA TABLAS MASTERS + ADMIN           */
/*********************************************************/

USE `abp35_padelweb`;

-- admin

INSERT INTO usuario(LOGIN,NOMBRE,PASSWORD,FECHA_NAC,TELEFONO,EMAIL,GENERO,PERMISO) VALUES ('admin','admin','admin','1995-01-29','666666666','admin@support.com','femenino',2);

-- horas

INSERT INTO horas(ID,HORA) VALUES (1,'09:00:00');
INSERT INTO horas(ID,HORA) VALUES (2,'10:30:00');
INSERT INTO horas(ID,HORA) VALUES (3,'12:00:00');
INSERT INTO horas(ID,HORA) VALUES (4,'13:30:00');
INSERT INTO horas(ID,HORA) VALUES (5,'15:00:00');
INSERT INTO horas(ID,HORA) VALUES (6,'16:30:00');
INSERT INTO horas(ID,HORA) VALUES (7,'18:00:00');
INSERT INTO horas(ID,HORA) VALUES (8,'19:30:00');

-- categorias

INSERT INTO categoria (ID_CATEGORIA,SEXONIVEL) VALUES (1,'M1');
INSERT INTO categoria (ID_CATEGORIA,SEXONIVEL) VALUES (2,'F1');
INSERT INTO categoria (ID_CATEGORIA,SEXONIVEL) VALUES (3,'MX1');
INSERT INTO categoria (ID_CATEGORIA,SEXONIVEL) VALUES (4,'M2');
INSERT INTO categoria (ID_CATEGORIA,SEXONIVEL) VALUES (5,'F2');
INSERT INTO categoria (ID_CATEGORIA,SEXONIVEL) VALUES (6,'MX2');
INSERT INTO categoria (ID_CATEGORIA,SEXONIVEL) VALUES (7,'M3');
INSERT INTO categoria (ID_CATEGORIA,SEXONIVEL) VALUES (8,'F3');
INSERT INTO categoria (ID_CATEGORIA,SEXONIVEL) VALUES (9,'MX3');