<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * RUTA MAESTRA: Cambia esto si el nombre de tu carpeta en htdocs cambia.
 */
$url_base = "/Odonto/public/index.php?c=";

// OBTENER ROL DESDE LA SESIÓN CORRECTA
$id_rol = $_SESSION['usuario']['rol_id'] ?? 0;

// Controlador y Acción actual para la clase 'active'
$current_c = isset($_GET['c']) ? ucfirst($_GET['c']) : 'Dashboard';
$current_a = isset($_GET['a']) ? $_GET['a'] : '';

/**
 * LÓGICA DE RUTAS SEGÚN EL ROL
 * Si el usuario es Rol 4 (Subadmin), sus rutas deben apuntar a su propio controlador.
 */
$ruta_panel = ($id_rol == 4) ? "Subadmin&a=dashboard" : "Dashboard";
$ruta_expedientes = ($id_rol == 4) ? "Subadmin&a=expedientes" : "Expedientes";
// NUEVA RUTA PARA ASIGNACIONES
$ruta_asignaciones = ($id_rol == 4) ? "Subadmin&a=vincular" : "Asignaciones";
?>

<style>
:root {
    --sb-bg: #ffffff;
    --sb-text: #64748b;
    --sb-accent: #0284c7;
    --sb-hover: #f1f5f9;
    --sb-active-bg: #e0f2fe;
    --sb-danger: #ef4444;
}

.sidebar-wrapper {
    width: 280px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: var(--sb-bg);
    border-right: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    z-index: 1000;
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 1rem 2.5rem 1rem;
    color: var(--sb-accent);
    font-weight: 800;
    font-size: 1.3rem;
}

.nav-label {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #94a3b8;
    margin: 1.8rem 0 0.6rem 1rem;
    font-weight: 700;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 18px;
    text-decoration: none;
    color: var(--sb-text);
    border-radius: 16px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.25s ease;
}

.nav-item:hover {
    background: var(--sb-hover);
    color: var(--sb-accent);
}

.nav-item.active {
    background: var(--sb-active-bg);
    color: var(--sb-accent);
}

.logout-section {
    margin-top: auto;
    padding-top: 1.5rem;
    border-top: 1px solid #f1f5f9;
}

.logout-item {
    color: var(--sb-danger) !important;
}

.logout-item:hover {
    background: #fef2f2 !important;
}
</style>

<aside class="sidebar-wrapper">

    <div class="sidebar-brand">
        <div style="background: linear-gradient(135deg,#0f172a,#0284c7);color:white;padding:10px;border-radius:12px;display:flex;">
            <span class="material-symbols-rounded">dentistry</span>
        </div>
        <span>SIGO UH</span>
    </div>

    <nav style="flex:1; overflow-y:auto;">

        <ul class="nav-menu">
            <li>
                <a href="<?= $url_base ?><?= $ruta_panel ?>"
                    class="nav-item <?= ($current_c == 'Dashboard' || ($current_c == 'Subadmin' && $current_a == 'dashboard')) ? 'active' : '' ?>">
                    <span class="material-symbols-rounded">dashboard</span>
                    <span>Panel Principal</span>
                </a>
            </li>
        </ul>

        <?php if ($id_rol == 1 || $id_rol == 4): ?>
        <div class="nav-label">Clínica</div>
        <ul class="nav-menu">
            <li>
                <a href="<?= $url_base ?><?= $ruta_expedientes ?>"
                    class="nav-item <?= ($current_c == 'Expedientes' || $current_a == 'expedientes') ? 'active' : '' ?>">
                    <span class="material-symbols-rounded">folder_managed</span>
                    <span>Solicitudes</span>
                </a>
            </li>

            <li>
                <a href="<?= $url_base ?><?= $ruta_asignaciones ?>"
                    class="nav-item <?= ($current_c == 'Asignaciones' || $current_a == 'vincular') ? 'active' : '' ?>">
                    <span class="material-symbols-rounded">hub</span>
                    <span>Asignaciones</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>

        <?php if ($id_rol == 1): ?>
        <div class="nav-label">Configuración</div>
        <ul class="nav-menu">
            <li>
                <a href="<?= $url_base ?>Usuarios" class="nav-item <?= ($current_c == 'Usuarios') ? 'active' : '' ?>">
                    <span class="material-symbols-rounded">manage_accounts</span>
                    <span>Usuarios</span>
                </a>
            </li>

            <li>
                <a href="<?= $url_base ?>Bitacora" class="nav-item <?= ($current_c == 'Bitacora') ? 'active' : '' ?>">
                    <span class="material-symbols-rounded">history_edu</span>
                    <span>Bitácora</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>

        <?php if ($id_rol == 2): ?>
        <div class="nav-label">Docencia</div>
        <ul class="nav-menu">
            <li>
                <a href="<?= $url_base ?>Docentes&a=alumnos"
                    class="nav-item <?= ($current_c == 'Docentes') ? 'active' : '' ?>">
                    <span class="material-symbols-rounded">group</span>
                    <span>Mis Alumnos</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>

    </nav>

    <div class="logout-section">
        <a href="<?= $url_base ?>Auth&a=logout" class="nav-item logout-item">
            <span class="material-symbols-rounded">logout</span>
            <span>Cerrar Sesión</span>
        </a>
    </div>

</aside>