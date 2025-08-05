<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

// Incluye la clase TCPDF
require_once('../TCPDF-main/tcpdf.php');

/**
 * Clase extendida de TCPDF con encabezado y pie de página personalizados.
 */
class TOC_TCPDF extends TCPDF
{
    public function Header()
    {
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        /**
         * $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');  */
    }
}

// Crea un nuevo documento PDF
$pdf = new TOC_TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Establece la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Frank Guiche');
$pdf->SetTitle('FORMATO REVISION DE EQUIPOS');
$pdf->SetSubject('Acta Revisión de Equipos Junio 2024');
$pdf->SetKeywords('TCPDF, PDF, acta, revisión, equipos');

// Establece los márgenes
$pdf->SetMargins(5, 25, 7);

// Establece los saltos de página automáticos
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Establece el factor de escala de la imagen
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Añadir una página
$pdf->AddPage();

// Establecer fuente
$pdf->SetFont('dejavusans', '', 8);
$pdf->SetFont('helvetica', '', 8);


// Incluir el archivo de conexión a la base de datos
include "../db.php";

// Obtener el ID de la revisión desde la URL
if (isset($_GET['id_acta'])) {
    $id = intval($_GET['id_acta']); // Asegurarse de que el ID sea un entero
} else {
    die('ID de revisión no proporcionado');
}

// Obtener los datos de la revisión
$sql = "SELECT * FROM acta_revision WHERE id_acta = $id";
$result = mysqli_query($conexion, $sql);
if (!$result) {
    die('Consulta fallida: ' . mysqli_error($conexion));
}
$row = mysqli_fetch_assoc($result);

// Verificar que se haya encontrado el registro
if (!$row) {
    die('Registro no encontrado');
}

// Formatear la fecha de revisión (suponiendo que $row['fecha_revision'] es una cadena en formato 'YYYY-MM-DD')
$fecha_revision_formateada = date('d/m/Y', strtotime($row['fecha_revision']));

// Convertir los saltos de línea en <br> en accesorios_perifericos
$accesorios_perifericos_formateado = nl2br($row['accesorios_perifericos']);

// Convertir los saltos de línea en <br> en resultado_revision
$resultado_revision_formateado = nl2br($row['resultado_revision']);

// Convertir los saltos de línea en <br> en conclusion_revision
$conclusion_revision_formateado = nl2br($row['conclusion_revision']);

// Establecer el contenido del PDF
$html = '
<table width="100%">
    <tr>
        <td width="55%">
            <img src="../../assets/img/logo1.png" width="280" height="90">
        </td>
        <td width="45%">
        <h3 style="text-align: right; font-size: 9pt; text-transform: uppercase; line-height: 0.5; font-weight: bold;">Departamento de Informática</h3>
            <h1 style="text-align: right; font-size: 15pt; text-transform: uppercase; line-height: 0.5; font-weight: bold;">Acta de Revisión de Equipos</h1>
            <table border="1.5" cellpadding="4" width="100%">
                <tr>
                    <td width="30%" style="text-align: center; font-weight: bold; font-size: 11pt; line-height: 0.8;"><b>Nº</b></td>
                    <td width="70%" style="text-align: center; font-weight: bold; font-size: 11pt; line-height: 0.8;"><b>FECHA</b></td>
                </tr>
                <tr>
                    <td style="text-align: center; color: red; font-weight: bold; font-size: 10pt;">' . $row['id_acta'] . '</td>
                    <td style="text-align: center;">' . $fecha_revision_formateada . '</td>
                </tr>
            </table>
        </td>
    </tr>
    </table>


    <br><br>

    <table border="1.5" cellpadding="4" width="100%" style="border-collapse: collapse;">
    <tr style="font-weight: bold; font-size: 9pt;">
        <td>DESCRIPCIÓN DEL EQUIPO:</td>
        <td>UNIDAD DE TRABAJO:</td>
        <td rowspan="6" style="text-align: center; vertical-align: middle;">
            <span>FIRMA RESPONSABLE (S) DE USO:</span><br><br><br><br><br>
            <span style="font-size: 8pt; color: #999;">FIRMA Y SELLO</span>
        </td>
    </tr>
    <tr style="font-size: 10pt;">
        <td height="70">' . $row['descripcion_equipo'] . '</td>
        <td>' . $row['unidad_trabajo'] . '</td>
    </tr>
    <tr style="font-weight: bold; font-size: 9pt;">
        <td>SERIAL:</td>
        <td>RESPONSABLE (S) DE USO:</td>
    </tr>
    <tr>
        <td>' . $row['serial'] . '</td>
        <td style="border-bottom: 1px solid white; font-size: 10pt;">' . $row['responsable_uso'] . '</td>
    </tr>
    <tr>
        <td style="font-weight: bold; font-size: 9pt;">CÓDIGO DE BIEN:</td>
        
    </tr>
    <tr style="font-size: 10pt;">
        <td>
            <span style="color: red; font-weight: bold;">3-1800-1-37-2- </span>' . $row['codigo_bienes'] . '
        </td>
    </tr>


    <tr>
        <td colspan="3">
            <table border="0" cellpadding="4" width="100%" style="border-collapse: collapse; font-family: dejavusans;">
                <tr style="font-size: 8pt;">
                    <td width="45%">
                        <span style="font-weight: bold; font-size: 9pt;">ESTADO:</span>
                            ' . getEstadoCheckbox($row['estado_equipo'], 'BUENO') . '
                            ' . getEstadoCheckbox($row['estado_equipo'], 'REGULAR') . '
                            ' . getEstadoCheckbox($row['estado_equipo'], 'DETERIORADO') . '
                    </td>

                    <td width="55%">
                        <span style="font-weight: bold; font-size: 9pt;">OPERATIVIDAD:</span>
                            ' . getOperatividadCheckbox($row['operatividad'], 'ENCIENDE') . '
                            ' . getOperatividadCheckbox($row['operatividad'], 'NO ENCIENDE') . '
                            ' . getOperatividadCheckbox($row['operatividad'], 'OTROS:') . '
                        </td>
                </tr>
        
            </table>
        </td>
    </tr>   
    <tr>
        <td colspan="3" height="70">
            <span style="font-weight: bold; font-size: 9pt;">ACCESORIOS Y/O PERIFÉRICOS:</span><br><br>
        ' . $accesorios_perifericos_formateado . '
        </td>
    </tr>

    <tr>
        <td colspan="3" height="240">
            <span style="font-weight: bold; font-size: 9pt;">RESULTADOS DE LA REVISIÓN:</span><br><br>
        ' . $resultado_revision_formateado . '
        </td>
    </tr>

    <tr>
        <td colspan="3" height="125">
            <span style="font-weight: bold; font-size: 9pt;">CONCLUCIONES Y/O RECOMENDACIONES:</span><br><br>
        ' . $conclusion_revision_formateado . '
        </td>
    </tr>

    <tr>
        <td rowspan="6" style="text-align: left; vertical-align: middle;">
            <span style="font-weight: bold; font-size: 9pt;">ELABORADO POR:</span><br><br>
            <span style="color: #222222;">' . $row['user_elaboracion'] . '</span><br><br>
        </td>
        <td rowspan="6" style="text-align: left; vertical-align: middle;">
            <span style="font-weight: bold; font-size: 9pt;">REVISADO POR:</span><br><br>
            <span style="color: #222222;">' . $row['user_revision'] . '</span><br><br>
        </td>
        <td rowspan="6" style="text-align: left; vertical-align: middle;">
            <span style="font-weight: bold; font-size: 9pt;">JEFE DE INFORMÁTICA:</span><br><br><br><br>
            <span style="font-size: 8pt; color: #999;"></span>
        </td>
    </tr>
</table>



';


// Función para obtener el checkbox de estado
function getEstadoCheckbox($estado, $valor) {
    $check = '<span class="checkbox" style="font-weight: bold; font-size: 12pt;">&#9744;</span>'; // Check vacío por defecto
    if ($estado == $valor) {
        $check = '<span class="checkbox" style="font-weight: bold; font-size: 12pt;">&#9745;</span>'; // Check marcado
    }
    return $check . ' ' . $valor . ' ';
}

// Función para obtener el checkbox de operatividad
function getOperatividadCheckbox($operatividad, $valor) {
    $check = '<span class="checkbox" style="font-weight: bold; font-size: 12pt;">&#9744;</span>'; // Check vacío por defecto
    if ($operatividad == $valor) {
        $check = '<span class="checkbox" style="font-weight: bold; font-size: 12pt;">&#9745;</span>'; // Check marcado
    }
    return $check . ' ' . $valor . ' ';
}

$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar y generar el PDF

// Obtener el id, descripcion_equipo y unidad_trabajo
$id = $row['id_acta'];
$descripcion_equipo = $row['descripcion_equipo'];
$unidad_trabajo = $row['unidad_trabajo'];

// Dividir la descripción del equipo en palabras y tomar las primeras tres
$descripcion_equipo_palabras = explode(' ', $descripcion_equipo);
$descripcion_equipo_limitada = implode(' ', array_slice($descripcion_equipo_palabras, 0, 3));

// Formatear el nombre del archivo
$nombre_archivo_base = 'FORMATO REVISION DE EQUIPOS ' . $id . '.' . $descripcion_equipo_limitada . ' ' . $unidad_trabajo;

// Convertir a mayúsculas
$nombre_archivo_base = strtoupper($nombre_archivo_base);

// Añadir la extensión en minúsculas
$nombre_archivo = $nombre_archivo_base . '.pdf';

// Generar el PDF
$pdf->Output($nombre_archivo, 'I');


