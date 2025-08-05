<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['username'];

// Incluye la clase TCPDF
require_once('../TCPDF-main/examples/tcpdf_include.php');

/**
 * Clase extendida de TCPDF con encabezado y pie de página personalizados para la página de TOC (Tabla de contenido).
 */
class TOC_TCPDF extends TCPDF
{

    /**
     * Método para sobrescribir el encabezado.
     * @public
     */
    public function Header()
    {
        if ($this->tocpage) {
            $fecha = date("d/m/Y"); 
            $html = '<table width="100%">
                    <tr>
                    <td align="left"><img src="../../assets/img/logo1.png" width="270" height="75"></td>
                    <td align="right"><span style="font-size: 12pt;">Fecha de Elaboración: ' . $fecha . '</span></td>                 
                    </tr>
                </table>';
            $this->writeHTML($html, true, false, false, false, '');
            // Agregar una línea horizontal después del encabezado
            $this->Ln(0); // Espacio antes de la línea
            $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 310, $this->GetY()); // Dibujar la línea
        } else {
            // Usa el encabezado normal para otras páginas
            parent::Header();
        }
    }

    /**
     * Método para sobrescribir el pie de página.
     * @public
     */
    public function Footer()
    {
        // No necesitas modificar el pie de página en este caso, pero puedes hacerlo si es necesario
        // Si deseas personalizar el pie de página para otras páginas, puedes hacerlo aquí
        parent::Footer();
    }
}

// Crea un nuevo documento PDF
$pdf = new TOC_TCPDF('L', 'mm', array(220, 340), true, 'UTF-8', false);

// Establece la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('Reporte de Inventario de Equipos Tecnológicos');

// Establece los datos del encabezado predeterminado
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// Establece las fuentes del encabezado y pie de página
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Establece la fuente monoespaciada predeterminada
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Establece los márgenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Establece los saltos de página automáticos
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Establece el factor de escala de la imagen
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// Agrega una página para la tabla de contenido (TOC)
$pdf->addTOCPage();

$pdf->SetFont('helvetica', '', 10);
$pdf->Ln(5);
// Iniciar la tabla
$html .= '
<style>
    h1, h3 {
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        text-transform: uppercase;
    }

    table {
        border-collapse: collapse;
        margin-top: 20px;
        width: 100%;
    }
    th {
        border: 1px solid black;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        background-color: #f2f2f2;
    }
    td {
        border: 1px solid black;
        text-align: center;
        padding: 8px;
        font-size: 12px;
    }

    .row-height {
        height: 40px;
    }
</style>

<h1></h1>
<h1>Inventario de Equipos Tecnológicos</h1>
<h1></h1>

';

// Incluir el archivo de conexión a la base de datos
include "../db.php";

// Capturar los datos del formulario
$departamento = $_POST['departamento'];
$tipo_equipo = $_POST['tipo_equipo'];

// Construir la consulta SQL base
$sql = "SELECT * FROM equipos";

// Construir el mensaje según las selecciones del usuario
$mensaje = '';
if ($departamento == 'TODAS' && $tipo_equipo == 'TODAS') {
    $mensaje = 'Reporte general del inventario de equipos.';
} elseif ($departamento != 'TODAS' && $tipo_equipo != 'TODAS') {
    $mensaje = 'Inventario del departamento ' . $departamento . ' y el tipo de equipo ' . $tipo_equipo . '.';
} elseif ($departamento != 'TODAS' && $tipo_equipo == 'TODAS') {
    $mensaje = 'Inventario del departamento ' . $departamento . '.';
} elseif ($departamento == 'TODAS' && $tipo_equipo != 'TODAS') {
    $mensaje = 'Inventario de equipos del tipo ' . $tipo_equipo . '.';
}

// Agregar condiciones de filtrado si se seleccionó un departamento o un tipo de equipo
if (!empty($departamento) && $departamento != 'TODAS') {
    $sql .= " WHERE departamento = '$departamento'";
    if (!empty($tipo_equipo) && $tipo_equipo != 'TODAS') {
        $sql .= " AND tipo_equipo = '$tipo_equipo'";
    }
} elseif (!empty($tipo_equipo) && $tipo_equipo != 'TODAS') {
    $sql .= " WHERE tipo_equipo = '$tipo_equipo'";
}

// Ordenar los resultados por departamento
$sql .= " ORDER BY departamento ASC";

// Ejecutar la consulta SQL
$result = mysqli_query($conexion, $sql);

// Incluir el mensaje en el reporte
$html .= '<h4 style="text-align: left; font-style: italic;">' . $mensaje . '</h4>';

$html .= '

<table>

<tr>
    <th>Departamento</th>
    <th>Usuario</th>
    <th>Equipo</th>
    <th>Marca</th>
    <th>Modelo</th>
    <th>Serial</th>
    <th>Codigo Bienes</th>';

// Añadir las columnas condicionalmente
if ($tipo_equipo == 'Laptop' || $tipo_equipo == 'CPU' || $tipo_equipo == 'TODAS') {
    $html .= '<th>Procesador</th>';
    $html .= '<th>RAM</th>';
    $html .= '<th>Disco Duro</th>';
}

$html .= '<th>Estado</th>
</tr>';

// Verificar si hay resultados
if (mysqli_num_rows($result) > 0) {
    // Recorrer los resultados y agregar filas a la tabla
    while ($fila = mysqli_fetch_assoc($result)) {
        $html .= '<tr>';
        $html .= '<td class="row-height">' . ($fila['departamento'] ? $fila['departamento'] : 'N/T') . '</td>';
        $html .= '<td>' . ($fila['usuario_responsable'] ? $fila['usuario_responsable'] : 'N/T') . '</td>';
        $html .= '<td>' . ($fila['tipo_equipo'] ? $fila['tipo_equipo'] : 'N/T') . '</td>';
        $html .= '<td>' . ($fila['marca'] ? $fila['marca'] : 'N/T') . '</td>';
        $html .= '<td>' . ($fila['modelo'] ? $fila['modelo'] : 'N/T') . '</td>';
        $html .= '<td>' . ($fila['serial'] ? $fila['serial'] : 'N/T') . '</td>';
        $html .= '<td>' . ($fila['codigo_bienes'] ? $fila['codigo_bienes'] : 'N/T') . '</td>';

        // Verificar si el tipo de equipo es igual a "Laptop", "CPU" o "TODAS"
        if ($fila['tipo_equipo'] == 'Laptop' || $fila['tipo_equipo'] == 'CPU' || $tipo_equipo == 'TODAS') {
            // Si es igual, mostrar las siguientes columnas
            $html .= '<td>' . ($fila['procesador'] ? $fila['procesador'] : 'No Aplica') . '</td>';
            $html .= '<td>' . (($fila['cant_memoria'] && $fila['tipo_ram']) ? $fila['cant_memoria'] . " GB - " . $fila['tipo_ram'] : 'No Aplica') . '</td>';
            $html .= '<td>' . (($fila['almacenamiento'] && $fila['tipo_disco']) ? $fila['almacenamiento'] . " GB - " . $fila['tipo_disco'] : 'No Aplica') . '</td>';
        }

        $html .= '<td>' . ($fila['estado'] ? $fila['estado'] : 'Sin Estado') . '</td>';
        $html .= '</tr>';
    }
} else {
    // No hay resultados, mostrar un mensaje
    $html .= '<tr>';
    $html .= '<td colspan="' . (($tipo_equipo == 'Laptop' || $tipo_equipo == 'CPU' || $tipo_equipo == 'TODAS') ? '11' : '8') . '" class="text-center">No se encontraron registros.</td>';
    $html .= '</tr>';
}

// Obtener el número total de filas en el resultado de la consulta
$totalFilas = mysqli_num_rows($result);

$html .= '
    </table>
    <tfoot>
        <tr>
            <td colspan="' . (($tipo_equipo == 'Laptop' || $tipo_equipo == 'CPU' || $tipo_equipo == 'TODAS') ? '11' : '8') . '" style="text-align: left; font-weight: bold; background-color: #f2f2f2;">Total de Equipos Registrados: ' . $totalFilas . '</td>
        </tr>
    </tfoot>
';


$html .= '</table>';


$pdf->writeHTML($html, true, false, false, false, 'C');

// Mueve el puntero a la última página
$pdf->lastPage();
ob_end_clean();

// Close and output PDF document
$pdf->Output($mensaje . ' - ' . date('d-m-Y') . '.pdf', 'I');
