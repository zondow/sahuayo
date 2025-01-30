
-- Volcando estructura para tabla sahuayo_prueba.cuestionario
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

-- Volcando estructura para tabla sahuayo_prueba.evaluadocuestionario
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

-- Volcando estructura para tabla sahuayo_prueba.evaluadorcuestionario
CREATE TABLE IF NOT EXISTS `evaluadorcuestionario` (
  `eva_EvaluadorCuestionarioID` int(11) NOT NULL AUTO_INCREMENT,
  `eva_CuestionarioID` int(11) DEFAULT NULL,
  `eva_EmpleadoID` int(11) DEFAULT NULL,
  `eva_UsuarioID` int(11) DEFAULT NULL,
  `eva_Fecha` date DEFAULT NULL,
  PRIMARY KEY (`eva_EvaluadorCuestionarioID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla sahuayo_prueba.evaluadorcuestionario: ~6 rows (aproximadamente)
INSERT INTO `evaluadorcuestionario` (`eva_EvaluadorCuestionarioID`, `eva_CuestionarioID`, `eva_EmpleadoID`, `eva_UsuarioID`, `eva_Fecha`) VALUES
	(3, 1, 84, 105, '0000-00-00'),
	(4, 1, 45, 105, '0000-00-00'),
	(5, 1, 72, 105, '0000-00-00'),
	(6, 1, 31, 105, '0000-00-00'),
	(7, 1, 24, 105, '0000-00-00'),
	(8, 1, 64, 105, '0000-00-00');

-- Volcando estructura para tabla sahuayo_prueba.grupocuestionario
CREATE TABLE IF NOT EXISTS `grupocuestionario` (
  `gru_GrupoID` int(11) NOT NULL AUTO_INCREMENT,
  `gru_Titulo` varchar(100) NOT NULL,
  `gru_UsuarioID` int(11) NOT NULL DEFAULT 0,
  `gru_Fecha` date NOT NULL DEFAULT current_timestamp(),
  `gru_Estatus` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`gru_GrupoID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sahuayo_prueba.grupocuestionario: ~2 rows (aproximadamente)
INSERT INTO `grupocuestionario` (`gru_GrupoID`, `gru_Titulo`, `gru_UsuarioID`, `gru_Fecha`, `gru_Estatus`) VALUES
	(1, 'Grupo 1', 105, '2024-11-21', 1),
	(2, 'Grupo 2', 105, '2024-11-21', 1);

-- Volcando estructura para tabla sahuayo_prueba.opcionrespuesta
CREATE TABLE IF NOT EXISTS `opcionrespuesta` (
  `opc_OpcionID` int(11) NOT NULL AUTO_INCREMENT,
  `opc_PreguntaID` int(11) NOT NULL DEFAULT 0,
  `opc_Texto` text NOT NULL,
  `opc_UsuarioID` int(11) NOT NULL DEFAULT 0,
  `opc_Fecha` date NOT NULL,
  `opc_Estatus` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`opc_OpcionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sahuayo_prueba.opcionrespuesta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla sahuayo_prueba.plantillacuestionario
CREATE TABLE IF NOT EXISTS `plantillacuestionario` (
  `pla_PlantillaID` int(11) NOT NULL AUTO_INCREMENT,
  `pla_Nombre` varchar(100) NOT NULL,
  `pla_Tipo` varchar(50) NOT NULL,
  `pla_Fecha` date NOT NULL DEFAULT current_timestamp(),
  `pla_Estatus` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`pla_PlantillaID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sahuayo_prueba.plantillacuestionario: ~3 rows (aproximadamente)
INSERT INTO `plantillacuestionario` (`pla_PlantillaID`, `pla_Nombre`, `pla_Tipo`, `pla_Fecha`, `pla_Estatus`) VALUES
	(1, 'Evaluacion de desempeño para cajeros', 'desempeño', '2024-10-26', 1),
	(2, 'Evaluacion de desempeño para MKT', 'desempeño', '2024-10-26', 1),
	(3, 'evaluacion de desempeño para asesores', 'desempeño', '2024-10-26', 1);

-- Volcando estructura para tabla sahuayo_prueba.preguntacuestionario
CREATE TABLE IF NOT EXISTS `preguntacuestionario` (
  `pre_PreguntaID` int(11) NOT NULL AUTO_INCREMENT,
  `pre_CuestionarioID` int(11) NOT NULL,
  `pre_GrupoID` int(11) DEFAULT NULL,
  `pre_Texto` text NOT NULL,
  `pre_TipoRespuesta` varchar(50) NOT NULL,
  `pre_Obligatoria` tinyint(4) NOT NULL DEFAULT 0,
  `pre_Ponderacion` float NOT NULL DEFAULT 0,
  `pre_UsuarioID` int(11) NOT NULL DEFAULT 0,
  `pre_Fecha` date NOT NULL DEFAULT current_timestamp(),
  `pre_Estatus` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`pre_PreguntaID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sahuayo_prueba.preguntacuestionario: ~2 rows (aproximadamente)
INSERT INTO `preguntacuestionario` (`pre_PreguntaID`, `pre_CuestionarioID`, `pre_GrupoID`, `pre_Texto`, `pre_TipoRespuesta`, `pre_Obligatoria`, `pre_Ponderacion`, `pre_UsuarioID`, `pre_Fecha`, `pre_Estatus`) VALUES
	(2, 1, 1, 'Pregunta 1', 'seleccion', 1, 0, 105, '2024-11-21', 1),
	(3, 1, 2, 'Pregunta 2', 'abierta', 1, 0, 105, '2024-11-21', 1);
