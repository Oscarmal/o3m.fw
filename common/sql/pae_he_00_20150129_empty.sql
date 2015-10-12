/*
Navicat MySQL Data Transfer

Source Server         : Server Produccion
Source Server Version : 50137
Source Host           : 201.148.150.198:3306
Source Database       : pae_he_00

Target Server Type    : MYSQL
Target Server Version : 50137
File Encoding         : 65001

Date: 2015-01-29 09:49:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cat_conceptos
-- ----------------------------
DROP TABLE IF EXISTS `cat_conceptos`;
CREATE TABLE `cat_conceptos` (
  `id_concepto` tinyint(2) NOT NULL AUTO_INCREMENT,
  `concepto` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clave` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` smallint(4) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_concepto`),
  KEY `i_clave` (`clave`),
  KEY `i_activo` (`activo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of cat_conceptos
-- ----------------------------
INSERT INTO `cat_conceptos` VALUES ('1', 'SIMPLES', '1', '1', '0');
INSERT INTO `cat_conceptos` VALUES ('2', 'DOBLES', 'P016', '2', '1');
INSERT INTO `cat_conceptos` VALUES ('3', 'TRIPLES', 'P019', '3', '1');

-- ----------------------------
-- Table structure for cat_seguimiento
-- ----------------------------
DROP TABLE IF EXISTS `cat_seguimiento`;
CREATE TABLE `cat_seguimiento` (
  `id_cat_seguimiento` mediumint(7) NOT NULL AUTO_INCREMENT,
  `tipo` enum('ACCION','ESTATUS') COLLATE utf8_spanish_ci DEFAULT 'ACCION',
  `descripcion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `siglas` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_cat_seguimiento`),
  KEY `i_tipo` (`tipo`),
  KEY `i_activo` (`activo`),
  KEY `i_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of cat_seguimiento
-- ----------------------------
INSERT INTO `cat_seguimiento` VALUES ('1', 'ACCION', 'CAPTURADO', 'CAP', '2014-08-29 16:48:06', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('2', 'ACCION', 'VALIDADO', 'VAL', '2014-08-29 16:48:25', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('3', 'ACCION', 'AUTORIZADO', 'AUT', '2014-08-29 16:49:54', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('4', 'ACCION', 'ENVIADO', 'ENV', '2014-08-29 16:50:06', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('5', 'ESTATUS', 'EN PROCESO', 'PROC', '2014-08-29 16:50:25', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('6', 'ESTATUS', 'APROBADO', 'APRO', '2014-08-29 16:51:03', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('7', 'ESTATUS', 'RECHAZADO', 'RECH', '2014-08-29 16:51:18', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('8', 'ESTATUS', 'CANCELADO', 'CANC', '2014-08-29 16:52:39', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('9', 'ESTATUS', 'CERRADO', 'CERR', '2014-08-29 16:52:49', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('10', 'ESTATUS', 'REALIZADO', 'REAL', '2014-08-29 16:53:07', '1', '1');
INSERT INTO `cat_seguimiento` VALUES ('11', 'ESTATUS', 'PENDIENTE', 'PEND', '2014-08-29 16:53:22', '1', '1');

-- ----------------------------
-- Table structure for he_autorizaciones
-- ----------------------------
DROP TABLE IF EXISTS `he_autorizaciones`;
CREATE TABLE `he_autorizaciones` (
  `id_autorizacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_horas_extra` int(11) NOT NULL,
  `id_cat_autorizacion` tinyint(2) DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT '1',
  `id_usuario` int(11) DEFAULT NULL,
  `argumento` text COLLATE utf8_spanish_ci,
  `h_dobles` time DEFAULT NULL,
  `h_triples` time DEFAULT NULL,
  `h_rechazadas` time DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_autorizacion`),
  KEY `i_id_usuario` (`id_horas_extra`),
  KEY `i_activo` (`activo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of he_autorizaciones
-- ----------------------------

-- ----------------------------
-- Table structure for he_autorizaciones_nomina
-- ----------------------------
DROP TABLE IF EXISTS `he_autorizaciones_nomina`;
CREATE TABLE `he_autorizaciones_nomina` (
  `id_autorizacion_nomina` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat_autorizaciones` tinyint(2) DEFAULT NULL,
  `id_horas_extra` int(11) NOT NULL,
  `anio` smallint(4) DEFAULT NULL,
  `periodo` mediumint(6) DEFAULT NULL,
  `periodo_especial` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL,
  `semana` tinyint(2) DEFAULT NULL,
  `horas` time DEFAULT NULL,
  `id_concepto` tinyint(2) DEFAULT NULL,
  `xls` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `final_anio` smallint(4) DEFAULT NULL,
  `final_periodo` mediumint(6) DEFAULT NULL,
  `final_periodo_especial` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL,
  `final_semana` tinyint(2) DEFAULT NULL,
  `final_timestamp` datetime DEFAULT NULL,
  `final_id_usuario` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_autorizacion_nomina`),
  KEY `i_id_concepto` (`id_concepto`),
  KEY `i_id_usuario` (`id_horas_extra`),
  KEY `i_activo` (`activo`),
  KEY `i_anio_periodo_semana` (`anio`,`periodo`,`semana`) USING BTREE,
  KEY `i_final_id_usuario` (`final_id_usuario`),
  KEY `i_final_anio_periodo_semana` (`final_anio`,`final_periodo`,`final_semana`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of he_autorizaciones_nomina
-- ----------------------------

-- ----------------------------
-- Table structure for he_empresas
-- ----------------------------
DROP TABLE IF EXISTS `he_empresas`;
CREATE TABLE `he_empresas` (
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
-- Records of he_empresas
-- ----------------------------
INSERT INTO `he_empresas` VALUES ('1', 'Desarrollo IS', 'Develop', null, 'iSolution.mx', null, 'MX', 'oscar.maldonado@isolution.mx', null, '0', '1', '0');
INSERT INTO `he_empresas` VALUES ('2', 'BIOMERIEUX S.A. DE C.V.', 'BIO2012', null, 'BIOMERIEUX S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3001');
INSERT INTO `he_empresas` VALUES ('3', 'LIKOM DE MEXICO, S.A. DE C.V.', 'LIKOM2012', null, 'LIKOM DE MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3002');
INSERT INTO `he_empresas` VALUES ('4', 'MATRIX WIRE DE MEXICO, S. DE R.L. DE C.V.', 'MATRIX2012', null, 'MATRIX WIRE DE MEXICO, S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3003');
INSERT INTO `he_empresas` VALUES ('5', 'ELEVADORES OTIS, SA. DE C.V.', 'OTIS2012', null, 'ELEVADORES OTIS, SA. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3004');
INSERT INTO `he_empresas` VALUES ('6', 'CIRCUITOS DE SEGURIDAD', 'PRIBOS2012', null, 'CIRCUITOS DE SEGURIDAD', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3005');
INSERT INTO `he_empresas` VALUES ('7', 'SEGURITECH PRIVADA S.A DE C.V.', 'SGTECH2013', null, 'SEGURITECH PRIVADA S.A DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3009');
INSERT INTO `he_empresas` VALUES ('8', 'SERVICIOS CORPORATIVOS MASTER CHOICE, S. DE R.L. DE C.V.', 'CHOICE2013', null, 'SERVICIOS CORPORATIVOS MASTER CHOICE, S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3016');
INSERT INTO `he_empresas` VALUES ('9', 'TRES VIDAS ACAPULCO, A.C', 'VIDAS2013', null, 'TRES VIDAS ACAPULCO, A.C', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3017');
INSERT INTO `he_empresas` VALUES ('10', 'OPFIN, S.A. DE C.V.', 'OPFIN2012', null, 'OPFIN, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3018');
INSERT INTO `he_empresas` VALUES ('11', 'THE NATURE CONSERVANCY', 'NATURE2012', null, 'THE NATURE CONSERVANCY', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3019');
INSERT INTO `he_empresas` VALUES ('12', 'DSM NUTRITIONAL PRODUCTS MEXICO SA DE CV', 'DSMNUT2012', null, 'DSM NUTRITIONAL PRODUCTS MEXICO SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3021');
INSERT INTO `he_empresas` VALUES ('13', 'ELVA GABRIELA MENA MIRANDA', 'FARECO2012', null, 'ELVA GABRIELA MENA MIRANDA', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3022');
INSERT INTO `he_empresas` VALUES ('14', 'USIMECA MEXICO SA DE CV', 'USIMECA2011', null, 'USIMECA MEXICO SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3024');
INSERT INTO `he_empresas` VALUES ('15', 'MENTE ESTRATEGICA S.A DE C.V', 'INTEGRA2012', null, 'MENTE ESTRATEGICA S.A DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3026');
INSERT INTO `he_empresas` VALUES ('16', 'WILLIS AGENTE DE SEGUROS Y DE FIANZAS, S.A. DE.C.V.', 'WILLIS2012', null, 'WILLIS AGENTE DE SEGUROS Y DE FIANZAS, S.A. DE.C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3027');
INSERT INTO `he_empresas` VALUES ('17', 'CORPORACION INTERPUBLIC MEXICANA, S.A. DE C.V.', 'INTEMEX2012', null, 'CORPORACION INTERPUBLIC MEXICANA, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3028');
INSERT INTO `he_empresas` VALUES ('18', 'GUY CARPENTER MEXICO INTERMEDIARIO DE REASEGURO, S. A. DE C. V.', 'GUY2012', null, 'GUY CARPENTER MEXICO INTERMEDIARIO DE REASEGURO, S. A. DE C. V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3029');
INSERT INTO `he_empresas` VALUES ('19', 'REHAU S.A. DE C.V.', 'REHAUS2012', null, 'REHAU S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3031');
INSERT INTO `he_empresas` VALUES ('20', 'CHECKPOINT DE MEXICO, S.A. DE C.V.', 'CPOINT2012', null, 'CHECKPOINT DE MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3035');
INSERT INTO `he_empresas` VALUES ('21', 'NAGAOKA DOS, S.A. DE C.V.', 'NAGAOKA2012', null, 'NAGAOKA DOS, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3036');
INSERT INTO `he_empresas` VALUES ('22', 'SOPORTE INDUSTRIAL PARA INGENIERIA MANTENIMIENTO Y CONSTRUCCION, S.A. DE C.V.', 'SISA2013', null, 'SOPORTE INDUSTRIAL PARA INGENIERIA MANTENIMIENTO Y CONSTRUCCION, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3038');
INSERT INTO `he_empresas` VALUES ('23', 'LEVITON S DE RL DE CV', 'LEVITON2012', null, 'LEVITON S DE RL DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3040');
INSERT INTO `he_empresas` VALUES ('24', 'GET IT, S.A DE C.V', 'GETIT2012', null, 'GET IT, S.A DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3042');
INSERT INTO `he_empresas` VALUES ('25', 'REXITE SA DE CV', 'REXITE2012', null, 'REXITE SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3051');
INSERT INTO `he_empresas` VALUES ('26', 'SEMMATERIALS MEXICO S DE R.L. DE CV.', 'SEM2012', null, 'SEMMATERIALS MEXICO S DE R.L. DE CV.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3054');
INSERT INTO `he_empresas` VALUES ('27', 'AMCOR PLASTIC CONTINERS DE MEXICO SA DE CV', 'ACMOR2012', null, 'AMCOR PLASTIC CONTINERS DE MEXICO SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3055');
INSERT INTO `he_empresas` VALUES ('28', 'TRANE SISTEMAS INTEGRALES S. DE R.L DE C.V', 'TRANE2012', null, 'TRANE SISTEMAS INTEGRALES S. DE R.L DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3057');
INSERT INTO `he_empresas` VALUES ('29', 'INMOBILIARIA NACIONAL MEXICANA,S.A.P.I DE C.V ', 'SEASONS2012', null, 'INMOBILIARIA NACIONAL MEXICANA,S.A.P.I DE C.V ', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3058');
INSERT INTO `he_empresas` VALUES ('30', 'LEGO MEXICO, S.A. DE C.V', 'LEGO2012', null, 'LEGO MEXICO, S.A. DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3059');
INSERT INTO `he_empresas` VALUES ('31', 'LUNDBECK MEXICO, S.A. DE C.V.', 'LUNDMX2012', null, 'LUNDBECK MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3060');
INSERT INTO `he_empresas` VALUES ('32', 'KORES DE MEXICO S.A DE C.V', 'KORES2012', null, 'KORES DE MEXICO S.A DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3063');
INSERT INTO `he_empresas` VALUES ('33', 'HUAWEI TECHNOLOGIES DE MEXICO, S.A. DE C.V.', 'HUAWEI2012', null, 'HUAWEI TECHNOLOGIES DE MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3064');
INSERT INTO `he_empresas` VALUES ('34', 'CORPORACION NOVAIMAGEN, S. DE R. L. DE C. V.', 'SKYTV2012', null, 'CORPORACION NOVAIMAGEN, S. DE R. L. DE C. V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3066');
INSERT INTO `he_empresas` VALUES ('35', 'EQUIPOS Y SOLUCIONES TECNOLOGICAS CADILLAC JACK, S. DE R.L. DE C.V', 'CADI2012', null, 'EQUIPOS Y SOLUCIONES TECNOLOGICAS CADILLAC JACK, S. DE R.L. DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3067');
INSERT INTO `he_empresas` VALUES ('36', 'SOPORTE INDUSTRIAL PARA INGENIERIA MANTENIMIENTO Y CONSTRUCCION, S.A. DE C.V.', 'SOPORTE2013', null, 'SOPORTE INDUSTRIAL PARA INGENIERIA MANTENIMIENTO Y CONSTRUCCION, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3072');
INSERT INTO `he_empresas` VALUES ('37', 'TORRE RESIDENCIAL AREIA A.C', 'AREIA2012', null, 'TORRE RESIDENCIAL AREIA A.C', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3075');
INSERT INTO `he_empresas` VALUES ('38', 'PARGROUP AGENTE DE SEGUROS Y DE FIANZAS, S. A. DE C. V.', 'PARGRP2012', null, 'PARGROUP AGENTE DE SEGUROS Y DE FIANZAS, S. A. DE C. V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3078');
INSERT INTO `he_empresas` VALUES ('39', 'QUIROZ, MUÑIZ Y BOLIO, S. C.', 'CQMB2012', null, 'QUIROZ, MUÑIZ Y BOLIO, S. C.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3079');
INSERT INTO `he_empresas` VALUES ('40', 'EDIFICIO ANICETO ORTEGA NO 1225', 'EDIF2012', null, 'EDIFICIO ANICETO ORTEGA NO 1225', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3080');
INSERT INTO `he_empresas` VALUES ('41', 'CHRYSLER MEXICO S.A DE C.V', 'CHRYSLR2012', null, 'CHRYSLER MEXICO S.A DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '1', '3082');
INSERT INTO `he_empresas` VALUES ('42', 'SISTEMA INTEGRAL DE ASISTENCIA AL EMPLEADO, S. DE R.L. DE C.V.', 'SIAE2012', null, 'SISTEMA INTEGRAL DE ASISTENCIA AL EMPLEADO, S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3087');
INSERT INTO `he_empresas` VALUES ('43', 'SISTEMA INTEGRAL DE ASISTENCIA AL EMPLEADO (HONORARIOS)', 'SIAEHA2012', null, 'SISTEMA INTEGRAL DE ASISTENCIA AL EMPLEADO (HONORARIOS)', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3088');
INSERT INTO `he_empresas` VALUES ('44', 'WILLIS MEXICO INTERMEDIARIO DE REASEGURO SA DE CV', 'WILLISR2012', null, 'WILLIS MEXICO INTERMEDIARIO DE REASEGURO SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3089');
INSERT INTO `he_empresas` VALUES ('45', 'NS4.COM INTERNET, S.A. DE C.V.', 'NS4.COM(Q)', null, 'NS4.COM INTERNET, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3091');
INSERT INTO `he_empresas` VALUES ('46', 'AVANXO MÉXICO S.A.P.I. DE C.V.', 'AVANXO(Q)', null, 'AVANXO MÉXICO S.A.P.I. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3093');
INSERT INTO `he_empresas` VALUES ('47', 'AAA TEC, S. A. DE C. V.', 'AAATEC2012', null, 'AAA TEC, S. A. DE C. V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3095');
INSERT INTO `he_empresas` VALUES ('48', 'CADENA COMERCIAL OXXO, S.A. DE C.V.', 'OXXO(Q)', null, 'CADENA COMERCIAL OXXO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3107');
INSERT INTO `he_empresas` VALUES ('49', 'MERCANTIL DE ALIMENTOS DEL MAR S.A. DE C.V.', 'MARSAS2012', null, 'MERCANTIL DE ALIMENTOS DEL MAR S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3108');
INSERT INTO `he_empresas` VALUES ('50', 'CHURCH & DWIGHT , S DE R.L DE C.V', 'CHURCH2012', null, 'CHURCH & DWIGHT , S DE R.L DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3109');
INSERT INTO `he_empresas` VALUES ('51', 'FERRAVI, S.C.', 'RECCAR2012', null, 'FERRAVI, S.C.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3110');
INSERT INTO `he_empresas` VALUES ('52', 'SUMMIT AGRO MEXICO S.A. DE C.V.', 'SUMMIT(Q)', null, 'SUMMIT AGRO MEXICO S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3134');
INSERT INTO `he_empresas` VALUES ('53', 'COMERCIAL TEIFAROS S DE RL', 'TEIFAROS(M)', null, 'COMERCIAL TEIFAROS S DE RL', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3135');
INSERT INTO `he_empresas` VALUES ('54', 'RAVENNA', 'RAVENNA(Q)', null, 'RAVENNA', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3136');
INSERT INTO `he_empresas` VALUES ('55', 'IMPULSO LOGISTICO, S.A. DE C.V.', 'IMPULSO2012', null, 'IMPULSO LOGISTICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3140');
INSERT INTO `he_empresas` VALUES ('56', 'JAIME LORENZO PORTILLA FORCEN', 'JLPF2012', null, 'JAIME LORENZO PORTILLA FORCEN', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3141');
INSERT INTO `he_empresas` VALUES ('57', 'CELATOR DE MEXICO, S. DE R.L. DE C.V.', 'CELATOR2012', null, 'CELATOR DE MEXICO, S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3143');
INSERT INTO `he_empresas` VALUES ('58', 'MARCAS NOTORIAS DE MEXICO, SA DE CV', 'TARDAN2012', null, 'MARCAS NOTORIAS DE MEXICO, SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3145');
INSERT INTO `he_empresas` VALUES ('59', 'NEW MILLENIUM JOIST & DECK DE MÉXICO, S. DE R.L DE C.V.', 'NEWMILL2012', null, 'NEW MILLENIUM JOIST & DECK DE MÉXICO, S. DE R.L DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3146');
INSERT INTO `he_empresas` VALUES ('60', 'IKUSI MEXICO, S.A. DE C.V.', 'IKUSI2012', null, 'IKUSI MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3147');
INSERT INTO `he_empresas` VALUES ('61', 'AVANT FORCE CAPITAL HUMANO, S.A. DE C.V.', 'AVANTG2012', null, 'AVANT FORCE CAPITAL HUMANO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3152');
INSERT INTO `he_empresas` VALUES ('62', 'LIABILITY AND TRUST DE MEXICO, S.A. DE C.V.', 'EFFORT2012', null, 'LIABILITY AND TRUST DE MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3153');
INSERT INTO `he_empresas` VALUES ('63', 'FEREGSO, S.A. DE C.V.', 'FEREGSO2012', null, 'FEREGSO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3154');
INSERT INTO `he_empresas` VALUES ('64', 'GINTOR ADMINISTRACIÓN, S.A. DE C.V.', 'TORNEL2012', null, 'GINTOR ADMINISTRACIÓN, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3156');
INSERT INTO `he_empresas` VALUES ('65', 'ARQUITECTOS Y DESARROLLISTAS DEL CENTRO, A.D. S.C.', 'DECCA2012', null, 'ARQUITECTOS Y DESARROLLISTAS DEL CENTRO, A.D. S.C.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3157');
INSERT INTO `he_empresas` VALUES ('66', 'PRODUCTOS RICH, S.A. DE C.V', 'RICH2012', null, 'PRODUCTOS RICH, S.A. DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3158');
INSERT INTO `he_empresas` VALUES ('67', 'ZELLER PLASTIK DE MEXICO, SA DE CV', 'ZELLER2012', null, 'ZELLER PLASTIK DE MEXICO, SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3160');
INSERT INTO `he_empresas` VALUES ('68', 'AAA COSMETICA, S.A. DE C.V.', 'ACOSSEM2012', null, 'AAA COSMETICA, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3162');
INSERT INTO `he_empresas` VALUES ('69', 'COMPAÑÍA HULERA TORNEL, S.A. DE C.V.', 'HULERA2013', null, 'COMPAÑÍA HULERA TORNEL, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3163');
INSERT INTO `he_empresas` VALUES ('70', 'KRISNHA DESIREE MURO SILVA', 'KRISNHA2012', null, 'KRISNHA DESIREE MURO SILVA', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3166');
INSERT INTO `he_empresas` VALUES ('71', 'ANA MARÍA VILLARREAL AMPARÁN', 'ANA(S)', null, 'ANA MARÍA VILLARREAL AMPARÁN', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3168');
INSERT INTO `he_empresas` VALUES ('72', 'LUC CHARLES DOMINIQUE TARDAN PERRIN', 'LUC(S)', null, 'LUC CHARLES DOMINIQUE TARDAN PERRIN', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3176');
INSERT INTO `he_empresas` VALUES ('73', 'TEN LIFESTYLE MANAGEMENT LIMITED S DE RL DE CV', 'TENGROUP(Q)', null, 'TEN LIFESTYLE MANAGEMENT LIMITED S DE RL DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3179');
INSERT INTO `he_empresas` VALUES ('74', 'INGRUSUR, S.A. DE C.V.', 'INGRUSUR(Q)', null, 'INGRUSUR, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3186');
INSERT INTO `he_empresas` VALUES ('75', 'BANCO INTERAMERICANO DE DESARROLLO', 'BANCO(Q)', null, 'BANCO INTERAMERICANO DE DESARROLLO', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3194');
INSERT INTO `he_empresas` VALUES ('76', 'FIDEICOMISO ADMINISTRADOR Y FINANCIERO', 'PROASA2012', null, 'FIDEICOMISO ADMINISTRADOR Y FINANCIERO', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3197');
INSERT INTO `he_empresas` VALUES ('77', 'INVERSIONES ACCIONARIAS LANDUS S A DE C V', 'LANDUS2012', null, 'INVERSIONES ACCIONARIAS LANDUS S A DE C V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3198');
INSERT INTO `he_empresas` VALUES ('78', 'EDGAR NORIEGA VALDEZ', 'NORIEGA2012', null, 'EDGAR NORIEGA VALDEZ', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3199');
INSERT INTO `he_empresas` VALUES ('79', 'INGENIERIA EN SERVICIOS DE INFORMATICA S.A DE C.V.', 'SONDA2012', null, 'INGENIERIA EN SERVICIOS DE INFORMATICA S.A DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3200');
INSERT INTO `he_empresas` VALUES ('80', 'PROLOGIST PROFESIONALES EN LOGISTICA INTERNACIONAL, S.A. DE C.V.', 'PROLOGI2012', null, 'PROLOGIST PROFESIONALES EN LOGISTICA INTERNACIONAL, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3202');
INSERT INTO `he_empresas` VALUES ('81', 'CIATEQ, A.C. ( QUERETARO )', 'CIATEQ2012', null, 'CIATEQ, A.C. ( QUERETARO )', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3204');
INSERT INTO `he_empresas` VALUES ('82', 'ITW WELDING SERVICIOS MEXICO S DE RL DE CV', 'ITW2012', null, 'ITW WELDING SERVICIOS MEXICO S DE RL DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3207');
INSERT INTO `he_empresas` VALUES ('83', 'SWISS BROKERS MEXICO INTERMEDIARIO DE REASEGURO, S. A. DE C. V.', 'SWISHON2012', null, 'SWISS BROKERS MEXICO INTERMEDIARIO DE REASEGURO, S. A. DE C. V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3208');
INSERT INTO `he_empresas` VALUES ('84', 'SWISS BROKERS MEXICO INTERMEDIARIO DE REASEGURO, S. A. DE C. V.', 'SWISSRE2012', null, 'SWISS BROKERS MEXICO INTERMEDIARIO DE REASEGURO, S. A. DE C. V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3209');
INSERT INTO `he_empresas` VALUES ('85', 'SERVICIOS CORPORATIVOS MASTER CHOICE, S. DE R.L. DE C.V.', 'MASTER2013', null, 'SERVICIOS CORPORATIVOS MASTER CHOICE, S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3210');
INSERT INTO `he_empresas` VALUES ('86', 'INDEQUIPOS MEXICO, S.A. DE C.V.', 'INDEQUIPOS(Q)', null, 'INDEQUIPOS MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3211');
INSERT INTO `he_empresas` VALUES ('87', 'CONEXIONES Y MANGUERAS INDUSTRIALES, S.A. DE C.V.', 'COMIMSA2012', null, 'CONEXIONES Y MANGUERAS INDUSTRIALES, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3214');
INSERT INTO `he_empresas` VALUES ('88', 'FIDEICOMISO COMERCIALIZADOR, S.A. DE C.V.', 'FICO2012', null, 'FIDEICOMISO COMERCIALIZADOR, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3215');
INSERT INTO `he_empresas` VALUES ('89', 'OLE, FUN &ENTERTAINMENT, SA DE CV', 'OLEFUN2012', null, 'OLE, FUN &ENTERTAINMENT, SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3216');
INSERT INTO `he_empresas` VALUES ('90', 'DSM NUTRITIONAL PRODUCTS MEXICO, S.A. DE C.V.', 'NUTRION2012', null, 'DSM NUTRITIONAL PRODUCTS MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3217');
INSERT INTO `he_empresas` VALUES ('91', 'WAC DE MEXICO, S.A. DE C.V. SOFOM ENR', 'SOFOMSE2012', null, 'WAC DE MEXICO, S.A. DE C.V. SOFOM ENR', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3226');
INSERT INTO `he_empresas` VALUES ('92', 'KONICA MINOLTA BUSINESS SOLUTIONS DE MEXICO SA DE CV', 'KONICA(Q)', null, 'KONICA MINOLTA BUSINESS SOLUTIONS DE MEXICO SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3229');
INSERT INTO `he_empresas` VALUES ('93', 'TEKSPAN DE MEXICO S.A DE C.V', 'TEKSPAN(S)', null, 'TEKSPAN DE MEXICO S.A DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3230');
INSERT INTO `he_empresas` VALUES ('94', 'INGENIERIA EN SERVICIOS DE INFORMATICA S.A DE C.V.', 'SONDHON2012', null, 'INGENIERIA EN SERVICIOS DE INFORMATICA S.A DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3234');
INSERT INTO `he_empresas` VALUES ('95', 'ZUKARA S.A. DE C.V.', 'ZUKARA(Q)', null, 'ZUKARA S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3239');
INSERT INTO `he_empresas` VALUES ('96', 'INGENIERIA EN SERVICIOS DE INFORMATICA S.A DE C.V.', 'SONSHON2012', null, 'INGENIERIA EN SERVICIOS DE INFORMATICA S.A DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3243');
INSERT INTO `he_empresas` VALUES ('97', 'EDESAMEX, S.A. DE C.V.', 'EDESAMEX(Q)', null, 'EDESAMEX, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3245');
INSERT INTO `he_empresas` VALUES ('98', 'GOOGLE MEXICO S. DE R.L. DE C.V.', 'GOOGLE(Q)', null, 'GOOGLE MEXICO S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3246');
INSERT INTO `he_empresas` VALUES ('99', 'BOLICHES AMF Y COMPAÑÍA', 'BOLICHES(Q)', null, 'BOLICHES AMF Y COMPAÑÍA', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3248');
INSERT INTO `he_empresas` VALUES ('100', 'RELATS MÉXICO S.A. DE CV', 'RELATS(Q)', null, 'RELATS MÉXICO S.A. DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3249');
INSERT INTO `he_empresas` VALUES ('101', 'INGENIERIA EN SERVICIOS DE INFORMATICA S.A DE C.V.', 'SONDHON(M)', null, 'INGENIERIA EN SERVICIOS DE INFORMATICA S.A DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3250');
INSERT INTO `he_empresas` VALUES ('102', 'RELATS MÉXICO S.A. DE CV', 'RELATS(S)', null, 'RELATS MÉXICO S.A. DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3251');
INSERT INTO `he_empresas` VALUES ('103', 'SAXON ENERGY SERVICES DE MEXICO S.A. DE C.V.', 'PERFO2013', null, 'SAXON ENERGY SERVICES DE MEXICO S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3257');
INSERT INTO `he_empresas` VALUES ('104', 'SERVICIOS LABIN MEXICO SA DE CV', 'SERVICIOS(Q2)', null, 'SERVICIOS LABIN MEXICO SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3260');
INSERT INTO `he_empresas` VALUES ('105', 'GRUPO SEGURITECH PRIVADA, SOCIEDAD ANONIMA PROMOTORA DE INVERSION DE CAPITAL VARIABLE', 'PRIVADA(Q)', null, 'GRUPO SEGURITECH PRIVADA, SOCIEDAD ANONIMA PROMOTORA DE INVERSION DE CAPITAL VARIABLE', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3265');
INSERT INTO `he_empresas` VALUES ('106', 'OFICINA DEL VALLE NORTE 2007, S.A. DE C.V.', 'TECNOCASA(Q)', null, 'OFICINA DEL VALLE NORTE 2007, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3271');
INSERT INTO `he_empresas` VALUES ('107', 'CASA CUERVO MEXICO, S.A. DE C.V.', 'JOSECUERVO(Q)', null, 'CASA CUERVO MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3277');
INSERT INTO `he_empresas` VALUES ('108', 'GRUPO SANTRO, S. DE R.L. DE C.V.', 'BLACKHORSE(Q)', null, 'GRUPO SANTRO, S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3279');
INSERT INTO `he_empresas` VALUES ('109', 'ALTA MODELOS PRODUCTIVOS EN MOVIMIENTO S A P I DE C.V.', 'MODELOS(Q)', null, 'ALTA MODELOS PRODUCTIVOS EN MOVIMIENTO S A P I DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3284');
INSERT INTO `he_empresas` VALUES ('110', 'AUTOMATIZACION DE SERVICIOS PRODUCTIVOS SA DE CV', 'AUTOMATIZACION(Q)', null, 'AUTOMATIZACION DE SERVICIOS PRODUCTIVOS SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3285');
INSERT INTO `he_empresas` VALUES ('111', 'PRODUCTOS DE ACERO Y SERVICIOS S.A. DE C.V.', 'IPASA(Q)', null, 'PRODUCTOS DE ACERO Y SERVICIOS S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3287');
INSERT INTO `he_empresas` VALUES ('112', 'AUTOMATIZACION DE SERVICIOS PRODUCTIVOS SA DE CV, TELEFONIA', 'AUTOMATIZACIONTEL(Q)', null, 'AUTOMATIZACION DE SERVICIOS PRODUCTIVOS SA DE CV, TELEFONIA', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3288');
INSERT INTO `he_empresas` VALUES ('113', 'ALTA SERVICIOS FINANCIEROS SA DE CV SFP', 'BENEFICIOS(Q)', null, 'ALTA SERVICIOS FINANCIEROS SA DE CV SFP', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3289');
INSERT INTO `he_empresas` VALUES ('114', 'ALTA TELECOM, S.A. C.V.', 'ALTATELECOM(Q)', null, 'ALTA TELECOM, S.A. C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3291');
INSERT INTO `he_empresas` VALUES ('115', 'OFICINA REFORMA IZTACCIHUATL 2012, S.A. DE C.V.', 'OFICINA(Q)', null, 'OFICINA REFORMA IZTACCIHUATL 2012, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3292');
INSERT INTO `he_empresas` VALUES ('116', 'ITW WELDING SERVICIOS MEXICO S DE RL DE CV', 'ITW(S)', null, 'ITW WELDING SERVICIOS MEXICO S DE RL DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3296');
INSERT INTO `he_empresas` VALUES ('117', 'TEKSPAN DE MEXICO S.A DE C.V', 'TEKSPAN(Q)', null, 'TEKSPAN DE MEXICO S.A DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3299');
INSERT INTO `he_empresas` VALUES ('118', 'JIMENEZ BELINCHÓN, S.A.', 'JIMENEZ(Q)', null, 'JIMENEZ BELINCHÓN, S.A.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3300');
INSERT INTO `he_empresas` VALUES ('119', 'BRITISH AMERICAN TOBACCO MÉXICO DISTRIBUCIONES, S.A DE C.V', 'BRITISH(Q)', null, 'BRITISH AMERICAN TOBACCO MÉXICO DISTRIBUCIONES, S.A DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3306');
INSERT INTO `he_empresas` VALUES ('120', 'FISOS (9 INGENIOS DIFERENTES)', 'FISOS(M)', null, 'FISOS (9 INGENIOS DIFERENTES)', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3307');
INSERT INTO `he_empresas` VALUES ('121', 'EDEVALLE, S.A. DE C.V.', 'EDEVALLE(Q)', null, 'EDEVALLE, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3308');
INSERT INTO `he_empresas` VALUES ('122', 'OFICINA GENERAL ANAYA, S.A. DE C.V.\n', 'GENERAL(Q)', null, 'OFICINA GENERAL ANAYA, S.A. DE C.V.\n', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3309');
INSERT INTO `he_empresas` VALUES ('123', 'FRANQUICIATARIO DEL VALLE CENTRO 2009, S.A. DE C.V.', 'FRANQUICIATARIO(Q)', null, 'FRANQUICIATARIO DEL VALLE CENTRO 2009, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3310');
INSERT INTO `he_empresas` VALUES ('124', 'DESARROLLO LETRÁN VALLE 2007, S.A. DE C.V.', 'DESARROLLO(Q)', null, 'DESARROLLO LETRÁN VALLE 2007, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3311');
INSERT INTO `he_empresas` VALUES ('125', 'INDORAMA VENTURES SERVICIOS CORPORATIVOS S. DE R.L. DE C.V.', 'INDORAMA(Q)', null, 'INDORAMA VENTURES SERVICIOS CORPORATIVOS S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3314');
INSERT INTO `he_empresas` VALUES ('126', 'INDORAMA VENTURES POLYCOM S DE RL DE CV', 'INDORAMA(Q2)', null, 'INDORAMA VENTURES POLYCOM S DE RL DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3315');
INSERT INTO `he_empresas` VALUES ('127', 'HUAWEI TECHNOLOGIES DE MEXICO S.A. DE C.V.', 'HUAWEIV(Q)', null, 'HUAWEI TECHNOLOGIES DE MEXICO S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3320');
INSERT INTO `he_empresas` VALUES ('128', 'INVERSIONES ACCIONARIAS LANDUS S.A. DE C.V.', 'INVERSIONES(S)', null, 'INVERSIONES ACCIONARIAS LANDUS S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3323');
INSERT INTO `he_empresas` VALUES ('129', 'EPAGO.COM SA DE CV', 'EPAGO.COM(Q)', null, 'EPAGO.COM SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3324');
INSERT INTO `he_empresas` VALUES ('130', 'DEINMEX, S.A. DE C.V.', 'DEINMEX(Q)', null, 'DEINMEX, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3325');
INSERT INTO `he_empresas` VALUES ('131', 'MATC SERVICIOS S. DE R.L. DE C.V.', 'MATC(Q)', null, 'MATC SERVICIOS S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3327');
INSERT INTO `he_empresas` VALUES ('132', 'TP ORTHODONTICS MEXICO S DE RL SE CV', 'TP(Q)', null, 'TP ORTHODONTICS MEXICO S DE RL SE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3330');
INSERT INTO `he_empresas` VALUES ('133', 'DIGITAL SOLUTIONS AMERICAS, S. DE R.L. DE C.V.', 'DIGITAL(Q)', null, 'DIGITAL SOLUTIONS AMERICAS, S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3332');
INSERT INTO `he_empresas` VALUES ('134', 'INDUSTRIAS FRIGORÍFICAS S.A DE C.V. INFRISA', 'HUSSMANN(Q)', null, 'INDUSTRIAS FRIGORÍFICAS S.A DE C.V. INFRISA', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3335');
INSERT INTO `he_empresas` VALUES ('135', 'CHINA STEEL GLOBAL TRADING CORPORATIÓN', 'CHINA(Q)', null, 'CHINA STEEL GLOBAL TRADING CORPORATIÓN', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3340');
INSERT INTO `he_empresas` VALUES ('136', 'TORMATO, S.A. DE C.V.', 'TORMATO(Q)', null, 'TORMATO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3341');
INSERT INTO `he_empresas` VALUES ('137', 'FERRO MEXICANA S.A DE C.V.', 'FERRO(Q)', null, 'FERRO MEXICANA S.A DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3345');
INSERT INTO `he_empresas` VALUES ('138', 'MICHAEL PAGE INTERNACIONAL MEXICO SERVICIOS CORPORATIVOS SA DE CV', 'MICHAEL(Q)', null, 'MICHAEL PAGE INTERNACIONAL MEXICO SERVICIOS CORPORATIVOS SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3349');
INSERT INTO `he_empresas` VALUES ('139', 'ASOCIACION MEXICANA DE ESTANDARES PARA EL COMERCIO ELECTRONICO A.C.', 'ESTANDARES(Q)', null, 'ASOCIACION MEXICANA DE ESTANDARES PARA EL COMERCIO ELECTRONICO A.C.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3352');
INSERT INTO `he_empresas` VALUES ('140', 'COMBUSTIBLES ECOLOGICOS MEXICANOS SA DE CV', 'GAZEL(Q)', null, 'COMBUSTIBLES ECOLOGICOS MEXICANOS SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3353');
INSERT INTO `he_empresas` VALUES ('141', 'NOEMI FLORES GUARNEROS', 'NOEMI(Q)', null, 'NOEMI FLORES GUARNEROS', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3354');
INSERT INTO `he_empresas` VALUES ('142', 'WALDO´S DÓLAR MART DE MEXICO, S DE R.L. DE C.V.', 'WALDOS(S)', null, 'WALDO´S DÓLAR MART DE MEXICO, S DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3356');
INSERT INTO `he_empresas` VALUES ('143', 'SCA SCHUCKER DE MEXICO S.A DE C.V.', 'SCA(Q)', null, 'SCA SCHUCKER DE MEXICO S.A DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3358');
INSERT INTO `he_empresas` VALUES ('144', 'COMERCIALIZADORA KELLY S.A. DE C.V.', 'TAMOE(Q)', null, 'COMERCIALIZADORA KELLY S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3359');
INSERT INTO `he_empresas` VALUES ('145', 'SEALED AIR DE MEXICO OPERATION S DE RL DE CV', 'SEALED(Q)', null, 'SEALED AIR DE MEXICO OPERATION S DE RL DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3361');
INSERT INTO `he_empresas` VALUES ('146', 'KRAUSE MANAGEMENT SERVICES DE MÉXICO, S. DE R.L. DE C.V.', 'KRAUSE(Q)', null, 'KRAUSE MANAGEMENT SERVICES DE MÉXICO, S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3362');
INSERT INTO `he_empresas` VALUES ('147', 'UNIDAD DE SERVICIOS COMPARTIDOS GIGANTE S.A. DE C.V.', 'GIGANTE(Q)', null, 'UNIDAD DE SERVICIOS COMPARTIDOS GIGANTE S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3363');
INSERT INTO `he_empresas` VALUES ('148', 'EMPRESAS GB SA DE CV', 'EMPRESASGB(S)', null, 'EMPRESAS GB SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3365');
INSERT INTO `he_empresas` VALUES ('149', 'NOVATECLEON S.A. DE C.V.', 'NOVATECLEON(S)', null, 'NOVATECLEON S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3366');
INSERT INTO `he_empresas` VALUES ('150', 'COMERCIAL RECICLADORA, S.A DE C.V.', 'RECICLADORA(S)', null, 'COMERCIAL RECICLADORA, S.A DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3367');
INSERT INTO `he_empresas` VALUES ('151', 'SOLUCIONES INTEGRALES EN LOGISTICA LV S DE RL DE CV', 'LORVA(S)', null, 'SOLUCIONES INTEGRALES EN LOGISTICA LV S DE RL DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3369');
INSERT INTO `he_empresas` VALUES ('152', 'AMCOR PLASTIC CONTINERS DE MEXICO SA DE CV', 'AMCOR(Q)', null, 'AMCOR PLASTIC CONTINERS DE MEXICO SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3373');
INSERT INTO `he_empresas` VALUES ('153', 'ORGANISMO PUBLICO DESCENTRALIZADO COMISION DE INFRAESTRUCTURA', 'CICAEG(Q)', null, 'ORGANISMO PUBLICO DESCENTRALIZADO COMISION DE INFRAESTRUCTURA', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3374');
INSERT INTO `he_empresas` VALUES ('154', 'ETISIGN SA DE CV', 'ETISIGN(S)', null, 'ETISIGN SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3375');
INSERT INTO `he_empresas` VALUES ('155', 'SEGURITECH PRIVADA SA DE CV', 'SGTECH(S)', null, 'SEGURITECH PRIVADA SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3377');
INSERT INTO `he_empresas` VALUES ('156', 'ASESORES Y PROVEEDORES EN INSTRUMENTACION SA DE CV', 'ASYPSA(Q)', null, 'ASESORES Y PROVEEDORES EN INSTRUMENTACION SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3378');
INSERT INTO `he_empresas` VALUES ('157', 'ASTRID RUBY RENDON ALARCON', 'PROMEZCLA(S)', null, 'ASTRID RUBY RENDON ALARCON', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3379');
INSERT INTO `he_empresas` VALUES ('158', 'DESARROLLO CIUDAD JARDIN SA DE CV', 'JARDIN(Q)', null, 'DESARROLLO CIUDAD JARDIN SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3382');
INSERT INTO `he_empresas` VALUES ('159', 'ERMENEGILDO ZEGNA, S.A. DE C.V.', 'ZEGNA(Q)', null, 'ERMENEGILDO ZEGNA, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3384');
INSERT INTO `he_empresas` VALUES ('160', 'PETRO PAC, S.DE R.L. DE C.V.', 'PETROPAC(S)', null, 'PETRO PAC, S.DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3385');
INSERT INTO `he_empresas` VALUES ('161', 'NSK SERVICIOS DE MÉXICO S.A. DE C.V.', 'NSK(Q)', null, 'NSK SERVICIOS DE MÉXICO S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3386');
INSERT INTO `he_empresas` VALUES ('162', 'SEARCH DIFERENCE, S.A. DE C.V', 'SEARCH(Q)', null, 'SEARCH DIFERENCE, S.A. DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3387');
INSERT INTO `he_empresas` VALUES ('163', 'EXTRASER S.A. DE C.V.', 'EXTRASER(Q)', null, 'EXTRASER S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3388');
INSERT INTO `he_empresas` VALUES ('164', 'PLAZA INSURGENTES SUR, S.A. DE C.V.', 'NAFINSA(C)', null, 'PLAZA INSURGENTES SUR, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3389');
INSERT INTO `he_empresas` VALUES ('165', 'NOVATECLEON S.A. DE C.V.', 'NOVATECLEON(Q)', null, 'NOVATECLEON S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3390');
INSERT INTO `he_empresas` VALUES ('166', 'HILOGISTICS MEXICO, S.A. DE C.V.', 'HILOGISTICS(Q)', null, 'HILOGISTICS MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3393');
INSERT INTO `he_empresas` VALUES ('167', 'YATA PRODUCTS DE MEXICO, S.A. DE V.', 'YATA(Q)', null, 'YATA PRODUCTS DE MEXICO, S.A. DE V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3396');
INSERT INTO `he_empresas` VALUES ('168', 'THE SWATCH GROUP MÉXICO S.A. DE C.V.', 'SWATCH(Q)', null, 'THE SWATCH GROUP MÉXICO S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3397');
INSERT INTO `he_empresas` VALUES ('169', 'PROTEIN S.A. DE C.V.', 'APOTEX(Q)', null, 'PROTEIN S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3398');
INSERT INTO `he_empresas` VALUES ('170', 'B&D GLOBAL TRADE MONITORING RESOURCES, S.A. DE C.V.', 'FREIGHTWATCH(Q)', null, 'B&D GLOBAL TRADE MONITORING RESOURCES, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3403');
INSERT INTO `he_empresas` VALUES ('171', 'CHANGYOU.COM HK LIMITED', 'CHANGYOU(Q)', null, 'CHANGYOU.COM HK LIMITED', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3404');
INSERT INTO `he_empresas` VALUES ('172', 'ALEXION PHARMA MEXICO, S.A. DE C.V.', 'ALEXION(M)', null, 'ALEXION PHARMA MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3409');
INSERT INTO `he_empresas` VALUES ('173', 'BANCO DE MÉXICO', 'BANXICO(Q)', null, 'BANCO DE MÉXICO', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3410');
INSERT INTO `he_empresas` VALUES ('174', 'Y-TEC KEYLEX OPERACIONES MEXICO, S.A. DE C.V.', 'YTEC(S)', null, 'Y-TEC KEYLEX OPERACIONES MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3411');
INSERT INTO `he_empresas` VALUES ('175', 'C&A MEXICO, S. DE R.L.', 'CA(C)', null, 'C&A MEXICO, S. DE R.L.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3412');
INSERT INTO `he_empresas` VALUES ('176', 'IMPORTADOR GRL S.A. DE C.V.', 'IMPORTADOR(C)', null, 'IMPORTADOR GRL S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3413');
INSERT INTO `he_empresas` VALUES ('177', 'ALTA REALIZACION SAPI DE CV', 'REALIZACION(Q)', null, 'ALTA REALIZACION SAPI DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3414');
INSERT INTO `he_empresas` VALUES ('178', 'TRELLEBORG MEXICO CITY S.A. DE C.V.', 'TRELLEBORG(S)', null, 'TRELLEBORG MEXICO CITY S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3415');
INSERT INTO `he_empresas` VALUES ('179', 'FERRAGAMO MEXICO  S DE RL DE CV', 'FERRAGAMO(Q)', null, 'FERRAGAMO MEXICO  S DE RL DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3416');
INSERT INTO `he_empresas` VALUES ('180', 'COMUNICACIÓN SEGURA S.A. DE C.V.', 'COMUNICACION(Q)', null, 'COMUNICACIÓN SEGURA S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3417');
INSERT INTO `he_empresas` VALUES ('181', 'LUCIANO GUTIERREZ SOLIS', 'AQUAMATIC(S)', null, 'LUCIANO GUTIERREZ SOLIS', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3418');
INSERT INTO `he_empresas` VALUES ('182', 'OSCAR ROBERTO RIOS VILLARREAL', 'OSCAR(S)', null, 'OSCAR ROBERTO RIOS VILLARREAL', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3419');
INSERT INTO `he_empresas` VALUES ('183', 'EXTRASER S.A. DE C.V.', 'EXTRASER(S)', null, 'EXTRASER S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3420');
INSERT INTO `he_empresas` VALUES ('184', 'VALLOUREC OIL & GAS MÉXICO S.A. DE C.V', 'VALLOUREC(Q)', null, 'VALLOUREC OIL & GAS MÉXICO S.A. DE C.V', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3421');
INSERT INTO `he_empresas` VALUES ('185', 'CIDECOF S.A DE C.V.', 'CIDECOF(S)', null, 'CIDECOF S.A DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3422');
INSERT INTO `he_empresas` VALUES ('186', 'GLOBIO S.A. DE C.V.', 'GLOBIO(M)', null, 'GLOBIO S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3423');
INSERT INTO `he_empresas` VALUES ('187', 'CIATEQ, A.C. ( QUERETARO )', 'CIATEQHON(M)', null, 'CIATEQ, A.C. ( QUERETARO )', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3424');
INSERT INTO `he_empresas` VALUES ('188', 'CELLMARK PAPER SA DE CV', 'CELLMARK(Q)', null, 'CELLMARK PAPER SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3425');
INSERT INTO `he_empresas` VALUES ('189', 'PAPELERA OPI SA DE CV', 'OPI(S)', null, 'PAPELERA OPI SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3428');
INSERT INTO `he_empresas` VALUES ('190', 'BIOMET MEXICO, S.A. DE C.V.', 'BIOMET(Q)', null, 'BIOMET MEXICO, S.A. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3432');
INSERT INTO `he_empresas` VALUES ('191', 'FALCONI CONSULTORES DE RESULTADOS, S. DE R.L. DE C.V.', 'FALCONI(Q)', null, 'FALCONI CONSULTORES DE RESULTADOS, S. DE R.L. DE C.V.', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3433');
INSERT INTO `he_empresas` VALUES ('192', 'LOGICONTACT S DE RL DE CV', 'LOGICOMER(Q)', null, 'LOGICONTACT S DE RL DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3439');
INSERT INTO `he_empresas` VALUES ('193', 'AMD MAQUINARIA SA DE CV', 'AMD(Q)', null, 'AMD MAQUINARIA SA DE CV', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3442');
INSERT INTO `he_empresas` VALUES ('194', 'RETAIL INKJET SOLUTIONS INC', 'INKJET(Q)', null, 'RETAIL INKJET SOLUTIONS INC', null, 'MX', null, '2015-01-28 12:22:10', '2', '0', '3443');

-- ----------------------------
-- Table structure for he_horas_extra
-- ----------------------------
DROP TABLE IF EXISTS `he_horas_extra`;
CREATE TABLE `he_horas_extra` (
  `id_horas_extra` int(11) NOT NULL AUTO_INCREMENT,
  `id_personal` int(11) NOT NULL,
  `id_empresa` smallint(4) DEFAULT NULL,
  `semana_iso8601` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `horas` time DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_horas_extra`),
  KEY `i_id_usuario` (`id_personal`),
  KEY `i_activo` (`activo`),
  KEY `i_id_personal` (`id_personal`),
  KEY `i_id_empresa` (`id_empresa`),
  KEY `i_semana_iso` (`semana_iso8601`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of he_horas_extra
-- ----------------------------

-- ----------------------------
-- Table structure for he_personal
-- ----------------------------
DROP TABLE IF EXISTS `he_personal`;
CREATE TABLE `he_personal` (
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
  PRIMARY KEY (`id_personal`),
  KEY `i_empresa` (`id_empresa`),
  KEY `i_activo` (`activo`),
  KEY `i_puesto` (`id_empresa`,`puesto`),
  KEY `i_empleado_num` (`empleado_num`),
  KEY `fk_usuario` (`id_usuario`),
  KEY `i_nomina` (`id_nomina`)
) ENGINE=MyISAM AUTO_INCREMENT=299 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of he_personal
-- ----------------------------
INSERT INTO `he_personal` VALUES ('1', 'Root', 'del', 'sistema', '', '', 'oscar.maldonado@isolution.mx', '', 'Root', '0', '1', null, null, '1', '0');
INSERT INTO `he_personal` VALUES ('2', 'Administrador', 'PAE', 'sistema', '', '', 'oscar.maldonado@isolution.mx', '', 'Administrador', '0', '1', null, null, '1', '0');
INSERT INTO `he_personal` VALUES ('3', 'Inplant', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Inplant', '0', '41', null, null, '1', '0');
INSERT INTO `he_personal` VALUES ('4', 'Nivel5', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel5', '0', '41', null, null, '1', '0');
INSERT INTO `he_personal` VALUES ('5', 'Nivel4', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel4', '0', '41', null, null, '1', '0');
INSERT INTO `he_personal` VALUES ('6', 'Nivel3', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel3', '0', '41', null, null, '1', '0');
INSERT INTO `he_personal` VALUES ('7', 'Nivel2', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel2', '0', '41', null, null, '1', '0');
INSERT INTO `he_personal` VALUES ('8', 'Nivel1', 'del', 'cliente', '', '', 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Nivel1', '0', '41', '0000-00-00 00:00:00', null, '1', '0');
INSERT INTO `he_personal` VALUES ('9', 'Empleado', 'del', 'cliente', '', '', 'omaldonadom@gmail.com', 'CHRYSLER SANTA.FE', 'Empleado', '0', '41', '0000-00-00 00:00:00', null, '1', '0');
INSERT INTO `he_personal` VALUES ('10', 'Usuario', 'Global', 'del Cliente', null, null, 'oscar.maldonado@isolution.mx', 'CHRYSLER SANTA.FE', 'Global', '0', '41', null, null, '1', '0');
INSERT INTO `he_personal` VALUES ('11', 'MIGUEL ANGEL', 'GUZMAN', 'MORA', 'GUMM7411123C3', '68907428780', '', 'CHRYSLER SANTA.FE', 'TEC. MEC. AUTOMOTRIZ', '124', '41', '2015-01-28 04:32:23', '1', '1', '1');
INSERT INTO `he_personal` VALUES ('12', 'ZAIRA', 'GARCIA', 'CHAVEZ', 'GACZ7508068X2', '12047500421', '', 'CHRYSLER TOLUCA', 'ENFERMERA', '1061', '41', '2015-01-28 04:32:23', '1', '1', '2');
INSERT INTO `he_personal` VALUES ('13', 'ROSALVA', 'GUTIERREZ', 'BELTRAN', 'GUBR611116TSA', '32816196425', '', 'CHRYSLER SALTILLO', 'ENFERMERA', '391', '41', '2015-01-28 04:32:23', '1', '1', '3');
INSERT INTO `he_personal` VALUES ('14', 'VICTOR HUGO', 'DIAZ', 'PASOS', 'DIPV740203T42', '16087404311', '', 'CHRYSLER TOLUCA', 'MEDICO DE TURNO', '1088', '41', '2015-01-28 04:32:23', '1', '1', '4');
INSERT INTO `he_personal` VALUES ('15', 'OSWALDO', 'ROJAS', 'ARZATE', 'ROAO781010AY4', '18967808579', 'crowora@hotmail.com', 'CHRYSLER TOLUCA', 'MEDICO DE TURNO', '1123', '41', '2015-01-28 04:32:23', '1', '1', '5');
INSERT INTO `he_personal` VALUES ('16', 'LIZETH ANAKAREN', 'CARDENAS', 'LOPEZ', 'CALL890330PC5', '32088939023', 'lizeth_ana@hotmail.com', 'CHRYSLER SALTILLO', 'INGENIERO CVQS', '1057', '41', '2015-01-28 04:32:23', '1', '1', '6');
INSERT INTO `he_personal` VALUES ('17', 'RUBEN', 'ALVAREZ', 'CAMACHO', 'AACR7905228Z5', '96057906875', '', 'CHRYSLER TOLUCA', 'FACILITADOR LABORATORIO CALIBRACION', '432', '41', '2015-01-28 04:32:23', '1', '1', '7');
INSERT INTO `he_personal` VALUES ('18', 'RENE', 'BLANCAS', 'BRAVO', 'BABR7911128J4', '45947902958', 'frwhitewild@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE CALIDAD A PROVEEDORES', '1165', '41', '2015-01-28 04:32:23', '1', '1', '8');
INSERT INTO `he_personal` VALUES ('19', 'CLAUDIA JANETH', 'CASAS', 'GUTIERREZ', 'CAGC870312DRA', '32058749972', 'clajaca12_15@hotmail.com', 'CHRYSLER SALTILLO', 'ENFERMERA', '1162', '41', '2015-01-28 04:32:23', '1', '1', '9');
INSERT INTO `he_personal` VALUES ('20', 'MANUEL', 'URIBE', 'RAMIREZ', 'UIRM570711KN3', '06805700082', 'mu5495@yahoo.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '625', '41', '2015-01-28 04:32:23', '1', '1', '10');
INSERT INTO `he_personal` VALUES ('21', 'PEDRO', 'BUSTAMANTE', 'ALCANTARA', 'BUAP870316FS3', '16108741360', '', 'CHRYSLER TOLUCA', 'INGENIERO DE CALIDAD', '678', '41', '2015-01-28 04:32:23', '1', '1', '11');
INSERT INTO `he_personal` VALUES ('22', 'LESLIE ALOUTTE', 'PEÑA', 'LOZADA', 'PELL780729L74', '03977879604', 'QUERIDALESLIE@HOTMAIL.COM', 'CHRYSLER SANTA.FE', 'COORDINADOR REGULATORIO', '1196', '41', '2015-01-28 04:32:23', '1', '1', '12');
INSERT INTO `he_personal` VALUES ('23', 'MARIA FERNANDA', 'RUIZ', 'TRABOLSI', 'RUTF900530T17', '45139002880', 'fernanda_alil@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE CALIDAD A PROVEEDORES', '1197', '41', '2015-01-28 04:32:23', '1', '1', '13');
INSERT INTO `he_personal` VALUES ('24', 'JORGE ABRAHAM', 'PERDOMO', 'MEJIA', 'PEMJ860913TR1', '16058630472', 'perdomo,japm@gmail.com', 'CHRYSLER TOLUCA', 'MEDICO DE TURNO', '1154', '41', '2015-01-28 04:32:23', '1', '1', '14');
INSERT INTO `he_personal` VALUES ('25', 'LAURA ASALIA', 'FRAGOSO', 'IZQUIERDO', 'FAIL841023EX2', '94118404329', 'laura_asalia@hotmail.com', 'CHRYSLER TOLUCA', 'MEDICO DE TURNO', '1195', '41', '2015-01-28 04:32:23', '1', '1', '15');
INSERT INTO `he_personal` VALUES ('26', 'LILIANA GUADALUPE', 'AGUIRRE', 'HERNANDEZ', 'AUHL8202204J8', '32028225475', 'lilyaguirre02@hotmail.com', 'CHRYSLER SALTILLO', 'ANALISTA DE NOMINA', '1201', '41', '2015-01-28 04:32:23', '1', '1', '16');
INSERT INTO `he_personal` VALUES ('27', 'ANA MIRIAM', 'MAYCOTT', 'VILLARREAL', 'MAVA890711KQA', '32128923177', 'maycott_11@hotmail.com', 'CHRYSLER SALTILLO', 'ANALISTA DE NOMINA', '1205', '41', '2015-01-28 04:32:23', '1', '1', '17');
INSERT INTO `he_personal` VALUES ('28', 'RODRIGO JAVIER', 'MORENO', 'GONZALEZ', 'MOGR9103277K6', '07089102193', 'moreno.gonzalez.rj@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1232', '41', '2015-01-28 04:32:23', '1', '1', '18');
INSERT INTO `he_personal` VALUES ('29', 'DANIEL', 'ALVARADO', 'VARGAS', 'AAVD830702RW6', '01028305165', '', 'CHRYSLER SANTA.FE', 'TECNICO MECANICO AUTOMOTRIZ', '8', '41', '2015-01-28 04:32:23', '1', '1', '19');
INSERT INTO `he_personal` VALUES ('30', 'EDGAR DANIEL', 'RIVERA', 'MARTINEZ', 'RIME7902222X9', '16067909461', '', 'CHRYSLER TOLUCA', 'SUPERVISOR MATERIAL NO', '247', '41', '2015-01-28 04:32:23', '1', '1', '20');
INSERT INTO `he_personal` VALUES ('31', 'JUAN MANUEL', 'AGUILAR', 'GUTIERREZ', 'AUGJ8408184W9', '16078412448', '', 'CHRYSLER TOLUCA', 'ANALISTA', '3', '41', '2015-01-28 04:32:23', '1', '1', '21');
INSERT INTO `he_personal` VALUES ('32', 'EMMANUEL', 'ARZATE', 'RUBIO', 'AARE750108PA9', '07957502920', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '18', '41', '2015-01-28 04:32:23', '1', '1', '22');
INSERT INTO `he_personal` VALUES ('33', 'ROBERTO CARLOS', 'BAEZ', 'MONROY', 'BAMR7911079B2', '68937901467', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '22', '41', '2015-01-28 04:32:23', '1', '1', '23');
INSERT INTO `he_personal` VALUES ('34', 'JESUS', 'CASTILLO', 'HERNANDEZ', 'CAHJ741102PW0', '30917413384', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '51', '41', '2015-01-28 04:32:23', '1', '1', '24');
INSERT INTO `he_personal` VALUES ('35', 'ROSA MARIA', 'FLORES', 'CHAVEZ', 'FOCR5703214W4', '10755738175', '', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '88', '41', '2015-01-28 04:32:23', '1', '1', '25');
INSERT INTO `he_personal` VALUES ('36', 'LEANDRO', 'GURZA', 'MENOCAL', 'GUML790607KU0', '45957914430', '', 'CHRYSLER SANTA.FE', 'TEC. MEC. AUTOMOTRIZ', '122', '41', '2015-01-28 04:32:23', '1', '1', '26');
INSERT INTO `he_personal` VALUES ('37', 'IVONNE', 'HERNANDEZ', 'GONZALEZ', 'HEGI800412CR0', '15978007936', '', 'CHRYSLER SANTA.FE', 'ANALISTA CONTABLE', '131', '41', '2015-01-28 04:32:23', '1', '1', '27');
INSERT INTO `he_personal` VALUES ('38', 'EDGAR', 'LUNA', 'CHAVEZ', 'LUCE670121E51', '17866710894', '', 'CHRYSLER SANTA.FE', 'ANALISTA ADMINISTRATIVO', '163', '41', '2015-01-28 04:32:23', '1', '1', '28');
INSERT INTO `he_personal` VALUES ('39', 'CELEDONIO', 'MARQUEZ', 'RAMIREZ', 'MARC5903048M3', '01765898240', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '167', '41', '2015-01-28 04:32:23', '1', '1', '29');
INSERT INTO `he_personal` VALUES ('40', 'MARIA DEL CARMEN', 'MEZA', 'RAMIREZ', 'MERC640301P69', '06866415117', '', 'CHRYSLER SANTA.FE', 'ESPECIALISTA EN ASUNTOS REGULATORIOS', '187', '41', '2015-01-28 04:32:23', '1', '1', '30');
INSERT INTO `he_personal` VALUES ('41', 'JUAN ANDRES', 'OLIVARES', 'MORENO', 'OIMJ760313GJ5', '11977616199', '', 'CHRYSLER TOLUCA', 'SUPERVISOR', '210', '41', '2015-01-28 04:32:23', '1', '1', '31');
INSERT INTO `he_personal` VALUES ('42', 'VALERIA', 'ROMAN', 'VARGAS', 'ROVV8001204Q6', '16988013492', '', 'CHRYSLER TOLUCA', 'AGENTE DE HELP DESK', '255', '41', '2015-01-28 04:32:23', '1', '1', '32');
INSERT INTO `he_personal` VALUES ('43', 'CRISTINA', 'VALDEZ', 'MARTINEZ', 'VAMC730819MC2', '01927342061', '', 'CHRYSLER TOLUCA', 'AGENTE DE HELP DESK', '300', '41', '2015-01-28 04:32:23', '1', '1', '33');
INSERT INTO `he_personal` VALUES ('44', 'GERARDO', 'VARGAS', 'CASTAÑEDA', 'VACG630419UK7', '11816330036', '', 'CHRYSLER SANTA.FE', 'CHOFER EJECUTIVO', '303', '41', '2015-01-28 04:32:23', '1', '1', '34');
INSERT INTO `he_personal` VALUES ('45', 'JOSE', 'VILLAVICENCIO', 'ALMEIDA', 'VIAJ690323MA4', '16866928084', '', 'CHRYSLER TOLUCA', 'CHOFER EJECUTIVO', '318', '41', '2015-01-28 04:32:23', '1', '1', '35');
INSERT INTO `he_personal` VALUES ('46', 'JOSE MARIO', 'DOMINGUEZ', 'BELTRAN', 'DOBM800228R11', '32088001071', '', 'CHRYSLER SALTILLO', 'MEDICO DE TURNO', '384', '41', '2015-01-28 04:32:23', '1', '1', '36');
INSERT INTO `he_personal` VALUES ('47', 'JOSE LUIS', 'DOMINGUEZ', 'MORALES', 'DOML680112R68', '32896879700', '', 'CHRYSLER SALTILLO', 'ENFERMERO', '386', '41', '2015-01-28 04:32:23', '1', '1', '37');
INSERT INTO `he_personal` VALUES ('48', 'IGNACIO', 'PEÑA', 'SOLCHAGA', 'PESI520928M98', '32765215002', '', 'CHRYSLER SALTILLO', 'COORDINADOR DE SERVICIO MEDICO', '400', '41', '2015-01-28 04:32:23', '1', '1', '38');
INSERT INTO `he_personal` VALUES ('49', 'ANA ROSA', 'PORTILLO', 'ZUGASTI', 'POZA600101KM7', '32946075333', '', 'CHRYSLER SALTILLO', 'COORDINADOR MEDICO', '401', '41', '2015-01-28 04:32:23', '1', '1', '39');
INSERT INTO `he_personal` VALUES ('50', 'MYRNA PAOLA', 'DIAZ', 'HERNANDEZ', 'DIHM810314LK9', '45008106879', '', 'CHRYSLER SANTA.FE', 'COORDINADORA DE CAPACITACION', '648', '41', '2015-01-28 04:32:23', '1', '1', '40');
INSERT INTO `he_personal` VALUES ('51', 'JOSE GUADALUPE', 'GUERRA', 'GARCIA', 'GUGG821113BX9', '43998209415', '', 'CHRYSLER SALTILLO', 'MEDICO DE TURNO', '659', '41', '2015-01-28 04:32:23', '1', '1', '41');
INSERT INTO `he_personal` VALUES ('52', 'LUIS GERARDO', 'GARCIA', 'DAVILA', 'GADL5403131V9', '32825412458', '', 'CHRYSLER SALTILLO', 'MEDICO DE TURNO', '660', '41', '2015-01-28 04:32:23', '1', '1', '42');
INSERT INTO `he_personal` VALUES ('53', 'JOSE DE JESUS', 'OSEGUERA', 'NAVARRO', 'OENJ740625J28', '90957208888', '', 'CHRYSLER SANTA.FE', 'CHOFER EJECUTIVO', '679', '41', '2015-01-28 04:32:23', '1', '1', '43');
INSERT INTO `he_personal` VALUES ('54', 'ELIZABETH', 'CEBALLOS', 'RUIZ', 'CERE7105207I6', '01907156853', '', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '703', '41', '2015-01-28 04:32:23', '1', '1', '44');
INSERT INTO `he_personal` VALUES ('55', 'MARIA DEL CARMEN', 'VALLES', 'ELIZALDE', 'VAEC8105176S5', '11028117031', '', 'CHRYSLER SANTA.FE', 'COORDINADOR DE EXPATRIADOS', '736', '41', '2015-01-28 04:32:23', '1', '1', '45');
INSERT INTO `he_personal` VALUES ('56', 'JULIAN', 'GAMEZ', 'ALVARADO', 'GAAJ670129S62', '32856789675', '', 'CHRYSLER SALTILLO', 'COORDINADOR MEDICO', '774', '41', '2015-01-28 04:32:23', '1', '1', '46');
INSERT INTO `he_personal` VALUES ('57', 'EDUARDO', 'OJEDA', 'ASBUN', 'OEAE8103259Q5', '11998119058', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE PESOS', '776', '41', '2015-01-28 04:32:23', '1', '1', '47');
INSERT INTO `he_personal` VALUES ('58', 'EDGAR', 'RAMIREZ', 'YRIGOYEN', 'RAYE800226T12', '92008026319', '', 'CHRYSLER SANTA.FE', 'TECNICO MECANICO AUTOMOTRIZ', '784', '41', '2015-01-28 04:32:23', '1', '1', '48');
INSERT INTO `he_personal` VALUES ('59', 'ROGELIO', 'GRANADOS', 'FERRUZCA', 'GAFR8409165JA', '16108417177', '', 'CHRYSLER TOLUCA', 'COORDINADOR MEDICO', '794', '41', '2015-01-28 04:32:23', '1', '1', '49');
INSERT INTO `he_personal` VALUES ('60', 'ETIEENE', 'ANGUIANO', 'GUTIERREZ', 'AUGE7508305E7', '60927584106', '', 'CHRYSLER SALTILLO', 'CHOFER EJECUTIVO', '805', '41', '2015-01-28 04:32:23', '1', '1', '50');
INSERT INTO `he_personal` VALUES ('61', 'DAVID', 'OLASCOAGA', 'SANCHEZ', 'OASD880930TMA', '16118813803', '', 'CHRYSLER TOLUCA', 'AUDITOR DINAMICA EXTENDIDA', '863', '41', '2015-01-28 04:32:23', '1', '1', '51');
INSERT INTO `he_personal` VALUES ('62', 'ERIKA', 'PULIDO', 'JUAREZ', 'PUJE860417EQA', '11078613244', '', 'CHRYSLER SANTA.FE', 'TECNICO', '915', '41', '2015-01-28 04:32:23', '1', '1', '52');
INSERT INTO `he_personal` VALUES ('63', 'MONICA SELENE', 'BERNAL', 'ZANABRIA', 'BEZM8406154C5', '16098403732', '', 'CHRYSLER TOLUCA', 'ESPECIALISTA EN SEG. INDUSTRIAL', '921', '41', '2015-01-28 04:32:23', '1', '1', '53');
INSERT INTO `he_personal` VALUES ('64', 'CRISTIAN OMAR', 'MARQUEZ', 'GÓMEZ', 'MAGC790915DN0', '11977939864', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '943', '41', '2015-01-28 04:32:23', '1', '1', '54');
INSERT INTO `he_personal` VALUES ('65', 'JAVIER FABIAN', 'MEDRANO', 'MARTINEZ', 'MEMJ760818PL8', '32977614521', '', 'CHRYSLER SALTILLO', 'AUDITOR DE CALIDAD', '980', '41', '2015-01-28 04:32:23', '1', '1', '55');
INSERT INTO `he_personal` VALUES ('66', 'VICTOR MANUEL', 'CEPEDA', 'CARRIZALES', 'CECV8308086S6', '32018370414', '', 'CHRYSLER SALTILLO', 'AUDITOR DE CALIDAD', '981', '41', '2015-01-28 04:32:23', '1', '1', '56');
INSERT INTO `he_personal` VALUES ('67', 'JUAN FERNANDO', 'ALANIZ', 'RUBIO', 'AARJ8305309K1', '35008304582', '', 'CHRYSLER SALTILLO', 'ENFERMERO', '998', '41', '2015-01-28 04:32:23', '1', '1', '57');
INSERT INTO `he_personal` VALUES ('68', 'BLANCA ELIZABETH', 'PEREZ', 'VAZQUEZ', 'PEVB781223JX4', '32967876668', '', 'CHRYSLER SALTILLO', 'ENFERMERO', '1005', '41', '2015-01-28 04:32:23', '1', '1', '58');
INSERT INTO `he_personal` VALUES ('69', 'MARCO ANTONIO', 'LARA', 'FIGUEROA', 'LAFM740913GH8', '45917455722', '', 'CHRYSLER SANTA.FE', 'CHOFER EJECUTIVO', '1007', '41', '2015-01-28 04:32:23', '1', '1', '59');
INSERT INTO `he_personal` VALUES ('70', 'ADRIANA', 'MEJIA', 'GARCIA', 'MEGA800518H20', '81078001328', '', 'CHRYSLER TOLUCA', 'COORDINADOR MEDICO', '1010', '41', '2015-01-28 04:32:23', '1', '1', '60');
INSERT INTO `he_personal` VALUES ('71', 'JOSE FAUSTO', 'ESCALONA', 'MONTIEL', 'EAMF730418S9A', '32937380262', '', 'CHRYSLER SANTA.FE', 'CHOFER EJECUTIVO', '1013', '41', '2015-01-28 04:32:23', '1', '1', '61');
INSERT INTO `he_personal` VALUES ('72', 'LUIS GERMAN', 'RAMIREZ', 'BARRON', 'RABL650528629', '64836515722', '', 'CHRYSLER TOLUCA', 'CHOFER EJECUTIVO', '1032', '41', '2015-01-28 04:32:23', '1', '1', '62');
INSERT INTO `he_personal` VALUES ('73', 'FRANCISCO JAVIER', 'PACHUCA', 'VAZQUEZ', 'PAVF710707MBA', '32947175504', '', 'CHRYSLER SALTILLO', 'CHOFER EJECUTIVO', '1040', '41', '2015-01-28 04:32:23', '1', '1', '63');
INSERT INTO `he_personal` VALUES ('74', 'HUGO CESAR', 'CARDENAS', 'TREJO', 'CATH860801I57', '16098602978', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '1050', '41', '2015-01-28 04:32:23', '1', '1', '64');
INSERT INTO `he_personal` VALUES ('75', 'ISRAEL ARTURO', 'GALLO', 'PEÑA', 'GAPI861005QA3', '11078613350', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1078', '41', '2015-01-28 04:32:23', '1', '1', '65');
INSERT INTO `he_personal` VALUES ('76', 'VICTOR HIRAM', 'VALDES', 'GONZALEZ', 'VAGV8811305N8', '32048828670', '', 'CHRYSLER SALTILLO', 'AUDITOR DINAMICA EXTENDIDA', '1066', '41', '2015-01-28 04:32:23', '1', '1', '66');
INSERT INTO `he_personal` VALUES ('77', 'J. ISIDRO REFUGIO', 'SANTOYO', 'HERRERA', 'SAHJ590704FN4', '16795909825', '', 'CHRYSLER SALTILLO', 'LAUNCH PROGRAM MANAGER', '1069', '41', '2015-01-28 04:32:23', '1', '1', '67');
INSERT INTO `he_personal` VALUES ('78', 'JUANA DEL CARMEN', 'REYES', 'MONTES DE OCA', 'REMJ820218MC8', '42978212613', '', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '1074', '41', '2015-01-28 04:32:23', '1', '1', '68');
INSERT INTO `he_personal` VALUES ('79', 'IGNACIO GIOVANNI', 'CEJUDO', 'RAMIREZ', 'CERI771207JQ0', '45067704903', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1080', '41', '2015-01-28 04:32:23', '1', '1', '69');
INSERT INTO `he_personal` VALUES ('80', 'CEZIA BERENICE', 'VILLA', 'JUAREZ', 'VIJC861014CY6', '32038655125', 'cbjv_86@hotmail.com', 'CHRYSLER SALTILLO', 'SUPERVISOR', '1085', '41', '2015-01-28 04:32:23', '1', '1', '70');
INSERT INTO `he_personal` VALUES ('81', 'VERONICA DEL CARMEN', 'ROMO', 'SORIA', 'ROSV7807023G8', '28017800559', 'vero_rs2009@hotmail.com', 'CHRYSLER SANTA.FE', 'TECNICO', '1095', '41', '2015-01-28 04:32:23', '1', '1', '71');
INSERT INTO `he_personal` VALUES ('82', 'JUAN HORACIO', 'CARDENAS', 'VILLALOBOS', 'CAVJ841017K95', '01038403869', 'acm_sports@hotmail.com', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '1108', '41', '2015-01-28 04:32:23', '1', '1', '72');
INSERT INTO `he_personal` VALUES ('83', 'CLAUDIA IVETTE', 'MEDINA', 'VAZQUEZ', 'MEVC830329399', '11088306250', 'claudiamv2903@hotmail.com', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '1114', '41', '2015-01-28 04:32:23', '1', '1', '73');
INSERT INTO `he_personal` VALUES ('84', 'GLADYS VALERIA', 'ALMARAZ', 'CONTRERAS', 'AACG8511279D1', '45088511600', 'glava_85@hotmail.com', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '1144', '41', '2015-01-28 04:32:23', '1', '1', '74');
INSERT INTO `he_personal` VALUES ('85', 'JOSE LUIS', 'COLIN', 'MEJIA', 'COML630121170', '16906302035', 'josecolin1@yahoo.com.mx', 'CHRYSLER SANTA.FE', 'TECNICO', '1147', '41', '2015-01-28 04:32:23', '1', '1', '75');
INSERT INTO `he_personal` VALUES ('86', 'ALEJANDRO', 'JARAMILLO', 'DE LA CRUZ', 'JACA8607107G6', '16048633560', 'alex-dulce-x-siempre@hotmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA CONTABLE', '1158', '41', '2015-01-28 04:32:23', '1', '1', '76');
INSERT INTO `he_personal` VALUES ('87', 'LAURA MATILDE', 'GARCIA', 'ALVAREZ', 'GAAL821226194', '48058218503', 'matilde.garcia@live.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE DISTRIBUCION Y VENTAS FIAT', '1159', '41', '2015-01-28 04:32:23', '1', '1', '77');
INSERT INTO `he_personal` VALUES ('88', 'MOIRA ITZEL', 'DIAZ', 'CASTILLO', 'DICM890210C79', '37128908920', 'moiraid_89@hotmail.com', 'CHRYSLER SANTA.FE', 'ESPECIALISTA EN ESPECIFICACIONES', '1176', '41', '2015-01-28 04:32:23', '1', '1', '78');
INSERT INTO `he_personal` VALUES ('89', 'JORGE', 'SERNA', 'RAMOS', 'SERJ841002QG1', '32038447606', 'jorge_serna_ramos@hotmail.com', 'CHRYSLER SALTILLO', 'QE LAUNCH SUPPORT', '1182', '41', '2015-01-28 04:32:23', '1', '1', '79');
INSERT INTO `he_personal` VALUES ('90', 'JAVIER', 'CALDERON', 'ALMONAZIN', 'CAAJ8704214M5', '37138700770', 'esimeipn8721@hotmail.com', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '1214', '41', '2015-01-28 04:32:23', '1', '1', '80');
INSERT INTO `he_personal` VALUES ('91', 'PABLO FRANCISCO', 'RODRIGUEZ', 'MORALES', 'ROMP9005162S5', '16139008235', 'romopao@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE ESPECIFICACIONES', '1236', '41', '2015-01-28 04:32:23', '1', '1', '81');
INSERT INTO `he_personal` VALUES ('92', 'ANTONIO DE JESUS', 'MORENO', 'CEDILLO', 'MOCA891223PQ9', '90138904900', 'antonio-j-mc@hotmail.com', 'CHRYSLER SANTA.FE', 'TECNICO', '1252', '41', '2015-01-28 04:32:23', '1', '1', '82');
INSERT INTO `he_personal` VALUES ('93', 'CECILIA ABIGAIL', 'AYALA', 'RUBIO', 'AARC900924Q55', '90139007034', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1253', '41', '2015-01-28 04:32:23', '1', '1', '83');
INSERT INTO `he_personal` VALUES ('94', 'JORGE LUIS', 'GONZALEZ', 'VEGA', 'GOVJ890727BM2', '90138906079', 'glezjl@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE CALIDAD A PROVEEDORES', '1265', '41', '2015-01-28 04:32:23', '1', '1', '84');
INSERT INTO `he_personal` VALUES ('95', 'FRANCISCO RAMIRO', 'MEZA', 'MEDINA', 'MEMF871102RH9', '32088715878', 'fm700@chrysler.com', 'CHRYSLER SALTILLO', 'AUDITOR DINAMICA EXTENDIDA', '1135', '41', '2015-01-28 04:32:23', '1', '1', '85');
INSERT INTO `he_personal` VALUES ('96', 'MONICA PATRICIA', 'RODRIGUEZ', 'GILES', 'ROGM850217RX6', '32118506016', 'monyrgiles@hotmail.com', 'CHRYSLER SALTILLO', 'MEDICO DE TURNO', '1266', '41', '2015-01-28 04:32:23', '1', '1', '86');
INSERT INTO `he_personal` VALUES ('97', 'SERGIO ERICK', 'REYES', 'VALENCIA', 'REVS910115IW5', '20079100382', 'asergioreyes@gmail.com', 'CHRYSLER SANTA.FE', 'COORDINADOR DE MARKETING', '1129', '41', '2015-01-28 04:32:23', '1', '1', '87');
INSERT INTO `he_personal` VALUES ('98', 'ARELI ALEJANDRA', 'AGUILERA', 'ALVAREZ', 'AUAA900107QL7', '16119031215', '', 'CHRYSLER SANTA.FE', 'ANALISTA DE CONTABILIDAD E INVENTARIOS', '898', '41', '2015-01-28 04:32:23', '1', '1', '88');
INSERT INTO `he_personal` VALUES ('99', 'HERMELINDA GUADALUPE', 'CEBRIAN', 'BECERRA', 'CEBH791009HN1', '32017901375', 'gcebrian@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE CALIDAD A PROVEEDORES', '1273', '41', '2015-01-28 04:32:23', '1', '1', '89');
INSERT INTO `he_personal` VALUES ('100', 'ARACELI', 'ARAUJO', 'RODRIGUEZ', 'AARA841022A40', '16088409731', 'araujo_ara@yahoo.com', 'CHRYSLER SANTA.FE', 'DIRECT BUYER', '1280', '41', '2015-01-28 04:32:23', '1', '1', '90');
INSERT INTO `he_personal` VALUES ('101', 'YESIKA', 'BENITEZ', 'SALAS', 'BESY8309112K3', '16078303456', 'yesikabenitez_salas@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE CALIDAD A PROVEEDORES', '1282', '41', '2015-01-28 04:32:23', '1', '1', '91');
INSERT INTO `he_personal` VALUES ('102', 'OCTAVIO', 'PRADO', 'AGUIRRE', 'PAAO8912272F1', '32138910693', 'octavio_agui55@hotmail.com', 'CHRYSLER SALTILLO', 'QE LAUNCH SUPPORT', '1284', '41', '2015-01-28 04:32:23', '1', '1', '92');
INSERT INTO `he_personal` VALUES ('103', 'LUIS GERARDO', 'MUNGUIA', 'VEGA', 'MUVL870810864', '45118709844', 'luismunguiav@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1277', '41', '2015-01-28 04:32:23', '1', '1', '93');
INSERT INTO `he_personal` VALUES ('104', 'ANTONIO', 'GONZALEZ', 'GARCIA', 'GOGA890627BMA', '32128918896', 'antonio_glz1989@hotmail.com', 'CHRYSLER SALTILLO', 'AUDITOR DE CALIDAD', '1292', '41', '2015-01-28 04:32:23', '1', '1', '94');
INSERT INTO `he_personal` VALUES ('105', 'ROSELY', 'CAMBEROS', 'RODRIGUEZ', 'CARR850909BXA', '32118500480', 'rosely.camrdz@gmail.com', 'CHRYSLER SALTILLO', 'ANALISTA DE RECURSOS HUMANOS', '1291', '41', '2015-01-28 04:32:23', '1', '1', '95');
INSERT INTO `he_personal` VALUES ('106', 'MIRIAM YAZMIN', 'BERNAL', 'ESCOBAR', 'BEEM880323NL7', '16098814607', 'miryzim2310gmail.com', 'CHRYSLER TOLUCA', 'ENFERMERA', '1287', '41', '2015-01-28 04:32:23', '1', '1', '96');
INSERT INTO `he_personal` VALUES ('107', 'RAUL EZEQUIEL', 'ESPINOSA', 'OROZCO', 'EIOR8902044D3', '32088921344', 'rulo_enfermero@hotmail.com', 'CHRYSLER SALTILLO', 'ENFERMERO', '1289', '41', '2015-01-28 04:32:23', '1', '1', '97');
INSERT INTO `he_personal` VALUES ('108', 'LUIS ALBERTO', 'RAMIREZ', 'ORTIZ', 'RAOL801102KC9', '30998020363', 'lramirezortiz7@gmail.com', 'CHRYSLER SANTA.FE', 'TECNICO MECANICO AUTOMOTRIZ', '1304', '41', '2015-01-28 04:32:23', '1', '1', '98');
INSERT INTO `he_personal` VALUES ('109', 'ANGEL', 'MOLINA', 'ACOSTA', 'MOAA900217FR0', '45099060860', 'angel.molinacosta@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1306', '41', '2015-01-28 04:32:23', '1', '1', '99');
INSERT INTO `he_personal` VALUES ('110', 'MAURICIO', 'GUTIERREZ', 'HERNANDEZ', 'GUHM7710233F3', '16957708213', 'maguhc_@hotmail.com', 'CHRYSLER SANTA.FE', 'CHOFER EJECUTIVO', '1310', '41', '2015-01-28 04:32:23', '1', '1', '100');
INSERT INTO `he_personal` VALUES ('111', 'ANA KAREN', 'MORENO', 'MEDELLIN', 'MOMA890305J85', '92138910887', 'karenmedellin@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1313', '41', '2015-01-28 04:32:23', '1', '1', '101');
INSERT INTO `he_personal` VALUES ('112', 'PATRICIA', 'BECERRIL', 'CORREA', 'BECP640714CL5', '64826424166', 'pabeco1407@yahoo.com.mx', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '1321', '41', '2015-01-28 04:32:23', '1', '1', '102');
INSERT INTO `he_personal` VALUES ('113', 'RAFAEL', 'ESCAMILLA', 'NUÑEZ', 'EANR881106UQ0', '01118803590', 'RFLSCMLL@GMAIL.COM', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1322', '41', '2015-01-28 04:32:23', '1', '1', '103');
INSERT INTO `he_personal` VALUES ('114', 'ROXANA ALEJANDRA', 'MORA', 'DE VALLE', 'MOVR891217UZ5', '32098906624', 'ROXANA17ALE@HOTMAIL.COM', 'CHRYSLER SALTILLO', 'INGENIERO MQAS', '1324', '41', '2015-01-28 04:32:23', '1', '1', '104');
INSERT INTO `he_personal` VALUES ('115', 'JOSE GERMAN', 'VAZQUEZ', 'ALONZO', 'VAAG910529IE3', '32119131376', '', 'CHRYSLER SALTILLO', 'INGENIERO DE CALIDAD', '1326', '41', '2015-01-28 04:32:23', '1', '1', '105');
INSERT INTO `he_personal` VALUES ('116', 'DAFNE', 'GAVIRIA', 'ARCILA', 'GAAD840121UB7', '37018407439', 'dafnega@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1328', '41', '2015-01-28 04:32:23', '1', '1', '106');
INSERT INTO `he_personal` VALUES ('117', 'OMAR ADRIAN', 'OLGUIN', 'TINAJERO', 'OUTO890816H7A', '30138905978', 'adrian.olguin.tin@gmail.com', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '1334', '41', '2015-01-28 04:32:23', '1', '1', '107');
INSERT INTO `he_personal` VALUES ('118', 'ARACELI', 'BRAVO', 'BASURTO', 'BABA851004590', '13058520944', 'nena-ccolva@hotmail.com', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '1339', '41', '2015-01-28 04:32:23', '1', '1', '108');
INSERT INTO `he_personal` VALUES ('119', 'ANA LIZETH', 'MAYA', 'VELAZQUEZ', 'MAVA861202K37', '16138609280', 'analizeth_51@hotmail.com', 'CHRYSLER TOLUCA', 'ENFERMERA', '1337', '41', '2015-01-28 04:32:23', '1', '1', '109');
INSERT INTO `he_personal` VALUES ('120', 'MARIA CONCEPCION', 'HERNANDEZ', 'MARTINEZ', 'HEMC671205I46', '76866700644', 'connyhernandez67@hotmail.com', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '1347', '41', '2015-01-28 04:32:23', '1', '1', '110');
INSERT INTO `he_personal` VALUES ('121', 'SMYRNA VANESSA', 'RIVERA', 'CORTES', 'RICS780502964', '11967825370', 'svrc22@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1350', '41', '2015-01-28 04:32:23', '1', '1', '111');
INSERT INTO `he_personal` VALUES ('122', 'JULIAN EMMANUEL', 'MENA', 'LAZARIN', 'MELJ8412251I0', '32068411217', 'jeml84@hotmail.com', 'CHRYSLER SALTILLO', 'MEDICO DE TURNO', '1355', '41', '2015-01-28 04:32:23', '1', '1', '112');
INSERT INTO `he_personal` VALUES ('123', 'MARIA ALEJANDRA', 'RAMIREZ', 'ALVAREZ', 'RAAA9004263H4', '32139028354', 'aleramirez_303@hotmail.com', 'CHRYSLER SALTILLO', 'INGENIERO MQAS', '1354', '41', '2015-01-28 04:32:23', '1', '1', '113');
INSERT INTO `he_personal` VALUES ('124', 'ERIKA', 'GARZA', 'GARCIA', 'GAGE740624428', '32947483346', 'garzaeri@hotmail.com', 'CHRYSLER SALTILLO', 'ANALISTA DE NOMINA', '1357', '41', '2015-01-28 04:32:23', '1', '1', '114');
INSERT INTO `he_personal` VALUES ('125', 'PEDRO DAVID', 'HERNANDEZ', 'TREJO', 'HETP860513K12', '94068622938', 'htpd86@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO DIMENSIONAL', '1356', '41', '2015-01-28 04:32:23', '1', '1', '115');
INSERT INTO `he_personal` VALUES ('126', 'EDGAR ALEJANDRO', 'PEREZ', 'MARIN', 'PEME890723CP4', '32108917884', 'ing.edgaralejandro@gmail.com', 'CHRYSLER SALTILLO', 'JD POWER AUDITOR', '1193', '41', '2015-01-28 04:32:23', '1', '1', '116');
INSERT INTO `he_personal` VALUES ('127', 'ALBERTO', 'DE DIEGO', 'MARTINEZ', 'DEMA8105258M0', '11138102188', 'alberdiego@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1364', '41', '2015-01-28 04:32:23', '1', '1', '117');
INSERT INTO `he_personal` VALUES ('128', 'ESPERANZA', 'BASTIDA', 'CALLEJAS', 'BACE8501169T1', '11118500062', 'CALLESPERANZA@GMAIL.COM', 'CHRYSLER SANTA.FE', 'ANALISTA DE PROGRAMA DE BECARIOS', '1366', '41', '2015-01-28 04:32:23', '1', '1', '118');
INSERT INTO `he_personal` VALUES ('129', 'ALEJANDRA', 'GONZALEZ', 'DOMENZAIN', 'GODA9205221H2', '37119208249', 'ale.domenzain@hotmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA', '1375', '41', '2015-01-28 04:32:23', '1', '1', '119');
INSERT INTO `he_personal` VALUES ('130', 'PABLO EDGAR', 'CORDOVA', 'HERNANDEZ', 'COHP871104MH6', '32118702359', 'men_00pech@hormail.com', 'CHRYSLER SALTILLO', 'ANALISTA DE LANZAMIENTO Y ESPECIFICACION', '1376', '41', '2015-01-28 04:32:23', '1', '1', '120');
INSERT INTO `he_personal` VALUES ('131', 'NORMA IRAIDA', 'MARTINEZ', 'MARTINEZ', 'MAMN8609144U8', '32068641946', 'iraida_mtz@hotmail.com', 'CHRYSLER SALTILLO', 'INGENIERO MQAS', '1152', '41', '2015-01-28 04:32:23', '1', '1', '121');
INSERT INTO `he_personal` VALUES ('132', 'JESUS', 'VAZQUEZ', 'CABRERA', 'VACJ901114QSA', '32109050487', 'kchuy_k13@hotmail.com', 'CHRYSLER SALTILLO', 'INGENIERO MQAS', '1285', '41', '2015-01-28 04:32:23', '1', '1', '122');
INSERT INTO `he_personal` VALUES ('133', 'MARICELA', 'CORPUS', 'GOMEZ', 'COGM720314UW4', '32037200162', 'corpusmar9@hotmail.com', 'CHRYSLER SALTILLO', 'ENFERMERA', '380', '41', '2015-01-28 04:32:23', '1', '1', '123');
INSERT INTO `he_personal` VALUES ('134', 'MARIA DEL CARMEN', 'TREVIÑO', 'DAVILA', 'TEDC650526LP6', '32866581690', 'MELITA1965@YAHOO.COM.MX', 'CHRYSLER SALTILLO', 'MEDICO DE TURNO', '1382', '41', '2015-01-28 04:32:23', '1', '1', '124');
INSERT INTO `he_personal` VALUES ('135', 'ERNESTO', 'DELGADO', 'CARRILLO', 'DECE5012102J4', '01745056315', 'ernesto.delgado@yahoo.comernesto.delgado@yahoo.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE CALIDAD A PROVEEDORES', '72', '41', '2015-01-28 04:32:23', '1', '1', '125');
INSERT INTO `he_personal` VALUES ('136', 'ANGELICA', 'VELAZQUEZ', 'ESPINOZA', 'VEEA861011B48', '16068614805', '', 'CHRYSLER TOLUCA', 'ANALISTA DE NOMINA', '1383', '41', '2015-01-28 04:32:23', '1', '1', '126');
INSERT INTO `he_personal` VALUES ('137', 'JOSE PABLO', 'SUBEALDEA', 'DE LEON', 'SULP910812SZ2', '32109134539', 'JPASUB@HOTMAIL.COM', 'CHRYSLER SALTILLO', 'QE LAUNCH SUPPORT', '1386', '41', '2015-01-28 04:32:23', '1', '1', '127');
INSERT INTO `he_personal` VALUES ('138', 'LUIS ENRIQUE', 'SUAREZ', 'URIBE', 'SUUL880523U70', '39118815909', 'kikegti.luis@gmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA', '1388', '41', '2015-01-28 04:32:23', '1', '1', '128');
INSERT INTO `he_personal` VALUES ('139', 'LAKSMI ESTRELLA', 'HERNANDEZ', 'MENDIETA', 'HEML8403204M5', '45078426033', 'laks.mystar@gmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA COMPANY CARS', '1389', '41', '2015-01-28 04:32:23', '1', '1', '129');
INSERT INTO `he_personal` VALUES ('140', 'MARIA DE LOURDES', 'FUENTES', 'PUENTE', 'FULP741217213', '45947404369', 'mlourdesf@hotmail.com', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '1390', '41', '2015-01-28 04:32:23', '1', '1', '130');
INSERT INTO `he_personal` VALUES ('141', 'CARLOS EDUARDO', 'BECERRIL', 'BENAVIDES', 'BEBC900723848', '11119006804', 'CARLOSBECERRIL23@HOTMAIL.COM', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '1391', '41', '2015-01-28 04:32:23', '1', '1', '131');
INSERT INTO `he_personal` VALUES ('142', 'JOSE DE JESUS', 'ACEVEDO', 'ESTRADA', 'AEEJ841202E69', '20038421747', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '935', '41', '2015-01-28 04:32:23', '1', '1', '132');
INSERT INTO `he_personal` VALUES ('143', 'JUSTO', 'ALVIRDE', 'VALENCIA', 'AIVJ5808065N3', '16875811537', '', 'CHRYSLER TOLUCA', 'MEDICO EN SALUD OCUPACIONAL', '496', '41', '2015-01-28 04:32:23', '1', '1', '133');
INSERT INTO `he_personal` VALUES ('144', 'CESAR ALBERTO', 'ANGELES', 'DIAZ', 'AEDC761227JZ0', '16087600272', '', 'CHRYSLER TOLUCA', 'MEDICO DE TURNO', '493', '41', '2015-01-28 04:32:23', '1', '1', '134');
INSERT INTO `he_personal` VALUES ('145', 'ALEJANDRO', 'DELGADO', 'TORRES', 'DETA611103MI1', '89806124049', '', 'CHRYSLER SANTA.FE', 'CHOFER EJECUTIVO', '789', '41', '2015-01-28 04:32:23', '1', '1', '135');
INSERT INTO `he_personal` VALUES ('146', 'JOSE ANTONIO', 'BRAVO', 'RAMIREZ', 'BARA820524MH9', '94048214889', '', 'CHRYSLER SANTA.FE', 'TECNICO DE DESARROLLO DE VEHICULOS', '871', '41', '2015-01-28 04:32:23', '1', '1', '136');
INSERT INTO `he_personal` VALUES ('147', 'JUAN ANTONIO', 'CERVANTES', 'ORTEGA', 'CEOJ691226SCA', '32876987135', '', 'CHRYSLER SALTILLO', 'CHOFER EJECUTIVO', '526', '41', '2015-01-28 04:32:23', '1', '1', '137');
INSERT INTO `he_personal` VALUES ('148', 'HECTOR', 'CORTES', 'VILLEDA', 'COVH710205IR8', '39887040499', '', 'CHRYSLER SANTA.FE', 'TECNICO EN MAQUINAS Y HERRAMIENTAS', '66', '41', '2015-01-28 04:32:23', '1', '1', '138');
INSERT INTO `he_personal` VALUES ('149', 'MARIA ANGELICA', 'FABRE', 'RIVERA', 'FARA700627378', '39937007068', '', 'CHRYSLER SANTA.FE', 'ESPECIALISTA EN ESPECIFICACIONES', '86', '41', '2015-01-28 04:32:23', '1', '1', '139');
INSERT INTO `he_personal` VALUES ('150', 'ISRAEL', 'FRAUSTO', 'CASTILLO', 'FACI740124L32', '30987400766', '', 'CHRYSLER SANTA.FE', 'CHOFER EJECUTIVO', '327', '41', '2015-01-28 04:32:23', '1', '1', '140');
INSERT INTO `he_personal` VALUES ('151', 'DANIEL', 'GARCIA', 'LOPEZ', 'GALD72060613A', '01947210710', '', 'CHRYSLER SANTA.FE', 'TEC. MEC. AUTOMOTRIZ', '102', '41', '2015-01-28 04:32:23', '1', '1', '141');
INSERT INTO `he_personal` VALUES ('152', 'CYNTIA', 'GAYTAN', 'RAMIREZ', 'GARC8308146U0', '32118303950', '', 'CHRYSLER SALTILLO', 'JD POWER AUDITOR', '940', '41', '2015-01-28 04:32:23', '1', '1', '142');
INSERT INTO `he_personal` VALUES ('153', 'ALEJANDRA DANIELA', 'HERNANDEZ', 'ROMERO', 'HERA900312FC1', '16109049789', '', 'CHRYSLER SANTA.FE', 'SEGUIDOR ANALISTA FIAT Y ALFA ROMEO', '1036', '41', '2015-01-28 04:32:23', '1', '1', '143');
INSERT INTO `he_personal` VALUES ('154', 'MARICELA DE JESUS', 'GONZALEZ', 'NUÑEZ', 'GONM7602093T1', '60937680829', '', 'CHRYSLER SALTILLO', 'INGENIERO DE CALIDAD', '470', '41', '2015-01-28 04:32:23', '1', '1', '144');
INSERT INTO `he_personal` VALUES ('155', 'SERGIO', 'GUTIERREZ', 'ESTRADA', 'GUES830603SD6', '92018360468', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '123', '41', '2015-01-28 04:32:23', '1', '1', '145');
INSERT INTO `he_personal` VALUES ('156', 'JESUS ENRIQUE', 'HERNANDEZ', 'CARDENAS', 'HECJ831011G76', '37008317424', '', 'CHRYSLER SANTA.FE', 'ANALISTA DE VENTAS', '988', '41', '2015-01-28 04:32:23', '1', '1', '146');
INSERT INTO `he_personal` VALUES ('157', 'KITZE ARMANDO', 'HUERTA', 'ARREGOITIA', 'HUAK8103123F3', '92998145533', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE CONTROL VEHICULAR', '141', '41', '2015-01-28 04:32:23', '1', '1', '147');
INSERT INTO `he_personal` VALUES ('158', 'LUCINO GABRIEL', 'ISLAS', 'SAUCILLO', 'IASL73063086A', '92907322660', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '561', '41', '2015-01-28 04:32:23', '1', '1', '148');
INSERT INTO `he_personal` VALUES ('159', 'LORENA', 'JAVIER', 'PEREZ', 'JAPL801101GK5', '39998011736', '', 'CHRYSLER SANTA.FE', 'ANALISTA CONTABLE', '145', '41', '2015-01-28 04:32:23', '1', '1', '149');
INSERT INTO `he_personal` VALUES ('160', 'SERGIO', 'JUAREZ', 'HERNANDEZ', 'JUHS651009EH0', '06816444886', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '148', '41', '2015-01-28 04:32:23', '1', '1', '150');
INSERT INTO `he_personal` VALUES ('161', 'SHEILA ABIGAIL', 'HERNANDEZ', 'GUTIERREZ', 'HEGS820310BE7', '42978201582', '', 'CHRYSLER SANTA.FE', 'ENFERMERA', '662', '41', '2015-01-28 04:32:23', '1', '1', '151');
INSERT INTO `he_personal` VALUES ('162', 'JOSE LUIS', 'LOPEZ', 'ALDAMA', 'LOAL7211283T4', '03967200175', '', 'CHRYSLER SANTA.FE', 'TEC. MEC. AUTOMOTRIZ', '156', '41', '2015-01-28 04:32:23', '1', '1', '152');
INSERT INTO `he_personal` VALUES ('163', 'PEDRO ALEJANDRO', 'LOPEZ', 'RANGEL', 'LORP810701LI9', '07998108976', '', 'CHRYSLER SALTILLO', 'ENFERMERO', '395', '41', '2015-01-28 04:32:23', '1', '1', '153');
INSERT INTO `he_personal` VALUES ('164', 'JORGE RAFAEL', 'PAGAZA', 'STRAFFON', 'PASJ7410246M9', '68937422704', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '219', '41', '2015-01-28 04:32:23', '1', '1', '154');
INSERT INTO `he_personal` VALUES ('165', 'INGRID FABIOLA', 'PALENCIA', 'ALCOCER', 'PAAI730721FP2', '92907327248', '', 'CHRYSLER SANTA.FE', 'ANALISTA DE GASTOS DE VIAJE', '761', '41', '2015-01-28 04:32:23', '1', '1', '155');
INSERT INTO `he_personal` VALUES ('166', 'JUAN CARLOS', 'PIÑA', 'ORTA', 'PIOJ740522VB7', '20907411563', '', 'CHRYSLER SANTA.FE', 'TECNICO MECANICO AUTOMOTRIZ', '231', '41', '2015-01-28 04:32:23', '1', '1', '156');
INSERT INTO `he_personal` VALUES ('167', 'HERLINDA', 'RAMIREZ', 'SANTAMARIA', 'RASH620520P3A', '64806226102', '', 'CHRYSLER SANTA.FE', 'ENFERMERA', '473', '41', '2015-01-28 04:32:23', '1', '1', '157');
INSERT INTO `he_personal` VALUES ('168', 'LILIANA SARAI', 'RIVERA', 'CRUZ', 'RICL860824H85', '37098603360', '', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '800', '41', '2015-01-28 04:32:23', '1', '1', '158');
INSERT INTO `he_personal` VALUES ('169', 'ALEJANDRA', 'RODRIGUEZ', 'VELAZQUEZ', 'ROVA830804SXA', '39038324131', '', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '1035', '41', '2015-01-28 04:32:23', '1', '1', '159');
INSERT INTO `he_personal` VALUES ('170', 'ALEJANDRA', 'ROSALES', 'COTO', 'ROCA830323568', '37058310733', '', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '1079', '41', '2015-01-28 04:32:23', '1', '1', '160');
INSERT INTO `he_personal` VALUES ('171', 'NELSON HECTOR', 'ROSSANO', 'VALDEZ', 'ROVN760422M5A', '16007606938', '', 'CHRYSLER TOLUCA', 'FACILITADOR LABORATORIO CALIBRACION', '364', '41', '2015-01-28 04:32:23', '1', '1', '161');
INSERT INTO `he_personal` VALUES ('172', 'IGNACIO', 'SANCHEZ', 'MONROY', 'SAMI790710964', '11977924114', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '270', '41', '2015-01-28 04:32:23', '1', '1', '162');
INSERT INTO `he_personal` VALUES ('173', 'JAIRO RAFAEL', 'SOLORZANO', 'AHUMADA', 'SOAJ830103TH6', '01988302046', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '286', '41', '2015-01-28 04:32:23', '1', '1', '163');
INSERT INTO `he_personal` VALUES ('174', 'UBALDO ALEJANDRO', 'TORRES', 'FLORES', 'TOFU821213PB8', '30018230638', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '292', '41', '2015-01-28 04:32:23', '1', '1', '164');
INSERT INTO `he_personal` VALUES ('175', 'CESAR HERIBERTO', 'VARGAS', 'MARTINEZ', 'VAMC770225KW3', '07957712289', '', 'CHRYSLER SANTA.FE', 'TEC. MEC. AUTOMOTRIZ', '305', '41', '2015-01-28 04:32:23', '1', '1', '165');
INSERT INTO `he_personal` VALUES ('176', 'JOSUE REYNALDO', 'VILLEDA', 'RUBIO', 'VIRJ880110NW7', '30068823209', '', 'CHRYSLER SANTA.FE', 'TÉCNICO MECÁNICO', '946', '41', '2015-01-28 04:32:23', '1', '1', '166');
INSERT INTO `he_personal` VALUES ('177', 'ALEJANDRINA', 'MEDINA', 'ORTIZ', 'MEOA8405128G2', '32128401257', 'ginay0512.amo@gmail.com', 'CHRYSLER SALTILLO', 'ENFERMERA', '1394', '41', '2015-01-28 04:32:23', '1', '1', '167');
INSERT INTO `he_personal` VALUES ('178', 'ALBERTO ISAAC', 'VALDEZ', 'HERRERA', 'VAHA861128B89', '32058634778', 'BTO_VH@HOTMAIL.COM', 'CHRYSLER SALTILLO', 'ENFERMERO', '1393', '41', '2015-01-28 04:32:23', '1', '1', '168');
INSERT INTO `he_personal` VALUES ('179', 'PEDRO', 'CARRILLO', 'PEREIRA', 'CAPP880913AVA', '16038802209', '', 'CHRYSLER TOLUCA', 'AUDITOR DINAMICA EXTENDIDA', '1396', '41', '2015-01-28 04:32:23', '1', '1', '169');
INSERT INTO `he_personal` VALUES ('180', 'JOSHUA', 'BAUTISTA', 'AZCARRAGA', 'BAAJ890709L26', '11138907966', '', 'CHRYSLER TOLUCA', 'AUDITOR DINAMICA EXTENDIDA', '1397', '41', '2015-01-28 04:32:23', '1', '1', '170');
INSERT INTO `he_personal` VALUES ('181', 'DIEGO DANIEL', 'PEREZ', 'JIMENEZ', 'PEJD860505HU5', '90098603674', 'DANIEL7473@HOTMAIL.COM', 'CHRYSLER SANTA.FE', 'INGENIERO DE DESARROLLO DE MATERIALES', '1340', '41', '2015-01-28 04:32:23', '1', '1', '171');
INSERT INTO `he_personal` VALUES ('182', 'MARIA DEL CARMEN', 'SERNA', 'MARTINEZ', 'SEMC850204173', '32038524461', 'maria_42rt@hotmail.com', 'CHRYSLER SALTILLO', 'ASISTENTE ADMINISTRATIVA', '1400', '41', '2015-01-28 04:32:23', '1', '1', '172');
INSERT INTO `he_personal` VALUES ('183', 'JUANA MARIA', 'RANGEL', 'RAMIREZ', 'RARJ7607073M5', '32017608087', 'rangel_jm@hotmail.com', 'CHRYSLER SALTILLO', 'MEDICO DE TURNO', '1399', '41', '2015-01-28 04:32:23', '1', '1', '173');
INSERT INTO `he_personal` VALUES ('184', 'ILSE', 'CAMACHO', 'GUTIERREZ', 'CAGI910312279', '16119153753', '', 'CHRYSLER TOLUCA', 'INGENIERO', '1403', '41', '2015-01-28 04:32:23', '1', '1', '174');
INSERT INTO `he_personal` VALUES ('185', 'RICARDO', 'ZENDEJAS', 'FUENTES', 'ZEFR651028U2A', '96906501109', '', 'CHRYSLER TOLUCA', 'INGENIERO', '1405', '41', '2015-01-28 04:32:23', '1', '1', '175');
INSERT INTO `he_personal` VALUES ('186', 'NOE', 'GUTIERREZ', 'ARTEAGA', 'GUAN870723522', '92108710499', '', 'CHRYSLER TOLUCA', 'INGENIERO', '1406', '41', '2015-01-28 04:32:23', '1', '1', '176');
INSERT INTO `he_personal` VALUES ('187', 'ADAN', 'RAMIREZ', 'VAZQUEZ', 'RAVA8609305K8', '16068641618', '', 'CHRYSLER TOLUCA', 'INGENIERO', '1402', '41', '2015-01-28 04:32:23', '1', '1', '177');
INSERT INTO `he_personal` VALUES ('188', 'ARNULFO SALVADOR', 'VALDES', 'DE LEON', 'VALA671127A84', '49916749978', '', 'CHRYSLER SALTILLO', 'TECNICO DE SEGURIDAD', '410', '41', '2015-01-28 04:32:23', '1', '1', '178');
INSERT INTO `he_personal` VALUES ('189', 'ERANDENI', 'JAIME', 'HERNANDEZ', 'JAHE850715SS5', '16108513843', '', 'CHRYSLER TOLUCA', 'INGENIERO', '1404', '41', '2015-01-28 04:32:23', '1', '1', '179');
INSERT INTO `he_personal` VALUES ('190', 'RICARDO', 'VASQUEZ', 'LEYVA', 'VALR8703024R7', '39118705480', 'rivale23@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO EN SISTEMAS DE ENFRIAMIENTO DE MOTOR', '1411', '41', '2015-01-28 04:32:23', '1', '1', '180');
INSERT INTO `he_personal` VALUES ('191', 'RODOLFO FELICIANO', 'FACIO', 'RIVERA', 'FARR900330B9A', '92139011685', 'beautiful-facio@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO EN SISTEMAS DE ENFRIAMIENTO DE MOTOR', '1410', '41', '2015-01-28 04:32:23', '1', '1', '181');
INSERT INTO `he_personal` VALUES ('192', 'LUIS EDUARDO', 'ESCUDERO', 'FRANCO', 'EUFL910314ID7', '03149164083', 'lalo.escudero@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO', '1412', '41', '2015-01-28 04:32:23', '1', '1', '182');
INSERT INTO `he_personal` VALUES ('193', 'RAUL', 'SILVA', 'QUIROZ', 'SIQR841212LKA', '16078406457', 'raul_silva@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE CALIDAD A PROVEEDORES', '1415', '41', '2015-01-28 04:32:23', '1', '1', '183');
INSERT INTO `he_personal` VALUES ('194', 'LUZ MARIA', 'PURECO', 'PIEDRAS', 'PUPL8501137D9', '94078502195', '', 'CHRYSLER SANTA.FE', 'ANALISTA', '1028', '41', '2015-01-28 04:32:23', '1', '1', '184');
INSERT INTO `he_personal` VALUES ('195', 'ESTEFANY', 'VILLA', 'VALLEJO', 'VIVE9010044K7', '16109059770', 'estefany.v.v@hotmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE ESTANDARES', '1414', '41', '2015-01-28 04:32:23', '1', '1', '185');
INSERT INTO `he_personal` VALUES ('196', 'RAFAEL', 'GONZALEZ', 'OROZCO', 'GOOR731003HS9', '32897298272', 'RAFAGONZALEZ73@HOTMAIL.COM', 'CHRYSLER SALTILLO', 'ENFERMERO', '1343', '41', '2015-01-28 04:32:23', '1', '1', '186');
INSERT INTO `he_personal` VALUES ('197', 'MIGUEL', 'CACHOA', 'OCAMPO', 'CAOM971014RB3', '27148913208', 'cachoamiguel@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1418', '41', '2015-01-28 04:32:23', '1', '1', '187');
INSERT INTO `he_personal` VALUES ('198', 'JOSE MARCOS', 'MEDINA', 'HERNANDEZ', 'MEHM511124DC7', '06715102114', '', 'CHRYSLER SANTA.FE', 'ESPECIALISTA EN REPRESENTACION EN EL MERCADO', '181', '41', '2015-01-28 04:32:23', '1', '1', '188');
INSERT INTO `he_personal` VALUES ('199', 'ERIC BENJAMIN', 'FLORAN', 'HERNANDEZ', 'FOHE900712239', '8149008305', 'ebenfloh@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1417', '41', '2015-01-28 04:32:23', '1', '1', '189');
INSERT INTO `he_personal` VALUES ('200', 'MAURICIO ARTURO', 'LEDESMA', 'HUERTA', 'LEHM820618E80', '94068202376', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1076', '41', '2015-01-28 04:32:23', '1', '1', '190');
INSERT INTO `he_personal` VALUES ('201', 'FROYLAN', 'HERNANDEZ', 'ANICETO', 'HEAF850425N82', '45008500378', 'froylan85@hotmail.com', 'CHRYSLER SANTA.FE', 'TECNICO DE DESARROLLO DE VEHICULOS', '1092', '41', '2015-01-28 04:32:23', '1', '1', '191');
INSERT INTO `he_personal` VALUES ('202', 'JOSE RAMON', 'CRUZ', 'GARCIA', 'CUGR900321LX4', '37149000111', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1371', '41', '2015-01-28 04:32:23', '1', '1', '192');
INSERT INTO `he_personal` VALUES ('203', 'ILSE DENISE', 'TREVINO', 'LOPE', 'TELI9103266L7', '08149191812', 'denise.trevino.26@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1424', '41', '2015-01-28 04:32:23', '1', '1', '193');
INSERT INTO `he_personal` VALUES ('204', 'ULISES', 'SANCHEZ', 'MORALES', 'SAMU910215IJ9', '08149159942', 'castordentista@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1426', '41', '2015-01-28 04:32:23', '1', '1', '194');
INSERT INTO `he_personal` VALUES ('205', 'DIANA', 'LUGO', 'PINON', 'LUPD910914HS8', '08149148697', 'diana.lugo.pi@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO', '1427', '41', '2015-01-28 04:32:23', '1', '1', '195');
INSERT INTO `he_personal` VALUES ('206', 'ILIANA', 'GARCIA', 'CARBAJAL', 'GACI860403GR2', '16038603532', 'igilianagarcia@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE DESARROLLO DE MATERIALES', '1425', '41', '2015-01-28 04:32:23', '1', '1', '196');
INSERT INTO `he_personal` VALUES ('207', 'ANTONIO', 'CARBALLIDO', 'LOZANO', 'CALA8701224MA', '75068734047', 'acarballido87@gmail.com', 'CHRYSLER SANTA.FE', 'COORDINADOR DE ATRACCION DE TALENTO', '1428', '41', '2015-01-28 04:32:23', '1', '1', '197');
INSERT INTO `he_personal` VALUES ('208', 'ALEJANDRO', 'VAZQUEZ', 'BRIONES', 'VABA880402S10', '32108822522', 'ato_vazquez@hotmail.com', 'CHRYSLER SALTILLO', 'ENFERMERO', '1429', '41', '2015-01-28 04:32:23', '1', '1', '198');
INSERT INTO `he_personal` VALUES ('209', 'JOSE GUADALUPE', 'VARGAS', 'VAZQUEZ', 'VAVG900902TB6', '32089036100', 'josevargas183@gmail.com', 'CHRYSLER SALTILLO', 'ENFERMERO', '1430', '41', '2015-01-28 04:32:23', '1', '1', '199');
INSERT INTO `he_personal` VALUES ('210', 'ARTURO', 'ALARCON', 'HERNANDEZ', 'AAHA780911H2A', '32997827459', '', 'CHRYSLER TOLUCA', 'MEDICO DE TURNO', '1433', '41', '2015-01-28 04:32:23', '1', '1', '200');
INSERT INTO `he_personal` VALUES ('211', 'MARLENNE BRENDA', 'REA', 'ESQUIVEL', 'REEM800803KU6', '18958035059', '', 'CHRYSLER TOLUCA', 'SUPERVISOR', '1434', '41', '2015-01-28 04:32:23', '1', '1', '201');
INSERT INTO `he_personal` VALUES ('212', 'CRISTHIAN', 'MALDONADO', 'QUIROZ', 'MAQC8903155L0', '27148908521', 'cmaldonadoq@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1421', '41', '2015-01-28 04:32:23', '1', '1', '202');
INSERT INTO `he_personal` VALUES ('213', 'CARMEN FERNANDA', 'FLORES', 'ALEJANDRE', 'FOAC900115KY1', '42109008401', 'fernandaalejandre@hotmail.com', 'CHRYSLER SANTA.FE', 'COORDINADOR DE CAPACITACION', '1432', '41', '2015-01-28 04:32:23', '1', '1', '203');
INSERT INTO `he_personal` VALUES ('214', 'CRISOFORO ARTURO', 'ROJAS', 'BLACIO', 'ROBC710717HW9', '18877118093', 'roblacrisart@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1431', '41', '2015-01-28 04:32:23', '1', '1', '204');
INSERT INTO `he_personal` VALUES ('215', 'IVONNE LUCIA', 'ESPINOZA', 'GONZALEZ', 'EIGI8412155M7', '16058416740', '', 'CHRYSLER TOLUCA', 'CAPACITADOR TECNICO', '1423', '41', '2015-01-28 04:32:23', '1', '1', '205');
INSERT INTO `he_personal` VALUES ('216', 'PERLA ESMERALDA', 'VALDEZ', 'VELAZQUEZ', 'VAVP911217JT2', '32109131543', 'cp_perlavaldez@hotmail.com', 'CHRYSLER SALTILLO', 'MATERIAL LOGISTICS PLANNER', '1436', '41', '2015-01-28 04:32:23', '1', '1', '206');
INSERT INTO `he_personal` VALUES ('217', 'ARMANDO', 'DIAZ', 'VILLEGAS', 'DIVA701206542', '07937001274', 'nigthryderb@gmail.com', 'CHRYSLER SANTA.FE', 'ESPECIALISTA EN ESPECIFICACIONES', '1438', '41', '2015-01-28 04:32:23', '1', '1', '207');
INSERT INTO `he_personal` VALUES ('218', 'ABRAHAM', 'ESPINOZA', 'MIGUEL', 'EIMA840920UL2', '30088402646', 'abraham.espinoza@outlook.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1437', '41', '2015-01-28 04:32:23', '1', '1', '208');
INSERT INTO `he_personal` VALUES ('219', 'AMELIA', 'MONTAÑO', 'GUTIERREZ', 'MOGA730105CE6', '16877307831', 'MONTANOAMELIA@HOTMAIL.COM', 'CHRYSLER SANTA.FE', 'MEDICO CORPORATIVO', '1409', '41', '2015-01-28 04:32:23', '1', '1', '209');
INSERT INTO `he_personal` VALUES ('220', 'ANDREA', 'ARROYO', 'ELIZONDO', 'AOEA901124N66', '32129010685', 'andreaarroyo24@hotmail.com', 'CHRYSLER SALTILLO', 'ASISTENTE ADMINISTRATIVA', '1441', '41', '2015-01-28 04:32:23', '1', '1', '210');
INSERT INTO `he_personal` VALUES ('221', 'RICARDO', 'BAZAN', 'HERNANDEZ', 'BAHR890524V32', '16058907110', '', 'CHRYSLER TOLUCA', 'AGENTE DE HELP DESK', '1440', '41', '2015-01-28 04:32:23', '1', '1', '211');
INSERT INTO `he_personal` VALUES ('222', 'CINTHIA', 'FAST', 'PAEZ', 'FAPC830703K47', '43998372262', '', 'CHRYSLER TOLUCA', 'AGENTE DE HELP DESK', '1439', '41', '2015-01-28 04:32:23', '1', '1', '212');
INSERT INTO `he_personal` VALUES ('223', 'EDGARDO', 'FUENTES', 'GOMEZ', 'FUGE790129M40', '16977962436', '', 'CHRYSLER TOLUCA', 'INGENIERO', '1442', '41', '2015-01-28 04:32:23', '1', '1', '213');
INSERT INTO `he_personal` VALUES ('224', 'IRVING ANTONIO', 'PIZAR', 'MAYEN', 'PIMI920621HB3', '90109217811', 'ipizar@hotmail.com', 'CHRYSLER SANTA.FE', 'TECNICO ALMACENISTA', '1443', '41', '2015-01-28 04:32:23', '1', '1', '214');
INSERT INTO `he_personal` VALUES ('225', 'LILIANA', 'SANCHEZ', 'BRAVO', 'SABL9011034Y7', '03149044608', 'lilianasanchezbravo@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE EMPAQUETAMIENTO', '1444', '41', '2015-01-28 04:32:23', '1', '1', '215');
INSERT INTO `he_personal` VALUES ('226', 'VICTOR HUGO', 'MARTINEZ', 'SOBERANES', 'MASV891113LW5', '16118921515', '', 'CHRYSLER TOLUCA', 'INGENIERO', '1445', '41', '2015-01-28 04:32:23', '1', '1', '216');
INSERT INTO `he_personal` VALUES ('227', 'LAURA', 'ANGULO', 'BALDERAS', 'AUBL800222M6A', '30988019763', 'lau_lab2000@yahoo.com.mx', 'CHRYSLER SANTA.FE', 'ANALISTA DE PROYECTOS', '1455', '41', '2015-01-28 04:32:23', '1', '1', '217');
INSERT INTO `he_personal` VALUES ('228', 'MARISELA', 'ESTRADA', 'TREVINO', 'EATM8101292P3', '32978179896', 'mariselaestrada81@hotmail.com', 'CHRYSLER SALTILLO', 'ANALISTA DE NOMINA', '1462', '41', '2015-01-28 04:32:23', '1', '1', '218');
INSERT INTO `he_personal` VALUES ('229', 'VICTOR MANUEL', 'BRETON', 'VALDEZ', 'BEVV740720FP5', '30927458114', 'vmbreton@gmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE GARANTIAS', '1453', '41', '2015-01-28 04:32:23', '1', '1', '219');
INSERT INTO `he_personal` VALUES ('230', 'TOMAS ABDIAS', 'MARIN', 'GARCIA', 'MAGT870331645', '07118704134', 'thomas@hotmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE INCENTIVOS DE PAGO', '1446', '41', '2015-01-28 04:32:23', '1', '1', '220');
INSERT INTO `he_personal` VALUES ('231', 'ALDO', 'MARTINEZ', 'MENDOZA', 'MAMA781129QD4', '16007804681', 'doal_11@hotmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE MGA', '1447', '41', '2015-01-28 04:32:23', '1', '1', '221');
INSERT INTO `he_personal` VALUES ('232', 'MARIO FERNANDO', 'CORRAL', 'MUNGUIA', 'COMM9104186YA', '16129142960', 'dadfather_55@hotmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE MGA', '1448', '41', '2015-01-28 04:32:23', '1', '1', '222');
INSERT INTO `he_personal` VALUES ('233', 'DULCE KARLA JANNET', 'ARIAS', 'GUILLEN', 'AIGD8004079L2', '39018000768', 'vp95@chrysler.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE INCENTIVOS', '1449', '41', '2015-01-28 04:32:23', '1', '1', '223');
INSERT INTO `he_personal` VALUES ('234', 'CATARINA', 'CASTILLO', 'GARCIA', 'CAGC9108088Q6', '42099111900', 'kattycasgar@hotmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE MGA', '1450', '41', '2015-01-28 04:32:23', '1', '1', '224');
INSERT INTO `he_personal` VALUES ('235', 'SOFIA', 'PEREZ', 'SANCHEZ', 'PESS900213AP2', '37099012405', 'sofiaps.7@gmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE GASTOS FIJOS', '1451', '41', '2015-01-28 04:32:23', '1', '1', '225');
INSERT INTO `he_personal` VALUES ('236', 'ARACELI', 'MONDRAGON', 'BERNABE', 'MOBA651224M58', '92916500082', '', 'CHRYSLER SANTA.FE', 'ANALISTA DE INCENTIVOS', '1452', '41', '2015-01-28 04:32:23', '1', '1', '226');
INSERT INTO `he_personal` VALUES ('237', 'JUAN', 'TINOCO', 'MANRIQUE', 'TIMJ661116DV2', '64856603739', 'juanm16@yahoo.com.mx', 'CHRYSLER SANTA.FE', 'ANALISTA DE GARANTIAS', '1454', '41', '2015-01-28 04:32:23', '1', '1', '227');
INSERT INTO `he_personal` VALUES ('238', 'ABRAHAM', 'GONZALEZ', 'AGUILAR', 'GOAA8212213Y6', '28088200275', 'abraham_glz@hotmail.com', 'CHRYSLER SANTA.FE', 'ESPECIALISTA DE GARANTIAS', '1456', '41', '2015-01-28 04:32:23', '1', '1', '228');
INSERT INTO `he_personal` VALUES ('239', 'LUIS ANGEL', 'GARCIA', 'CASAS', 'GACL870331NZ6', '92138703407', 'red2fourty@hotmail.com', 'CHRYSLER SANTA.FE', 'COORDINADOR DE ATENCION A CLIENTES', '1457', '41', '2015-01-28 04:32:23', '1', '1', '229');
INSERT INTO `he_personal` VALUES ('240', 'ESBEIRE', 'AYLLON', 'TAPIA', 'AOTE840516616', '16068419254', 'esbeireayte@hotmail.com', 'CHRYSLER SANTA.FE', 'COORD DE ESTANDARES DE DISTRIBUIDORAS', '1458', '41', '2015-01-28 04:32:23', '1', '1', '230');
INSERT INTO `he_personal` VALUES ('241', 'NATALIA GABRIEL', 'MARQUEZ', 'BURGOA', 'MABN890624T70', '03148919313', 'addyburgoa@hotmail.com', 'CHRYSLER SANTA.FE', 'ESPECIALISTA DE PROTECCION VEHICULAR', '1459', '41', '2015-01-28 04:32:23', '1', '1', '231');
INSERT INTO `he_personal` VALUES ('242', 'PEDRO', 'ORTIZ', 'REZA', 'OIRP880712TC5', '01058802263', 'peter.or@gmail.com', 'CHRYSLER SANTA.FE', 'ESPECIALISTA EHS', '1460', '41', '2015-01-28 04:32:23', '1', '1', '232');
INSERT INTO `he_personal` VALUES ('243', 'ARMANDO ALLAN', 'GONZALEZ', 'MEDINA', 'GOMA890818E95', '92128911812', 'gringoallan@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO CONTROL DIMENSIONAL', '1461', '41', '2015-01-28 04:32:23', '1', '1', '233');
INSERT INTO `he_personal` VALUES ('244', 'INGRID FRANCELI', 'DEL RAZO', 'LOPEZ', 'RALI870822EY9', '08148770871', '', 'CHRYSLER TOLUCA', 'MEDICO DE TURNO', '1463', '41', '2015-01-28 04:32:23', '1', '1', '234');
INSERT INTO `he_personal` VALUES ('245', 'ANDRES GERARDO', 'GAMIZ', 'VARGAS', 'GAVA830121FM5', '90018344292', 'andres.gamiz@live.com.mx', 'CHRYSLER SANTA.FE', 'ESPECIALISTA EN ESPECIFICACIONES', '1465', '41', '2015-01-28 04:32:23', '1', '1', '235');
INSERT INTO `he_personal` VALUES ('246', 'SERGIO EDUARDO', 'ALEMAN', 'MENDOZA', 'AEMS870930H19', '32058778104', 'a_pasific@hotmail.com', 'CHRYSLER SALTILLO', 'AUDITOR DINAMICA EXTENDIDA', '1132', '41', '2015-01-28 04:32:23', '1', '1', '236');
INSERT INTO `he_personal` VALUES ('247', 'ETNA FATIMA', 'MUNOZ', 'ALANIS', 'MUAE790309GJ5', '71077900737', 'fuerza1804@hotmail.com', 'CHRYSLER SALTILLO', 'MEDICO DE TURNO', '1466', '41', '2015-01-28 04:32:23', '1', '1', '237');
INSERT INTO `he_personal` VALUES ('248', 'JUANA', 'NEYRA', 'VELAZQUEZ', 'NEVJ700715293', '32927077951', 'juamaneyve@gmail.com', 'CHRYSLER SALTILLO', 'ENFERMERA', '1467', '41', '2015-01-28 04:32:23', '1', '1', '238');
INSERT INTO `he_personal` VALUES ('249', 'MAURICIO', 'GUERRA', 'LUZ', 'GULM901114SE4', '37139007522', 'mauricio.guerraluz@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE EMPAQUETAMIENTO', '1469', '41', '2015-01-28 04:32:23', '1', '1', '239');
INSERT INTO `he_personal` VALUES ('250', 'MARIA ISABEL', 'NANDAYAPA', 'JIMENEZ', 'NAJI820728BA1', '45038225368', '', 'CHRYSLER SANTA.FE', 'ASISTENTE ADMINISTRATIVA', '198', '41', '2015-01-28 04:32:23', '1', '1', '240');
INSERT INTO `he_personal` VALUES ('251', 'ELSA ALEJANDRA', 'FERREIRO', 'NUNEZ', 'FENE790424SP9', '39037904248', 'elsalexa@yahoo.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE MERCADOTECNIA DIGITAL', '1468', '41', '2015-01-28 04:32:23', '1', '1', '241');
INSERT INTO `he_personal` VALUES ('252', 'ARTURO', 'GARCIA', 'LEON', 'GALA920525718', '96109234854', 'arturo_garcia_alan@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO CORE ELECTRICAL', '1471', '41', '2015-01-28 04:32:23', '1', '1', '242');
INSERT INTO `he_personal` VALUES ('253', 'OMAR SAID', 'RODRIGUEZ', 'DIEGO', 'RODO890210HY3', '05148920209', 'osr.diego@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1472', '41', '2015-01-28 04:32:23', '1', '1', '243');
INSERT INTO `he_personal` VALUES ('254', 'JOSE EDUARDO', 'NUÑEZ', 'CRUZ', 'NUCE860503634', '11108602027', 'ING.JOSEEDUARDO@GMAIL.COM', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1473', '41', '2015-01-28 04:32:23', '1', '1', '244');
INSERT INTO `he_personal` VALUES ('255', 'DALIA', 'AMAYA', 'LUCIO', 'AALD9002152M2', '32129010933', 'daliia15@hotmail.com', 'CHRYSLER SALTILLO', 'ANALISTA DE CALIDAD', '1470', '41', '2015-01-28 04:32:23', '1', '1', '245');
INSERT INTO `he_personal` VALUES ('256', 'JUAN JOSE', 'GARZA', 'VILLARREAL', 'GAVJ9006152R4', '32089042413', 'juan.garza@gmail.com', 'CHRYSLER SALTILLO', 'INGENIERO MQAS', '1298', '41', '2015-01-28 04:32:23', '1', '1', '246');
INSERT INTO `he_personal` VALUES ('257', 'HECTOR EDUARDO ADRIAN', 'SANTOYO', 'CONTRERAS', 'SACH860307KW9', '32048630084', 'hector10santoyo@gmail.com', 'CHRYSLER SALTILLO', 'MEDICO DE TURNO', '1474', '41', '2015-01-28 04:32:23', '1', '1', '247');
INSERT INTO `he_personal` VALUES ('258', 'GARY', 'BOGUSLAVSKY', 'SAYUN', 'BOSG8807304H5', '90128808525', 'garybogus@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE CHASIS', '1476', '41', '2015-01-28 04:32:23', '1', '1', '248');
INSERT INTO `he_personal` VALUES ('259', 'MIGUEL ANGEL', 'POBLETE', 'JUAREZ', 'POJM8902176L4', '72088917132', '', 'CHRYSLER TOLUCA', 'ANALISTA DE PRESUPUESTO', '1477', '41', '2015-01-28 04:32:23', '1', '1', '249');
INSERT INTO `he_personal` VALUES ('260', 'MARCO ANTONIO', 'MARCOS', 'ORDOÑEZ', 'MAOM8710242I7', '16068736723', '', 'CHRYSLER TOLUCA', 'FACILITADOR LABORATORIO CALIBRACION', '1478', '41', '2015-01-28 04:32:23', '1', '1', '250');
INSERT INTO `he_personal` VALUES ('261', 'AARON', 'ALVAREZ', 'MUNGUIA', 'AAMA790526MA3', '16957901875', '', 'CHRYSLER TOLUCA', 'CHOFER EJECUTIVO', '1475', '41', '2015-01-28 04:32:23', '1', '1', '251');
INSERT INTO `he_personal` VALUES ('262', 'FELIPE DE JESUS', 'ALMANZA', 'HERNANDEZ', 'AAHF6802051VA', '32866883609', 'felm68@hotmail.com', 'CHRYSLER SALTILLO', 'TECNICO DE SEGURIDAD', '1348', '41', '2015-01-28 04:32:23', '1', '1', '252');
INSERT INTO `he_personal` VALUES ('263', 'ARELI', 'GARCIA', 'AMAYA', 'GAAA750501C55', '28977500322', 'ARELIGAG@HOTMAIL.COM', 'CHRYSLER SANTA.FE', 'COORDINADOR DE CAPACITACION', '1479', '41', '2015-01-28 04:32:23', '1', '1', '253');
INSERT INTO `he_personal` VALUES ('264', 'MARIA GABRIELA', 'FUENTES', 'ZUÑIGA', 'FUZG920101JG1', '10149244641', 'gabyfzuniga@gmail.com', 'CHRYSLER SALTILLO', 'INGENIERO MQAS', '1480', '41', '2015-01-28 04:32:23', '1', '1', '254');
INSERT INTO `he_personal` VALUES ('265', 'TANIA', 'HERNANDEZ', 'ALVAREZ', 'HEAT911210TS7', '32089125648', 'tania.hdz.alvarez@gmail.com', 'CHRYSLER SALTILLO', 'INGENIERO MQAS', '1481', '41', '2015-01-28 04:32:23', '1', '1', '255');
INSERT INTO `he_personal` VALUES ('266', 'ISAAC', 'MEZA', 'BELTRAN', 'MEBI771002G68', '62957720717', '', 'CHRYSLER TOLUCA', 'MEDICO DE TURNO', '1482', '41', '2015-01-28 04:32:23', '1', '1', '256');
INSERT INTO `he_personal` VALUES ('267', 'GERARDO ANTONIO', 'HERNANDEZ', 'MARTINEZ', 'HEMG880306MN8', '16108833092', 'g.antonio.hm63@gmail.com', 'CHRYSLER TOLUCA', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1486', '41', '2015-01-28 04:32:23', '1', '1', '257');
INSERT INTO `he_personal` VALUES ('268', 'JOHNATAN ALBERTO', 'BERLANGA', 'HERNANDEZ', 'BEHJ880628D3A', '32088831667', 'jbhdz@outlook.com', 'CHRYSLER SALTILLO', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1797', '41', '2015-01-28 04:32:23', '1', '1', '258');
INSERT INTO `he_personal` VALUES ('269', 'EDUARDO', 'LADRON DE GUEVARA', 'VELAZQUEZ', 'LAVE8503255Z9', '37088511227', 'lalo_boss@yahoo.com', 'CHRYSLER TOLUCA', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1488', '41', '2015-01-28 04:32:23', '1', '1', '259');
INSERT INTO `he_personal` VALUES ('270', 'LAYLA', 'CARRUM', 'URIBE', 'CAUL801005424', '60978089575', 'laylacarrum@hotmail.com', 'CHRYSLER SALTILLO', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1798', '41', '2015-01-28 04:32:23', '1', '1', '260');
INSERT INTO `he_personal` VALUES ('271', 'HUMBERTO JAVIER', 'MONTOYA', 'RAMIREZ', 'MORH551029AF3', '01795588035', 'tito_chapu29@hotmail.com', 'CHRYSLER TOLUCA', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1484', '41', '2015-01-28 04:32:23', '1', '1', '261');
INSERT INTO `he_personal` VALUES ('272', 'KARLA ALEJANDRA', 'GARAY', 'AGÜERO', 'GAAK930226UK2', '32089309168', 'KARLA GARAYAGUERO@OUTLOOK.COM', 'CHRYSLER SALTILLO', 'ING PRODUCCION', '1801', '41', '2015-01-28 04:32:23', '1', '1', '262');
INSERT INTO `he_personal` VALUES ('273', 'MARINE', 'FROMENT', '0', 'FOXM850309NX4', '92138502494', 'marinefroment@gmail.com', 'CHRYSLER SANTA.FE', 'COMPRADOR MRO PARA MP', '1492', '41', '2015-01-28 04:32:23', '1', '1', '263');
INSERT INTO `he_personal` VALUES ('274', 'CESAR', 'ALDAMA', 'OROZCO', 'AAOC871003RTA', '16098720051', 'lucas_12_82@hotmail.com', 'CHRYSLER TOLUCA', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1485', '41', '2015-01-28 04:32:23', '1', '1', '264');
INSERT INTO `he_personal` VALUES ('275', 'JUAN GABRIEL', 'SANCHEZ', 'GONZALEZ', 'SAGJ790313M60', '16007914449', 'gabovalesanriv@gmail.com', 'CHRYSLER SANTA.FE', 'ESPECIALISTA DE GARANTIAS', '1489', '41', '2015-01-28 04:32:23', '1', '1', '265');
INSERT INTO `he_personal` VALUES ('276', 'MARLENE', 'GUERRERO', 'OLALDE', 'GUOM8803254D1', '39138803349', 'marolalde@gmail.com', 'CHRYSLER SANTA.FE', 'COMPRADOR MRO PARA MP', '1491', '41', '2015-01-28 04:32:23', '1', '1', '266');
INSERT INTO `he_personal` VALUES ('277', 'DANIELA', 'REYES', 'ANGELES', 'READ8704224C1', '96088701550', 'daniela.r.angeles39@gmail.com', 'CHRYSLER SANTA.FE', 'TECNICO SAP PARA SNEP', '1483', '41', '2015-01-28 04:32:23', '1', '1', '267');
INSERT INTO `he_personal` VALUES ('278', 'JESUS EMMANUEL', 'VALENCIA', 'ROMERO', 'VARJ900726L86', '16109065173', '', 'CHRYSLER SANTA.FE', 'COMPRADOR MRO PARA MP', '1490', '41', '2015-01-28 04:32:23', '1', '1', '268');
INSERT INTO `he_personal` VALUES ('279', 'ANGELICA', 'MACHUCA', 'HERNANDEZ', 'MAHA880712QC1', '92118801288', '', 'CHRYSLER SANTA.FE', 'ESPECIALISTA EN LEARNING & DEVELOPMENT', '1493', '41', '2015-01-28 04:32:23', '1', '1', '269');
INSERT INTO `he_personal` VALUES ('280', 'BLANCA PAOLA', 'RODRIGUEZ', 'ARROYO', 'ROAB911028HN3', '10149179417', 'paola.rdz.28@gmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE INTELIGENCIA DE MERCADO', '1794', '41', '2015-01-28 04:32:23', '1', '1', '270');
INSERT INTO `he_personal` VALUES ('281', 'ALEJANDRO', 'ROMERO', 'VALLE', 'ROVA890424GE0', '16068930979', '', 'CHRYSLER TOLUCA', 'UNIT LEADER', '1795', '41', '2015-01-28 04:32:23', '1', '1', '271');
INSERT INTO `he_personal` VALUES ('282', 'LUIS ALBERTO', 'OLALDE', 'LOPEZ', 'OALL880812227', '16108838109', '', 'CHRYSLER TOLUCA', 'MEDICO DE TURNO', '1796', '41', '2015-01-28 04:32:23', '1', '1', '272');
INSERT INTO `he_personal` VALUES ('283', 'JOSUE', 'LUCIO', 'GARCIA', 'LUGJ830414JJ4', '20088200058', 'jhosuasme@gmail.com', 'CHRYSLER TOLUCA', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1487', '41', '2015-01-28 04:32:23', '1', '1', '273');
INSERT INTO `he_personal` VALUES ('284', 'SERGIO OMAR', 'CRUZ', 'MARTINEZ', 'CUMS9003228T4', '32089001450', 'checo_cm90@hotmail.com', 'CHRYSLER SALTILLO', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1800', '41', '2015-01-28 04:32:23', '1', '1', '274');
INSERT INTO `he_personal` VALUES ('285', 'LUIS ANGEL', 'CRUZ', 'ARREDONDO', 'CUAL910210JD8', '32119153842', 'cruz_me412@hotmail.com', 'CHRYSLER SALTILLO', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1799', '41', '2015-01-28 04:32:23', '1', '1', '275');
INSERT INTO `he_personal` VALUES ('286', 'JOSE GUADALUPE', 'JIMENEZ', 'COVARRUBIAS', 'JICG600718LUA', '32806033802', 'jjimenez12397@gmail.com', 'CHRYSLER SALTILLO', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1802', '41', '2015-01-28 04:32:23', '1', '1', '276');
INSERT INTO `he_personal` VALUES ('287', 'JUAN PABLO', 'NOYOLA', 'BAROCIO', 'NOBJ910610PP7', '32139124518', 'jp.noyola@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO', '1804', '41', '2015-01-28 04:32:23', '1', '1', '277');
INSERT INTO `he_personal` VALUES ('288', 'ALAN', 'SERRANO', 'ESCOBAR', 'SEEA910625NK4', '03149106571', 'aserrano409@gmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO', '1805', '41', '2015-01-28 04:32:23', '1', '1', '278');
INSERT INTO `he_personal` VALUES ('289', 'UBALDO MATEO', 'CALVILLO', 'CERDA', 'CACU8604099Z4', '32108603120', 'ubaldo_mateo@hotmail.com', 'CHRYSLER SALTILLO', 'AUDITOR DE CALIDAD', '1360', '41', '2015-01-28 04:32:23', '1', '1', '279');
INSERT INTO `he_personal` VALUES ('290', 'CAROLINA', 'LIRA', 'ALANIS', 'LIAC6611065L9', '88846609258', 'carolira11@yahoo.com.mx', 'CHRYSLER SANTA.FE', 'INGENIERO DE SOPORTE', '1803', '41', '2015-01-28 04:32:23', '1', '1', '280');
INSERT INTO `he_personal` VALUES ('291', 'DANIEL ALEJANDRO', 'DUARTE', 'CERVANTES', 'DUCD9205251Q6', '11109207271', '', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1806', '41', '2015-01-28 04:32:23', '1', '1', '281');
INSERT INTO `he_personal` VALUES ('292', 'HUGO', 'BERLANGA', 'MONTES', 'BEMH770725B93', '32017708119', '', 'CHRYSLER SALTILLO', 'CHOFER EJECUTIVO', '376', '41', '2015-01-28 04:32:23', '1', '1', '282');
INSERT INTO `he_personal` VALUES ('293', 'JORGE', 'RAMIREZ', 'RUIZ', 'RARJ9108199H0', '03149146890', '', 'CHRYSLER TOLUCA', 'ING. LAYOUTISTA / NX &TEAM CENTER', '1373', '41', '2015-01-28 04:32:23', '1', '1', '283');
INSERT INTO `he_personal` VALUES ('294', 'GLADIS', 'BARRIENTOS', 'LEAL', 'BALG870919FW2', '42118707233', '', 'CHRYSLER SANTA.FE', 'ESPECIALISTA AMBIENTAL', '1808', '41', '2015-01-28 04:32:23', '1', '1', '284');
INSERT INTO `he_personal` VALUES ('295', 'GUILLERMO', 'IBAÑEZ', 'CASTRO', 'IACG8801062A9', '02158819264', 'GUILLERMO.IBANEZ@GMAIL.COM', 'CHRYSLER SANTA.FE', 'ANALISTA DE PROTECION VEHICULAR', '1809', '41', '2015-01-28 04:32:23', '1', '1', '285');
INSERT INTO `he_personal` VALUES ('296', 'ROGELIO IVAN', 'NERI', 'MIJANGOS', 'NEMR910313NUA', '02159146980', 'ivannm@hotmail.com', 'CHRYSLER SANTA.FE', 'INGENIERO DE PRODUCTO', '1810', '41', '2015-01-28 04:32:23', '1', '1', '286');
INSERT INTO `he_personal` VALUES ('297', 'ARIANNA', 'ROCHA', 'VIVENCIO', 'ROVA890922HYA', '09068992776', 'arocha.vicencio@gmail.com', 'CHRYSLER SANTA.FE', 'ANALISTA DE TALENT MANAGMENT', '1807', '41', '2015-01-28 04:32:23', '1', '1', '287');
INSERT INTO `he_personal` VALUES ('298', 'KARINA ALEJANDRA', 'VALDES', 'ESPINOZA', 'VAEK900125PTA', '32109021769', 'karyvaldes_25@hotmail.com', 'CHRYSLER SALTILLO', 'FACILITADOR CVQS', '1133', '41', '2015-01-28 04:32:23', '1', '1', '288');

-- ----------------------------
-- Table structure for he_seguimiento
-- ----------------------------
DROP TABLE IF EXISTS `he_seguimiento`;
CREATE TABLE `he_seguimiento` (
  `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_captura` int(11) DEFAULT NULL,
  `id_empresa` smallint(4) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `id_accion` mediumint(7) DEFAULT NULL,
  `id_estatus` mediumint(7) DEFAULT NULL,
  `doc` varchar(200) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_seguimiento`),
  KEY `i_captura` (`id_captura`),
  KEY `i_empresa` (`id_empresa`),
  KEY `i_estatus` (`id_accion`,`id_estatus`),
  KEY `i_usuario` (`id_usuario`),
  KEY `i_activo` (`activo`),
  KEY `fk_estatus` (`id_estatus`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of he_seguimiento
-- ----------------------------
INSERT INTO `he_seguimiento` VALUES ('1', '1', '1', '2014-08-29', '16:40:02', '1', '1', 'Documento', '1', '2014-08-29 16:40:17', '1');

-- ----------------------------
-- Table structure for he_supervisores
-- ----------------------------
DROP TABLE IF EXISTS `he_supervisores`;
CREATE TABLE `he_supervisores` (
  `id_super` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` mediumint(6) DEFAULT NULL,
  `id_personal` int(11) DEFAULT NULL,
  `id_supervisor` int(11) DEFAULT NULL,
  `id_nivel` smallint(1) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id_super`),
  KEY `i_empresa_empleado` (`id_empresa`,`id_personal`),
  KEY `i_empresa_supervisor` (`id_empresa`,`id_supervisor`),
  KEY `i_nivel` (`id_nivel`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of he_supervisores
-- ----------------------------
INSERT INTO `he_supervisores` VALUES ('1', '41', '9', '8', '1', null, null);
INSERT INTO `he_supervisores` VALUES ('2', '41', '9', '7', '2', null, null);
INSERT INTO `he_supervisores` VALUES ('3', '41', '9', '6', '3', null, null);
INSERT INTO `he_supervisores` VALUES ('4', '41', '9', '5', '4', null, null);
INSERT INTO `he_supervisores` VALUES ('5', '41', '9', '4', '5', null, null);
INSERT INTO `he_supervisores` VALUES ('23', '41', '333', '8', '1', '2', '2015-01-28 15:52:46');
INSERT INTO `he_supervisores` VALUES ('24', '41', '333', '7', '2', '2', '2015-01-28 15:52:46');
INSERT INTO `he_supervisores` VALUES ('25', '41', '333', '6', '3', '2', '2015-01-28 15:52:46');
INSERT INTO `he_supervisores` VALUES ('26', '41', '333', '5', '4', '2', '2015-01-28 15:52:46');
INSERT INTO `he_supervisores` VALUES ('27', '41', '333', '4', '5', '2', '2015-01-28 15:52:46');
INSERT INTO `he_supervisores` VALUES ('28', '41', '334', '8', '1', '2', '2015-01-28 15:56:06');
INSERT INTO `he_supervisores` VALUES ('29', '41', '334', '7', '2', '2', '2015-01-28 15:56:06');
INSERT INTO `he_supervisores` VALUES ('30', '41', '334', '6', '3', '2', '2015-01-28 15:56:06');
INSERT INTO `he_supervisores` VALUES ('31', '41', '334', '5', '4', '2', '2015-01-28 15:56:06');
INSERT INTO `he_supervisores` VALUES ('32', '41', '334', '4', '5', '2', '2015-01-28 15:56:06');
INSERT INTO `he_supervisores` VALUES ('33', '41', '335', '8', '1', '2', '2015-01-28 16:01:48');
INSERT INTO `he_supervisores` VALUES ('34', '41', '335', '7', '2', '2', '2015-01-28 16:01:48');
INSERT INTO `he_supervisores` VALUES ('35', '41', '335', '6', '3', '2', '2015-01-28 16:01:48');
INSERT INTO `he_supervisores` VALUES ('36', '41', '335', '5', '4', '2', '2015-01-28 16:01:48');
INSERT INTO `he_supervisores` VALUES ('37', '41', '335', '4', '5', '2', '2015-01-28 16:01:48');

-- ----------------------------
-- Table structure for sis_grupos
-- ----------------------------
DROP TABLE IF EXISTS `sis_grupos`;
CREATE TABLE `sis_grupos` (
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
  PRIMARY KEY (`id_grupo`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_grupos
-- ----------------------------
INSERT INTO `sis_grupos` VALUES ('10', 'administradores', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `sis_grupos` VALUES ('20', 'inplant', '1', '0', '0', '1', '1', '1', '1', '0', '0', '0');
INSERT INTO `sis_grupos` VALUES ('30', 'nivel5', '1', '0', '1', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `sis_grupos` VALUES ('40', 'nivel2', '1', '0', '1', '1', '0', '0', '0', '0', '0', '0');
INSERT INTO `sis_grupos` VALUES ('50', 'nivel1', '1', '0', '1', '1', '0', '0', '0', '0', '0', '0');
INSERT INTO `sis_grupos` VALUES ('60', 'empleados', '1', '1', '0', '1', '0', '0', '0', '0', '0', '0');
INSERT INTO `sis_grupos` VALUES ('70', 'extra', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `sis_grupos` VALUES ('0', 'root', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `sis_grupos` VALUES ('21', 'global', '1', '1', '1', '1', '1', '0', '1', '0', '0', '0');
INSERT INTO `sis_grupos` VALUES ('35', 'nivel3', '1', '0', '1', '1', '1', '0', '0', '0', '0', '0');
INSERT INTO `sis_grupos` VALUES ('34', 'nivel4', '1', '0', '1', '1', '1', '0', '0', '0', '0', '0');

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
-- Table structure for sis_online
-- ----------------------------
DROP TABLE IF EXISTS `sis_online`;
CREATE TABLE `sis_online` (
  `id_online` mediumint(4) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `online` int(12) DEFAULT NULL,
  PRIMARY KEY (`id_online`),
  KEY `i_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sis_online
-- ----------------------------
INSERT INTO `sis_online` VALUES ('1', '2', '1422546428');
INSERT INTO `sis_online` VALUES ('2', '9', '1422546494');

-- ----------------------------
-- Table structure for sis_usuarios
-- ----------------------------
DROP TABLE IF EXISTS `sis_usuarios`;
CREATE TABLE `sis_usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clave` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_grupo` tinyint(2) DEFAULT '60',
  `id_personal` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `login` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  KEY `i_grupo` (`id_grupo`),
  KEY `i_activo` (`activo`),
  KEY `i_personal` (`id_personal`)
) ENGINE=MyISAM AUTO_INCREMENT=299 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sis_usuarios
-- ----------------------------
INSERT INTO `sis_usuarios` VALUES ('1', 'root', 'root', '0', '1', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('2', 'admin', 'admin', '10', '2', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('3', 'inplant', 'inplant', '20', '3', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('4', 'nivel5', 'nivel5', '30', '4', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('5', 'nivel4', 'nivel4', '34', '5', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('6', 'nivel3', 'nivel3', '35', '6', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('7', 'nivel2', 'nivel2', '40', '7', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('8', 'nivel1', 'nivel1', '50', '8', '0000-00-00 00:00:00', '1', '1');
INSERT INTO `sis_usuarios` VALUES ('9', 'empleado', 'empleado', '60', '9', '0000-00-00 00:00:00', '1', '1');
INSERT INTO `sis_usuarios` VALUES ('10', 'global', 'global', '21', '10', null, '1', '1');
INSERT INTO `sis_usuarios` VALUES ('11', 'GUMM7411123C3', '12345', '60', '11', '2015-01-28 04:32:23', '1', '1');
INSERT INTO `sis_usuarios` VALUES ('12', 'GACZ7508068X2', '12047500421', '60', '12', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('13', 'GUBR611116TSA', '32816196425', '60', '13', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('14', 'DIPV740203T42', '16087404311', '60', '14', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('15', 'ROAO781010AY4', '18967808579', '60', '15', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('16', 'CALL890330PC5', '32088939023', '60', '16', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('17', 'AACR7905228Z5', '96057906875', '60', '17', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('18', 'BABR7911128J4', '45947902958', '60', '18', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('19', 'CAGC870312DRA', '32058749972', '60', '19', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('20', 'UIRM570711KN3', '06805700082', '60', '20', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('21', 'BUAP870316FS3', '16108741360', '60', '21', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('22', 'PELL780729L74', '03977879604', '60', '22', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('23', 'RUTF900530T17', '45139002880', '60', '23', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('24', 'PEMJ860913TR1', '16058630472', '60', '24', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('25', 'FAIL841023EX2', '94118404329', '60', '25', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('26', 'AUHL8202204J8', '32028225475', '60', '26', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('27', 'MAVA890711KQA', '32128923177', '60', '27', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('28', 'MOGR9103277K6', '07089102193', '60', '28', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('29', 'AAVD830702RW6', '01028305165', '60', '29', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('30', 'RIME7902222X9', '16067909461', '60', '30', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('31', 'AUGJ8408184W9', '16078412448', '60', '31', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('32', 'AARE750108PA9', '07957502920', '60', '32', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('33', 'BAMR7911079B2', '68937901467', '60', '33', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('34', 'CAHJ741102PW0', '30917413384', '60', '34', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('35', 'FOCR5703214W4', '10755738175', '60', '35', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('36', 'GUML790607KU0', '45957914430', '60', '36', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('37', 'HEGI800412CR0', '15978007936', '60', '37', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('38', 'LUCE670121E51', '17866710894', '60', '38', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('39', 'MARC5903048M3', '01765898240', '60', '39', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('40', 'MERC640301P69', '06866415117', '60', '40', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('41', 'OIMJ760313GJ5', '11977616199', '60', '41', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('42', 'ROVV8001204Q6', '16988013492', '60', '42', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('43', 'VAMC730819MC2', '01927342061', '60', '43', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('44', 'VACG630419UK7', '11816330036', '60', '44', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('45', 'VIAJ690323MA4', '16866928084', '60', '45', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('46', 'DOBM800228R11', '32088001071', '60', '46', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('47', 'DOML680112R68', '32896879700', '60', '47', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('48', 'PESI520928M98', '32765215002', '60', '48', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('49', 'POZA600101KM7', '32946075333', '60', '49', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('50', 'DIHM810314LK9', '45008106879', '60', '50', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('51', 'GUGG821113BX9', '43998209415', '60', '51', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('52', 'GADL5403131V9', '32825412458', '60', '52', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('53', 'OENJ740625J28', '90957208888', '60', '53', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('54', 'CERE7105207I6', '01907156853', '60', '54', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('55', 'VAEC8105176S5', '11028117031', '60', '55', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('56', 'GAAJ670129S62', '32856789675', '60', '56', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('57', 'OEAE8103259Q5', '11998119058', '60', '57', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('58', 'RAYE800226T12', '92008026319', '60', '58', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('59', 'GAFR8409165JA', '16108417177', '60', '59', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('60', 'AUGE7508305E7', '60927584106', '60', '60', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('61', 'OASD880930TMA', '16118813803', '60', '61', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('62', 'PUJE860417EQA', '11078613244', '60', '62', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('63', 'BEZM8406154C5', '16098403732', '60', '63', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('64', 'MAGC790915DN0', '11977939864', '60', '64', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('65', 'MEMJ760818PL8', '32977614521', '60', '65', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('66', 'CECV8308086S6', '32018370414', '60', '66', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('67', 'AARJ8305309K1', '35008304582', '60', '67', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('68', 'PEVB781223JX4', '32967876668', '60', '68', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('69', 'LAFM740913GH8', '45917455722', '60', '69', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('70', 'MEGA800518H20', '81078001328', '60', '70', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('71', 'EAMF730418S9A', '32937380262', '60', '71', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('72', 'RABL650528629', '64836515722', '60', '72', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('73', 'PAVF710707MBA', '32947175504', '60', '73', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('74', 'CATH860801I57', '16098602978', '60', '74', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('75', 'GAPI861005QA3', '11078613350', '60', '75', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('76', 'VAGV8811305N8', '32048828670', '60', '76', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('77', 'SAHJ590704FN4', '16795909825', '60', '77', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('78', 'REMJ820218MC8', '42978212613', '60', '78', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('79', 'CERI771207JQ0', '45067704903', '60', '79', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('80', 'VIJC861014CY6', '32038655125', '60', '80', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('81', 'ROSV7807023G8', '28017800559', '60', '81', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('82', 'CAVJ841017K95', '01038403869', '60', '82', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('83', 'MEVC830329399', '11088306250', '60', '83', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('84', 'AACG8511279D1', '45088511600', '60', '84', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('85', 'COML630121170', '16906302035', '60', '85', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('86', 'JACA8607107G6', '16048633560', '60', '86', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('87', 'GAAL821226194', '48058218503', '60', '87', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('88', 'DICM890210C79', '37128908920', '60', '88', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('89', 'SERJ841002QG1', '32038447606', '60', '89', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('90', 'CAAJ8704214M5', '37138700770', '60', '90', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('91', 'ROMP9005162S5', '16139008235', '60', '91', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('92', 'MOCA891223PQ9', '90138904900', '60', '92', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('93', 'AARC900924Q55', '90139007034', '60', '93', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('94', 'GOVJ890727BM2', '90138906079', '60', '94', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('95', 'MEMF871102RH9', '32088715878', '60', '95', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('96', 'ROGM850217RX6', '32118506016', '60', '96', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('97', 'REVS910115IW5', '20079100382', '60', '97', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('98', 'AUAA900107QL7', '16119031215', '60', '98', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('99', 'CEBH791009HN1', '32017901375', '60', '99', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('100', 'AARA841022A40', '16088409731', '60', '100', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('101', 'BESY8309112K3', '16078303456', '60', '101', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('102', 'PAAO8912272F1', '32138910693', '60', '102', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('103', 'MUVL870810864', '45118709844', '60', '103', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('104', 'GOGA890627BMA', '32128918896', '60', '104', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('105', 'CARR850909BXA', '32118500480', '60', '105', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('106', 'BEEM880323NL7', '16098814607', '60', '106', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('107', 'EIOR8902044D3', '32088921344', '60', '107', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('108', 'RAOL801102KC9', '30998020363', '60', '108', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('109', 'MOAA900217FR0', '45099060860', '60', '109', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('110', 'GUHM7710233F3', '16957708213', '60', '110', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('111', 'MOMA890305J85', '92138910887', '60', '111', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('112', 'BECP640714CL5', '64826424166', '60', '112', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('113', 'EANR881106UQ0', '01118803590', '60', '113', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('114', 'MOVR891217UZ5', '32098906624', '60', '114', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('115', 'VAAG910529IE3', '32119131376', '60', '115', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('116', 'GAAD840121UB7', '37018407439', '60', '116', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('117', 'OUTO890816H7A', '30138905978', '60', '117', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('118', 'BABA851004590', '13058520944', '60', '118', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('119', 'MAVA861202K37', '16138609280', '60', '119', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('120', 'HEMC671205I46', '76866700644', '60', '120', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('121', 'RICS780502964', '11967825370', '60', '121', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('122', 'MELJ8412251I0', '32068411217', '60', '122', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('123', 'RAAA9004263H4', '32139028354', '60', '123', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('124', 'GAGE740624428', '32947483346', '60', '124', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('125', 'HETP860513K12', '94068622938', '60', '125', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('126', 'PEME890723CP4', '32108917884', '60', '126', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('127', 'DEMA8105258M0', '11138102188', '60', '127', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('128', 'BACE8501169T1', '11118500062', '60', '128', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('129', 'GODA9205221H2', '37119208249', '60', '129', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('130', 'COHP871104MH6', '32118702359', '60', '130', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('131', 'MAMN8609144U8', '32068641946', '60', '131', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('132', 'VACJ901114QSA', '32109050487', '60', '132', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('133', 'COGM720314UW4', '32037200162', '60', '133', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('134', 'TEDC650526LP6', '32866581690', '60', '134', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('135', 'DECE5012102J4', '01745056315', '60', '135', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('136', 'VEEA861011B48', '16068614805', '60', '136', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('137', 'SULP910812SZ2', '32109134539', '60', '137', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('138', 'SUUL880523U70', '39118815909', '60', '138', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('139', 'HEML8403204M5', '45078426033', '60', '139', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('140', 'FULP741217213', '45947404369', '60', '140', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('141', 'BEBC900723848', '11119006804', '60', '141', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('142', 'AEEJ841202E69', '20038421747', '60', '142', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('143', 'AIVJ5808065N3', '16875811537', '60', '143', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('144', 'AEDC761227JZ0', '16087600272', '60', '144', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('145', 'DETA611103MI1', '89806124049', '60', '145', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('146', 'BARA820524MH9', '94048214889', '60', '146', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('147', 'CEOJ691226SCA', '32876987135', '60', '147', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('148', 'COVH710205IR8', '39887040499', '60', '148', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('149', 'FARA700627378', '39937007068', '60', '149', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('150', 'FACI740124L32', '30987400766', '60', '150', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('151', 'GALD72060613A', '01947210710', '60', '151', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('152', 'GARC8308146U0', '32118303950', '60', '152', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('153', 'HERA900312FC1', '16109049789', '60', '153', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('154', 'GONM7602093T1', '60937680829', '60', '154', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('155', 'GUES830603SD6', '92018360468', '60', '155', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('156', 'HECJ831011G76', '37008317424', '60', '156', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('157', 'HUAK8103123F3', '92998145533', '60', '157', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('158', 'IASL73063086A', '92907322660', '60', '158', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('159', 'JAPL801101GK5', '39998011736', '60', '159', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('160', 'JUHS651009EH0', '06816444886', '60', '160', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('161', 'HEGS820310BE7', '42978201582', '60', '161', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('162', 'LOAL7211283T4', '03967200175', '60', '162', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('163', 'LORP810701LI9', '07998108976', '60', '163', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('164', 'PASJ7410246M9', '68937422704', '60', '164', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('165', 'PAAI730721FP2', '92907327248', '60', '165', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('166', 'PIOJ740522VB7', '20907411563', '60', '166', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('167', 'RASH620520P3A', '64806226102', '60', '167', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('168', 'RICL860824H85', '37098603360', '60', '168', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('169', 'ROVA830804SXA', '39038324131', '60', '169', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('170', 'ROCA830323568', '37058310733', '60', '170', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('171', 'ROVN760422M5A', '16007606938', '60', '171', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('172', 'SAMI790710964', '11977924114', '60', '172', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('173', 'SOAJ830103TH6', '01988302046', '60', '173', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('174', 'TOFU821213PB8', '30018230638', '60', '174', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('175', 'VAMC770225KW3', '07957712289', '60', '175', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('176', 'VIRJ880110NW7', '30068823209', '60', '176', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('177', 'MEOA8405128G2', '32128401257', '60', '177', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('178', 'VAHA861128B89', '32058634778', '60', '178', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('179', 'CAPP880913AVA', '16038802209', '60', '179', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('180', 'BAAJ890709L26', '11138907966', '60', '180', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('181', 'PEJD860505HU5', '90098603674', '60', '181', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('182', 'SEMC850204173', '32038524461', '60', '182', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('183', 'RARJ7607073M5', '32017608087', '60', '183', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('184', 'CAGI910312279', '16119153753', '60', '184', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('185', 'ZEFR651028U2A', '96906501109', '60', '185', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('186', 'GUAN870723522', '92108710499', '60', '186', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('187', 'RAVA8609305K8', '16068641618', '60', '187', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('188', 'VALA671127A84', '49916749978', '60', '188', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('189', 'JAHE850715SS5', '16108513843', '60', '189', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('190', 'VALR8703024R7', '39118705480', '60', '190', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('191', 'FARR900330B9A', '92139011685', '60', '191', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('192', 'EUFL910314ID7', '03149164083', '60', '192', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('193', 'SIQR841212LKA', '16078406457', '60', '193', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('194', 'PUPL8501137D9', '94078502195', '60', '194', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('195', 'VIVE9010044K7', '16109059770', '60', '195', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('196', 'GOOR731003HS9', '32897298272', '60', '196', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('197', 'CAOM971014RB3', '27148913208', '60', '197', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('198', 'MEHM511124DC7', '06715102114', '60', '198', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('199', 'FOHE900712239', '8149008305', '60', '199', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('200', 'LEHM820618E80', '94068202376', '60', '200', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('201', 'HEAF850425N82', '45008500378', '60', '201', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('202', 'CUGR900321LX4', '37149000111', '60', '202', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('203', 'TELI9103266L7', '08149191812', '60', '203', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('204', 'SAMU910215IJ9', '08149159942', '60', '204', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('205', 'LUPD910914HS8', '08149148697', '60', '205', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('206', 'GACI860403GR2', '16038603532', '60', '206', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('207', 'CALA8701224MA', '75068734047', '60', '207', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('208', 'VABA880402S10', '32108822522', '60', '208', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('209', 'VAVG900902TB6', '32089036100', '60', '209', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('210', 'AAHA780911H2A', '32997827459', '60', '210', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('211', 'REEM800803KU6', '18958035059', '60', '211', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('212', 'MAQC8903155L0', '27148908521', '60', '212', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('213', 'FOAC900115KY1', '42109008401', '60', '213', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('214', 'ROBC710717HW9', '18877118093', '60', '214', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('215', 'EIGI8412155M7', '16058416740', '60', '215', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('216', 'VAVP911217JT2', '32109131543', '60', '216', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('217', 'DIVA701206542', '07937001274', '60', '217', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('218', 'EIMA840920UL2', '30088402646', '60', '218', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('219', 'MOGA730105CE6', '16877307831', '60', '219', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('220', 'AOEA901124N66', '32129010685', '60', '220', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('221', 'BAHR890524V32', '16058907110', '60', '221', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('222', 'FAPC830703K47', '43998372262', '60', '222', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('223', 'FUGE790129M40', '16977962436', '60', '223', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('224', 'PIMI920621HB3', '90109217811', '60', '224', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('225', 'SABL9011034Y7', '03149044608', '60', '225', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('226', 'MASV891113LW5', '16118921515', '60', '226', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('227', 'AUBL800222M6A', '30988019763', '60', '227', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('228', 'EATM8101292P3', '32978179896', '60', '228', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('229', 'BEVV740720FP5', '30927458114', '60', '229', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('230', 'MAGT870331645', '07118704134', '60', '230', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('231', 'MAMA781129QD4', '16007804681', '60', '231', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('232', 'COMM9104186YA', '16129142960', '60', '232', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('233', 'AIGD8004079L2', '39018000768', '60', '233', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('234', 'CAGC9108088Q6', '42099111900', '60', '234', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('235', 'PESS900213AP2', '37099012405', '60', '235', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('236', 'MOBA651224M58', '92916500082', '60', '236', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('237', 'TIMJ661116DV2', '64856603739', '60', '237', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('238', 'GOAA8212213Y6', '28088200275', '60', '238', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('239', 'GACL870331NZ6', '92138703407', '60', '239', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('240', 'AOTE840516616', '16068419254', '60', '240', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('241', 'MABN890624T70', '03148919313', '60', '241', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('242', 'OIRP880712TC5', '01058802263', '60', '242', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('243', 'GOMA890818E95', '92128911812', '60', '243', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('244', 'RALI870822EY9', '08148770871', '60', '244', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('245', 'GAVA830121FM5', '90018344292', '60', '245', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('246', 'AEMS870930H19', '32058778104', '60', '246', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('247', 'MUAE790309GJ5', '71077900737', '60', '247', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('248', 'NEVJ700715293', '32927077951', '60', '248', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('249', 'GULM901114SE4', '37139007522', '60', '249', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('250', 'NAJI820728BA1', '45038225368', '60', '250', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('251', 'FENE790424SP9', '39037904248', '60', '251', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('252', 'GALA920525718', '96109234854', '60', '252', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('253', 'RODO890210HY3', '05148920209', '60', '253', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('254', 'NUCE860503634', '11108602027', '60', '254', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('255', 'AALD9002152M2', '32129010933', '60', '255', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('256', 'GAVJ9006152R4', '32089042413', '60', '256', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('257', 'SACH860307KW9', '32048630084', '60', '257', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('258', 'BOSG8807304H5', '90128808525', '60', '258', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('259', 'POJM8902176L4', '72088917132', '60', '259', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('260', 'MAOM8710242I7', '16068736723', '60', '260', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('261', 'AAMA790526MA3', '16957901875', '60', '261', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('262', 'AAHF6802051VA', '32866883609', '60', '262', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('263', 'GAAA750501C55', '28977500322', '60', '263', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('264', 'FUZG920101JG1', '10149244641', '60', '264', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('265', 'HEAT911210TS7', '32089125648', '60', '265', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('266', 'MEBI771002G68', '62957720717', '60', '266', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('267', 'HEMG880306MN8', '16108833092', '60', '267', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('268', 'BEHJ880628D3A', '32088831667', '60', '268', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('269', 'LAVE8503255Z9', '37088511227', '60', '269', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('270', 'CAUL801005424', '60978089575', '60', '270', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('271', 'MORH551029AF3', '01795588035', '60', '271', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('272', 'GAAK930226UK2', '32089309168', '60', '272', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('273', 'FOXM850309NX4', '92138502494', '60', '273', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('274', 'AAOC871003RTA', '16098720051', '60', '274', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('275', 'SAGJ790313M60', '16007914449', '60', '275', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('276', 'GUOM8803254D1', '39138803349', '60', '276', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('277', 'READ8704224C1', '96088701550', '60', '277', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('278', 'VARJ900726L86', '16109065173', '60', '278', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('279', 'MAHA880712QC1', '92118801288', '60', '279', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('280', 'ROAB911028HN3', '10149179417', '60', '280', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('281', 'ROVA890424GE0', '16068930979', '60', '281', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('282', 'OALL880812227', '16108838109', '60', '282', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('283', 'LUGJ830414JJ4', '20088200058', '60', '283', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('284', 'CUMS9003228T4', '32089001450', '60', '284', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('285', 'CUAL910210JD8', '32119153842', '60', '285', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('286', 'JICG600718LUA', '32806033802', '60', '286', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('287', 'NOBJ910610PP7', '32139124518', '60', '287', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('288', 'SEEA910625NK4', '03149106571', '60', '288', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('289', 'CACU8604099Z4', '32108603120', '60', '289', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('290', 'LIAC6611065L9', '88846609258', '60', '290', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('291', 'DUCD9205251Q6', '11109207271', '60', '291', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('292', 'BEMH770725B93', '32017708119', '60', '292', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('293', 'RARJ9108199H0', '03149146890', '60', '293', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('294', 'BALG870919FW2', '42118707233', '60', '294', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('295', 'IACG8801062A9', '02158819264', '60', '295', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('296', 'NEMR910313NUA', '02159146980', '60', '296', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('297', 'ROVA890922HYA', '09068992776', '60', '297', '2015-01-28 04:32:23', '1', '0');
INSERT INTO `sis_usuarios` VALUES ('298', 'VAEK900125PTA', '32109021769', '60', '298', '2015-01-28 04:32:23', '1', '0');

-- ----------------------------
-- Table structure for view_vista_credenciales
-- ----------------------------
DROP TABLE IF EXISTS `view_vista_credenciales`;
CREATE TABLE `view_vista_credenciales` (
  `id_view_nomina` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `id_number` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rfc` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imss` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ingreso` date DEFAULT NULL,
  `empresa` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `empresa_razon_social` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `apellido_paterno_empleado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido_materno_empleado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_empleado` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo_electronico` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_view_nomina`),
  KEY `i_id_empresa` (`id_empresa`),
  KEY `i_empresa_empleado` (`id_empresa`,`id_empleado`)
) ENGINE=MyISAM AUTO_INCREMENT=289 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of view_vista_credenciales
-- ----------------------------
INSERT INTO `view_vista_credenciales` VALUES ('1', '41', '124', null, 'TEC. MEC. AUTOMOTRIZ', 'CHRYSLER SANTA.FE', 'GUMM7411123C3', '68907428780', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '124', 'GUZMAN', 'MORA', 'MIGUEL ANGEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('2', '41', '1061', null, 'ENFERMERA', 'CHRYSLER TOLUCA', 'GACZ7508068X2', '12047500421', '2012-06-27', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1061', 'GARCIA', 'CHAVEZ', 'ZAIRA', '');
INSERT INTO `view_vista_credenciales` VALUES ('3', '41', '391', null, 'ENFERMERA', 'CHRYSLER SALTILLO', 'GUBR611116TSA', '32816196425', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '391', 'GUTIERREZ', 'BELTRAN', 'ROSALVA', '');
INSERT INTO `view_vista_credenciales` VALUES ('4', '41', '1088', null, 'MEDICO DE TURNO', 'CHRYSLER TOLUCA', 'DIPV740203T42', '16087404311', '2012-07-30', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1088', 'DIAZ', 'PASOS', 'VICTOR HUGO', '');
INSERT INTO `view_vista_credenciales` VALUES ('5', '41', '1123', null, 'MEDICO DE TURNO', 'CHRYSLER TOLUCA', 'ROAO781010AY4', '18967808579', '2012-09-14', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1123', 'ROJAS', 'ARZATE', 'OSWALDO', 'crowora@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('6', '41', '1057', null, 'INGENIERO CVQS', 'CHRYSLER SALTILLO', 'CALL890330PC5', '32088939023', '2012-09-26', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1057', 'CARDENAS', 'LOPEZ', 'LIZETH ANAKAREN', 'lizeth_ana@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('7', '41', '432', null, 'FACILITADOR LABORATORIO CALIBRACION', 'CHRYSLER TOLUCA', 'AACR7905228Z5', '96057906875', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '432', 'ALVAREZ', 'CAMACHO', 'RUBEN', '');
INSERT INTO `view_vista_credenciales` VALUES ('8', '41', '1165', null, 'INGENIERO DE CALIDAD A PROVEEDORES', 'CHRYSLER SANTA.FE', 'BABR7911128J4', '45947902958', '2012-11-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1165', 'BLANCAS', 'BRAVO', 'RENE', 'frwhitewild@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('9', '41', '1162', null, 'ENFERMERA', 'CHRYSLER SALTILLO', 'CAGC870312DRA', '32058749972', '2012-11-14', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1162', 'CASAS', 'GUTIERREZ', 'CLAUDIA JANETH', 'clajaca12_15@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('10', '41', '625', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'UIRM570711KN3', '06805700082', '2012-12-10', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '625', 'URIBE', 'RAMIREZ', 'MANUEL', 'mu5495@yahoo.com');
INSERT INTO `view_vista_credenciales` VALUES ('11', '41', '678', null, 'INGENIERO DE CALIDAD', 'CHRYSLER TOLUCA', 'BUAP870316FS3', '16108741360', '2013-01-29', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '678', 'BUSTAMANTE', 'ALCANTARA', 'PEDRO', '');
INSERT INTO `view_vista_credenciales` VALUES ('12', '41', '1196', null, 'COORDINADOR REGULATORIO', 'CHRYSLER SANTA.FE', 'PELL780729L74', '03977879604', '2013-02-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1196', 'PEÑA', 'LOZADA', 'LESLIE ALOUTTE', 'QUERIDALESLIE@HOTMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('13', '41', '1197', null, 'INGENIERO DE CALIDAD A PROVEEDORES', 'CHRYSLER SANTA.FE', 'RUTF900530T17', '45139002880', '2013-02-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1197', 'RUIZ', 'TRABOLSI', 'MARIA FERNANDA', 'fernanda_alil@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('14', '41', '1154', null, 'MEDICO DE TURNO', 'CHRYSLER TOLUCA', 'PEMJ860913TR1', '16058630472', '2013-01-28', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1154', 'PERDOMO', 'MEJIA', 'JORGE ABRAHAM', 'perdomo,japm@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('15', '41', '1195', null, 'MEDICO DE TURNO', 'CHRYSLER TOLUCA', 'FAIL841023EX2', '94118404329', '2013-01-28', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1195', 'FRAGOSO', 'IZQUIERDO', 'LAURA ASALIA', 'laura_asalia@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('16', '41', '1201', null, 'ANALISTA DE NOMINA', 'CHRYSLER SALTILLO', 'AUHL8202204J8', '32028225475', '2013-02-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1201', 'AGUIRRE', 'HERNANDEZ', 'LILIANA GUADALUPE', 'lilyaguirre02@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('17', '41', '1205', null, 'ANALISTA DE NOMINA', 'CHRYSLER SALTILLO', 'MAVA890711KQA', '32128923177', '2013-02-07', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1205', 'MAYCOTT', 'VILLARREAL', 'ANA MIRIAM', 'maycott_11@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('18', '41', '1232', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'MOGR9103277K6', '07089102193', '2013-04-04', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1232', 'MORENO', 'GONZALEZ', 'RODRIGO JAVIER', 'moreno.gonzalez.rj@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('19', '41', '8', null, 'TECNICO MECANICO AUTOMOTRIZ', 'CHRYSLER SANTA.FE', 'AAVD830702RW6', '01028305165', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '8', 'ALVARADO', 'VARGAS', 'DANIEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('20', '41', '247', null, 'SUPERVISOR MATERIAL NO', 'CHRYSLER TOLUCA', 'RIME7902222X9', '16067909461', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '247', 'RIVERA', 'MARTINEZ', 'EDGAR DANIEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('21', '41', '3', null, 'ANALISTA', 'CHRYSLER TOLUCA', 'AUGJ8408184W9', '16078412448', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '3', 'AGUILAR', 'GUTIERREZ', 'JUAN MANUEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('22', '41', '18', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'AARE750108PA9', '07957502920', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '18', 'ARZATE', 'RUBIO', 'EMMANUEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('23', '41', '22', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'BAMR7911079B2', '68937901467', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '22', 'BAEZ', 'MONROY', 'ROBERTO CARLOS', '');
INSERT INTO `view_vista_credenciales` VALUES ('24', '41', '51', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'CAHJ741102PW0', '30917413384', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '51', 'CASTILLO', 'HERNANDEZ', 'JESUS', '');
INSERT INTO `view_vista_credenciales` VALUES ('25', '41', '88', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'FOCR5703214W4', '10755738175', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '88', 'FLORES', 'CHAVEZ', 'ROSA MARIA', '');
INSERT INTO `view_vista_credenciales` VALUES ('26', '41', '122', null, 'TEC. MEC. AUTOMOTRIZ', 'CHRYSLER SANTA.FE', 'GUML790607KU0', '45957914430', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '122', 'GURZA', 'MENOCAL', 'LEANDRO', '');
INSERT INTO `view_vista_credenciales` VALUES ('27', '41', '131', null, 'ANALISTA CONTABLE', 'CHRYSLER SANTA.FE', 'HEGI800412CR0', '15978007936', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '131', 'HERNANDEZ', 'GONZALEZ', 'IVONNE', '');
INSERT INTO `view_vista_credenciales` VALUES ('28', '41', '163', null, 'ANALISTA ADMINISTRATIVO', 'CHRYSLER SANTA.FE', 'LUCE670121E51', '17866710894', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '163', 'LUNA', 'CHAVEZ', 'EDGAR', '');
INSERT INTO `view_vista_credenciales` VALUES ('29', '41', '167', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'MARC5903048M3', '01765898240', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '167', 'MARQUEZ', 'RAMIREZ', 'CELEDONIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('30', '41', '187', null, 'ESPECIALISTA EN ASUNTOS REGULATORIOS', 'CHRYSLER SANTA.FE', 'MERC640301P69', '06866415117', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '187', 'MEZA', 'RAMIREZ', 'MARIA DEL CARMEN', '');
INSERT INTO `view_vista_credenciales` VALUES ('31', '41', '210', null, 'SUPERVISOR', 'CHRYSLER TOLUCA', 'OIMJ760313GJ5', '11977616199', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '210', 'OLIVARES', 'MORENO', 'JUAN ANDRES', '');
INSERT INTO `view_vista_credenciales` VALUES ('32', '41', '255', null, 'AGENTE DE HELP DESK', 'CHRYSLER TOLUCA', 'ROVV8001204Q6', '16988013492', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '255', 'ROMAN', 'VARGAS', 'VALERIA', '');
INSERT INTO `view_vista_credenciales` VALUES ('33', '41', '300', null, 'AGENTE DE HELP DESK', 'CHRYSLER TOLUCA', 'VAMC730819MC2', '01927342061', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '300', 'VALDEZ', 'MARTINEZ', 'CRISTINA', '');
INSERT INTO `view_vista_credenciales` VALUES ('34', '41', '303', null, 'CHOFER EJECUTIVO', 'CHRYSLER SANTA.FE', 'VACG630419UK7', '11816330036', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '303', 'VARGAS', 'CASTAÑEDA', 'GERARDO', '');
INSERT INTO `view_vista_credenciales` VALUES ('35', '41', '318', null, 'CHOFER EJECUTIVO', 'CHRYSLER TOLUCA', 'VIAJ690323MA4', '16866928084', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '318', 'VILLAVICENCIO', 'ALMEIDA', 'JOSE', '');
INSERT INTO `view_vista_credenciales` VALUES ('36', '41', '384', null, 'MEDICO DE TURNO', 'CHRYSLER SALTILLO', 'DOBM800228R11', '32088001071', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '384', 'DOMINGUEZ', 'BELTRAN', 'JOSE MARIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('37', '41', '386', null, 'ENFERMERO', 'CHRYSLER SALTILLO', 'DOML680112R68', '32896879700', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '386', 'DOMINGUEZ', 'MORALES', 'JOSE LUIS', '');
INSERT INTO `view_vista_credenciales` VALUES ('38', '41', '400', null, 'COORDINADOR DE SERVICIO MEDICO', 'CHRYSLER SALTILLO', 'PESI520928M98', '32765215002', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '400', 'PEÑA', 'SOLCHAGA', 'IGNACIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('39', '41', '401', null, 'COORDINADOR MEDICO', 'CHRYSLER SALTILLO', 'POZA600101KM7', '32946075333', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '401', 'PORTILLO', 'ZUGASTI', 'ANA ROSA', '');
INSERT INTO `view_vista_credenciales` VALUES ('40', '41', '648', null, 'COORDINADORA DE CAPACITACION', 'CHRYSLER SANTA.FE', 'DIHM810314LK9', '45008106879', '2010-10-15', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '648', 'DIAZ', 'HERNANDEZ', 'MYRNA PAOLA', '');
INSERT INTO `view_vista_credenciales` VALUES ('41', '41', '659', null, 'MEDICO DE TURNO', 'CHRYSLER SALTILLO', 'GUGG821113BX9', '43998209415', '2010-11-03', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '659', 'GUERRA', 'GARCIA', 'JOSE GUADALUPE', '');
INSERT INTO `view_vista_credenciales` VALUES ('42', '41', '660', null, 'MEDICO DE TURNO', 'CHRYSLER SALTILLO', 'GADL5403131V9', '32825412458', '2010-11-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '660', 'GARCIA', 'DAVILA', 'LUIS GERARDO', '');
INSERT INTO `view_vista_credenciales` VALUES ('43', '41', '679', null, 'CHOFER EJECUTIVO', 'CHRYSLER SANTA.FE', 'OENJ740625J28', '90957208888', '2010-12-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '679', 'OSEGUERA', 'NAVARRO', 'JOSE DE JESUS', '');
INSERT INTO `view_vista_credenciales` VALUES ('44', '41', '703', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'CERE7105207I6', '01907156853', '2010-12-17', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '703', 'CEBALLOS', 'RUIZ', 'ELIZABETH', '');
INSERT INTO `view_vista_credenciales` VALUES ('45', '41', '736', null, 'COORDINADOR DE EXPATRIADOS', 'CHRYSLER SANTA.FE', 'VAEC8105176S5', '11028117031', '2011-02-11', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '736', 'VALLES', 'ELIZALDE', 'MARIA DEL CARMEN', '');
INSERT INTO `view_vista_credenciales` VALUES ('46', '41', '774', null, 'COORDINADOR MEDICO', 'CHRYSLER SALTILLO', 'GAAJ670129S62', '32856789675', '2011-04-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '774', 'GAMEZ', 'ALVARADO', 'JULIAN', '');
INSERT INTO `view_vista_credenciales` VALUES ('47', '41', '776', null, 'INGENIERO DE PESOS', 'CHRYSLER SANTA.FE', 'OEAE8103259Q5', '11998119058', '2011-04-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '776', 'OJEDA', 'ASBUN', 'EDUARDO', '');
INSERT INTO `view_vista_credenciales` VALUES ('48', '41', '784', null, 'TECNICO MECANICO AUTOMOTRIZ', 'CHRYSLER SANTA.FE', 'RAYE800226T12', '92008026319', '2011-04-11', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '784', 'RAMIREZ', 'YRIGOYEN', 'EDGAR', '');
INSERT INTO `view_vista_credenciales` VALUES ('49', '41', '794', null, 'COORDINADOR MEDICO', 'CHRYSLER TOLUCA', 'GAFR8409165JA', '16108417177', '2011-05-06', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '794', 'GRANADOS', 'FERRUZCA', 'ROGELIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('50', '41', '805', null, 'CHOFER EJECUTIVO', 'CHRYSLER SALTILLO', 'AUGE7508305E7', '60927584106', '2011-05-23', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '805', 'ANGUIANO', 'GUTIERREZ', 'ETIEENE', '');
INSERT INTO `view_vista_credenciales` VALUES ('51', '41', '863', null, 'AUDITOR DINAMICA EXTENDIDA', 'CHRYSLER TOLUCA', 'OASD880930TMA', '16118813803', '2013-02-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '863', 'OLASCOAGA', 'SANCHEZ', 'DAVID', '');
INSERT INTO `view_vista_credenciales` VALUES ('52', '41', '915', null, 'TECNICO', 'CHRYSLER SANTA.FE', 'PUJE860417EQA', '11078613244', '2011-09-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '915', 'PULIDO', 'JUAREZ', 'ERIKA', '');
INSERT INTO `view_vista_credenciales` VALUES ('53', '41', '921', null, 'ESPECIALISTA EN SEG. INDUSTRIAL', 'CHRYSLER TOLUCA', 'BEZM8406154C5', '16098403732', '2011-09-13', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '921', 'BERNAL', 'ZANABRIA', 'MONICA SELENE', '');
INSERT INTO `view_vista_credenciales` VALUES ('54', '41', '943', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'MAGC790915DN0', '11977939864', '2011-10-28', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '943', 'MARQUEZ', 'GÓMEZ', 'CRISTIAN OMAR', '');
INSERT INTO `view_vista_credenciales` VALUES ('55', '41', '980', null, 'AUDITOR DE CALIDAD', 'CHRYSLER SALTILLO', 'MEMJ760818PL8', '32977614521', '2012-01-02', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '980', 'MEDRANO', 'MARTINEZ', 'JAVIER FABIAN', '');
INSERT INTO `view_vista_credenciales` VALUES ('56', '41', '981', null, 'AUDITOR DE CALIDAD', 'CHRYSLER SALTILLO', 'CECV8308086S6', '32018370414', '2012-01-02', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '981', 'CEPEDA', 'CARRIZALES', 'VICTOR MANUEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('57', '41', '998', null, 'ENFERMERO', 'CHRYSLER SALTILLO', 'AARJ8305309K1', '35008304582', '2011-02-07', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '998', 'ALANIZ', 'RUBIO', 'JUAN FERNANDO', '');
INSERT INTO `view_vista_credenciales` VALUES ('58', '41', '1005', null, 'ENFERMERO', 'CHRYSLER SALTILLO', 'PEVB781223JX4', '32967876668', '2012-02-23', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1005', 'PEREZ', 'VAZQUEZ', 'BLANCA ELIZABETH', '');
INSERT INTO `view_vista_credenciales` VALUES ('59', '41', '1007', null, 'CHOFER EJECUTIVO', 'CHRYSLER SANTA.FE', 'LAFM740913GH8', '45917455722', '2012-03-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1007', 'LARA', 'FIGUEROA', 'MARCO ANTONIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('60', '41', '1010', null, 'COORDINADOR MEDICO', 'CHRYSLER TOLUCA', 'MEGA800518H20', '81078001328', '2012-03-20', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1010', 'MEJIA', 'GARCIA', 'ADRIANA', '');
INSERT INTO `view_vista_credenciales` VALUES ('61', '41', '1013', null, 'CHOFER EJECUTIVO', 'CHRYSLER SANTA.FE', 'EAMF730418S9A', '32937380262', '2012-03-21', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1013', 'ESCALONA', 'MONTIEL', 'JOSE FAUSTO', '');
INSERT INTO `view_vista_credenciales` VALUES ('62', '41', '1032', null, 'CHOFER EJECUTIVO', 'CHRYSLER TOLUCA', 'RABL650528629', '64836515722', '2012-05-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1032', 'RAMIREZ', 'BARRON', 'LUIS GERMAN', '');
INSERT INTO `view_vista_credenciales` VALUES ('63', '41', '1040', null, 'CHOFER EJECUTIVO', 'CHRYSLER SALTILLO', 'PAVF710707MBA', '32947175504', '2012-05-29', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1040', 'PACHUCA', 'VAZQUEZ', 'FRANCISCO JAVIER', '');
INSERT INTO `view_vista_credenciales` VALUES ('64', '41', '1050', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'CATH860801I57', '16098602978', '2012-06-06', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1050', 'CARDENAS', 'TREJO', 'HUGO CESAR', '');
INSERT INTO `view_vista_credenciales` VALUES ('65', '41', '1078', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'GAPI861005QA3', '11078613350', '2012-07-18', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1078', 'GALLO', 'PEÑA', 'ISRAEL ARTURO', '');
INSERT INTO `view_vista_credenciales` VALUES ('66', '41', '1066', null, 'AUDITOR DINAMICA EXTENDIDA', 'CHRYSLER SALTILLO', 'VAGV8811305N8', '32048828670', '2012-07-03', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1066', 'VALDES', 'GONZALEZ', 'VICTOR HIRAM', '');
INSERT INTO `view_vista_credenciales` VALUES ('67', '41', '1069', null, 'LAUNCH PROGRAM MANAGER', 'CHRYSLER SALTILLO', 'SAHJ590704FN4', '16795909825', '2012-07-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1069', 'SANTOYO', 'HERRERA', 'J. ISIDRO REFUGIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('68', '41', '1074', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'REMJ820218MC8', '42978212613', '2012-07-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1074', 'REYES', 'MONTES DE OCA', 'JUANA DEL CARMEN', '');
INSERT INTO `view_vista_credenciales` VALUES ('69', '41', '1080', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'CERI771207JQ0', '45067704903', '2012-07-20', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1080', 'CEJUDO', 'RAMIREZ', 'IGNACIO GIOVANNI', '');
INSERT INTO `view_vista_credenciales` VALUES ('70', '41', '1085', null, 'SUPERVISOR', 'CHRYSLER SALTILLO', 'VIJC861014CY6', '32038655125', '2012-07-30', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1085', 'VILLA', 'JUAREZ', 'CEZIA BERENICE', 'cbjv_86@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('71', '41', '1095', null, 'TECNICO', 'CHRYSLER SANTA.FE', 'ROSV7807023G8', '28017800559', '2012-08-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1095', 'ROMO', 'SORIA', 'VERONICA DEL CARMEN', 'vero_rs2009@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('72', '41', '1108', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'CAVJ841017K95', '01038403869', '2012-08-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1108', 'CARDENAS', 'VILLALOBOS', 'JUAN HORACIO', 'acm_sports@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('73', '41', '1114', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'MEVC830329399', '11088306250', '2012-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1114', 'MEDINA', 'VAZQUEZ', 'CLAUDIA IVETTE', 'claudiamv2903@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('74', '41', '1144', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'AACG8511279D1', '45088511600', '2012-10-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1144', 'ALMARAZ', 'CONTRERAS', 'GLADYS VALERIA', 'glava_85@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('75', '41', '1147', null, 'TECNICO', 'CHRYSLER SANTA.FE', 'COML630121170', '16906302035', '2012-10-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1147', 'COLIN', 'MEJIA', 'JOSE LUIS', 'josecolin1@yahoo.com.mx');
INSERT INTO `view_vista_credenciales` VALUES ('76', '41', '1158', null, 'ANALISTA CONTABLE', 'CHRYSLER SANTA.FE', 'JACA8607107G6', '16048633560', '2012-11-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1158', 'JARAMILLO', 'DE LA CRUZ', 'ALEJANDRO', 'alex-dulce-x-siempre@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('77', '41', '1159', null, 'ANALISTA DE DISTRIBUCION Y VENTAS FIAT', 'CHRYSLER SANTA.FE', 'GAAL821226194', '48058218503', '2012-11-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1159', 'GARCIA', 'ALVAREZ', 'LAURA MATILDE', 'matilde.garcia@live.com');
INSERT INTO `view_vista_credenciales` VALUES ('78', '41', '1176', null, 'ESPECIALISTA EN ESPECIFICACIONES', 'CHRYSLER SANTA.FE', 'DICM890210C79', '37128908920', '2013-01-03', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1176', 'DIAZ', 'CASTILLO', 'MOIRA ITZEL', 'moiraid_89@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('79', '41', '1182', null, 'QE LAUNCH SUPPORT', 'CHRYSLER SALTILLO', 'SERJ841002QG1', '32038447606', '2013-01-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1182', 'SERNA', 'RAMOS', 'JORGE', 'jorge_serna_ramos@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('80', '41', '1214', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'CAAJ8704214M5', '37138700770', '2013-02-20', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1214', 'CALDERON', 'ALMONAZIN', 'JAVIER', 'esimeipn8721@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('81', '41', '1236', null, 'INGENIERO DE ESPECIFICACIONES', 'CHRYSLER SANTA.FE', 'ROMP9005162S5', '16139008235', '2013-04-08', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1236', 'RODRIGUEZ', 'MORALES', 'PABLO FRANCISCO', 'romopao@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('82', '41', '1252', null, 'TECNICO', 'CHRYSLER SANTA.FE', 'MOCA891223PQ9', '90138904900', '2013-05-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1252', 'MORENO', 'CEDILLO', 'ANTONIO DE JESUS', 'antonio-j-mc@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('83', '41', '1253', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'AARC900924Q55', '90139007034', '2013-05-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1253', 'AYALA', 'RUBIO', 'CECILIA ABIGAIL', '');
INSERT INTO `view_vista_credenciales` VALUES ('84', '41', '1265', null, 'INGENIERO DE CALIDAD A PROVEEDORES', 'CHRYSLER SANTA.FE', 'GOVJ890727BM2', '90138906079', '2013-06-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1265', 'GONZALEZ', 'VEGA', 'JORGE LUIS', 'glezjl@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('85', '41', '1135', null, 'AUDITOR DINAMICA EXTENDIDA', 'CHRYSLER SALTILLO', 'MEMF871102RH9', '32088715878', '2013-06-03', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1135', 'MEZA', 'MEDINA', 'FRANCISCO RAMIRO', 'fm700@chrysler.com');
INSERT INTO `view_vista_credenciales` VALUES ('86', '41', '1266', null, 'MEDICO DE TURNO', 'CHRYSLER SALTILLO', 'ROGM850217RX6', '32118506016', '2013-06-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1266', 'RODRIGUEZ', 'GILES', 'MONICA PATRICIA', 'monyrgiles@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('87', '41', '1129', null, 'COORDINADOR DE MARKETING', 'CHRYSLER SANTA.FE', 'REVS910115IW5', '20079100382', '2013-10-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1129', 'REYES', 'VALENCIA', 'SERGIO ERICK', 'asergioreyes@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('88', '41', '898', null, 'ANALISTA DE CONTABILIDAD E INVENTARIOS', 'CHRYSLER SANTA.FE', 'AUAA900107QL7', '16119031215', '2013-06-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '898', 'AGUILERA', 'ALVAREZ', 'ARELI ALEJANDRA', '');
INSERT INTO `view_vista_credenciales` VALUES ('89', '41', '1273', null, 'INGENIERO DE CALIDAD A PROVEEDORES', 'CHRYSLER SANTA.FE', 'CEBH791009HN1', '32017901375', '2013-06-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1273', 'CEBRIAN', 'BECERRA', 'HERMELINDA GUADALUPE', 'gcebrian@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('90', '41', '1280', null, 'DIRECT BUYER', 'CHRYSLER SANTA.FE', 'AARA841022A40', '16088409731', '2013-07-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1280', 'ARAUJO', 'RODRIGUEZ', 'ARACELI', 'araujo_ara@yahoo.com');
INSERT INTO `view_vista_credenciales` VALUES ('91', '41', '1282', null, 'INGENIERO DE CALIDAD A PROVEEDORES', 'CHRYSLER SANTA.FE', 'BESY8309112K3', '16078303456', '2013-07-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1282', 'BENITEZ', 'SALAS', 'YESIKA', 'yesikabenitez_salas@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('92', '41', '1284', null, 'QE LAUNCH SUPPORT', 'CHRYSLER SALTILLO', 'PAAO8912272F1', '32138910693', '2013-07-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1284', 'PRADO', 'AGUIRRE', 'OCTAVIO', 'octavio_agui55@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('93', '41', '1277', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'MUVL870810864', '45118709844', '2013-07-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1277', 'MUNGUIA', 'VEGA', 'LUIS GERARDO', 'luismunguiav@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('94', '41', '1292', null, 'AUDITOR DE CALIDAD', 'CHRYSLER SALTILLO', 'GOGA890627BMA', '32128918896', '2013-07-17', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1292', 'GONZALEZ', 'GARCIA', 'ANTONIO', 'antonio_glz1989@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('95', '41', '1291', null, 'ANALISTA DE RECURSOS HUMANOS', 'CHRYSLER SALTILLO', 'CARR850909BXA', '32118500480', '2013-07-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1291', 'CAMBEROS', 'RODRIGUEZ', 'ROSELY', 'rosely.camrdz@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('96', '41', '1287', null, 'ENFERMERA', 'CHRYSLER TOLUCA', 'BEEM880323NL7', '16098814607', '2013-07-02', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1287', 'BERNAL', 'ESCOBAR', 'MIRIAM YAZMIN', 'miryzim2310gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('97', '41', '1289', null, 'ENFERMERO', 'CHRYSLER SALTILLO', 'EIOR8902044D3', '32088921344', '2013-07-08', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1289', 'ESPINOSA', 'OROZCO', 'RAUL EZEQUIEL', 'rulo_enfermero@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('98', '41', '1304', null, 'TECNICO MECANICO AUTOMOTRIZ', 'CHRYSLER SANTA.FE', 'RAOL801102KC9', '30998020363', '2013-08-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1304', 'RAMIREZ', 'ORTIZ', 'LUIS ALBERTO', 'lramirezortiz7@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('99', '41', '1306', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'MOAA900217FR0', '45099060860', '2013-08-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1306', 'MOLINA', 'ACOSTA', 'ANGEL', 'angel.molinacosta@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('100', '41', '1310', null, 'CHOFER EJECUTIVO', 'CHRYSLER SANTA.FE', 'GUHM7710233F3', '16957708213', '2013-08-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1310', 'GUTIERREZ', 'HERNANDEZ', 'MAURICIO', 'maguhc_@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('101', '41', '1313', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'MOMA890305J85', '92138910887', '2013-08-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1313', 'MORENO', 'MEDELLIN', 'ANA KAREN', 'karenmedellin@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('102', '41', '1321', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'BECP640714CL5', '64826424166', '2013-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1321', 'BECERRIL', 'CORREA', 'PATRICIA', 'pabeco1407@yahoo.com.mx');
INSERT INTO `view_vista_credenciales` VALUES ('103', '41', '1322', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'EANR881106UQ0', '01118803590', '2013-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1322', 'ESCAMILLA', 'NUÑEZ', 'RAFAEL', 'RFLSCMLL@GMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('104', '41', '1324', null, 'INGENIERO MQAS', 'CHRYSLER SALTILLO', 'MOVR891217UZ5', '32098906624', '2013-09-03', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1324', 'MORA', 'DE VALLE', 'ROXANA ALEJANDRA', 'ROXANA17ALE@HOTMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('105', '41', '1326', null, 'INGENIERO DE CALIDAD', 'CHRYSLER SALTILLO', 'VAAG910529IE3', '32119131376', '2013-09-17', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1326', 'VAZQUEZ', 'ALONZO', 'JOSE GERMAN', '');
INSERT INTO `view_vista_credenciales` VALUES ('106', '41', '1328', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'GAAD840121UB7', '37018407439', '2013-09-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1328', 'GAVIRIA', 'ARCILA', 'DAFNE', 'dafnega@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('107', '41', '1334', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'OUTO890816H7A', '30138905978', '2013-10-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1334', 'OLGUIN', 'TINAJERO', 'OMAR ADRIAN', 'adrian.olguin.tin@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('108', '41', '1339', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'BABA851004590', '13058520944', '2013-10-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1339', 'BRAVO', 'BASURTO', 'ARACELI', 'nena-ccolva@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('109', '41', '1337', null, 'ENFERMERA', 'CHRYSLER TOLUCA', 'MAVA861202K37', '16138609280', '2013-10-11', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1337', 'MAYA', 'VELAZQUEZ', 'ANA LIZETH', 'analizeth_51@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('110', '41', '1347', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'HEMC671205I46', '76866700644', '2013-10-29', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1347', 'HERNANDEZ', 'MARTINEZ', 'MARIA CONCEPCION', 'connyhernandez67@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('111', '41', '1350', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'RICS780502964', '11967825370', '2013-11-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1350', 'RIVERA', 'CORTES', 'SMYRNA VANESSA', 'svrc22@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('112', '41', '1355', null, 'MEDICO DE TURNO', 'CHRYSLER SALTILLO', 'MELJ8412251I0', '32068411217', '2013-11-25', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1355', 'MENA', 'LAZARIN', 'JULIAN EMMANUEL', 'jeml84@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('113', '41', '1354', null, 'INGENIERO MQAS', 'CHRYSLER SALTILLO', 'RAAA9004263H4', '32139028354', '2013-11-18', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1354', 'RAMIREZ', 'ALVAREZ', 'MARIA ALEJANDRA', 'aleramirez_303@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('114', '41', '1357', null, 'ANALISTA DE NOMINA', 'CHRYSLER SALTILLO', 'GAGE740624428', '32947483346', '2013-12-02', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1357', 'GARZA', 'GARCIA', 'ERIKA', 'garzaeri@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('115', '41', '1356', null, 'INGENIERO DE PRODUCTO DIMENSIONAL', 'CHRYSLER SANTA.FE', 'HETP860513K12', '94068622938', '2013-11-25', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1356', 'HERNANDEZ', 'TREJO', 'PEDRO DAVID', 'htpd86@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('116', '41', '1193', null, 'JD POWER AUDITOR', 'CHRYSLER SALTILLO', 'PEME890723CP4', '32108917884', '2013-12-09', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1193', 'PEREZ', 'MARIN', 'EDGAR ALEJANDRO', 'ing.edgaralejandro@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('117', '41', '1364', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'DEMA8105258M0', '11138102188', '2013-12-09', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1364', 'DE DIEGO', 'MARTINEZ', 'ALBERTO', 'alberdiego@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('118', '41', '1366', null, 'ANALISTA DE PROGRAMA DE BECARIOS', 'CHRYSLER SANTA.FE', 'BACE8501169T1', '11118500062', '2014-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1366', 'BASTIDA', 'CALLEJAS', 'ESPERANZA', 'CALLESPERANZA@GMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('119', '41', '1375', null, 'ANALISTA', 'CHRYSLER SANTA.FE', 'GODA9205221H2', '37119208249', '2014-01-27', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1375', 'GONZALEZ', 'DOMENZAIN', 'ALEJANDRA', 'ale.domenzain@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('120', '41', '1376', null, 'ANALISTA DE LANZAMIENTO Y ESPECIFICACION', 'CHRYSLER SALTILLO', 'COHP871104MH6', '32118702359', '2014-02-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1376', 'CORDOVA', 'HERNANDEZ', 'PABLO EDGAR', 'men_00pech@hormail.com');
INSERT INTO `view_vista_credenciales` VALUES ('121', '41', '1152', null, 'INGENIERO MQAS', 'CHRYSLER SALTILLO', 'MAMN8609144U8', '32068641946', '2014-02-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1152', 'MARTINEZ', 'MARTINEZ', 'NORMA IRAIDA', 'iraida_mtz@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('122', '41', '1285', null, 'INGENIERO MQAS', 'CHRYSLER SALTILLO', 'VACJ901114QSA', '32109050487', '2014-02-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1285', 'VAZQUEZ', 'CABRERA', 'JESUS', 'kchuy_k13@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('123', '41', '380', null, 'ENFERMERA', 'CHRYSLER SALTILLO', 'COGM720314UW4', '32037200162', '2014-01-31', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '380', 'CORPUS', 'GOMEZ', 'MARICELA', 'corpusmar9@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('124', '41', '1382', null, 'MEDICO DE TURNO', 'CHRYSLER SALTILLO', 'TEDC650526LP6', '32866581690', '2014-02-06', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1382', 'TREVIÑO', 'DAVILA', 'MARIA DEL CARMEN', 'MELITA1965@YAHOO.COM.MX');
INSERT INTO `view_vista_credenciales` VALUES ('125', '41', '72', null, 'INGENIERO DE CALIDAD A PROVEEDORES', 'CHRYSLER SANTA.FE', 'DECE5012102J4', '01745056315', '2013-03-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '72', 'DELGADO', 'CARRILLO', 'ERNESTO', 'ernesto.delgado@yahoo.comernesto.delgado@yahoo.com');
INSERT INTO `view_vista_credenciales` VALUES ('126', '41', '1383', null, 'ANALISTA DE NOMINA', 'CHRYSLER TOLUCA', 'VEEA861011B48', '16068614805', '2014-02-10', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1383', 'VELAZQUEZ', 'ESPINOZA', 'ANGELICA', '');
INSERT INTO `view_vista_credenciales` VALUES ('127', '41', '1386', null, 'QE LAUNCH SUPPORT', 'CHRYSLER SALTILLO', 'SULP910812SZ2', '32109134539', '2014-03-03', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1386', 'SUBEALDEA', 'DE LEON', 'JOSE PABLO', 'JPASUB@HOTMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('128', '41', '1388', null, 'ANALISTA', 'CHRYSLER SANTA.FE', 'SUUL880523U70', '39118815909', '2014-03-10', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1388', 'SUAREZ', 'URIBE', 'LUIS ENRIQUE', 'kikegti.luis@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('129', '41', '1389', null, 'ANALISTA COMPANY CARS', 'CHRYSLER SANTA.FE', 'HEML8403204M5', '45078426033', '2014-03-10', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1389', 'HERNANDEZ', 'MENDIETA', 'LAKSMI ESTRELLA', 'laks.mystar@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('130', '41', '1390', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'FULP741217213', '45947404369', '2014-03-10', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1390', 'FUENTES', 'PUENTE', 'MARIA DE LOURDES', 'mlourdesf@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('131', '41', '1391', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'BEBC900723848', '11119006804', '2014-03-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1391', 'BECERRIL', 'BENAVIDES', 'CARLOS EDUARDO', 'CARLOSBECERRIL23@HOTMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('132', '41', '935', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'AEEJ841202E69', '20038421747', '2011-10-19', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '935', 'ACEVEDO', 'ESTRADA', 'JOSE DE JESUS', '');
INSERT INTO `view_vista_credenciales` VALUES ('133', '41', '496', null, 'MEDICO EN SALUD OCUPACIONAL', 'CHRYSLER TOLUCA', 'AIVJ5808065N3', '16875811537', '2010-03-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '496', 'ALVIRDE', 'VALENCIA', 'JUSTO', '');
INSERT INTO `view_vista_credenciales` VALUES ('134', '41', '493', null, 'MEDICO DE TURNO', 'CHRYSLER TOLUCA', 'AEDC761227JZ0', '16087600272', '2010-03-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '493', 'ANGELES', 'DIAZ', 'CESAR ALBERTO', '');
INSERT INTO `view_vista_credenciales` VALUES ('135', '41', '789', null, 'CHOFER EJECUTIVO', 'CHRYSLER SANTA.FE', 'DETA611103MI1', '89806124049', '2011-05-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '789', 'DELGADO', 'TORRES', 'ALEJANDRO', '');
INSERT INTO `view_vista_credenciales` VALUES ('136', '41', '871', null, 'TECNICO DE DESARROLLO DE VEHICULOS', 'CHRYSLER SANTA.FE', 'BARA820524MH9', '94048214889', '2011-07-18', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '871', 'BRAVO', 'RAMIREZ', 'JOSE ANTONIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('137', '41', '526', null, 'CHOFER EJECUTIVO', 'CHRYSLER SALTILLO', 'CEOJ691226SCA', '32876987135', '2010-04-15', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '526', 'CERVANTES', 'ORTEGA', 'JUAN ANTONIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('138', '41', '66', null, 'TECNICO EN MAQUINAS Y HERRAMIENTAS', 'CHRYSLER SANTA.FE', 'COVH710205IR8', '39887040499', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '66', 'CORTES', 'VILLEDA', 'HECTOR', '');
INSERT INTO `view_vista_credenciales` VALUES ('139', '41', '86', null, 'ESPECIALISTA EN ESPECIFICACIONES', 'CHRYSLER SANTA.FE', 'FARA700627378', '39937007068', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '86', 'FABRE', 'RIVERA', 'MARIA ANGELICA', '');
INSERT INTO `view_vista_credenciales` VALUES ('140', '41', '327', null, 'CHOFER EJECUTIVO', 'CHRYSLER SANTA.FE', 'FACI740124L32', '30987400766', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '327', 'FRAUSTO', 'CASTILLO', 'ISRAEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('141', '41', '102', null, 'TEC. MEC. AUTOMOTRIZ', 'CHRYSLER SANTA.FE', 'GALD72060613A', '01947210710', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '102', 'GARCIA', 'LOPEZ', 'DANIEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('142', '41', '940', null, 'JD POWER AUDITOR', 'CHRYSLER SALTILLO', 'GARC8308146U0', '32118303950', '2011-10-25', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '940', 'GAYTAN', 'RAMIREZ', 'CYNTIA', '');
INSERT INTO `view_vista_credenciales` VALUES ('143', '41', '1036', null, 'SEGUIDOR ANALISTA FIAT Y ALFA ROMEO', 'CHRYSLER SANTA.FE', 'HERA900312FC1', '16109049789', '2012-05-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1036', 'HERNANDEZ', 'ROMERO', 'ALEJANDRA DANIELA', '');
INSERT INTO `view_vista_credenciales` VALUES ('144', '41', '470', null, 'INGENIERO DE CALIDAD', 'CHRYSLER SALTILLO', 'GONM7602093T1', '60937680829', '2010-02-11', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '470', 'GONZALEZ', 'NUÑEZ', 'MARICELA DE JESUS', '');
INSERT INTO `view_vista_credenciales` VALUES ('145', '41', '123', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'GUES830603SD6', '92018360468', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '123', 'GUTIERREZ', 'ESTRADA', 'SERGIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('146', '41', '988', null, 'ANALISTA DE VENTAS', 'CHRYSLER SANTA.FE', 'HECJ831011G76', '37008317424', '2012-01-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '988', 'HERNANDEZ', 'CARDENAS', 'JESUS ENRIQUE', '');
INSERT INTO `view_vista_credenciales` VALUES ('147', '41', '141', null, 'INGENIERO DE CONTROL VEHICULAR', 'CHRYSLER SANTA.FE', 'HUAK8103123F3', '92998145533', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '141', 'HUERTA', 'ARREGOITIA', 'KITZE ARMANDO', '');
INSERT INTO `view_vista_credenciales` VALUES ('148', '41', '561', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'IASL73063086A', '92907322660', '2010-06-11', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '561', 'ISLAS', 'SAUCILLO', 'LUCINO GABRIEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('149', '41', '145', null, 'ANALISTA CONTABLE', 'CHRYSLER SANTA.FE', 'JAPL801101GK5', '39998011736', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '145', 'JAVIER', 'PEREZ', 'LORENA', '');
INSERT INTO `view_vista_credenciales` VALUES ('150', '41', '148', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'JUHS651009EH0', '06816444886', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '148', 'JUAREZ', 'HERNANDEZ', 'SERGIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('151', '41', '662', null, 'ENFERMERA', 'CHRYSLER SANTA.FE', 'HEGS820310BE7', '42978201582', '2012-05-18', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '662', 'HERNANDEZ', 'GUTIERREZ', 'SHEILA ABIGAIL', '');
INSERT INTO `view_vista_credenciales` VALUES ('152', '41', '156', null, 'TEC. MEC. AUTOMOTRIZ', 'CHRYSLER SANTA.FE', 'LOAL7211283T4', '03967200175', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '156', 'LOPEZ', 'ALDAMA', 'JOSE LUIS', '');
INSERT INTO `view_vista_credenciales` VALUES ('153', '41', '395', null, 'ENFERMERO', 'CHRYSLER SALTILLO', 'LORP810701LI9', '07998108976', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '395', 'LOPEZ', 'RANGEL', 'PEDRO ALEJANDRO', '');
INSERT INTO `view_vista_credenciales` VALUES ('154', '41', '219', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'PASJ7410246M9', '68937422704', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '219', 'PAGAZA', 'STRAFFON', 'JORGE RAFAEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('155', '41', '761', null, 'ANALISTA DE GASTOS DE VIAJE', 'CHRYSLER SANTA.FE', 'PAAI730721FP2', '92907327248', '2011-03-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '761', 'PALENCIA', 'ALCOCER', 'INGRID FABIOLA', '');
INSERT INTO `view_vista_credenciales` VALUES ('156', '41', '231', null, 'TECNICO MECANICO AUTOMOTRIZ', 'CHRYSLER SANTA.FE', 'PIOJ740522VB7', '20907411563', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '231', 'PIÑA', 'ORTA', 'JUAN CARLOS', '');
INSERT INTO `view_vista_credenciales` VALUES ('157', '41', '473', null, 'ENFERMERA', 'CHRYSLER SANTA.FE', 'RASH620520P3A', '64806226102', '2010-02-17', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '473', 'RAMIREZ', 'SANTAMARIA', 'HERLINDA', '');
INSERT INTO `view_vista_credenciales` VALUES ('158', '41', '800', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'RICL860824H85', '37098603360', '2012-06-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '800', 'RIVERA', 'CRUZ', 'LILIANA SARAI', '');
INSERT INTO `view_vista_credenciales` VALUES ('159', '41', '1035', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'ROVA830804SXA', '39038324131', '2012-05-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1035', 'RODRIGUEZ', 'VELAZQUEZ', 'ALEJANDRA', '');
INSERT INTO `view_vista_credenciales` VALUES ('160', '41', '1079', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'ROCA830323568', '37058310733', '2012-07-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1079', 'ROSALES', 'COTO', 'ALEJANDRA', '');
INSERT INTO `view_vista_credenciales` VALUES ('161', '41', '364', null, 'FACILITADOR LABORATORIO CALIBRACION', 'CHRYSLER TOLUCA', 'ROVN760422M5A', '16007606938', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '364', 'ROSSANO', 'VALDEZ', 'NELSON HECTOR', '');
INSERT INTO `view_vista_credenciales` VALUES ('162', '41', '270', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'SAMI790710964', '11977924114', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '270', 'SANCHEZ', 'MONROY', 'IGNACIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('163', '41', '286', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'SOAJ830103TH6', '01988302046', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '286', 'SOLORZANO', 'AHUMADA', 'JAIRO RAFAEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('164', '41', '292', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'TOFU821213PB8', '30018230638', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '292', 'TORRES', 'FLORES', 'UBALDO ALEJANDRO', '');
INSERT INTO `view_vista_credenciales` VALUES ('165', '41', '305', null, 'TEC. MEC. AUTOMOTRIZ', 'CHRYSLER SANTA.FE', 'VAMC770225KW3', '07957712289', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '305', 'VARGAS', 'MARTINEZ', 'CESAR HERIBERTO', '');
INSERT INTO `view_vista_credenciales` VALUES ('166', '41', '946', null, 'TÉCNICO MECÁNICO', 'CHRYSLER SANTA.FE', 'VIRJ880110NW7', '30068823209', '2012-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '946', 'VILLEDA', 'RUBIO', 'JOSUE REYNALDO', '');
INSERT INTO `view_vista_credenciales` VALUES ('167', '41', '1394', null, 'ENFERMERA', 'CHRYSLER SALTILLO', 'MEOA8405128G2', '32128401257', '2014-03-24', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1394', 'MEDINA', 'ORTIZ', 'ALEJANDRINA', 'ginay0512.amo@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('168', '41', '1393', null, 'ENFERMERO', 'CHRYSLER SALTILLO', 'VAHA861128B89', '32058634778', '2014-03-24', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1393', 'VALDEZ', 'HERRERA', 'ALBERTO ISAAC', 'BTO_VH@HOTMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('169', '41', '1396', null, 'AUDITOR DINAMICA EXTENDIDA', 'CHRYSLER TOLUCA', 'CAPP880913AVA', '16038802209', '2014-04-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1396', 'CARRILLO', 'PEREIRA', 'PEDRO', '');
INSERT INTO `view_vista_credenciales` VALUES ('170', '41', '1397', null, 'AUDITOR DINAMICA EXTENDIDA', 'CHRYSLER TOLUCA', 'BAAJ890709L26', '11138907966', '2014-04-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1397', 'BAUTISTA', 'AZCARRAGA', 'JOSHUA', '');
INSERT INTO `view_vista_credenciales` VALUES ('171', '41', '1340', null, 'INGENIERO DE DESARROLLO DE MATERIALES', 'CHRYSLER SANTA.FE', 'PEJD860505HU5', '90098603674', '2014-04-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1340', 'PEREZ', 'JIMENEZ', 'DIEGO DANIEL', 'DANIEL7473@HOTMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('172', '41', '1400', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SALTILLO', 'SEMC850204173', '32038524461', '2014-04-15', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1400', 'SERNA', 'MARTINEZ', 'MARIA DEL CARMEN', 'maria_42rt@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('173', '41', '1399', null, 'MEDICO DE TURNO', 'CHRYSLER SALTILLO', 'RARJ7607073M5', '32017608087', '2014-04-14', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1399', 'RANGEL', 'RAMIREZ', 'JUANA MARIA', 'rangel_jm@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('174', '41', '1403', null, 'INGENIERO', 'CHRYSLER TOLUCA', 'CAGI910312279', '16119153753', '2014-05-12', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1403', 'CAMACHO', 'GUTIERREZ', 'ILSE', '');
INSERT INTO `view_vista_credenciales` VALUES ('175', '41', '1405', null, 'INGENIERO', 'CHRYSLER TOLUCA', 'ZEFR651028U2A', '96906501109', '2014-05-12', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1405', 'ZENDEJAS', 'FUENTES', 'RICARDO', '');
INSERT INTO `view_vista_credenciales` VALUES ('176', '41', '1406', null, 'INGENIERO', 'CHRYSLER TOLUCA', 'GUAN870723522', '92108710499', '2014-05-12', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1406', 'GUTIERREZ', 'ARTEAGA', 'NOE', '');
INSERT INTO `view_vista_credenciales` VALUES ('177', '41', '1402', null, 'INGENIERO', 'CHRYSLER TOLUCA', 'RAVA8609305K8', '16068641618', '2014-05-12', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1402', 'RAMIREZ', 'VAZQUEZ', 'ADAN', '');
INSERT INTO `view_vista_credenciales` VALUES ('178', '41', '410', null, 'TECNICO DE SEGURIDAD', 'CHRYSLER SALTILLO', 'VALA671127A84', '49916749978', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '410', 'VALDES', 'DE LEON', 'ARNULFO SALVADOR', '');
INSERT INTO `view_vista_credenciales` VALUES ('179', '41', '1404', null, 'INGENIERO', 'CHRYSLER TOLUCA', 'JAHE850715SS5', '16108513843', '2014-05-12', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1404', 'JAIME', 'HERNANDEZ', 'ERANDENI', '');
INSERT INTO `view_vista_credenciales` VALUES ('180', '41', '1411', null, 'INGENIERO EN SISTEMAS DE ENFRIAMIENTO DE MOTOR', 'CHRYSLER SANTA.FE', 'VALR8703024R7', '39118705480', '2014-06-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1411', 'VASQUEZ', 'LEYVA', 'RICARDO', 'rivale23@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('181', '41', '1410', null, 'INGENIERO EN SISTEMAS DE ENFRIAMIENTO DE MOTOR', 'CHRYSLER SANTA.FE', 'FARR900330B9A', '92139011685', '2014-06-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1410', 'FACIO', 'RIVERA', 'RODOLFO FELICIANO', 'beautiful-facio@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('182', '41', '1412', null, 'INGENIERO', 'CHRYSLER SANTA.FE', 'EUFL910314ID7', '03149164083', '2014-06-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1412', 'ESCUDERO', 'FRANCO', 'LUIS EDUARDO', 'lalo.escudero@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('183', '41', '1415', null, 'INGENIERO DE CALIDAD A PROVEEDORES', 'CHRYSLER SANTA.FE', 'SIQR841212LKA', '16078406457', '2014-06-09', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1415', 'SILVA', 'QUIROZ', 'RAUL', 'raul_silva@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('184', '41', '1028', null, 'ANALISTA', 'CHRYSLER SANTA.FE', 'PUPL8501137D9', '94078502195', '2014-06-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1028', 'PURECO', 'PIEDRAS', 'LUZ MARIA', '');
INSERT INTO `view_vista_credenciales` VALUES ('185', '41', '1414', null, 'ANALISTA DE ESTANDARES', 'CHRYSLER SANTA.FE', 'VIVE9010044K7', '16109059770', '2014-06-09', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1414', 'VILLA', 'VALLEJO', 'ESTEFANY', 'estefany.v.v@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('186', '41', '1343', null, 'ENFERMERO', 'CHRYSLER SALTILLO', 'GOOR731003HS9', '32897298272', '2014-05-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1343', 'GONZALEZ', 'OROZCO', 'RAFAEL', 'RAFAGONZALEZ73@HOTMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('187', '41', '1418', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'CAOM971014RB3', '27148913208', '2014-06-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1418', 'CACHOA', 'OCAMPO', 'MIGUEL', 'cachoamiguel@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('188', '41', '181', null, 'ESPECIALISTA EN REPRESENTACION EN EL MERCADO', 'CHRYSLER SANTA.FE', 'MEHM511124DC7', '06715102114', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '181', 'MEDINA', 'HERNANDEZ', 'JOSE MARCOS', '');
INSERT INTO `view_vista_credenciales` VALUES ('189', '41', '1417', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'FOHE900712239', '8149008305', '2014-06-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1417', 'FLORAN', 'HERNANDEZ', 'ERIC BENJAMIN', 'ebenfloh@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('190', '41', '1076', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'LEHM820618E80', '94068202376', '2014-06-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1076', 'LEDESMA', 'HUERTA', 'MAURICIO ARTURO', '');
INSERT INTO `view_vista_credenciales` VALUES ('191', '41', '1092', null, 'TECNICO DE DESARROLLO DE VEHICULOS', 'CHRYSLER SANTA.FE', 'HEAF850425N82', '45008500378', '2014-06-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1092', 'HERNANDEZ', 'ANICETO', 'FROYLAN', 'froylan85@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('192', '41', '1371', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'CUGR900321LX4', '37149000111', '2014-06-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1371', 'CRUZ', 'GARCIA', 'JOSE RAMON', '');
INSERT INTO `view_vista_credenciales` VALUES ('193', '41', '1424', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'TELI9103266L7', '08149191812', '2014-07-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1424', 'TREVINO', 'LOPE', 'ILSE DENISE', 'denise.trevino.26@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('194', '41', '1426', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'SAMU910215IJ9', '08149159942', '2014-07-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1426', 'SANCHEZ', 'MORALES', 'ULISES', 'castordentista@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('195', '41', '1427', null, 'INGENIERO', 'CHRYSLER SANTA.FE', 'LUPD910914HS8', '08149148697', '2014-07-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1427', 'LUGO', 'PINON', 'DIANA', 'diana.lugo.pi@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('196', '41', '1425', null, 'INGENIERO DE DESARROLLO DE MATERIALES', 'CHRYSLER SANTA.FE', 'GACI860403GR2', '16038603532', '2014-07-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1425', 'GARCIA', 'CARBAJAL', 'ILIANA', 'igilianagarcia@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('197', '41', '1428', null, 'COORDINADOR DE ATRACCION DE TALENTO', 'CHRYSLER SANTA.FE', 'CALA8701224MA', '75068734047', '2014-07-07', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1428', 'CARBALLIDO', 'LOZANO', 'ANTONIO', 'acarballido87@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('198', '41', '1429', null, 'ENFERMERO', 'CHRYSLER SALTILLO', 'VABA880402S10', '32108822522', '2014-07-07', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1429', 'VAZQUEZ', 'BRIONES', 'ALEJANDRO', 'ato_vazquez@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('199', '41', '1430', null, 'ENFERMERO', 'CHRYSLER SALTILLO', 'VAVG900902TB6', '32089036100', '2014-07-07', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1430', 'VARGAS', 'VAZQUEZ', 'JOSE GUADALUPE', 'josevargas183@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('200', '41', '1433', null, 'MEDICO DE TURNO', 'CHRYSLER TOLUCA', 'AAHA780911H2A', '32997827459', '2014-07-15', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1433', 'ALARCON', 'HERNANDEZ', 'ARTURO', '');
INSERT INTO `view_vista_credenciales` VALUES ('201', '41', '1434', null, 'SUPERVISOR', 'CHRYSLER TOLUCA', 'REEM800803KU6', '18958035059', '2014-07-14', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1434', 'REA', 'ESQUIVEL', 'MARLENNE BRENDA', '');
INSERT INTO `view_vista_credenciales` VALUES ('202', '41', '1421', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'MAQC8903155L0', '27148908521', '2014-06-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1421', 'MALDONADO', 'QUIROZ', 'CRISTHIAN', 'cmaldonadoq@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('203', '41', '1432', null, 'COORDINADOR DE CAPACITACION', 'CHRYSLER SANTA.FE', 'FOAC900115KY1', '42109008401', '2014-07-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1432', 'FLORES', 'ALEJANDRE', 'CARMEN FERNANDA', 'fernandaalejandre@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('204', '41', '1431', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'ROBC710717HW9', '18877118093', '2014-07-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1431', 'ROJAS', 'BLACIO', 'CRISOFORO ARTURO', 'roblacrisart@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('205', '41', '1423', null, 'CAPACITADOR TECNICO', 'CHRYSLER TOLUCA', 'EIGI8412155M7', '16058416740', '2014-06-09', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1423', 'ESPINOZA', 'GONZALEZ', 'IVONNE LUCIA', '');
INSERT INTO `view_vista_credenciales` VALUES ('206', '41', '1436', null, 'MATERIAL LOGISTICS PLANNER', 'CHRYSLER SALTILLO', 'VAVP911217JT2', '32109131543', '2014-07-25', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1436', 'VALDEZ', 'VELAZQUEZ', 'PERLA ESMERALDA', 'cp_perlavaldez@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('207', '41', '1438', null, 'ESPECIALISTA EN ESPECIFICACIONES', 'CHRYSLER SANTA.FE', 'DIVA701206542', '07937001274', '2014-08-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1438', 'DIAZ', 'VILLEGAS', 'ARMANDO', 'nigthryderb@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('208', '41', '1437', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'EIMA840920UL2', '30088402646', '2014-08-04', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1437', 'ESPINOZA', 'MIGUEL', 'ABRAHAM', 'abraham.espinoza@outlook.com');
INSERT INTO `view_vista_credenciales` VALUES ('209', '41', '1409', null, 'MEDICO CORPORATIVO', 'CHRYSLER SANTA.FE', 'MOGA730105CE6', '16877307831', '2014-05-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1409', 'MONTAÑO', 'GUTIERREZ', 'AMELIA', 'MONTANOAMELIA@HOTMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('210', '41', '1441', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SALTILLO', 'AOEA901124N66', '32129010685', '2014-08-13', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1441', 'ARROYO', 'ELIZONDO', 'ANDREA', 'andreaarroyo24@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('211', '41', '1440', null, 'AGENTE DE HELP DESK', 'CHRYSLER TOLUCA', 'BAHR890524V32', '16058907110', '2014-08-11', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1440', 'BAZAN', 'HERNANDEZ', 'RICARDO', '');
INSERT INTO `view_vista_credenciales` VALUES ('212', '41', '1439', null, 'AGENTE DE HELP DESK', 'CHRYSLER TOLUCA', 'FAPC830703K47', '43998372262', '2014-08-11', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1439', 'FAST', 'PAEZ', 'CINTHIA', '');
INSERT INTO `view_vista_credenciales` VALUES ('213', '41', '1442', null, 'INGENIERO', 'CHRYSLER TOLUCA', 'FUGE790129M40', '16977962436', '2014-08-18', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1442', 'FUENTES', 'GOMEZ', 'EDGARDO', '');
INSERT INTO `view_vista_credenciales` VALUES ('214', '41', '1443', null, 'TECNICO ALMACENISTA', 'CHRYSLER SANTA.FE', 'PIMI920621HB3', '90109217811', '2014-08-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1443', 'PIZAR', 'MAYEN', 'IRVING ANTONIO', 'ipizar@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('215', '41', '1444', null, 'INGENIERO DE EMPAQUETAMIENTO', 'CHRYSLER SANTA.FE', 'SABL9011034Y7', '03149044608', '2014-08-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1444', 'SANCHEZ', 'BRAVO', 'LILIANA', 'lilianasanchezbravo@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('216', '41', '1445', null, 'INGENIERO', 'CHRYSLER TOLUCA', 'MASV891113LW5', '16118921515', '2014-08-25', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1445', 'MARTINEZ', 'SOBERANES', 'VICTOR HUGO', '');
INSERT INTO `view_vista_credenciales` VALUES ('217', '41', '1455', null, 'ANALISTA DE PROYECTOS', 'CHRYSLER SANTA.FE', 'AUBL800222M6A', '30988019763', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1455', 'ANGULO', 'BALDERAS', 'LAURA', 'lau_lab2000@yahoo.com.mx');
INSERT INTO `view_vista_credenciales` VALUES ('218', '41', '1462', null, 'ANALISTA DE NOMINA', 'CHRYSLER SALTILLO', 'EATM8101292P3', '32978179896', '2014-09-02', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1462', 'ESTRADA', 'TREVINO', 'MARISELA', 'mariselaestrada81@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('219', '41', '1453', null, 'ANALISTA DE GARANTIAS', 'CHRYSLER SANTA.FE', 'BEVV740720FP5', '30927458114', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1453', 'BRETON', 'VALDEZ', 'VICTOR MANUEL', 'vmbreton@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('220', '41', '1446', null, 'ANALISTA DE INCENTIVOS DE PAGO', 'CHRYSLER SANTA.FE', 'MAGT870331645', '07118704134', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1446', 'MARIN', 'GARCIA', 'TOMAS ABDIAS', 'thomas@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('221', '41', '1447', null, 'ANALISTA DE MGA', 'CHRYSLER SANTA.FE', 'MAMA781129QD4', '16007804681', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1447', 'MARTINEZ', 'MENDOZA', 'ALDO', 'doal_11@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('222', '41', '1448', null, 'ANALISTA DE MGA', 'CHRYSLER SANTA.FE', 'COMM9104186YA', '16129142960', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1448', 'CORRAL', 'MUNGUIA', 'MARIO FERNANDO', 'dadfather_55@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('223', '41', '1449', null, 'ANALISTA DE INCENTIVOS', 'CHRYSLER SANTA.FE', 'AIGD8004079L2', '39018000768', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1449', 'ARIAS', 'GUILLEN', 'DULCE KARLA JANNET', 'vp95@chrysler.com');
INSERT INTO `view_vista_credenciales` VALUES ('224', '41', '1450', null, 'ANALISTA DE MGA', 'CHRYSLER SANTA.FE', 'CAGC9108088Q6', '42099111900', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1450', 'CASTILLO', 'GARCIA', 'CATARINA', 'kattycasgar@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('225', '41', '1451', null, 'ANALISTA DE GASTOS FIJOS', 'CHRYSLER SANTA.FE', 'PESS900213AP2', '37099012405', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1451', 'PEREZ', 'SANCHEZ', 'SOFIA', 'sofiaps.7@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('226', '41', '1452', null, 'ANALISTA DE INCENTIVOS', 'CHRYSLER SANTA.FE', 'MOBA651224M58', '92916500082', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1452', 'MONDRAGON', 'BERNABE', 'ARACELI', '');
INSERT INTO `view_vista_credenciales` VALUES ('227', '41', '1454', null, 'ANALISTA DE GARANTIAS', 'CHRYSLER SANTA.FE', 'TIMJ661116DV2', '64856603739', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1454', 'TINOCO', 'MANRIQUE', 'JUAN', 'juanm16@yahoo.com.mx');
INSERT INTO `view_vista_credenciales` VALUES ('228', '41', '1456', null, 'ESPECIALISTA DE GARANTIAS', 'CHRYSLER SANTA.FE', 'GOAA8212213Y6', '28088200275', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1456', 'GONZALEZ', 'AGUILAR', 'ABRAHAM', 'abraham_glz@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('229', '41', '1457', null, 'COORDINADOR DE ATENCION A CLIENTES', 'CHRYSLER SANTA.FE', 'GACL870331NZ6', '92138703407', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1457', 'GARCIA', 'CASAS', 'LUIS ANGEL', 'red2fourty@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('230', '41', '1458', null, 'COORD DE ESTANDARES DE DISTRIBUIDORAS', 'CHRYSLER SANTA.FE', 'AOTE840516616', '16068419254', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1458', 'AYLLON', 'TAPIA', 'ESBEIRE', 'esbeireayte@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('231', '41', '1459', null, 'ESPECIALISTA DE PROTECCION VEHICULAR', 'CHRYSLER SANTA.FE', 'MABN890624T70', '03148919313', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1459', 'MARQUEZ', 'BURGOA', 'NATALIA GABRIEL', 'addyburgoa@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('232', '41', '1460', null, 'ESPECIALISTA EHS', 'CHRYSLER SANTA.FE', 'OIRP880712TC5', '01058802263', '2014-09-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1460', 'ORTIZ', 'REZA', 'PEDRO', 'peter.or@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('233', '41', '1461', null, 'INGENIERO CONTROL DIMENSIONAL', 'CHRYSLER SANTA.FE', 'GOMA890818E95', '92128911812', '2014-09-04', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1461', 'GONZALEZ', 'MEDINA', 'ARMANDO ALLAN', 'gringoallan@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('234', '41', '1463', null, 'MEDICO DE TURNO', 'CHRYSLER TOLUCA', 'RALI870822EY9', '08148770871', '2014-12-22', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1463', 'DEL RAZO', 'LOPEZ', 'INGRID FRANCELI', '');
INSERT INTO `view_vista_credenciales` VALUES ('235', '41', '1465', null, 'ESPECIALISTA EN ESPECIFICACIONES', 'CHRYSLER SANTA.FE', 'GAVA830121FM5', '90018344292', '2014-09-17', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1465', 'GAMIZ', 'VARGAS', 'ANDRES GERARDO', 'andres.gamiz@live.com.mx');
INSERT INTO `view_vista_credenciales` VALUES ('236', '41', '1132', null, 'AUDITOR DINAMICA EXTENDIDA', 'CHRYSLER SALTILLO', 'AEMS870930H19', '32058778104', '2012-09-26', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1132', 'ALEMAN', 'MENDOZA', 'SERGIO EDUARDO', 'a_pasific@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('237', '41', '1466', null, 'MEDICO DE TURNO', 'CHRYSLER SALTILLO', 'MUAE790309GJ5', '71077900737', '2014-09-22', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1466', 'MUNOZ', 'ALANIS', 'ETNA FATIMA', 'fuerza1804@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('238', '41', '1467', null, 'ENFERMERA', 'CHRYSLER SALTILLO', 'NEVJ700715293', '32927077951', '2014-09-23', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1467', 'NEYRA', 'VELAZQUEZ', 'JUANA', 'juamaneyve@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('239', '41', '1469', null, 'INGENIERO DE EMPAQUETAMIENTO', 'CHRYSLER SANTA.FE', 'GULM901114SE4', '37139007522', '2014-10-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1469', 'GUERRA', 'LUZ', 'MAURICIO', 'mauricio.guerraluz@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('240', '41', '198', null, 'ASISTENTE ADMINISTRATIVA', 'CHRYSLER SANTA.FE', 'NAJI820728BA1', '45038225368', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '198', 'NANDAYAPA', 'JIMENEZ', 'MARIA ISABEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('241', '41', '1468', null, 'ANALISTA DE MERCADOTECNIA DIGITAL', 'CHRYSLER SANTA.FE', 'FENE790424SP9', '39037904248', '2014-10-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1468', 'FERREIRO', 'NUNEZ', 'ELSA ALEJANDRA', 'elsalexa@yahoo.com');
INSERT INTO `view_vista_credenciales` VALUES ('242', '41', '1471', null, 'INGENIERO DE PRODUCTO CORE ELECTRICAL', 'CHRYSLER SANTA.FE', 'GALA920525718', '96109234854', '2014-10-20', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1471', 'GARCIA', 'LEON', 'ARTURO', 'arturo_garcia_alan@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('243', '41', '1472', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'RODO890210HY3', '05148920209', '2014-10-20', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1472', 'RODRIGUEZ', 'DIEGO', 'OMAR SAID', 'osr.diego@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('244', '41', '1473', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'NUCE860503634', '11108602027', '2014-10-17', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1473', 'NUÑEZ', 'CRUZ', 'JOSE EDUARDO', 'ING.JOSEEDUARDO@GMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('245', '41', '1470', null, 'ANALISTA DE CALIDAD', 'CHRYSLER SALTILLO', 'AALD9002152M2', '32129010933', '2014-10-20', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1470', 'AMAYA', 'LUCIO', 'DALIA', 'daliia15@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('246', '41', '1298', null, 'INGENIERO MQAS', 'CHRYSLER SALTILLO', 'GAVJ9006152R4', '32089042413', '2013-08-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1298', 'GARZA', 'VILLARREAL', 'JUAN JOSE', 'juan.garza@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('247', '41', '1474', null, 'MEDICO DE TURNO', 'CHRYSLER SALTILLO', 'SACH860307KW9', '32048630084', '2014-10-30', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1474', 'SANTOYO', 'CONTRERAS', 'HECTOR EDUARDO ADRIAN', 'hector10santoyo@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('248', '41', '1476', null, 'INGENIERO DE CHASIS', 'CHRYSLER SANTA.FE', 'BOSG8807304H5', '90128808525', '2014-11-03', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1476', 'BOGUSLAVSKY', 'SAYUN', 'GARY', 'garybogus@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('249', '41', '1477', null, 'ANALISTA DE PRESUPUESTO', 'CHRYSLER TOLUCA', 'POJM8902176L4', '72088917132', '2014-11-11', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1477', 'POBLETE', 'JUAREZ', 'MIGUEL ANGEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('250', '41', '1478', null, 'FACILITADOR LABORATORIO CALIBRACION', 'CHRYSLER TOLUCA', 'MAOM8710242I7', '16068736723', '2014-11-10', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1478', 'MARCOS', 'ORDOÑEZ', 'MARCO ANTONIO', '');
INSERT INTO `view_vista_credenciales` VALUES ('251', '41', '1475', null, 'CHOFER EJECUTIVO', 'CHRYSLER TOLUCA', 'AAMA790526MA3', '16957901875', '2014-11-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1475', 'ALVAREZ', 'MUNGUIA', 'AARON', '');
INSERT INTO `view_vista_credenciales` VALUES ('252', '41', '1348', null, 'TECNICO DE SEGURIDAD', 'CHRYSLER SALTILLO', 'AAHF6802051VA', '32866883609', '2014-12-22', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1348', 'ALMANZA', 'HERNANDEZ', 'FELIPE DE JESUS', 'felm68@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('253', '41', '1479', null, 'COORDINADOR DE CAPACITACION', 'CHRYSLER SANTA.FE', 'GAAA750501C55', '28977500322', '2014-12-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1479', 'GARCIA', 'AMAYA', 'ARELI', 'ARELIGAG@HOTMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('254', '41', '1480', null, 'INGENIERO MQAS', 'CHRYSLER SALTILLO', 'FUZG920101JG1', '10149244641', '2014-12-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1480', 'FUENTES', 'ZUÑIGA', 'MARIA GABRIELA', 'gabyfzuniga@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('255', '41', '1481', null, 'INGENIERO MQAS', 'CHRYSLER SALTILLO', 'HEAT911210TS7', '32089125648', '2014-12-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1481', 'HERNANDEZ', 'ALVAREZ', 'TANIA', 'tania.hdz.alvarez@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('256', '41', '1482', null, 'MEDICO DE TURNO', 'CHRYSLER TOLUCA', 'MEBI771002G68', '62957720717', '2014-12-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1482', 'MEZA', 'BELTRAN', 'ISAAC', '');
INSERT INTO `view_vista_credenciales` VALUES ('257', '41', '1486', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER TOLUCA', 'HEMG880306MN8', '16108833092', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1486', 'HERNANDEZ', 'MARTINEZ', 'GERARDO ANTONIO', 'g.antonio.hm63@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('258', '41', '1797', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER SALTILLO', 'BEHJ880628D3A', '32088831667', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1797', 'BERLANGA', 'HERNANDEZ', 'JOHNATAN ALBERTO', 'jbhdz@outlook.com');
INSERT INTO `view_vista_credenciales` VALUES ('259', '41', '1488', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER TOLUCA', 'LAVE8503255Z9', '37088511227', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1488', 'LADRON DE GUEVARA', 'VELAZQUEZ', 'EDUARDO', 'lalo_boss@yahoo.com');
INSERT INTO `view_vista_credenciales` VALUES ('260', '41', '1798', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER SALTILLO', 'CAUL801005424', '60978089575', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1798', 'CARRUM', 'URIBE', 'LAYLA', 'laylacarrum@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('261', '41', '1484', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER TOLUCA', 'MORH551029AF3', '01795588035', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1484', 'MONTOYA', 'RAMIREZ', 'HUMBERTO JAVIER', 'tito_chapu29@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('262', '41', '1801', null, 'ING PRODUCCION', 'CHRYSLER SALTILLO', 'GAAK930226UK2', '32089309168', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1801', 'GARAY', 'AGÜERO', 'KARLA ALEJANDRA', 'KARLA GARAYAGUERO@OUTLOOK.COM');
INSERT INTO `view_vista_credenciales` VALUES ('263', '41', '1492', null, 'COMPRADOR MRO PARA MP', 'CHRYSLER SANTA.FE', 'FOXM850309NX4', '92138502494', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1492', 'FROMENT', '0', 'MARINE', 'marinefroment@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('264', '41', '1485', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER TOLUCA', 'AAOC871003RTA', '16098720051', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1485', 'ALDAMA', 'OROZCO', 'CESAR', 'lucas_12_82@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('265', '41', '1489', null, 'ESPECIALISTA DE GARANTIAS', 'CHRYSLER SANTA.FE', 'SAGJ790313M60', '16007914449', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1489', 'SANCHEZ', 'GONZALEZ', 'JUAN GABRIEL', 'gabovalesanriv@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('266', '41', '1491', null, 'COMPRADOR MRO PARA MP', 'CHRYSLER SANTA.FE', 'GUOM8803254D1', '39138803349', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1491', 'GUERRERO', 'OLALDE', 'MARLENE', 'marolalde@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('267', '41', '1483', null, 'TECNICO SAP PARA SNEP', 'CHRYSLER SANTA.FE', 'READ8704224C1', '96088701550', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1483', 'REYES', 'ANGELES', 'DANIELA', 'daniela.r.angeles39@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('268', '41', '1490', null, 'COMPRADOR MRO PARA MP', 'CHRYSLER SANTA.FE', 'VARJ900726L86', '16109065173', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1490', 'VALENCIA', 'ROMERO', 'JESUS EMMANUEL', '');
INSERT INTO `view_vista_credenciales` VALUES ('269', '41', '1493', null, 'ESPECIALISTA EN LEARNING & DEVELOPMENT', 'CHRYSLER SANTA.FE', 'MAHA880712QC1', '92118801288', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1493', 'MACHUCA', 'HERNANDEZ', 'ANGELICA', '');
INSERT INTO `view_vista_credenciales` VALUES ('270', '41', '1794', null, 'ANALISTA DE INTELIGENCIA DE MERCADO', 'CHRYSLER SANTA.FE', 'ROAB911028HN3', '10149179417', '2015-01-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1794', 'RODRIGUEZ', 'ARROYO', 'BLANCA PAOLA', 'paola.rdz.28@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('271', '41', '1795', null, 'UNIT LEADER', 'CHRYSLER TOLUCA', 'ROVA890424GE0', '16068930979', '2015-01-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1795', 'ROMERO', 'VALLE', 'ALEJANDRO', '');
INSERT INTO `view_vista_credenciales` VALUES ('272', '41', '1796', null, 'MEDICO DE TURNO', 'CHRYSLER TOLUCA', 'OALL880812227', '16108838109', '2015-01-05', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1796', 'OLALDE', 'LOPEZ', 'LUIS ALBERTO', '');
INSERT INTO `view_vista_credenciales` VALUES ('273', '41', '1487', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER TOLUCA', 'LUGJ830414JJ4', '20088200058', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1487', 'LUCIO', 'GARCIA', 'JOSUE', 'jhosuasme@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('274', '41', '1800', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER SALTILLO', 'CUMS9003228T4', '32089001450', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1800', 'CRUZ', 'MARTINEZ', 'SERGIO OMAR', 'checo_cm90@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('275', '41', '1799', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER SALTILLO', 'CUAL910210JD8', '32119153842', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1799', 'CRUZ', 'ARREDONDO', 'LUIS ANGEL', 'cruz_me412@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('276', '41', '1802', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER SALTILLO', 'JICG600718LUA', '32806033802', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1802', 'JIMENEZ', 'COVARRUBIAS', 'JOSE GUADALUPE', 'jjimenez12397@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('277', '41', '1804', null, 'INGENIERO', 'CHRYSLER SANTA.FE', 'NOBJ910610PP7', '32139124518', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1804', 'NOYOLA', 'BAROCIO', 'JUAN PABLO', 'jp.noyola@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('278', '41', '1805', null, 'INGENIERO', 'CHRYSLER SANTA.FE', 'SEEA910625NK4', '03149106571', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1805', 'SERRANO', 'ESCOBAR', 'ALAN', 'aserrano409@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('279', '41', '1360', null, 'AUDITOR DE CALIDAD', 'CHRYSLER SALTILLO', 'CACU8604099Z4', '32108603120', '2015-01-07', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1360', 'CALVILLO', 'CERDA', 'UBALDO MATEO', 'ubaldo_mateo@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('280', '41', '1803', null, 'INGENIERO DE SOPORTE', 'CHRYSLER SANTA.FE', 'LIAC6611065L9', '88846609258', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1803', 'LIRA', 'ALANIS', 'CAROLINA', 'carolira11@yahoo.com.mx');
INSERT INTO `view_vista_credenciales` VALUES ('281', '41', '1806', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'DUCD9205251Q6', '11109207271', '2015-01-12', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1806', 'DUARTE', 'CERVANTES', 'DANIEL ALEJANDRO', '');
INSERT INTO `view_vista_credenciales` VALUES ('282', '41', '376', null, 'CHOFER EJECUTIVO', 'CHRYSLER SALTILLO', 'BEMH770725B93', '32017708119', '2010-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '376', 'BERLANGA', 'MONTES', 'HUGO', '');
INSERT INTO `view_vista_credenciales` VALUES ('283', '41', '1373', null, 'ING. LAYOUTISTA / NX &TEAM CENTER', 'CHRYSLER TOLUCA', 'RARJ9108199H0', '03149146890', '2015-01-01', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1373', 'RAMIREZ', 'RUIZ', 'JORGE', '');
INSERT INTO `view_vista_credenciales` VALUES ('284', '41', '1808', null, 'ESPECIALISTA AMBIENTAL', 'CHRYSLER SANTA.FE', 'BALG870919FW2', '42118707233', '2015-01-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1808', 'BARRIENTOS', 'LEAL', 'GLADIS', '');
INSERT INTO `view_vista_credenciales` VALUES ('285', '41', '1809', null, 'ANALISTA DE PROTECION VEHICULAR', 'CHRYSLER SANTA.FE', 'IACG8801062A9', '02158819264', '2015-01-19', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1809', 'IBAÑEZ', 'CASTRO', 'GUILLERMO', 'GUILLERMO.IBANEZ@GMAIL.COM');
INSERT INTO `view_vista_credenciales` VALUES ('286', '41', '1810', null, 'INGENIERO DE PRODUCTO', 'CHRYSLER SANTA.FE', 'NEMR910313NUA', '02159146980', '2015-01-19', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1810', 'NERI', 'MIJANGOS', 'ROGELIO IVAN', 'ivannm@hotmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('287', '41', '1807', null, 'ANALISTA DE TALENT MANAGMENT', 'CHRYSLER SANTA.FE', 'ROVA890922HYA', '09068992776', '2015-01-16', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1807', 'ROCHA', 'VIVENCIO', 'ARIANNA', 'arocha.vicencio@gmail.com');
INSERT INTO `view_vista_credenciales` VALUES ('288', '41', '1133', null, 'FACILITADOR CVQS', 'CHRYSLER SALTILLO', 'VAEK900125PTA', '32109021769', '2015-01-19', 'CHRYSLR2012', 'CHRYSLER MEXICO S.A DE C.V', '1133', 'VALDES', 'ESPINOZA', 'KARINA ALEJANDRA', 'karyvaldes_25@hotmail.com');
