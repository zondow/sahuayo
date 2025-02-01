<?php

defined('WRITEPATH') or exit('No direct script access allowed');

function db()
{
    return $db = \Config\Database::connect();
}

/*function biometrico()
{
    return \Config\Database::connect('biometrico',true);
}*/

//Verifica que la secion sea correcta
function validarSesion_old($sesion)
{
    $ok = false;
    if (is_array($sesion)) {
        foreach ($sesion as $k) {
            if (isset($_SESSION['type']) && $_SESSION['type'] === $k) {
                $ok = true;
            } //if
        } //foreach
    } else {
        if (!isset($_SESSION['type']) || $_SESSION['type'] !== $sesion) {
            $ok = false;
        } //if
        else {
            $ok = true;
        }
    } //if-else

    if (!$ok) {
        $url = "Location: " . base_url('Access/logOut');
        header($url);
        exit();
    }
}
// Verifica que la sesión sea correcta
function validarSesion($sesion)
{
    $ok = false;
    if (is_array($sesion)) {
        foreach ($sesion as $k) {
            if (isset($_SESSION['type']) && $_SESSION['type'] === $k) {
                $ok = true;
            }
        }
    } else {
        if (!isset($_SESSION['type']) || $_SESSION['type'] !== $sesion) {
            $ok = false;
        } else {
            $ok = true;
        }
    }

    if (!$ok) {
        // Guarda la URL original antes de redirigir al login
        $_SESSION['redirect_url'] = current_url();  // Guardar la URL actual
        $url = "Location: " . base_url('Access/logIn');
        header($url);
        exit();
    }
}
//validateSession

//prints a safe value applying htmlspecialchars
function output($str)
{
    return htmlspecialchars($str);
} //output

//Returns a cleaned post value
function post($key = NULL)
{
    $output = null;
    if ($key !== NULL) {
        if (isset($_POST[$key])) {
            $output = trim($_POST[$key]);
            $output = strip_tags($output);
        } //if isset
    } else {
        $output = array();
        foreach ($_POST as $key => $value) {
            $output[$key] = strip_tags(trim($value));
        } //foreach
    } //if-else
    return $output;
} //post

//HUGO->Returns a cleaned post value
function post2($key = NULL)
{
    $output = null;
    if ($key !== NULL) {
        if (isset($_POST[$key])) {
            if (is_array($_POST[$key])) {
                $valores = array();
                foreach ($_POST[$key] as $valor) {
                    if (trim($valor) != "")
                        array_push($valores, $valor);
                }
                $output = $valores;
            } else {
                $output = trim($_POST[$key]);
                $output = strip_tags($output);
            }
        } //if isset
    } else {
        $output = array();
        foreach ($_POST as $key => $value) {
            if (is_array($value)) {
                $valores = array();
                foreach ($value as $valor) {
                    if (trim($valor) != "")
                        array_push($valores, $valor);
                }
                $output[$key] = $valores;
            } else {
                $output[$key] = strip_tags(trim($value));
            }
        } //foreach
    } //if-else
    return $output;
} //post

//Returns a cleaned gest value
function get($key = NULL)
{
    $output = null;
    if ($key !== NULL) {
        if (isset($_GET[$key])) {
            $output = trim($_GET[$key]);
            $output = strip_tags($output);
        } //if isset
    } else {
        $output = array();
        foreach ($_GET as $key => $value) {
            $output[$key] = strip_tags(trim($value));
        } //foreach
    } //if-else
    return $output;
} //get

//Generates a secures hash key
function encryptKey($key)
{
    return password_hash($key, PASSWORD_DEFAULT);
} //encryptKey

//Creates a random alphanumeric password
function createPassword()
{
    //Initialize variables
    $password = '';
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $totalCharacters = strlen($characters) - 1;
    //Get characters
    for ($i = 0; $i < 6; $i++) {
        $random = mt_rand(0, $totalCharacters);
        $password .= $characters[$random];
    } //for
    //Shuffle array
    $password = str_shuffle($password);
    return $password;
} //createPassword

//returns a dd-month-yyyy mysql date
function longDate($date, $delimiter = '-')
{
    $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    $output = '';
    //Format date
    if (!empty($date)) {
        $exploded = explode('-', $date);
        $output = $exploded[2] . $delimiter . $meses[(int)$exploded[1]] . $delimiter . $exploded[0];
    } //if
    return $output;
} //longDate

//returns a dd-month-yyyy mysql date
function shortDate($date, $delimiter = '-')
{
    $meses = array('', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
    $output = '';
    //Format date
    if (!empty($date)) {
        $exploded = explode('-', $date);
        $output = $exploded[2] . $delimiter . $meses[(int)$exploded[1]] . $delimiter . $exploded[0];
    } //if
    return $output;
} //longDate

//Verifies a key-value pair and redirects to logout page
function validateSession($key, $value = NULL)
{
    if (is_array($key)) {
        $ok = false;
        foreach ($key as $k => $value) {
            if (isset($_SESSION[$k]) && $_SESSION[$k] === $value) {
                $ok = true;
            } //if
        } //foreach
        if ($ok === false) {
            redirect(base_url('Access/logOut'));
        } //if
    } else {
        if (!isset($_SESSION[$key]) || $_SESSION[$key] !== $value) {
            redirect(base_url('Access/logOut'));
        } //if
    } //if-else
} //validateSession

//Retursn an active string if v1 and v2 are identical
function activeMenu($v1, $v2)
{
    $output = '';
    if (is_array($v1)) {
        if (in_array($v2, $v1)) {
            $output = 'active';
        } //if
    } else if ($v1 === $v2) {
        $output = 'active';
    }
    return $output;
} //activeMenu

function precision($number, $precision = 2, $separator = '.')
{
    $numberParts = explode($separator, $number);
    $response = $numberParts[0];
    if (count($numberParts) > 1) {
        $response .= $separator;
        $response .= substr($numberParts[1], 0, $precision);
    }
    return $response;
} //function

//Regresa la diferencia entre dos fechas, con el formato especificado
function diffDate($d1, $d2, $format)
{
    $dt1 = new DateTime($d1);
    $dt2 = new DateTime($d2);
    $interval = $dt1->diff($dt2);
    return $interval->format($format);
} //diffDate

//Tipo de moneda a prefijo
function num_letras($numero, $moneda)
{

    $flag = "N";
    $entero = "";
    $deci = "";
    $moneda_prefijo = "";

    if ($moneda == "MNX") {
        $moneda_prefijo = " PESOS ";
        $moneda_sufijo_2 = " MN ";
    }

    if ($moneda == "MN") {
        $moneda_prefijo = " PESOS ";
        $moneda_sufijo_2 = " MN ";
    }

    if ($moneda == "PESOS") {
        $moneda_prefijo = " PESOS ";
        $moneda_sufijo_2 = "MN ";
    }

    if ($moneda == "USD") {
        $moneda_prefijo = " DOLARES ";
        $moneda_sufijo_2 = " USD ";
    }

    if ($moneda == "DOLARES") {
        $moneda_prefijo = " DOLARES ";
        $moneda_sufijo_2 = " USD ";
    }

    for ($i = 0; $i <= strlen($numero); $i++) {
        $caracter = substr($numero, $i, 1);
        if ($caracter == ".") {
            $flag = "S";
        } else {
            if ($flag == "N") {
                $entero .= $caracter;
            } else {
                if (strlen($deci) <= 1) {
                    $deci .= $caracter;
                }
            }
        }
    }
    if ($deci == "") {
        $deci = "00";
    } else {
        if (strlen($deci) == 1) {
            $deci .= "0";
        }
    }
    //echo "Entero: ".$entero."<br>";
    $Letras = num_texto($entero);
    if ($entero == 1)
        $Letras = "(" . $Letras . " " . $moneda_prefijo . substr($deci, strlen($deci) - 2, 2) . "/100 " . $moneda_sufijo_2 . ")";
    else
        $Letras = "(" . $Letras . " " . $moneda_prefijo . substr($deci, strlen($deci) - 2, 2) . "/100 " . $moneda_sufijo_2 . ")";

    return $Letras;
} //num_letras

//Una cantidad da texto
function num_texto($numero)
{
    $texto = "";
    $millones = "";
    $miles = "";
    $cientos = "";
    $decimales = "";
    $cadena = "";
    $cadMillones = "";
    $cadMiles = "";
    $cadCientos = "";

    $texto = "                 " . $numero;
    $millones = substr($texto, strlen($texto) - 9, 3);
    $miles = substr($texto, strlen($texto) - 6, 3);
    $cientos = substr($texto, strlen($texto) - 3, 3);

    //return "Millones: ".$millones." Miles:".$miles." Cientos:".$cientos;

    $cadMillones = ConvierteCifra($millones, "1");
    $cadMiles = ConvierteCifra($miles, "1");
    $cadCientos = ConvierteCifra($cientos, "1");

    if (trim($cadMillones) != "") {
        if (trim($cadMillones) == "UN") {
            $cadena = $cadMillones . " MILLON";
        } else {
            $cadena = $cadMillones . " MILLONES ";
        }
    }

    if (trim($cadMiles) != "") {
        $cadena .= $cadMiles . " MIL";
    }

    if ((trim($cadMiles . $cadCientos)) == "UN") {
        $cadena .= " UNO";
    } else {
        if (trim($cadMiles) . trim($cadCientos) == "000000") {
            $cadena .= " " . $cadCientos;
        } else {
            $cadena .= " " . $cadCientos;
        }
    }

    return $cadena;
} //num_texto

//ConvierteCifra
function ConvierteCifra($Texto, $SW)
{

    $Centena = "";
    $Decena = "";
    $Unidad = "";
    $txtCentena = "";
    $txtDecena = "";
    $txtUnidad = "";

    $Centena = substr($Texto, 0, 1);
    $Decena = substr($Texto, 1, 1);
    $Unidad = substr($Texto, 2, 1);

    //echo "Texto: ".$Texto."<br>";
    //echo "Longitud: ".strlen($Texto)."<br>";
    //echo $Centena."<br>";
    //echo $Decena."<br>";
    //echo $Unidad."<br>";

    switch ($Centena) {
        case "1":
            $txtCentena = "CIEN";
            if ($Decena . $Unidad != "00") {
                $txtCentena = "CIENTO";
            }
            break;
        case "2":
            $txtCentena = "DOSCIENTOS";
            break;
        case "3":
            $txtCentena = "TRESCIENTOS";
            break;
        case "4":
            $txtCentena = "CUATROCIENTOS";
            break;
        case "5":
            $txtCentena = "QUINIENTOS";
            break;
        case "6":
            $txtCentena = "SEISCIENTOS";
            break;
        case "7":
            $txtCentena = "SETECIENTOS";
            break;
        case "8":
            $txtCentena = "OCHOCIENTOS";
            break;
        case "9":
            $txtCentena = "NOVECIENTOS";
            break;
    }

    switch ($Decena) {
        case "1":
            $txtDecena = "DIEZ";
            switch ($Unidad) {
                case "1":
                    $txtDecena = "ONCE";
                    break;
                case "2":
                    $txtDecena = "DOCE";
                    break;
                case "3":
                    $txtDecena = "TRECE";
                    break;
                case "4":
                    $txtDecena = "CATORCE";
                    break;
                case "5":
                    $txtDecena = "QUINCE";
                    break;
                case "6":
                    $txtDecena = "DIECISEIS";
                    break;
                case "7":
                    $txtDecena = "DIECISIETE";
                    break;
                case "8":
                    $txtDecena = "DIECIOCHO";
                    break;
                case "9":
                    $txtDecena = "DIECINUEVE";
                    break;
            }
            break;
        case "2":
            $txtDecena = "VEINTE";
            if ($Unidad != "0") {
                $txtDecena = "VEINTI";
            }
            break;
        case "3":
            $txtDecena = "TREINTA";
            if ($Unidad != "0") {
                $txtDecena = "TREINTA Y ";
            }
            break;
        case "4":
            $txtDecena = "CUARENTA";
            if ($Unidad != "0") {
                $txtDecena = "CUARENTA Y ";
            }
            break;
        case "5":
            $txtDecena = "CINCUENTA";
            if ($Unidad != "0") {
                $txtDecena = "CINCUENTA Y ";
            }
            break;
        case "6":
            $txtDecena = "SESENTA";
            if ($Unidad != "0") {
                $txtDecena = "SESENTA Y ";
            }
            break;
        case "7":
            $txtDecena = "SETENTA";
            if ($Unidad != "0") {
                $txtDecena = "SETENTA Y ";
            }
            break;
        case "8":
            $txtDecena = "OCHENTA";
            if ($Unidad != "0") {
                $txtDecena = "OCHENTA Y ";
            }
            break;
        case "9":
            $txtDecena = "NOVENTA";
            if ($Unidad != "0") {
                $txtDecena = "NOVENTA Y ";
            }
            break;
    }

    if ($Decena != "1") {
        switch ($Unidad) {
            case "1":
                if ($SW == "1") {
                    $txtUnidad = "UN";
                } else {
                    $txtUnidad = "UNO";
                }
                break;
            case "2":
                $txtUnidad = "DOS";
                break;
            case "3":
                $txtUnidad = "TRES";
                break;
            case "4":
                $txtUnidad = "CUATRO";
                break;
            case "5":
                $txtUnidad = "CINCO";
                break;
            case "6":
                $txtUnidad = "SEIS";
                break;
            case "7":
                $txtUnidad = "SIETE";
                break;
            case "8":
                $txtUnidad = "OCHO";
                break;
            case "9":
                $txtUnidad = "NUEVE";
                break;
        }
    }
    return $txtCentena . " " . $txtDecena . $txtUnidad;
} //ConvierteCifra

//La función ceil de excel
function ceilExcel($number, $significance = 1)
{
    return (is_numeric($number) && is_numeric($significance)) ? (floor($number / $significance) * $significance) : false;
}

//Para enviar mensaje al Slack
function slack()
{
    $url = "https://hooks.slack.com/services/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";
    @$canal = func_get_arg(0);
    @$msg = func_get_arg(1);
    @$bot = func_get_arg(2);
    if (empty($bot)) $bot = "botonete";
    $datas = ["text" => $msg, "channel" => $canal, "username" => $bot]; // datos a enviar
    $data = "payload=" . json_encode($datas); //lo convertimos a formato JSON
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    //print_r(json_decode($result)); mostrar resultado
}

/**NOTIFICACIONES ANDROID**/
//HUGO->Enviar notificación android
function pushAndroid($device_id, $message)
{
    $api_key = "AIzaSyAhI2zCXDhVFYJdL-lCS7OIHrDkJOdoBu4";
    if (empty($api_key)) {
        return array(
            'success' => 0,
            'results' => array(
                array(
                    'error' => 'missing api key'
                )
            )
        );
    }

    if (empty($device_id)) {
        return array(
            'success' => 0,
            'results' => array(
                array(
                    'error' => 'missing device id'
                )
            )
        );
    }

    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        'to' => $device_id,
        'notification' => $message,
    );

    $headers = array(
        'Authorization: key=' . $api_key,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        return array(
            'success' => 0,
            'results' => array(
                array(
                    'error' => 'Curl failed: ' . curl_error($ch)
                )
            )
        );
    }

    curl_close($ch);

    $result = !empty($result) ? json_decode($result, true) : false;

    if ($result == false) {
        return array(
            'success' => 0,
            'results' => array(
                array(

                    'error' => 'invalid response from push service'
                )
            )
        );
    }

    return $result;
} //pushAndroid

//HUGO->Notificaciónes
/*function notificacionesAndroid($to_perfilID, $to_empleadoID, $body, $title)
{
    $ci = &get_instance();

    $message = array(
        'body' => $body,
        'title' => $title,
        'sound' => "default",
        'vibrate' => "true"
    );

    if ($to_perfilID > 0) {
        //Get tokens
        $sql = "SELECT emp_Token,emp_Dispositivo FROM empleado WHERE emp_Estatus = 1 AND emp_PerfilID = ? AND emp_Token != ''";
        $tokens = $ci->db->query($sql, array("emp_PerfilID" => $to_perfilID))->getResultArray();

        if (count($tokens) > 0) {
            foreach ($tokens as $token) {
                if ($token['emp_Dispositivo'] == 'android') {
                    pushAndroid($token['emp_Token'], $message);
                } //if token
            } //foreach
        } //if count
    } elseif ($to_empleadoID > 0) {
        $sql = "SELECT emp_Token,emp_Dispositivo FROM empleado WHERE emp_Estatus = 1 AND emp_EmpleadoID = ? AND emp_Token != ''";
        $token = $ci->db->query($sql, array("emp_EmpleadoID" => $to_empleadoID))->getRowArray();

        if (count($token) > 0) {
            pushAndroid($token['emp_Token'], $message);
        } //if count
    } //if perfilID
} //function notificacionesAndroid*/

//Encrypt corto
function encrypt($string){
    return encryptDecrypt('encrypt',$string);
}

//Decrypt corto
function decrypt($string){
    return encryptDecrypt('decrypt',$string);
}

//Encriptar / Desencriptar
function encryptDecrypt($action, $string)
{
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

//HUGO->Set lenguaje
/*function setLang($lang)
{
    $ci = &get_instance();
    $lenguaje = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'spanish';
    $ci->lang->load('idioma', $lenguaje);
    return $ci->lang->line($lang);
} //setLang*/

//HUGO->Validar si la cuenta que elige es correcta y no eliga una cta padre
function codigoAgrupadorSAT($codigo)
{
    $response = false;
    $ctas = array(
        '100', '100.01', '101', '102', '103', '104', '105', '106', '107',
        '108', '109', '109', '110', '111', '112', '113', '114', '115', '116', '100.02',
        '151', '152', '152'
    );
    if (!in_array($codigo, $ctas))
        $response = true;

    return $response;
} //codigoAgrupadorsSAT

//HUGO->Get foto perfil
function fotoPerfil($empleadoID)
{
    $empleadoID = (int)encryptDecrypt('decrypt', $empleadoID);

    $url = dirname(WRITEPATH) . "/assets/uploads/fotosPerfil/" . $empleadoID . "-Empleado.png";
    $url2 = dirname(WRITEPATH) . "/assets/uploads/fotosPerfil/" . $empleadoID . "-Empleado.jpg";
    $url3 = dirname(WRITEPATH) . "/assets/uploads/fotosPerfil/" . $empleadoID . "-Empleado.JPG";
    $imagen = base_url("assets/images/avatar.jpg");

    if (file_exists($url)) {
        $imagen = base_url("assets/uploads/fotosPerfil/" . $empleadoID . "-Empleado.png");
    } elseif (file_exists($url2)) {
        $imagen = base_url("assets/uploads/fotosPerfil/" . $empleadoID . "-Empleado.jpg");
    } elseif (file_exists($url3)) {
        $imagen = base_url("assets/uploads/fotosPerfil/" . $empleadoID . "-Empleado.JPG");
    }

    return $imagen;
} //fotoPerfil

function numMeses($numMes)
{
    switch ($numMes) {
        case '01':
            $mes = "Enero";
            break;
        case '02':
            $mes = "Febrero";
            break;
        case '03':
            $mes = "Marzo";
            break;
        case '04':
            $mes = "Abril";
            break;
        case '05':
            $mes = "Mayo";
            break;
        case '06':
            $mes = "Junio";
            break;
        case '07':
            $mes = "Julio";
            break;
        case '08':
            $mes = "Agosto";
            break;
        case '09':
            $mes = "Septiembre";
            break;
        case '10':
            $mes = "Octubre";
            break;
        case '11':
            $mes = "Noviembre";
            break;
        case '12':
            $mes = "Diciembre";
            break;
    }
    return $mes;
}

//Obtiene si el empleado es jefe
function isJefe()
{
    $numEmpleado = session("numero");
    $colaboradores = db()->query("SELECT * FROM empleado WHERE emp_Jefe='" . $numEmpleado . "'")->getResultArray();
    return (count($colaboradores) > 0) ? TRUE : FALSE;
}

//Obtiene si es rh
function isRH()
{
    return revisarPermisos('Ver', 'dashboardRH');
}

//Obtiene si el empleado es jefe de departamento
function isJefeDepartamento()
{
    $idEmpleado = session("id");
    $jefe = db()->query("SELECT * FROM departamento WHERE dep_JefeID=" . (int)$idEmpleado)->getResultArray();
    return (count($jefe) > 0) ? TRUE : FALSE;
}

//Obtiene si el empleado autoriza alguna solicitud de personal
function autorizaSolicitudesPersonal($obj)
{
    $idEmpleado = $obj->session->userdata("id");

    $solicitudes = $obj->db->get_where("solicitudpersonal", array("sol_Autoriza" => (int)$idEmpleado))->getResultArray();
    return (count($solicitudes) > 0) ? TRUE : FALSE;
}

//Calcula la edad
function calculaedad($fechanacimiento)
{
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    return $ano_diferencia;
}

//Regresa una fecha en formato Nombredía-dia-mes
function weekDate($d)
{
    $dias = array('', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom');
    $meses = array('', 'Ene', 'Feb', 'Mar', 'Abr', 'Mayo', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
    $output = '';
    if (!empty($d)) {
        $exp = explode('-', $d);
        $dayOfWeek = date('N', strtotime($d));
        $output = $dias[$dayOfWeek] . ' ' . $exp[2] . ' ' . $meses[(int)$exp[1]] . '/' . $exp[0];
    } //if
    return $output;
} //weekDate

function diffDatetime($d1, $d2)
{
    return (strtotime($d1) - strtotime($d2)) / 60;
} //diffDatetime

//Nat -> Comprimir imagenes, recibe archivo temporal, lugar de destino y que calidad debe tener (porcentaje)
function comprimirImagen($source, $destination, $quality)
{
    // Obtenemos la información de la imagen
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];
    // Creamos una imagen
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }

    // Guardamos la imagen
    $response = imagejpeg($image, $destination, $quality);
    //Destruir imagen para liberar memoria
    imagedestroy($image);
    // Devolvemos si la imagen se guardo
    return $response;
} //comprimirImagen

function crearUsernameByEmail($email, $obj)
{
    $user = strstr($email, '@', true);
    return $user;
}

//Returns a 12 hr format time
function shortTime($time)
{
    $output = '';
    if (!empty($time)) {
        $mer = 'AM';
        $hr = (int)substr($time, 0, 2);
        $min = substr($time, 3, 2);
        if ($hr >= 12) {
            $mer = 'PM';
        }
        if ($hr > 12) {
            $hr = $hr - 12;
        }
        $hr = str_pad($hr, 2, '0', STR_PAD_LEFT);
        return $hr . ':' . $min . ' ' . $mer;
    } //if
    return $output;
}

//Return a dd-mm-yyyy hh:mm mer datetime string format
function shortDateTime($datetime, $delimiter = '-')
{
    $output = '';
    if (!empty($datetime)) {
        $split = explode(' ', $datetime);
        if (count($split) === 2) {
            $date = shortDate($split[0], $delimiter);
            $time = shortTime($split[1]);
            $output = $date . ' ' . $time;
        } //if
    } //if
    return $output;
} //shortDateTime

//Return a dd-mm-yyyy hh:mm mer datetime string format
function longDateTime($datetime, $delimiter = '-')
{
    $output = '';
    if (!empty($datetime)) {
        $split = explode(' ', $datetime);
        if (count($split) === 2) {
            $date = longDate($split[0], $delimiter);
            $time = shortTime($split[1]);
            $output = $date . ' a las ' . $time;
        } //if
    } //if
    return $output;
} //longDateTime

//HUGO->Disponibilidad usuario
function disponibilidadUsuario($disponibilidad)
{

    switch ($disponibilidad) {
        case "En línea":
            return 'dot dot-linea';
            break;
        case "Ausente":
            return 'dot';
            break;
        case "Home office":
            return ' icon-screen-desktop homehoffice';
            break;
        case "En reunión":
            return ' icon-calender enreunion';
            break;
        case "De vacaciones":
            return 'icon-plane devacaciones';
            break;
        default:
            break;
    }
} //disponibilidadUsuario

//Lia -> Obtiene el valor de las variables de configuracion
function getSetting($key)
{
    return db()->query("SELECT S.* FROM settings S WHERE S.set_Key=?", array($key))->getRowArray()['set_Value'];
} //getSetting

//Diego -> Get file expediente
function fileExpediente($expedienteID, $empleadoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/expediente/" . $empleadoID . "/" . $expedienteID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $archivosCount = count($files);
    $data = array();
    if ($archivosCount > 2) {
        $archivo = $files[2];
        $extension = substr($archivo, -3);

        $config = array();
        if (file_exists($url . $archivo)) {
            $config["url"] = base_url("/assets/uploads/expediente/" . $empleadoID . "/" . $expedienteID . "/" . $archivo);
            array_push($data, $config);
        }
    }

    return $data;
} //fileExpedienteUnidad

//Diego -> Get file expediente
function historialExpediente($expedienteID, $empleadoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/expediente/" . $empleadoID . "/" . $expedienteID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();

    for ($i = 2; $i <= $num_files; $i++) {

        if (file_exists($url . $files[$i])) {
            $rest = strtolower(substr($files[$i], 0, 10));
            $config['fecha'] = $rest;
            $config["url"] = base_url("/assets/uploads/expediente/" . $empleadoID . "/" . $expedienteID . "/" . $files[$i]);
            array_push($data, $config);
        }
    }
    usort($data, "date_sort");
    return $data;
} //fileExpedienteUnidad

function date_sort($a, $b)
{
    return strtotime($a['fecha']) < strtotime($b['fecha']);
}

//Diego -> Get files materiales
function materialesCapacitacion($capacitacionID)
{
    $url = FCPATH . "/assets/uploads/capacitacion/" . $capacitacionID . "/material/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = base_url("/assets/uploads/capacitacion/" . $capacitacionID . "/material/" . $files[$i]);
        }
        array_push($data, $config["url"]);
    }
    return $data;
} //materialesCapacitacion


//Diego -> Get curriculum vitae
function CVCandidato($solicitudPersonalID, $candidatoID)
{

    $url = FCPATH . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        $archivo = explode('.', $files[$i]);
        if ($archivo[0] === 'CurriculumVitae') {
            if (file_exists($url . $files[$i])) {
                $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
                //var_dump($config["url"]);exit();
            }
            array_push($data, $config["url"]);
        }
    }
    return $data;
} //materialesCapacitacion

//Diego -> Get documentacion
function documentacionCandidato($solicitudPersonalID, $candidatoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        $archivo = explode('.', $files[$i]);
        if ($archivo[0] === 'Acta de Nacimiento' || $archivo[0] === 'Buro de Credito') {
            if (file_exists($url . $files[$i])) {
                $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
            }
            array_push($data, $config["url"]);
        }
    }
    return $data;
} //documentacionCandidato

//Diego -> Get docCandidato
function docCandidato($solicitudPersonalID, $candidatoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
        }
        array_push($data, $config["url"]);
    }
    return $data;
} //docCandidato

//Diego -> Get resultadoInvCR
function resultadoInvCR($solicitudPersonalID, $candidatoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        $archivo = explode('.', $files[$i]);
        if ($archivo[0] === 'Resultado Investigacion Cartas Recomendacion') {
            if (file_exists($url . $files[$i])) {
                $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
            }
            array_push($data, $config["url"]);
        }
    }
    return $data;
} //resultadoInvCR

//Diego -> Get candidatoDeclaracion
function candidatoDeclaracion($solicitudPersonalID, $candidatoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        $archivo = explode('.', $files[$i]);
        if ($archivo[0] === 'Declaracion') {
            if (file_exists($url . $files[$i])) {
                $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
            }
            array_push($data, $config["url"]);
        }
    }
    return $data;
} //candidatoDeclaracion

//Diego -> Get documentosInfoPer
function documentosInfoPer($solicitudPersonalID, $candidatoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        $archivo = explode('.', $files[$i]);
        if ($archivo[0] === 'Infonavit' || $archivo[0] === 'Infonacot' || $archivo[0] === 'Pension') {
            if (file_exists($url . $files[$i])) {
                $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
            }
            array_push($data, $config["url"]);
        }
    }
    return $data;
} //documentosInfoPer


//Diego -> Get cartasRecomendacion
function cartasRecomendacion($solicitudPersonalID, $candidatoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        $archivo = explode('.', $files[$i]);
        if ($archivo[0] === 'Carta Recomendacion 1' || $archivo[0] === 'Carta Recomendacion 2' || $archivo[0] === 'Carta Recomendacion 3') {
            if (file_exists($url . $files[$i])) {
                $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
            }
            array_push($data, $config["url"]);
        }
    }
    return $data;
} //cartasRecomendacion

//Diego -> Get file convocatoria
function convocatoriaSolicitudPersonal($solicitudPersonalID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/convocatoria/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/convocatoria/" . $files[$i]);
        }
        array_push($data, $config["url"]);
    }
    return $data;
} //convocatoriaSolicitudPersonal

//Diego -> Get file convocatoria
function evaluacionTecnicaCandidato($solicitudPersonalID, $candidatoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        $archivo = explode('.', $files[$i]);
        if ($archivo[0] === 'Evaluacion Tecnica') {
            if (file_exists($url . $files[$i])) {
                $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
            }
            array_push($data, $config["url"]);
        }
    }
    return $data;
} //evaluacionTecnicaCandidato


//Diego -> Get file convocatoria
function informeFinalCandidato($solicitudPersonalID, $candidatoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        $archivo = explode('.', $files[$i]);
        if ($archivo[0] === 'Informe Final') {
            if (file_exists($url . $files[$i])) {
                $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
            }
            array_push($data, $config["url"]);
        }
    }
    return $data;
} //evaluacionTecnicaCandidato

//Diego -> Get file evaluacion Psicometrica
function evaluacionPsicometricaCandidato($solicitudPersonalID, $candidatoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        $archivo = explode('.', $files[$i]);
        if ($archivo[0] === 'Evaluacion Psicometrica') {
            if (file_exists($url . $files[$i])) {
                $config["url"] = base_url("/assets/uploads/solicitudPersonal/" . $solicitudPersonalID . "/candidato/" . $candidatoID . "/" . $files[$i]);
            }
            array_push($data, $config["url"]);
        }
    }
    return $data;
} //evaluacionTecnicaCandidato

//Diego -> Getimagen curso
function cursoImagen($cursoID)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/curso/" . $cursoID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = base_url("/assets/uploads/curso/" . $cursoID .  "/" . $files[$i]);
            array_push($data, $config);
        }
    }
    return $data;
} //fileExpedienteUnidad

//Diego -> Get file expediente
function historialExpedienteUltima($expedienteID, $empleadoID, $Rtiempo, $Rduracion)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/expediente/" . $empleadoID . "/" . $expedienteID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;
    if ($num_files >= 2) {
        if (file_exists($url . $files[$num_files])) {
            $config = base_url("/assets/uploads/expediente/" . $empleadoID . "/" . $expedienteID . "/" . $files[$num_files]);
        }

        //Diferencia de tiempo
        $archivoNombre = explode('/', $config);
        $count = count($archivoNombre) - 1;
        if ($Rduracion == 'month') {
            $duracion = $Rtiempo;
        } else {
            $duracion = ($Rtiempo / 12);
        }

        $fechaNArchivo = explode('.', $archivoNombre[$count]);
        $longitud = strlen($fechaNArchivo[0]);
        if ($longitud > 10) {
            $longitud = 10 - $longitud;
            $fechaArchivo = substr($fechaNArchivo[0], 0, $longitud);
        }
        $fechaActual = date('Y-m-d');
        $diferencia = diferenciaMeses($fechaActual, $fechaArchivo);
        if ($diferencia < $duracion) {
            $notificacion = 0;
        } else {
            $notificacion = 1;
        }
    } else {
        $notificacion = 0;
    }
    return $notificacion;
} //fileExpedienteUnidad

//traer diferencia de meses entre dos fechas
function diferenciaMeses($fecha1, $fecha2)
{
    $diferencia = abs(strtotime($fecha1) - strtotime($fecha2));
    $years = floor($diferencia / (365 * 60 * 60 * 24));
    $months = floor(($diferencia - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    return $months;
} //end diferenciaMeses

function revisarPermisos($accion, $funcion = null)
{
    $permisos = json_decode(session('permisos'), 1);
    $response = false;

    if (is_null($funcion)) {
        $url = uri_string(true);
        $url = explode('/', $url);
        $funcion = $url[1];
    }
    if (isset($permisos[$funcion])) {
        if (in_array($accion, $permisos[$funcion])) {
            $response = true;
        }
    }
    return $response;
}

function showMenu($funcion)
{
    $permisos = json_decode(session('permisos'), true);
    $mostrar = false;
    if (is_array($funcion)) {
        foreach ($funcion as $f) {
            if (isset($permisos[$f])) {
                $mostrar = true;
            }
        }
    } else {
        if (isset($permisos[$funcion])) {
            $mostrar = true;
        }
    }
    return $mostrar;
}
function showSubMenu($funciones, $nombre)
{
    $html = '';
    $mostrarMenu = false;
    $permisos = json_decode(session('permisos'), true);

    foreach ($funciones as $funcion) {
        if (isset($permisos[$funcion[0]])) {
            $mostrarMenu = true;
            break;
        }
    }

    if ($mostrarMenu) {
        $html .= '<li><a href="javascript:void(0);" class="menu-toggle"><b>' . htmlspecialchars($nombre) . '</b></a>';
        $html .= '<ul class="ml-menu">';

        foreach ($funciones as $funcion) {
            if (isset($permisos[$funcion[0]])) {
                $html .= addMenuOption($funcion[0], $funcion[1], $funcion[2]);
            }
        }

        $html .= '</ul></li>';
    }

    return $html;
}
/*function addMenuOption($controlador, $funcion, $permisos, $txt, $show = 0)
{
    if (showMenu($funcion, $permisos) || $show) {
        echo '<li>';
        echo '<a href="' . base_url($controlador . "/" . $funcion) . '">';
        echo $txt;
        echo '</a>';
        echo '</li>';
    }
}*/

function insertLog($obj, $empleado, $accion, $tabla, $id)
{
    $array = array(
        'log_EmpleadoID' => $empleado,
        'log_Accion' => $accion,
        'log_Tabla' => $tabla,
        'log_Fecha' => date('Y-m-d H:i:s'),
        'log_ID' => $id,
    );
    $builder = db()->table("log");
    $builder->insert($array);
    return $result = $obj->db->insertID();
}

function diasCapacitacion($inicio, $fin, $arrayDias, $obj)
{
    $DiasCapacitacion = array();
    foreach ($arrayDias as $arrdias) {
        $sql = "SELECT  * FROM (SELECT  DATE_ADD('2021-01-01',INTERVAL n4.num*1000+n3.num*100+n2.num*10+n1.num DAY ) AS DATE
         FROM  (SELECT 0 AS num UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS n1,
               (SELECT 0 AS num UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS n2,
               (SELECT 0 AS num UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS n3,
               (SELECT 0 AS num UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS n4
            ) AS a
        WHERE DATE >= ? AND DATE <= ?
            AND WEEKDAY(DATE) = ?
        ORDER BY DATE";
        $dias = $obj->db->query($sql, array($inicio, $fin, $arrdias))->getResultArray();
        foreach ($dias as $dia) {
            array_push($DiasCapacitacion, $dia['DATE']);
        }
    }
    sort($DiasCapacitacion);
    return json_encode($DiasCapacitacion);
}

function isInstructor()
{
    $id = session("id");
    $instructor = db()->query("SELECT I.*FROM instructor I WHERE I.ins_Estatus=1 AND I.ins_EmpleadoID=" . (int)$id)->getRowArray();
    return ($instructor) ? TRUE : FALSE;
}

//Lia -> Get convocatoria curso
function convocatoriaCapacitacion($capacitacionID)
{
    $url = FCPATH . "/assets/uploads/capacitacion/" . $capacitacionID . "/convocatoria/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = base_url("/assets/uploads/capacitacion/" . $capacitacionID . "/convocatoria/" . $files[$i]);
        }
        array_push($data, $config["url"]);
    }
    return $data;
} //convocatoriaCapacitacion


//Lia -> Get convocatoria curso
function convocatoriaCapacitacionJquery($capacitacionID)
{
    $url = FCPATH . "/assets/uploads/capacitacion/" . $capacitacionID . "/convocatoria/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = "assets/uploads/capacitacion/" . $capacitacionID . "/convocatoria/" . $files[$i];
        }
        array_push($data, $config["url"]);
    }
    return $data;
} //convocatoriaCapacitacion

//Lia -> Get convocatoria curso
function fotoEquipoInformatico($clave)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/material/equipoInformatico/" . $clave . ".png";
    $url2 = dirname(WRITEPATH) . "/assets/uploads/material/equipoInformatico/" . $clave . ".jpg";
    $url3 = dirname(WRITEPATH) . "/assets/uploads/material/equipoInformatico/" . $clave . ".JPG";

    $imagen = base_url("assets/images/EquipoInformaticoDefault.jpg");

    if (file_exists($url)) {
        $imagen = base_url("assets/uploads/material/equipoInformatico/" . $clave . ".png");
    } elseif (file_exists($url2)) {
        $imagen = base_url("assets/uploads/material/equipoInformatico/" . $clave . ".jpg");
    } elseif (file_exists($url3)) {
        $imagen = base_url("assets/uploads/material/equipoInformatico/" . $clave . ".JPG");
    }

    return $imagen;
}


function documentosPolitica($idPolitica)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/politicas/" . $idPolitica . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    for ($i = $num_files; $i >= 2; $i--) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = base_url("/assets/uploads/politicas/" . $idPolitica . "/" . $files[$i]);
        }
        array_push($data, $config["url"]);
    }
    return $data;
}

function ultimoDocumentoPolitica($idPolitica)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/politicas/" . $idPolitica . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = base_url("/assets/uploads/politicas/" . $idPolitica . "/" . $files[$i]);
        }
    }
    if (!empty($config["url"])) {
        return $config["url"];
    } else {
        return null;
    }
}

function historialPoliticaUltima($politicaID, $Rtiempo, $Rduracion)
{
    $url = dirname(WRITEPATH) . "/assets/uploads/politicas/" . $politicaID . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;
    if ($num_files >= 2) {
        if (file_exists($url . $files[$num_files])) {
            $config = base_url("/assets/uploads/politicas/" . $politicaID . "/"  . $files[$num_files]);
        }

        //Diferencia de tiempo
        $archivoNombre = explode('/', $config);
        $count = count($archivoNombre) - 1;
        if ($Rduracion == 'month') {
            $duracion = $Rtiempo;
        } else {
            $duracion = ($Rtiempo / 12);
        }

        $fechaNArchivo = explode('.', $archivoNombre[$count]);
        $nombreA = explode('-', $fechaNArchivo[0]);
        $fechaArchivo = $nombreA[1] . '-' . $nombreA[2] . '-' . $nombreA[3];
        $fechaActual = date('Y-m-d');
        $diferencia = diferenciaMeses($fechaActual, $fechaArchivo);

        if ($diferencia < $duracion) {
            $notificacion = 0;
        } else {
            $notificacion = 1;
        }
    } else {
        $notificacion = 0;
    }
    return $notificacion;
}

function get_nombre_dia($fecha)
{
    $dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
    return $dias[date('w', strtotime($fecha))];
}

function proximaFechaHabil($fecha)
{
    $diaInhabil = federacion()->query("SELECT dia_Fecha FROM diainhabil WHERE dia_Fecha = '" . date('Y-m-d', strtotime($fecha)) . "' UNION SELECT dial_Fecha FROM diainhabilley WHERE dial_Fecha = '" . date('Y-m-d', strtotime($fecha)) . "'")->getRowArray();
    // Si la consulta devuelve un resultado, es decir, la fecha es inhabilitada
    if ($diaInhabil) {
        // Incrementar la fecha en un día
        $fecha = date('Y-m-d H:i:s', strtotime($fecha . ' +1 day'));
        // Llamar a la función de nuevo con la nueva fecha
        return proximaFechaHabil($fecha);
    } else {
        // Si la fecha es hábil, retornarla
        return $fecha;
    }
}

//Hora Salida de la federacion a la caja
//Hora Regreso de la caja a la federacion
function calculoHorasExtraxDia($fecha, $dia, $salida, $regreso, $idEmpleado)
{
    $totalHoras = diferenciaHoras($salida, $regreso);
    return (int)$totalHoras;
}

function calculoHorasExtra($inicio, $fin)
{
    return ceil(diferenciaHoras($inicio, $fin));
}

function diferenciaHoras($cadena, $cadena2)
{
    $horaInicio = new DateTime($cadena);
    $horaTermino = new DateTime($cadena2);

    $interval = $horaInicio->diff($horaTermino);
    return $interval->format('%H');
}

function horasExtra($idEmpleado)
{
    $sql = "SELECT SUM(R.rep_Horas) as 'pendientes' FROM reportehoraextra R
            WHERE R.rep_Estado='APLICADO' AND R.rep_Estatus=1 AND R.rep_EmpleadoID=?";
    $horas = db()->query($sql, array($idEmpleado))->getRowArray();

    return $horas['pendientes'];
}


function horarioColaborador($idEmpleado, $tipo, $fecha)
{
    //Si tiene horario de guardia
    $sqlg = "SELECT * FROM guardia G JOIN horario H ON H.hor_HorarioID=G.gua_HorarioID WHERE G.gua_EmpleadoID=? AND ? BETWEEN G.gua_FechaInicio AND G.gua_FechaFin";
    $horario = db()->query($sqlg, array($idEmpleado, $fecha))->getRowArray();

    if (empty($horario) || $horario === null) {
        $sql = "SELECT H.* FROM horario H JOIN empleado E ON E.emp_HorarioID = H.hor_HorarioID WHERE E.emp_EmpleadoID=?";
        $horario = db()->query($sql, array($idEmpleado))->getRowArray();
    }

    $tolerancia = "+" . $horario['hor_Tolerancia'] . " minutes";

    $dia = get_nombre_dia($fecha);
    if ($tipo === 'entrada') {
        $horaTolerancia = strtotime($tolerancia, strtotime($horario["hor_{$dia}Entrada"]));
        $horario = date('h:i', $horaTolerancia);
        return $horario;
    } else {
        return $horario["hor_{$dia}Salida"];
    }
}

function nombreHorarioColaborador($idEmpleado, $fecha)
{
    //Si tiene horario de guardia
    $sqlg = "SELECT * FROM guardia G JOIN horario H ON H.hor_HorarioID=G.gua_HorarioID WHERE G.gua_EmpleadoID=? AND ? BETWEEN G.gua_FechaInicio AND G.gua_FechaFin";
    $horario = db()->query($sqlg, array($idEmpleado, $fecha))->getRowArray()['hor_Nombre'] ?? null;

    if (empty($horario) || $horario === null) {
        $sql = "SELECT H.* FROM horario H JOIN empleado E ON E.emp_HorarioID = H.hor_HorarioID WHERE E.emp_EmpleadoID=?";
        $horario = db()->query($sql, array($idEmpleado))->getRowArray()['hor_Nombre'];
    }

    return $horario;
}

function eliminar_acentos($cadena)
{

    //Reemplazamos la A y a
    $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena
    );

    //Reemplazamos la I y i
    $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena
    );

    //Reemplazamos la O y o
    $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena
    );

    //Reemplazamos la U y u
    $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena
    );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', 'C', 'c'),
        $cadena
    );

    return $cadena;
}

function totalFondoAhorro($idEmpleado)
{
    $sql = "SELECT SUM(fon_Total) as 'total' , MAX(fon_Fecha) as 'fecha' FROM fondoahorro WHERE fon_EmpleadoID= ?";
    return db()->query($sql, array($idEmpleado))->getRowArray();
}

function hojaTransferPrestamoFondo($idPrestamo)
{
    $idPrestamo = encryptDecrypt('decrypt', $idPrestamo);
    $url = dirname(WRITEPATH) . "/assets/uploads/prestamos/fondoahorro/" . $idPrestamo . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = base_url("/assets/uploads/prestamos/fondoahorro/" . $idPrestamo . "/" . $files[$i]);
        }
    }
    if (!empty($config["url"])) {
        return $config["url"];
    } else {
        return null;
    }
}

function totalAdelantos($empleadoID)
{
    $estatus = array('PENDIENTE', 'AUTORIZADO', 'APLICADO');
    $estatus = join("','", $estatus);

    $sql = "SELECT SUM(pre_Monto) as 'total' FROM prestamofondoahorro
    WHERE pre_EmpleadoID= ? AND pre_Estado IN ('$estatus') AND pre_Estatus=1";
    return db()->query($sql, array($empleadoID))->getRowArray();
}

function postalCumpleanios($empleadoID)
{
    $empleadoID = (int)encryptDecrypt('decrypt', $empleadoID);

    $url = dirname(WRITEPATH) . "/assets/images/cumpleanios/" . $empleadoID . ".png";
    $url2 = dirname(WRITEPATH) . "/assets/images/cumpleanios/" . $empleadoID . ".jpg";
    $url3 = dirname(WRITEPATH) . "/assets/images/cumpleanios/" . $empleadoID . ".JPG";
    $imagen = base_url("assets/images/avatar.jpg");

    if (file_exists($url)) {
        $imagen = base_url("/assets/images/cumpleanios/" . $empleadoID . ".png");
    } elseif (file_exists($url2)) {
        $imagen = base_url("/assets/images/cumpleanios/" . $empleadoID . ".jpg");
    } elseif (file_exists($url3)) {
        $imagen = base_url("/assets/images/cumpleanios/" . $empleadoID . ".JPG");
    }

    return $imagen;
}

function postalAniversario($empleadoID)
{
    $empleadoID = (int)encryptDecrypt('decrypt', $empleadoID);

    $url = dirname(WRITEPATH) . "/assets/images/aniversarios/" . $empleadoID . ".png";
    $url2 = dirname(WRITEPATH) . "/assets/images/aniversarios/" . $empleadoID . ".jpg";
    $url3 = dirname(WRITEPATH) . "/assets/images/aniversarios/" . $empleadoID . ".JPG";
    $imagen = base_url("assets/images/avatar.jpg");

    if (file_exists($url)) {
        $imagen = base_url("/assets/images/aniversarios/" . $empleadoID . ".png");
    } elseif (file_exists($url2)) {
        $imagen = base_url("/assets/images/aniversarios/" . $empleadoID . ".jpg");
    } elseif (file_exists($url3)) {
        $imagen = base_url("/assets/images/aniversarios/" . $empleadoID . ".JPG");
    }

    return $imagen;
}

//Diego -> Get fotos ultima galeria
function galeriaFotos()
{
    $ultimaGaleria = db()->query("SELECT gal_Nombre FROM galeria WHERE gal_Estatus=1 ORDER BY gal_Fecha DESC LIMIT 1")->getRowArray();
    $url = FCPATH . "/assets/uploads/galeria/" . $ultimaGaleria['gal_Nombre'];

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;

    $data = array();
    $config = array();
    $n = 0;
    for ($i = 2; $i <= $num_files; $i++) {
        $config["url"] = base_url("/assets/uploads/galeria/" . $ultimaGaleria['gal_Nombre'] . "/" . $files[$i]);
        array_push($data, $config["url"]);
    }
    return $data;
} //materialesCapacitacion


function DescansoColaborador($idEmpleado, $fecha)
{
    //Si tiene horario de guardia
    $sqlg = "SELECT * FROM guardia G JOIN horario H ON H.hor_HorarioID=G.gua_HorarioID WHERE G.gua_EmpleadoID=? AND ? BETWEEN G.gua_FechaInicio AND G.gua_FechaFin";
    $horario = db()->query($sqlg, array($idEmpleado, $fecha))->getRowArray();

    if (empty($horario) || $horario === null) {
        $sql = "SELECT H.* FROM horario H JOIN empleado E ON E.emp_HorarioID = H.hor_HorarioID WHERE E.emp_EmpleadoID=?";
        $horario = db()->query($sql, array($idEmpleado))->getRowArray();
    }

    $dia = get_nombre_dia($fecha);
    return (int)$horario['hor_' . $dia . 'Descanso'];
}


function calcularDiasPermiso($fechaInicio, $fechaFin)
{
    $fechaInicio = new DateTime($fechaInicio);
    $fechaFin = new DateTime($fechaFin);

    $inhabiles = diasInhabilesPermiso();
    $fechaFin = $fechaFin->modify("+1 day");
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($fechaInicio, $interval, $fechaFin);

    $dias = 0;

    foreach ($daterange as $date) {
        if (date('l', strtotime($date->format("Y-m-d"))) !== 'Sunday') {
            if (!in_array($date->format("Y-m-d"), $inhabiles)) {
                $dias++;
            }
        }
    }
    return $dias;
} //calcularDiasPermiso



//Lia -> meses de antiguedad
function antiguedadMeses($emp_fechaIngreso)
{
    $fi = new DateTime($emp_fechaIngreso);
    $fn = new DateTime("now");
    $diff = $fi->diff($fn);

    $meses = $diff->m;

    return $meses;
} //end antiguedad

function cumpleanos($fechaNacimiento)
{
    $from = new DateTime($fechaNacimiento);
    $to   = new DateTime('today');
    return $from->diff($to)->y;
}


function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function domingosAnio()
{
    $anio = date('Y');
    $startDate = new DateTime($anio . '-01-01');
    $endDate = new DateTime($anio . '-12-31');

    $sundays = array();

    while ($startDate <= $endDate) {
        if ($startDate->format('w') == 0) {
            $sundays[] = $startDate->format('Y-m-d');
        }

        $startDate->modify('+1 day');
    }
    return $sundays;
}

function RemoveSpecialChar($str)
{
    $res = str_replace(array("#", "'", ";", " ", "(", ")", "$", "#", "/", "-", "_"), '', $str);
    return $res;
}


function antiguedadMesesAnios($fechaIngreso)
{
    $fecha = new DateTime(date('Y/m/d', strtotime($fechaIngreso))); // Creo un objeto DateTime de la fecha ingresada
    $fecha_hoy =  new DateTime(date('Y/m/d', time())); // Creo un objeto DateTime de la fecha de hoy
    $antiguedad = date_diff($fecha_hoy, $fecha);
    return " {$antiguedad->format('%Y')} años y {$antiguedad->format('%m')} meses";
}


function evidenciaPagoAnticipo($adelantoID, $pago)
{
    $url =  FCPATH . "/assets/uploads/prestamos/anticiposueldo/" . $adelantoID . "/" . $pago . "/";

    if (!file_exists($url)) mkdir($url, 0777, true);

    $directory = $url;
    $files = scandir($directory);
    $num_files = count($files) - 1;
    $config = array();
    for ($i = 2; $i <= $num_files; $i++) {
        if (file_exists($url . $files[$i])) {
            $config["url"] = base_url("/assets/uploads/prestamos/anticiposueldo/" . $adelantoID . "/" . $pago . "/" . $files[$i]);
        }
    }
    if (!empty($config["url"])) {
        return $config["url"];
    } else {
        return null;
    }
}

function getHorasExtraByEmpleado($empleadoID)
{
    $horasExtra = db()->query("SELECT SUM(rep_Horas) as 'horas' FROM reportehoraextra WHERE rep_Estado='PAGADO' AND rep_TipoPago='Tiempo por tiempo' AND rep_EmpleadoID=?", array($empleadoID))->getRowArray()['horas'] ?? 0;
    $horasAcumuladas = db()->query("SELECT acu_HorasExtra as 'horas' FROM acumulados WHERE acu_EmpleadoID=?", [$empleadoID])->getRowArray()['horas'] ?? 0;
    $horasConsumidas = db()->query("SELECT SUM(per_Horas) AS 'horas' FROM permiso WHERE per_Estado IN ('PENDIENTE','AUTORIZADO_GG','AUTORIZADO_GO','AUTORIZADO_RH') AND per_Estatus=1 AND per_EmpleadoID=" . $empleadoID)->getRowArray()['horas'] ?? 0;
    return ($horasExtra + $horasAcumuladas) - $horasConsumidas;
}

function getTipoEmpleado($empleadoID)
{
    return db()->query("SELECT emp_TipoEmp FROM empleado WHERE emp_EmpleadoID=?", [$empleadoID])->getRowArray()['emp_TipoEmp'];
}

function actualizarVacacion($empleado, $dias)
{
    $builder = db()->table('vacacionempleado');
    $builder->update(array('vace_Dias' => $dias, 'vace_FechaActualizacion' => date('Y-m-d H:i:s')), array('vace_EmpleadoID' => $empleado));
    if (db()->affectedRows() > 0) return TRUE;
    else  return FALSE;
}

function diferenciaAnios($f1, $f2)
{
    $from = new DateTime($f1);
    $to   = new DateTime($f2);
    return $from->diff($to)->y;
}

function fechaPresentarse($fechaFinVacacion, $empleadoID)
{
    $fechaRegreso = date('Y-m-d', strtotime('+1 days', strtotime($fechaFinVacacion)));
    if (get_nombre_dia($fechaRegreso) != 'Domingo') {
        $guardia = db()->query("SELECT * FROM guardia WHERE gua_EmpleadoID=? AND ? BETWEEN gua_FechaInicio AND gua_FechaFin", [$empleadoID, $fechaRegreso])->getRowArray();
        if (is_null($guardia)) {
            if (get_nombre_dia($fechaRegreso) == 'Sabado') {
                $fechaRegreso = date('Y-m-d', strtotime('+1 days', strtotime($fechaRegreso)));
                if (get_nombre_dia($fechaRegreso) == 'Domingo') $fechaRegreso = date('Y-m-d', strtotime('+1 days', strtotime($fechaRegreso)));
            }
        } else {
            $fechaRegreso = $fechaRegreso;
        }
    } else {
        $fechaRegreso = date('Y-m-d', strtotime('+1 days', strtotime($fechaRegreso)));
    }
    $sucursal = '["' . db()->query("SELECT emp_SucursalID FROM empleado WHERE emp_EmpleadoID=?", [$empleadoID])->getRowArray()['emp_SucursalID'] . '","0"]';
    $diaInhabil = db()->query("SELECT dial_Fecha AS 'fecha' FROM diainhabilley WHERE dial_Fecha = ?
    UNION
    SELECT dia_Fecha AS 'fecha' FROM diainhabil WHERE dia_Fecha = ? AND JSON_CONTAINS(dia_SucursalID,'" . $sucursal . "')", [$fechaRegreso, $fechaRegreso])->getResultArray();
    if ($diaInhabil) {
        $fechaRegreso = date('Y-m-d', strtotime('+1 days', strtotime($fechaRegreso)));
    }
    return $fechaRegreso;
}

//Diego -> Get fotos ultima galeria
function portadaGaleria($galeriaNombre)
{
    $url = FCPATH . "/assets/uploads/galeria/" . $galeriaNombre;
    if (!file_exists($url)) mkdir($url, 0777, true);
    $directory = $url;
    $files = scandir($directory);
    $data = array();
    $config = array();
    for ($i = 2; $i <= 2; $i++) {
        $config["url"] = base_url("/assets/uploads/galeria/" . $galeriaNombre . "/" . $files[$i]);
        array_push($data, $config["url"]);
    }
    return $data;
} //portadaGaleria

//Diego -> Get fotos ultima galeria
function verGaleriaFotos($album)
{
    $url = FCPATH . "/assets/uploads/galeria/" . $album;

    if (!file_exists($url)) mkdir($url, 0777, true);
    $files = preg_grep('/^([^.])/', scandir($url));
    $data = array();
    $config = array();
    foreach ($files as $file) {
        $config["url"] = base_url("/assets/uploads/galeria/" . $album . "/" . $file);
        array_push($data, $config["url"]);
    }
    return $data;
} //galeriaFotos

function getAnuncio($anuncio)
{
    if ($anuncio == null) {
        return null;
    } else {
        $url = FCPATH . "/assets/uploads/anuncios/" . encryptDecrypt('encrypt', $anuncio) . "/";
        if (!file_exists($url)) mkdir($url, 0777, true);
        $files = preg_grep('/^([^.])/', scandir($url));
        if ($files) {
            sort($files);
            $reproducir = '';
            /*if ($autoplay == true) {
                $reproducir = 'autoplay="true"';
            }*/

            switch (strtolower(substr($files[0], -3))) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                    return '<div id="donut-chart-container" class="flot-chart mt-2" style="height: auto; padding: 0px; position: relative;">
                                <img src="' . base_url("/assets/uploads/anuncios/" . encryptDecrypt('encrypt', $anuncio) . "/" . $files[0]) . '" style="width: 90%;display:block;margin-left:auto;margin-right:auto;margin-top: auto;margin-bottom: auto;" ></img>
                            </div>';
                    break;
                default:
                    return '<div id="donut-chart-container" class="flot-chart mt-2" style="height: auto; padding: 0px; position: relative;">
                                <video src="' . base_url("/assets/uploads/anuncios/" . encryptDecrypt('encrypt', $anuncio) . "/" . $files[0]) . '" type="video/mp4" controls="true" style="width: 90%;display:block;margin-left:auto;margin-right:auto;margin-top: auto;margin-bottom: auto;" ></video>
                            </div>';
                    break;
            }
        } else {
            return null;
        }
    }
}

function archivoAnuncio($anuncioID)
{
    $url = FCPATH . "/assets/uploads/anuncios/" . $anuncioID . "/";
    if (!file_exists($url)) mkdir($url, 0777, true);
    $files = preg_grep('/^([^.])/', scandir($url));
    if ($files) {
        sort($files);
        return base_url("/assets/uploads/anuncios/" . $anuncioID . "/" . $files[0]);
    } else {
        return null;
    }
}

function nombreEmpleadoById($id)
{
    return db()->query("select emp_Nombre from empleado where emp_EmpleadoID =?", array($id))->getRowArray()['emp_Nombre'];
}

function addMenuOption($funcion, $controlador, $nombre)
{
    $permisos = json_decode(session('permisos'), true);
    if (isset($permisos[$funcion])) {
        if (in_array("Ver", $permisos[$funcion])) {
            return '<li><a href="' . base_url($controlador . '/' . $funcion) . '">' . $nombre . '</a></li>';
        }
    }
    return '';
}

function addMenuOptionSingle($funcion, $controlador, $nombre, $icono)
{
    $permisos = json_decode(session('permisos'), true);
    if (isset($permisos[$funcion])) {
        if (in_array("Ver", $permisos[$funcion])) {
            return '<li><a href="' . base_url($controlador . '/' . $funcion) . '"><i class="' . $icono . '"></i><span>' . $nombre . '</span></a></li>';
        }
    }
    return '';
}

function diferenciaTiempo($fechaInicio, $fechaFin)
{
    $start_date = new DateTime(date($fechaInicio));
    $since_start = $start_date->diff(new DateTime(date($fechaFin)));
    $time = "";
    $time .= (($since_start->m > 0 ? $since_start->m . ' mes ' : $since_start->m == 1) ? $since_start->m . ' meses ' : '');
    $time .= (($since_start->d > 0 ? $since_start->d . ' día ' : $since_start->d == 1) ? $since_start->d . ' días ' : '');
    $time .= (($since_start->h > 0 ? $since_start->h . ' horas ' : $since_start->h == 1) ? $since_start->h . ' horas ' : '');
    $time .= (($since_start->i > 0 ? $since_start->i . ' minuto ' : $since_start->i == 1) ? $since_start->i . ' minutos ' : '');
    $time .= (($since_start->s > 0 ? $since_start->s . ' segundos ' : $since_start->s == 1) ? $since_start->s . ' segundos ' : '');
    return $time;
}

function updatePermisos()
{
    return db()->query("SELECT rol_Permisos FROM empleado LEFT JOIN rol ON rol_RolID=emp_Rol WHERE emp_EmpleadoID = ?", [session('id')])->getRowArray()['rol_Permisos'];
}

// Función auxiliar para generar opciones HTML
function generateOptions($items, $valueField, $textField)
{
    $options = '<option value="0">Seleccionar</option>';
    foreach ($items as $item) {
        $options .= "<option value='{$item[$valueField]}'>{$item[$textField]}</option>";
    }
    return $options;
}

function mensajeBienvenida()
{
    $horario = date('H:i');
    $configuraciones = [
        ['inicio' => '06:00', 'fin' => '11:59', 'mensaje' => 'Buenos días', 'icon' => base_url('assets/images/dia/amanecer.svg'), 'color' => '#f7cd5d'],
        ['inicio' => '12:00', 'fin' => '15:59', 'mensaje' => 'Buen día', 'icon' => base_url('assets/images/dia/dia.svg'), 'color' => '#fce391'],
        ['inicio' => '16:00', 'fin' => '18:59', 'mensaje' => 'Buenas tardes', 'icon' => base_url('assets/images/dia/atardecer.svg'), 'color' => '#fb9062'],
        ['inicio' => '19:00', 'fin' => '23:59', 'mensaje' => 'Buenas noches', 'icon' => base_url('assets/images/dia/noche.svg'), 'color' => '#546bab'],
        ['inicio' => '00:00', 'fin' => '05:59', 'mensaje' => 'Buenas noches', 'icon' => base_url('assets/images/dia/noche.svg'), 'color' => '#546bab'],
    ];

    foreach ($configuraciones as $config) {
        if ($horario >= $config['inicio'] && $horario <= $config['fin']) {
            $mensaje = $config['mensaje'];
            $icon = $config['icon'];
            $color = $config['color'];
            break;
        }
    }

    $infoEmpleado = consultar_dato('empleado', 'emp_Sexo,emp_Nombre', 'emp_EmpleadoID =' . session('id'));
    $nombreCompleto = explode(' ', trim($infoEmpleado['emp_Nombre']));
    $nombres = array_slice($nombreCompleto, -2);
    $infoEmpleado['emp_Nombre'] = implode(' ', $nombres);
    
    return [
        'mensaje' => $mensaje,
        'icon' => $icon,
        'color' => $color,
        'nombre' => ucwords(strtolower($infoEmpleado['emp_Nombre'])),
        'genero' => ($infoEmpleado['emp_Sexo'] == 'Femenino') ? 'Bienvenida' : 'Bienvenido'
    ];
    }

    // DEVUELVE EL ULTIMO QUERY REALIZADO A LA BASE DE DATOS
	use Config\Database;

function debugsql() {
    $db = Database::connect();
    $query = $db->getLastQuery(); // Obtener la última consulta ejecutada

    $calledFrom = debug_backtrace();
    echo '<strong>' . $calledFrom[0]['file'] . '</strong>';
    echo ' (line <strong>' . $calledFrom[0]['line'] . '</strong>)';
    echo "\n<pre style=\"background: #f0f0f0; padding: 1em;\">\n";
    echo print_r($query, true) . "\n</pre>\n";
    exit();
}

