<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/Asignacion.php';
require_once __DIR__ . '/../../vendor/autoload.php'; 

class DocentesController {

    // 1. IMPORTANTE: Declarar la propiedad
    private $asignacionModel;

    // 2. IMPORTANTE: El constructor para inicializar el modelo
    public function __construct() {
        $this->asignacionModel = new Asignacion();
    }

    public function dashboard() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 2) {
            header("Location: index.php");
            exit;
        }

        $docenteId = $_SESSION['usuario']['id'];
        
        // Ahora $this->asignacionModel ya no es null
        $alumnos = $this->asignacionModel->obtenerPorDocente($docenteId);

        require_once __DIR__ . '/../views/docente/dashboard.php';
    }

    public function misAlumnos() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 2) {
            header("Location: index.php");
            exit;
        }

        $docenteId = $_SESSION['usuario']['id']; 
        $alumnos = $this->asignacionModel->obtenerPorDocente($docenteId);

        require_once __DIR__ . '/../views/docente/mis_alumnos.php';
    }

    public function alumnos() {
        if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['rol_id'], [1, 4])) {
            header("Location: index.php");
            exit;
        }

        $docentes = $this->asignacionModel->obtenerDocentesConAsignaciones();

        $alumnos = [];
        if (!empty($_GET['docente'])) {
            $alumnos = $this->asignacionModel->obtenerPorDocente($_GET['docente']);
        }

        require_once __DIR__ . '/../views/admin/alumnos_docente.php';
    }

    public function exportar() {
        // Permitir a Admin (1), Docente (2) y Subadmin (4)
        if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['rol_id'], [1, 2, 4])) {
            exit('Acceso denegado');
        }

        // Si es docente, solo sus alumnos. Si es admin/subadmin, por facultad.
        if ($_SESSION['usuario']['rol_id'] == 2) {
            $alumnos = $this->asignacionModel->obtenerPorDocente($_SESSION['usuario']['id']);
        } else {
            $alumnos = $this->asignacionModel->obtenerAsignacionesPorFacultad('CIENCIAS DE LA SALUD');
        }

        if (empty($alumnos)) {
            exit('No hay alumnos registrados para generar este reporte.');
        }

        try {
            $mpdf = new \Mpdf\Mpdf([
                'margin_top' => 45,
                'margin_header' => 10,
                'margin_footer' => 10,
                'format' => 'Letter'
            ]);

            $urlLogo = 'https://www.hipocrates.edu.mx/assets/img/logo.png'; 
      
            $html = '
            <style>
                body { font-family: "Helvetica", sans-serif; color: #334155; }
                .header-table { width: 100%; border-bottom: 3px solid #84cc16; padding-bottom: 15px; }
                .logo-img { height: 65px; }
                .main-title { color: #005596; font-size: 16pt; font-weight: bold; margin: 0; text-align: right; }
                .sub-title { color: #84cc16; font-size: 11pt; font-weight: bold; margin-top: 5px; text-align: right; }
                table.data-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                table.data-table th { background-color: #005596; color: white; font-size: 9pt; padding: 12px 8px; text-align: left; }
                table.data-table td { padding: 10px 8px; border-bottom: 1px solid #e2e8f0; font-size: 9.5pt; }
                .row-alt { background-color: #f8fafc; }
                .footer { font-size: 8pt; text-align: center; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
            </style>

            <table class="header-table">
                <tr>
                    <td style="width: 40%; border: none;">
                        <img src="' . $urlLogo . '" class="logo-img">
                    </td>
                    <td style="width: 60%; border: none;">
                        <div class="main-title">REPORTE DE ACTIVIDAD CLÍNICA</div>
                        <div class="sub-title">Facultad de Ciencias de la Salud</div>
                    </td>
                </tr>
            </table>

            <p style="text-align: right; font-size: 8pt; color: #64748b;">Generado el: ' . date('d/m/Y H:i A') . '</p>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Docente Responsable</th>
                        <th>Nombre del Alumno</th>
                        <th style="text-align: center;">Matrícula</th>
                        <th style="text-align: center;">Fecha</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($alumnos as $index => $a) {
                $class = ($index % 2 != 0) ? 'class="row-alt"' : '';
                $html .= '
                <tr ' . $class . '>
                    <td style="font-weight: bold; color: #005596;">' . htmlspecialchars($a['docente_nombre'] ?? $_SESSION['usuario']['nombre']) . '</td>
                    <td>' . htmlspecialchars($a['alumno_nombre']) . '</td>
                    <td style="text-align: center;">' . $a['alumno_matricula'] . '</td>
                    <td style="text-align: center;">' . date('d/m/Y', strtotime($a['fecha_asignacion'])) . '</td>
                </tr>';
            }

            $html .= '</tbody></table>

            <htmlpagefooter name="myFooter">
                <div class="footer">Página {PAGENO} de {nbpg} - Universidad Hipócrates</div>
            </htmlpagefooter>
            <sethtmlpagefooter name="myFooter" value="on" />';

            $mpdf->WriteHTML($html);
            
            if (ob_get_contents()) ob_end_clean();
            $mpdf->Output('Reporte_Clinico_UH.pdf', 'D');

        } catch (\Mpdf\MpdfException $e) {
            exit('Error: ' . $e->getMessage());
        }
        exit;
    }

    public function verExpediente() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_id'] != 2) {
            exit("No autorizado");
        }

        $matricula = $_GET['matricula'] ?? null;
        if (!$matricula) exit("Matrícula requerida");

        require_once __DIR__ . '/../models/Expediente.php';
        $expedienteModel = new Expediente();

        $expediente = $expedienteModel->obtenerOCrear($matricula, ""); 
        $consultas = $expedienteModel->obtenerConsultas($expediente['id']);

        require_once __DIR__ . '/../views/docente/gestionar_expediente.php';
    }
}