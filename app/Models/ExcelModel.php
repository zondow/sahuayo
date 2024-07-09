<?php

namespace App\Models;

use CodeIgniter\Model;

class ExcelModel extends Model
{

    //Diego - traer los departamentos por empresa
    public function traerDepartamentos()
    {
        $array = array();
        $departamentos = $this->db->query("SELECT dep_Nombre,emp_Nombre,dep_DepartamentoID FROM departamento JOIN empleado ON emp_EmpleadoID=dep_JefeID where dep_Estatus=1 order by dep_Nombre ASC")->getResultArray();
        foreach ($departamentos as $departamento) {
            $sql = "SELECT emp_Nombre FROM empleado WHERE emp_DepartamentoID=? AND emp_Nombre!=? ORDER BY emp_Nombre ASC";
            $empleados = $this->db->query($sql, array($departamento['dep_DepartamentoID'], $departamento['emp_Nombre']))->getResultArray();
            $arrayempleados = '';
            foreach ($empleados as $empleado) {
                $arrayempleados .= $empleado['emp_Nombre'] . ', ';
            }
            $data = array($departamento['dep_Nombre'], $departamento['emp_Nombre'], $arrayempleados);
            array_push($array, $data);
        }
        return $array;
    }

    //Lia->Get puestos
    function getPuestos()
    {
        return $this->db->query("select pue_Nombre,pue_Nivel from puesto where pue_Estatus=1 order by pue_Nombre ASC")->getResultArray();
    } //getPuestos


    //Lia-> get cooperativas
    function getCooperativas()
    {
        return $this->db->query("SELECT coo_Sucursal,coo_Gerente,coo_Telefono,coo_Correo FROM cooperativa  where coo_Estatus=1 order by coo_Sucursal ASC")->getResultArray();
    }

    function getEmpleadosHorario_old($fechaInicio, $fechaFinMasUnDIa, $dateCols)
    {
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Numero, E.emp_Nombre,H.hor_Nombre, H.hor_Tolerancia,S.suc_Sucursal,E.emp_SucursalID
                FROM empleado E
                LEFT JOIN horario H ON H.hor_HorarioID = E.emp_HorarioID
                LEFT JOIN sucursal S ON S.suc_SucursalID=E.emp_SucursalID
                WHERE E.emp_estatus = 1 AND E.emp_Estado='Activo'
                ORDER BY E.emp_Nombre ASC";
        $empleados = $this->db->query($sql)->getResultArray();
        $asistencia = array();
        $a = array();

        foreach ($empleados as $empleado) {
            $sql = "SELECT A.asi_Fecha AS 'fecha', A.asi_Hora AS 'hora'
                    FROM asistencia A
                    WHERE A.asi_EmpleadoID=?
                      AND A.asi_Fecha >= ? AND A.asi_Fecha <= ?";
            $marca = $this->db->query($sql, array($empleado['emp_EmpleadoID'], $fechaInicio, $fechaFinMasUnDIa))->getResultArray();

            if (!empty($marca)) {
                //Agrupar marcas por fecha
                $entradas = array();
                $salidas = array();
                $medias = array();

                foreach ($marca as $m) {
                    if (!empty($m['hora'])) {
                        $horas = json_decode($m['hora']);

                        $primeraChecada = reset($horas);
                        $ultimaChecada = end($horas);

                        if (count($horas) > 2) {
                            array_pop($horas);
                            array_shift($horas);
                            $medias[$m['fecha']] = $horas;
                        } else {
                            $medias[$m['fecha']] = "";
                        }

                        $entradas[$m['fecha']] = $primeraChecada;
                        $salidas[$m['fecha']] = $ultimaChecada;
                    } else {
                        $entradas[$m['fecha']] = "";
                        $salidas[$m['fecha']] = "";
                        $medias[$m['fecha']] = "";
                    }
                }


                $n = 0;
                $totalRetardos = 0;
                $totalFaltas = 0;
                $horaEntrada = array();
                $horaSalida = array();
                $comentarios = array();
                $i = 1;
                foreach ($dateCols as $date => $col) {

                    // == WRITE ATTENDANCE ==
                    //__SI MARCÓ EN ESA FECHA__

                    if (isset($entradas[$date])) {
                        $entrada = $entradas[$date];
                        $entradaFecha = $m['fecha'];
                        $horarioEntradaEmpleado = horarioColaborador($empleado['emp_EmpleadoID'], 'entrada', $entradaFecha);
                        $diferencia = diffDatetime($entrada, $horarioEntradaEmpleado);

                        //Dia inhabil
                        $all = '["0"]';
                        $sucursalID = $empleado['emp_SucursalID'];
                        $queryInhabiles = "SELECT D.dia_Fecha AS 'fecha', D.dia_Motivo AS 'motivo' , D.dia_SucursalID AS 'sucursal' FROM diainhabil D
                                                WHERE D.dia_Fecha = ? AND D.dia_MedioDia=0
                                            UNION SELECT DI.dial_Fecha as 'fecha', DI.dial_Motivo as 'motivo', '" . $all . "' AS 'sucursal' FROM diainhabilley DI
                                                WHERE  DI.dial_Fecha = ?";
                        $inhabiles = $this->db->query($queryInhabiles, array($date, $date))->getRowArray();

                        //Permisos
                        $queryPermisos = "SELECT P.*, C.cat_Nombre FROM permiso P
                        LEFT JOIN catalogopermiso C ON C.cat_CatalogoPermisoID=P.per_TipoID
                        WHERE ( ?  >= P.per_FechaInicio  AND  ? <=  P.per_FechaFin) AND P.per_EmpleadoID=? AND P.per_Estado = ?";
                        $permisos = $this->db->query($queryPermisos, array($date, $date, $empleado['emp_EmpleadoID'], 'AUTORIZADO_RH'))->getRowArray();

                        //Vacaciones
                        $sql = "SELECT V.vac_FechaInicio AS 'FechaIni', V.vac_FechaFin AS 'FechaFin'
                        FROM vacacion V
                        WHERE V.vac_EmpleadoID=? AND V.vac_Estatus='AUTORIZADO_RH' AND ( ?  >= V.vac_FechaInicio  AND  ? <=  V.vac_FechaFin)";
                        $vacaciones = $this->db->query($sql, array($empleado['emp_EmpleadoID'], $date, $date))->getRowArray();


                        //Incapacidad
                        $sql = "SELECT I.inc_FechaInicio AS 'FechaIni', I.inc_FechaFin AS 'FechaFin',I.inc_Tipo AS 'tipo'
                        FROM incapacidad I
                        WHERE I.inc_EmpleadoID=? AND ( ?  >= I.inc_FechaInicio  AND  ? <=  I.inc_FechaFin) AND I.inc_Estatus='Autorizada'";
                        $incapacidades = $this->db->query($sql, array($empleado['emp_EmpleadoID'], $date, $date))->getRowArray();

                        if (empty($entrada)) { //Si no hay registro de entrada

                            $descanso = DescansoColaborador($empleado['emp_EmpleadoID'], $date);

                            //Si es domingo
                            $nameDia = date("l", strtotime($date));
                            if ($nameDia === 'Sunday') {
                                $horaEntrada[$n] = 'Domingo';
                                $comentarios[$n] = "No hay registro de asistencia \r\n";
                            } elseif (!empty($inhabiles)) {
                                $sucursales = json_decode($inhabiles['sucursal']);
                                if ($sucursales) {
                                    foreach ($sucursales as $sucursal) {
                                        if ((int)$sucursal == (int)$sucursalID || (int)$sucursal == 0) {
                                            $horaEntrada[$n] = 'Día inhábil';
                                            $comentarios[$n] = $inhabiles['motivo'] . "\r\n";
                                        }
                                    }
                                }
                            } elseif (!empty($permisos)) { //Si hay permiso
                                $horaEntrada[$n] = 'Permiso';
                                $tipoCatalogo = empty($permisos['cat_Nombre']) ? '' : $permisos['cat_Nombre'];
                                $tipoNomina = empty($permisos['per_TipoPermiso']) ? '' : $permisos['per_TipoPermiso'];
                                //$tipoHoras = empty($permisos['per_HoraTipo']) ? '' : $permisos['per_HoraTipo'];
                                $comentarios[$n] = $tipoCatalogo . $tipoNomina . "\r\n";
                            } elseif (!empty($vacaciones)) {
                                $horaEntrada[$n] = 'Vacaciones';
                                $comentarios[$n] = "Dia de vacaciones \r\n";
                            } elseif (!empty($incapacidades)) {
                                $horaEntrada[$n] = 'Incapacidad';
                                $comentarios[$n] = $incapacidades['tipo'];
                            } elseif ((int)$descanso == 1) {
                                $horaEntrada[$n] = '/';
                                $comentarios[$n] = "Descanso \r\n";
                            } else {  //Si no hay registro
                                $horaEntrada[$n] = '/';
                                $comentarios[$n] = "No hay registro de asistencia \r\n";
                                $totalFaltas = +1;
                            }
                        } else { //Si si hay registro
                            if ($horarioEntradaEmpleado >= $entrada) { //Si el horario es mayor o igual a la checada
                                $horaEntrada[$n] = $entrada;
                            } else { //Si la checada es mayor a la tolerancia

                                //Permisos
                                $queryPermisos = "SELECT P.*, C.cat_Nombre FROM permiso P
                                LEFT JOIN catalogopermiso C ON C.cat_CatalogoPermisoID=P.per_TipoID
                                WHERE ( ?  >= P.per_FechaInicio  AND  ? <=  P.per_FechaFin) AND P.per_EmpleadoID=? AND P.per_Estado = ?";
                                $permisos = $this->db->query($queryPermisos, array($date, $date, $empleado['emp_EmpleadoID'], 'AUTORIZADO_RH'))->getRowArray();

                                //Vacaciones
                                $sql = "SELECT V.vac_FechaInicio AS 'FechaIni', V.vac_FechaFin AS 'FechaFin', V.vac_Disfrutar as 'observaciones'
                                FROM vacacion V
                                WHERE V.vac_EmpleadoID=? AND V.vac_Estatus='AUTORIZADO_RH' AND ( ?  >= V.vac_FechaInicio  AND  ? <=  V.vac_FechaFin)";
                                $vacaciones = $this->db->query($sql, array($empleado['emp_EmpleadoID'], $date, $date))->getRowArray();


                                if (!empty($permisos)) { //Si hay permiso
                                    $horaEntrada[$n] = $entrada;
                                    $tipoCatalogo = empty($permisos['cat_Nombre']) ? '' : $permisos['cat_Nombre'];
                                    $tipoNomina = empty($permisos['per_TipoPermiso']) ? '' : $permisos['per_TipoPermiso'];
                                    //$tipoHoras = empty($permisos['per_HoraTipo']) ? '' : $permisos['per_HoraTipo'];
                                    $comentarios[$n] = $tipoCatalogo . $tipoNomina . "\r\n";
                                } elseif (!empty($vacaciones)) {
                                    $horaEntrada[$n] = $entrada;
                                    $comentarios[$n] = "Vacación " . $vacaciones['observaciones'] . " dia (s) \r\n";
                                } else {
                                    $horaEntrada[$n] = $entrada;
                                    $comentarios[$n] = "Retardo de " . round($diferencia, 2) . " minutos\r\n";
                                    $totalRetardos += 1;
                                }
                            }
                        }
                    }


                    if (isset($salidas[$date])) {
                        $salida = $salidas[$date];
                        $horarioSalidaEmpleado = horarioColaborador($empleado['emp_EmpleadoID'], 'salida', $date);
                        $diferencia = diffDatetime($horarioSalidaEmpleado, $salida);

                        if (empty($salida)) {
                            //Si no hay registro
                            $horaSalida[$n] = '/';
                        } else {

                            //Permisos
                            $queryPermisos = "SELECT P.*, C.cat_Nombre FROM permiso P
                            LEFT JOIN catalogopermiso C ON C.cat_CatalogoPermisoID=P.per_TipoID
                            WHERE ( ?  >= P.per_FechaInicio  AND  ? <=  P.per_FechaFin) AND P.per_EmpleadoID=? AND P.per_Estado = ?";
                            $permisos = $this->db->query($queryPermisos, array($date, $date, $empleado['emp_EmpleadoID'], 'AUTORIZADO_RH'))->getRowArray();

                            //Vacaciones
                            $sql = "SELECT V.vac_FechaInicio AS 'FechaIni', V.vac_FechaFin AS 'FechaFin', V.vac_Disfrutar as 'observaciones'
                            FROM vacacion V
                            WHERE V.vac_EmpleadoID=? AND V.vac_Estatus='AUTORIZADO_RH' AND ( ?  >= V.vac_FechaInicio  AND  ? <=  V.vac_FechaFin)";
                            $vacaciones = $this->db->query($sql, array($empleado['emp_EmpleadoID'], $date, $date))->getRowArray();

                            if (!empty($permisos)) { //Si hay permiso
                                $horaSalida[$n] = $salida;
                                $tipoCatalogo = empty($permisos['cat_Nombre']) ? '' : $permisos['cat_Nombre'];
                                $tipoNomina = empty($permisos['per_TipoPermiso']) ? '' : $permisos['per_TipoPermiso'];
                                //$tipoHoras = empty($permisos['per_HoraTipo']) ? '' : $permisos['per_HoraTipo'];
                                $comentarios[$n] = $tipoCatalogo . $tipoNomina . "\r\n";
                            } elseif (!empty($vacaciones)) {
                                $horaSalida[$n] = $salida;
                                $comentarios[$n] = "Vacación " . $vacaciones['observaciones'] . " dia (s) \r\n";
                            } else if ($diferencia > 5) {
                                $horaSalida[$n] = $salida;
                                $comentarios[$n] = "Salio antes " . round($diferencia, 2) . " minutos\r\n";
                            } else {
                                $horaSalida[$n] = $salida;
                            }
                        }
                    }

                    if (!empty($medias[$date])) {

                        $comida[$n] = implode(' | ', $medias[$date]);
                    } else {
                        $comida[$n] = "";
                    }
                    $n++;
                } //foreach


                $a['numero'] = $empleado['emp_Numero'];
                $a['nombre'] = $empleado['emp_Nombre'];
                $a['horario'] = $empleado['hor_Nombre'];
                $a['sucursal'] = $empleado['suc_Sucursal'];
                $a['retardos'] = $totalRetardos;
                $a['faltas'] = $totalFaltas;
                for ($i = 0; $i <= $n - 1; $i++) {
                    if (array_key_exists($i, $horaEntrada)) {
                        $a['entrada' . $i] = $horaEntrada[$i];
                    } else {
                        $a['entrada' . $i] = '';
                    }
                    if (array_key_exists($i, $horaSalida)) {
                        $a['salida' . $i] = $horaSalida[$i];
                    } else {
                        $a['salida' . $i] = '';
                    }
                    if (!empty($comida[$i])) {

                        $a['comidas' . $i] = $comida[$i];
                    } else {
                        $a['comidas' . $i] = "";
                    }

                    if (!empty($comentarios[$i])) {
                        $a['comentarios' . $i] = $comentarios[$i];
                    } else {
                        $a['comentarios' . $i] = "";
                    }
                }
                array_push($asistencia, $a);
            }
        }

        return $asistencia;
    }

    function getEmpleadosHorario($fechaInicio, $fechaFinMasUnDIa, $dateCols)
    {
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Numero, E.emp_Nombre,E.emp_FechaIngreso, E.emp_SucursalID,S.suc_Sucursal FROM empleado E JOIN sucursal S ON suc_SucursalID=E.emp_SucursalID WHERE E.emp_estatus = 1 AND E.emp_Estado='Activo' ORDER BY E.emp_Nombre ASC";
        $empleados = $this->db->query($sql)->getResultArray();
        $asistencia = array();
        $a = array();
        foreach ($empleados as $empleado) {
            $fechaI = $fechaInicio;
            $totalRetardos = 0;
            $totalFaltas = 0;
            $horaEntrada = array();
            $horaSalida = array();
            $comentarios = array();
            $horarios = array();
            $n = 0;
            while ($fechaI <= $fechaFinMasUnDIa) {
                $fecha = $fechaI;
                $sql = "SELECT asi_Fecha AS 'fecha', asi_Hora AS 'hora' FROM asistencia  WHERE asi_EmpleadoID=? AND asi_Fecha = ?";
                $marca = $this->db->query($sql, array($empleado['emp_EmpleadoID'], $fecha))->getRowArray();
                if ($marca) {
                    $hora = $marca['hora'] ? json_decode($marca['hora']) : '';
                    $entrada = $hora ? reset($hora) : '';
                    $salidas = $hora ? end($hora) : '';
                    $medias = count($hora) > 2 ? array_slice($hora, 1, -1) : '';
                } else {
                    $hora = '';
                    $entrada = '';
                    $salidas = '';
                    $medias = '';
                }
                $nombreHorario = nombreHorarioColaborador($empleado['emp_EmpleadoID'], $fecha);

                //Horario y dia de descanso
                $horarioEntradaEmpleado = horarioColaborador($empleado['emp_EmpleadoID'], 'entrada', $fecha);
                $descanso = DescansoColaborador($empleado['emp_EmpleadoID'], $fecha);

                //Permisos
                $queryPermisos = "SELECT P.*, C.cat_Nombre FROM permiso P JOIN catalogopermiso C ON C.cat_CatalogoPermisoID=P.per_TipoID WHERE  (?  >= P.per_FechaInicio  AND  ? <=  P.per_FechaFin) AND P.per_EmpleadoID=? AND P.per_Estado = ?";
                $permisos = $this->db->query($queryPermisos, array($fecha, $fecha, $empleado['emp_EmpleadoID'], 'AUTORIZADO_RH'))->getRowArray();

                //check entrada
                if (empty($entrada)) {

                    //Dia inhabil
                    $all = '["0"]';
                    $sucursalID = $empleado['emp_SucursalID'];
                    $sucursal = '["'.$sucursalID.'"]';
                    $queryInhabiles = "SELECT D.dia_Fecha AS 'fecha', D.dia_Motivo AS 'motivo' , D.dia_SucursalID AS 'sucursal' FROM diainhabil D
                                            WHERE D.dia_Fecha = ? AND D.dia_MedioDia=0 AND (JSON_CONTAINS(dia_SucursalID,'".$all."') OR JSON_CONTAINS(dia_SucursalID,'".$sucursal."'))
                                        UNION SELECT DI.dial_Fecha as 'fecha', DI.dial_Motivo as 'motivo', '" . $all . "' AS 'sucursal' FROM diainhabilley DI
                                            WHERE  DI.dial_Fecha = ?";
                    $inhabiles = $this->db->query($queryInhabiles, array($fecha, $fecha))->getRowArray();

                    //Vacaciones
                    $sql = "SELECT V.vac_FechaInicio AS 'FechaIni', V.vac_FechaFin AS 'FechaFin' FROM vacacion V WHERE V.vac_EmpleadoID=? AND V.vac_Estatus='AUTORIZADO_RH' AND ( ?  >= V.vac_FechaInicio  AND  ? <=  V.vac_FechaFin)";
                    $vacaciones = $this->db->query($sql, array($empleado['emp_EmpleadoID'], $fecha, $fecha))->getRowArray();

                    //Incapacidad
                    $sql = "SELECT I.inc_FechaInicio AS 'FechaIni', I.inc_FechaFin AS 'FechaFin',I.inc_Tipo AS 'tipo' FROM incapacidad I WHERE I.inc_EmpleadoID=? AND ( ?  >= I.inc_FechaInicio  AND  ? <=  I.inc_FechaFin) AND I.inc_Estatus='Autorizada'";
                    $incapacidades = $this->db->query($sql, array($empleado['emp_EmpleadoID'], $fecha, $fecha))->getRowArray();

                    //Salidas
                    $sql = "SELECT * FROM reportesalida WHERE rep_EmpleadoID=? AND rep_Estado IN ('APLICADO','PAGADO') AND ? BETWEEN rep_DiaInicio AND rep_DiaFin";
                    $repsalidas = $this->db->query($sql, array($empleado['emp_EmpleadoID'], $fecha))->getResultArray();

                    $arrSalidas = array();
                    foreach ($repsalidas as $sal) {
                        $diasRep = json_decode($sal['rep_Dias'], true);
                        foreach ($diasRep as $diaR) {
                            if ($diaR['fecha'] == $fecha) {
                                switch ($diaR['socap']) {
                                    case 0:
                                        $socap = 'FEDERACION';
                                        break;
                                    case 10001:
                                        $socap = 'OTRO';
                                        break;
                                        //default: $socap = $this->db->query("SELECT coo_Sucursal FROM cooperativa WHERE coo_CooperativaID=" . (int)$dias[$i]['socap'])->getRowArray()['coo_Sucursal']; break;
                                    default:
                                        $socap = $this->db->query("SELECT suc_Sucursal FROM sucursal WHERE suc_SucursalID=" . (int)$diaR['socap'])->getRowArray()['suc_Sucursal'];
                                        break;
                                }

                                $arrSalidas = [
                                    'fecha' => $diaR['fecha'],
                                    'socap' => $socap,
                                ];
                            }
                        }
                    }

                    //Si es domingo y dia de descanzo
                    $nameDia = get_nombre_dia($fecha);
                    if ($nameDia == 'Domingo') {
                        $horaEntrada[$n] = 'Domingo';
                        $comentarios[$n] = "No hay registro de asistencia \r\n";
                        $horarios[$n] = "";
                    } elseif ($descanso == 1) {
                        $horaEntrada[$n] = '/';
                        $comentarios[$n] = "Descanso \r\n";
                        $horarios[$n] = "";
                    } elseif (!empty($inhabiles)) {
                        $horaEntrada[$n] = 'Día inhábil';
                        $comentarios[$n] = $inhabiles['motivo'] . "\r\n";
                        $horarios[$n] = "";
                    } elseif (!empty($permisos)) { //Si hay permiso
                        $horaEntrada[$n] = 'Permiso';
                        $tipoCatalogo = empty($permisos['cat_Nombre']) ? '' : $permisos['cat_Nombre'];
                        $tipoNomina = empty($permisos['per_TipoPermiso']) ? '' : $permisos['per_TipoPermiso'];
                        $tipoHoras = empty($permisos['per_HoraTipo']) ? '' : $permisos['per_HoraTipo'];
                        $comentarios[$n] = $tipoCatalogo . ' ' . $tipoNomina . ' ' . $tipoHoras . "\r\n";
                    } elseif (!empty($vacaciones)) {
                        $horaEntrada[$n] = 'Vacaciones';
                        $comentarios[$n] = "Dia de vacaciones \r\n";
                    } elseif (!empty($incapacidades)) {
                        $horaEntrada[$n] = 'Incapacidad';
                        $comentarios[$n] = $incapacidades['tipo'];
                    } elseif (!empty($arrSalidas)) {
                        $horaEntrada[$n] = 'Salida';
                        $comentarios[$n] = 'Sucursal ' . $arrSalidas['socap'];
                    } else {
                        $horaEntrada[$n] = '/';
                        $comentarios[$n] = "No hay registro de asistencia \r\n";
                        $totalFaltas += 1;
                    }
                } else {
                    if ($horarioEntradaEmpleado >= $entrada) { //Si el horario es mayor o igual a la checada
                        $horaEntrada[$n] = $entrada;
                    } else { //Si la checada es mayor a la tolerancia
                        $diferencia = diffDatetime($entrada, $horarioEntradaEmpleado);
                        if (!empty($permisos)) { //Si hay permiso
                            $horaEntrada[$n] = $entrada;
                            $tipoCatalogo = empty($permisos['cat_Nombre']) ? '' : $permisos['cat_Nombre'];
                            $tipoNomina = empty($permisos['per_TipoPermiso']) ? '' : $permisos['per_TipoPermiso'];
                            //$tipoHoras = empty($permisos['per_HoraTipo']) ? '' : $permisos['per_HoraTipo'];
                            $comentarios[$n] = $tipoCatalogo . $tipoNomina . "\r\n";
                        } else {
                            $horaEntrada[$n] = $entrada;
                            $comentarios[$n] = "Retardo de " . round($diferencia, 2) . " minutos\r\n";
                            $totalRetardos += 1;
                        }
                    }
                }

                //check salida
                if (isset($salidas)) {
                    $salida = $salidas;
                    $horarioSalidaEmpleado = horarioColaborador($empleado['emp_EmpleadoID'], 'salida', $fecha);
                    $diferencia = diffDatetime($horarioSalidaEmpleado, $salida);

                    if (empty($salida)) {
                        //Si no hay registro
                        $horaSalida[$n] = '/';
                    } else {

                        $queryPermisos = "SELECT P.*, C.cat_Nombre FROM permiso P LEFT JOIN catalogopermiso C ON C.cat_CatalogoPermisoID=P.per_TipoID WHERE ( ?  >= P.per_FechaInicio  AND  ? <=  P.per_FechaFin) AND P.per_EmpleadoID=? AND P.per_Estado = ?";
                        $permisos = $this->db->query($queryPermisos, array($fecha, $fecha, $empleado['emp_EmpleadoID'], 'AUTORIZADO_RH'))->getRowArray();
                        if (!empty($permisos)) { //Si hay permiso
                            $horaSalida[$n] = $salida;
                            $tipoCatalogo = empty($permisos['cat_Nombre']) ? '' : $permisos['cat_Nombre'];
                            $tipoNomina = empty($permisos['per_TipoPermiso']) ? '' : $permisos['per_TipoPermiso'];
                            //$tipoHoras = empty($permisos['per_HoraTipo']) ? '' : $permisos['per_HoraTipo'];
                            $comentarios[$n] = $tipoCatalogo . $tipoNomina . "\r\n";
                        } elseif ($diferencia > 5) {
                            $horaSalida[$n] = $salida;
                            $comentarios[$n] = "Salio antes " . round($diferencia, 2) . " minutos\r\n";
                        } else {
                            $horaSalida[$n] = $salida;
                        }
                    }
                }
                $comida[$n] = !empty($medias) ? implode(' | ', $medias) : "";

                $horarios[$n] = $nombreHorario;
                //incrementa un dia para el while
                $fechaI = date('Y-m-d', strtotime($fecha . "+1 days"));
                $n++;
            }
            $a['numero'] = $empleado['emp_Numero'];
            $a['nombre'] = $empleado['emp_Nombre'];
            $a['sucursal'] = $empleado['suc_Sucursal'];
            $a['retardos'] = $totalRetardos;
            $a['faltas'] = $totalFaltas;
            for ($i = 0; $i <= $n - 1; $i++) {
                $a['entrada' . $i] = array_key_exists($i, $horaEntrada) ? $horaEntrada[$i] : '';
                $a['salida' . $i] = array_key_exists($i, $horaSalida) ? $horaSalida[$i] : '';
                $a['horarios' . $i] = array_key_exists($i, $horarios) ? $horarios[$i] : '';
                $a['comidas' . $i] = !empty($comida[$i]) ? $comida[$i] : '';
                $a['comentarios' . $i] = !empty($comentarios[$i]) ? $comentarios[$i] : '';
            }
            array_push($asistencia, $a);
        }
        return $asistencia;
    }
}
