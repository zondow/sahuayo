
-- cuestionario
CREATE TABLE IF NOT EXISTS `cuestionario` (
  `cue_CuestionarioID` int(11) NOT NULL AUTO_INCREMENT,
  `cue_Titulo` varchar(100) NOT NULL,
  `cue_Descripcion` text DEFAULT NULL,
  `cue_PlantillaID` int(11) DEFAULT NULL,
  `cue_UsuarioID` int(11) NOT NULL DEFAULT 0,
  `cue_Fecha` date NOT NULL,
  `cue_Estatus` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cue_CuestionarioID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sahuayo_prueba.cuestionario: ~0 rows (aproximadamente)

--evaluadocuestionario
CREATE TABLE IF NOT EXISTS `evaluadocuestionario` (
  `eva_EvaluadoCuestionarioID` int(11) NOT NULL AUTO_INCREMENT,
  `eva_CuestionarioID` int(11) DEFAULT NULL,
  `eva_EmpleadoID` int(11) DEFAULT NULL,
  `eva_UsuarioID` int(11) DEFAULT NULL,
  `eva_Fecha` date DEFAULT NULL,
  PRIMARY KEY (`eva_EvaluadoCuestionarioID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sahuayo_prueba.evaluadocuestionario: ~15 rows (aproximadamente)
INSERT INTO `evaluadocuestionario` (`eva_EvaluadoCuestionarioID`, `eva_CuestionarioID`, `eva_EmpleadoID`, `eva_UsuarioID`, `eva_Fecha`) VALUES
	(4, 1, 108, 105, '0000-00-00'),
	(6, 1, 88, 105, '0000-00-00'),
	(7, 1, 103, 105, '0000-00-00'),
	(8, 1, 117, 105, '0000-00-00'),
	(9, 1, 54, 105, '0000-00-00'),
	(10, 1, 114, 105, '0000-00-00'),
	(11, 1, 73, 105, '0000-00-00'),
	(12, 1, 89, 105, '0000-00-00'),
	(13, 1, 102, 105, '0000-00-00'),
	(14, 1, 104, 105, '0000-00-00'),
	(15, 1, 129, 105, '0000-00-00'),
	(16, 1, 95, 105, '0000-00-00'),
	(17, 1, 107, 105, '0000-00-00'),
	(18, 1, 125, 105, '0000-00-00'),
	(19, 1, 126, 105, '0000-00-00');

-- evaluadorcuestionario
CREATE TABLE IF NOT EXISTS `evaluadorcuestionario` (
  `eva_EvaluadorCuestionarioID` int(11) NOT NULL AUTO_INCREMENT,
  `eva_CuestionarioID` int(11) DEFAULT NULL,
  `eva_EmpleadoID` int(11) DEFAULT NULL,
  `eva_UsuarioID` int(11) DEFAULT NULL,
  `eva_Fecha` date DEFAULT NULL,
  PRIMARY KEY (`eva_EvaluadorCuestionarioID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla sahuayo_prueba.evaluadorcuestionario: ~7 rows (aproximadamente)
INSERT INTO `evaluadorcuestionario` (`eva_EvaluadorCuestionarioID`, `eva_CuestionarioID`, `eva_EmpleadoID`, `eva_UsuarioID`, `eva_Fecha`) VALUES
	(3, 1, 84, 105, '0000-00-00'),
	(4, 1, 45, 105, '0000-00-00'),
	(5, 1, 72, 105, '0000-00-00'),
	(6, 1, 31, 105, '0000-00-00'),
	(7, 1, 24, 105, '0000-00-00'),
	(8, 1, 64, 105, '0000-00-00');