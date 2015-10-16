/*
Navicat MySQL Data Transfer

Source Server         : Develop PHP - 192.168.228.48
Source Server Version : 50137
Source Host           : 192.168.228.48:3306
Source Database       : o3m_fw_00

Target Server Type    : MYSQL
Target Server Version : 50137
File Encoding         : 65001

Date: 2015-10-16 13:28:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sis_empresas
-- ----------------------------
DROP TABLE IF EXISTS `sis_empresas`;
CREATE TABLE `sis_empresas` (
  `id_empresa` mediumint(6) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `siglas` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rfc` varchar(18) COLLATE utf8_spanish_ci DEFAULT NULL,
  `razon` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` text COLLATE utf8_spanish_ci,
  `pais` varchar(15) COLLATE utf8_spanish_ci DEFAULT 'MX',
  `email` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `id_nomina` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`),
  KEY `i_nomina` (`id_nomina`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_empresas
-- ----------------------------
INSERT INTO `sis_empresas` VALUES ('1', 'Desarrollo IS', 'Develop', null, 'iSolution.mx', null, 'MX', 'oscar.maldonado@isolution.mx', null, '0', '1', '0');

-- ----------------------------
-- Table structure for sis_grupos
-- ----------------------------
DROP TABLE IF EXISTS `sis_grupos`;
CREATE TABLE `sis_grupos` (
  `id_grupo` tinyint(2) NOT NULL,
  `grupo` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `visible` text COLLATE utf8_spanish_ci,
  `invisible` text COLLATE utf8_spanish_ci,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_grupo`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_grupos
-- ----------------------------
INSERT INTO `sis_grupos` VALUES ('10', 'administradores', null, '14', '1');
INSERT INTO `sis_grupos` VALUES ('20', 'inplant', null, '2', '1');
INSERT INTO `sis_grupos` VALUES ('30', 'nivel5', null, null, '1');
INSERT INTO `sis_grupos` VALUES ('40', 'nivel2', '2,3,16', '2,8|20|21,18', '1');
INSERT INTO `sis_grupos` VALUES ('50', 'nivel1', '*', '2,3|4 5,6;16', '1');
INSERT INTO `sis_grupos` VALUES ('60', 'empleados', null, null, '1');
INSERT INTO `sis_grupos` VALUES ('70', 'extra', null, null, '1');
INSERT INTO `sis_grupos` VALUES ('0', 'root', null, null, '1');
INSERT INTO `sis_grupos` VALUES ('21', 'global', null, null, '1');
INSERT INTO `sis_grupos` VALUES ('35', 'nivel3', null, null, '1');
INSERT INTO `sis_grupos` VALUES ('34', 'nivel4', null, null, '1');

-- ----------------------------
-- Table structure for sis_grupos_copy
-- ----------------------------
DROP TABLE IF EXISTS `sis_grupos_copy`;
CREATE TABLE `sis_grupos_copy` (
  `id_grupo` tinyint(2) NOT NULL,
  `grupo` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mod1` tinyint(1) NOT NULL DEFAULT '0',
  `mod2` tinyint(1) NOT NULL DEFAULT '0',
  `mod3` tinyint(1) NOT NULL DEFAULT '0',
  `mod4` tinyint(1) NOT NULL DEFAULT '0',
  `mod5` tinyint(1) NOT NULL DEFAULT '0',
  `mod6` tinyint(1) NOT NULL DEFAULT '0',
  `mod7` tinyint(1) NOT NULL DEFAULT '0',
  `mod8` tinyint(1) NOT NULL DEFAULT '0',
  `mod9` tinyint(1) NOT NULL DEFAULT '0',
  `mod10` tinyint(1) NOT NULL DEFAULT '0',
  `visible` text COLLATE utf8_spanish_ci,
  `invisible` text COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_grupo`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_grupos_copy
-- ----------------------------
INSERT INTO `sis_grupos_copy` VALUES ('10', 'administradores', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2,3', '4,8,7,2');
INSERT INTO `sis_grupos_copy` VALUES ('20', 'inplant', '1', '0', '0', '1', '1', '1', '1', '0', '0', '0', null, '2');
INSERT INTO `sis_grupos_copy` VALUES ('30', 'nivel5', '1', '0', '1', '1', '1', '0', '0', '0', '0', '0', null, null);
INSERT INTO `sis_grupos_copy` VALUES ('40', 'nivel2', '1', '0', '1', '1', '0', '0', '0', '0', '0', '0', '2,3,16', '2,8|20|21,18');
INSERT INTO `sis_grupos_copy` VALUES ('50', 'nivel1', '1', '0', '1', '1', '0', '0', '0', '0', '0', '0', '*', '2,3|4 5,6;16');
INSERT INTO `sis_grupos_copy` VALUES ('60', 'empleados', '1', '1', '0', '1', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `sis_grupos_copy` VALUES ('70', 'extra', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `sis_grupos_copy` VALUES ('0', 'root', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null, null);
INSERT INTO `sis_grupos_copy` VALUES ('21', 'global', '1', '1', '1', '1', '1', '0', '1', '0', '0', '0', null, null);
INSERT INTO `sis_grupos_copy` VALUES ('35', 'nivel3', '1', '0', '1', '1', '1', '0', '0', '0', '0', '0', null, null);
INSERT INTO `sis_grupos_copy` VALUES ('34', 'nivel4', '1', '0', '1', '1', '1', '0', '0', '0', '0', '0', null, null);

-- ----------------------------
-- Table structure for sis_logs
-- ----------------------------
DROP TABLE IF EXISTS `sis_logs`;
CREATE TABLE `sis_logs` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_table` int(11) DEFAULT NULL,
  `accion` enum('UPDATE','DELETE','INSERT') COLLATE utf8_spanish_ci DEFAULT NULL,
  `query` text COLLATE utf8_spanish_ci,
  `txt` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `url` text COLLATE utf8_spanish_ci,
  `timestamp` datetime DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_log`),
  KEY `id_usuario` (`id_usuario`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_logs
-- ----------------------------

-- ----------------------------
-- Table structure for sis_menu
-- ----------------------------
DROP TABLE IF EXISTS `sis_menu`;
CREATE TABLE `sis_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) DEFAULT NULL,
  `id_superior` int(11) DEFAULT NULL,
  `nivel` tinyint(1) DEFAULT '1',
  `menu` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ico` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` smallint(3) DEFAULT NULL,
  `link` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `texto` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_menu`),
  KEY `i_superior` (`id_superior`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_menu
-- ----------------------------
INSERT INTO `sis_menu` VALUES ('1', '1', '1', '1', 'MODULO-01', 'inicio.png', '1', 'GENERAL/INICIO', 'Inicio', null, '1');
INSERT INTO `sis_menu` VALUES ('2', '2', '2', '1', 'MODULO-02', 'captura.png', '2', 'MOD-01/CAPTURA', 'Captura', null, '1');
INSERT INTO `sis_menu` VALUES ('3', '3', '3', '1', 'MODULO-03', 'autorizacion.png', '3', null, 'Módulo 03', null, '1');
INSERT INTO `sis_menu` VALUES ('4', '4', '4', '1', 'MODULO-04', 'consultas.png', '4', null, 'Módulo 04', null, '1');
INSERT INTO `sis_menu` VALUES ('5', '5', '5', '1', 'MODULO-05', 'reportes.png', '5', null, 'Módulo 05', null, '1');
INSERT INTO `sis_menu` VALUES ('6', '6', '6', '1', 'MODULO-06', 'consultas.png', '6', null, 'Módulo 06', null, '1');
INSERT INTO `sis_menu` VALUES ('7', '7', '7', '1', 'MODULO-07', 'consultas.png', '7', null, 'Módulo 07', null, '1');
INSERT INTO `sis_menu` VALUES ('8', '3', '3', '2', 'SUBMODULO-3-1', null, '1', 'AUTORIZACION/AUTORIZACION_1', 'Submodulo 3-1', null, '1');
INSERT INTO `sis_menu` VALUES ('9', '3', '3', '2', 'SUBMODULO-3-2', null, '2', 'AUTORIZACION/AUTORIZACION_2', 'Submodulo 3-2', null, '1');
INSERT INTO `sis_menu` VALUES ('10', '4', '4', '2', 'SUBMODULO-4-1', null, '1', null, 'Submodulo 4-1', null, '1');
INSERT INTO `sis_menu` VALUES ('11', '5', '5', '2', 'SUBMODULO-5-1', null, '1', null, 'Submodulo 5-1', null, '1');
INSERT INTO `sis_menu` VALUES ('12', '5', '5', '2', 'SUBMODULO-5-2', null, '2', null, 'Submodulo 5-2', null, '1');
INSERT INTO `sis_menu` VALUES ('13', '5', '5', '2', 'SUBMODULO-5-3', null, '3', null, 'Submodulo 5-3', null, '1');
INSERT INTO `sis_menu` VALUES ('14', '6', '6', '2', 'SUBMODULO-6-1', null, '1', null, 'Submodulo 6-1', null, '1');
INSERT INTO `sis_menu` VALUES ('15', '6', '14', '3', 'SUBMODULO-6-1-1', null, '1', null, 'Submodulo 6-1-1', null, '1');
INSERT INTO `sis_menu` VALUES ('16', '16', '16', '1', 'MODULO-08', 'captura.png', '8', null, 'Módulo 08', null, '1');
INSERT INTO `sis_menu` VALUES ('17', '16', '16', '2', 'SUBMODULO-8-1', '', '1', null, 'Submodulo 8-1', '0000-00-00 00:00:00', '1');
INSERT INTO `sis_menu` VALUES ('18', '16', '17', '3', 'SUBMODULO-8-1-1', '', '1', null, 'Submodulo 8-1-1', '0000-00-00 00:00:00', '1');
INSERT INTO `sis_menu` VALUES ('19', '16', '17', '3', 'SUBMODULO-8-1-2', null, '2', null, 'Submodulo 8-1-2', null, '1');
INSERT INTO `sis_menu` VALUES ('20', '16', '16', '2', 'SUBMODULO-8-2', null, '2', null, 'Submodulo 8-2', null, '1');
INSERT INTO `sis_menu` VALUES ('21', '16', '20', '3', 'SUBMODULO-8-2-1', null, '1', null, 'Submodulo 8-2-1', null, '1');

-- ----------------------------
-- Table structure for sis_modulos
-- ----------------------------
DROP TABLE IF EXISTS `sis_modulos`;
CREATE TABLE `sis_modulos` (
  `id_modulo` smallint(3) NOT NULL AUTO_INCREMENT,
  `id_nivel` smallint(3) DEFAULT '0',
  `modulo` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `icono` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_superior` smallint(3) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_modulo`),
  KEY `i_nivel` (`id_nivel`),
  KEY `i_superior` (`id_superior`),
  KEY `i_activo` (`activo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_modulos
-- ----------------------------
INSERT INTO `sis_modulos` VALUES ('1', '0', 'ADMINISTRACION', null, null, '1');
INSERT INTO `sis_modulos` VALUES ('2', '0', 'INICIO', null, null, '1');
INSERT INTO `sis_modulos` VALUES ('3', '0', 'CAPTURA', null, null, '1');
INSERT INTO `sis_modulos` VALUES ('4', '0', 'CONSULTA', null, null, '1');
INSERT INTO `sis_modulos` VALUES ('5', '0', 'REPORTES', null, null, '1');

-- ----------------------------
-- Table structure for sis_online
-- ----------------------------
DROP TABLE IF EXISTS `sis_online`;
CREATE TABLE `sis_online` (
  `id_online` mediumint(4) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `online` int(12) DEFAULT NULL,
  PRIMARY KEY (`id_online`),
  KEY `i_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sis_online
-- ----------------------------
INSERT INTO `sis_online` VALUES ('1', '2', '1445020005');
INSERT INTO `sis_online` VALUES ('2', '0', '1444678734');
INSERT INTO `sis_online` VALUES ('3', '8', '1444853002');
INSERT INTO `sis_online` VALUES ('4', '3', '1444853175');

-- ----------------------------
-- Table structure for sis_personal
-- ----------------------------
DROP TABLE IF EXISTS `sis_personal`;
CREATE TABLE `sis_personal` (
  `id_personal` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `paterno` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `materno` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rfc` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imss` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sucursal` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `puesto` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `empleado_num` int(11) DEFAULT NULL,
  `id_empresa` smallint(4) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `id_nomina` int(11) DEFAULT NULL,
  `estado` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sucursal_nomina` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_personal`),
  KEY `i_empresa` (`id_empresa`),
  KEY `i_activo` (`activo`),
  KEY `i_puesto` (`id_empresa`,`puesto`),
  KEY `i_empleado_num` (`empleado_num`),
  KEY `fk_usuario` (`id_usuario`),
  KEY `i_nomina` (`id_nomina`),
  KEY `i_estado` (`estado`)
) ENGINE=MyISAM AUTO_INCREMENT=783 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_personal
-- ----------------------------
INSERT INTO `sis_personal` VALUES ('1', 'Root', 'del', 'sistema', '', '', 'oscar.maldonado@isolution.mx', '', 'Root', '0', '1', null, null, '1', '0', null, null);
INSERT INTO `sis_personal` VALUES ('2', 'Administrador', 'PAE', 'sistema', '', '', 'oscar.maldonado@isolution.mx', '', 'Administrador', '0', '1', null, null, '1', '0', null, null);
INSERT INTO `sis_personal` VALUES ('3', 'Inplant', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Inplant', '0', '41', null, null, '1', '0', null, null);
INSERT INTO `sis_personal` VALUES ('4', 'Nivel5', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel5', '0', '41', null, null, '0', '0', null, null);
INSERT INTO `sis_personal` VALUES ('5', 'Nivel4', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel4', '0', '41', null, null, '0', '0', null, null);
INSERT INTO `sis_personal` VALUES ('6', 'Nivel3', 'de', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel3', '0', '41', '2015-07-13 12:58:54', '2', '1', '0', null, null);
INSERT INTO `sis_personal` VALUES ('7', 'Nivel2', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel2', '0', '41', null, null, '1', '0', null, null);
INSERT INTO `sis_personal` VALUES ('8', 'Nivel1', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel1', '0', '41', null, null, '1', '0', null, null);
INSERT INTO `sis_personal` VALUES ('9', 'Empleado ', 'Del', 'Cliente', '', '', 'oscar.maldonado@isolution.mx', 'PRUEBAS', 'Empleado', '0', '41', '2015-03-19 14:08:26', '3', '1', '0', 'CIUDAD DE MÉXICO', 'COORPORATIVO');
INSERT INTO `sis_personal` VALUES ('10', 'Usuario', 'Global', 'del Cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Global', '0', '41', null, null, '0', '0', null, null);

-- ----------------------------
-- Table structure for sis_usuarios
-- ----------------------------
DROP TABLE IF EXISTS `sis_usuarios`;
CREATE TABLE `sis_usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clave` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_grupo` tinyint(2) DEFAULT '60',
  `visible` text COLLATE utf8_spanish_ci,
  `invisible` text COLLATE utf8_spanish_ci,
  `id_personal` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `login` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  KEY `i_grupo` (`id_grupo`),
  KEY `i_activo` (`activo`),
  KEY `i_personal` (`id_personal`)
) ENGINE=MyISAM AUTO_INCREMENT=775 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_usuarios
-- ----------------------------
INSERT INTO `sis_usuarios` VALUES ('1', 'root', '63a9f0ea7bb98050796b649e85481845', '0', null, null, '1', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('2', 'admin', '21232f297a57a5a743894a0e4a801fc3', '10', null, null, '2', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('3', 'inplant', 'd3136ade621c131e74a833684324cd3f', '20', null, null, '3', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('4', 'nivel5', '75edac518e49dbc4b6930f0c76c27569', '30', null, null, '4', null, '1', '0');
INSERT INTO `sis_usuarios` VALUES ('5', 'nivel4', 'fd57d7925c772b24bf450663508230de', '34', null, null, '5', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('6', 'nivel3', 'f4d49413fb521f083563646b8054e3e9', '35', null, null, '6', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('7', 'nivel2', '19726b6c8dfe0a48bac15542db28134c', '40', null, null, '7', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('8', 'nivel1', 'cd000523267ff95b50c356f0d6f67703', '50', null, null, '8', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('9', 'empleado', '088ef99bff55c67dc863f83980a66a9b', '60', null, null, '9', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('10', 'global', '9c70933aff6b2a6d08c687a6cbb6b765', '21', null, null, '10', null, '1', '1');
