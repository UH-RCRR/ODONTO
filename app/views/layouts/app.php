<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div style="display:flex; min-height:100vh;">

    <!-- SIDEBAR -->
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <!-- CONTENIDO -->
    <div style="flex:1; padding:30px;">
        <?php require_once $view; ?>
    </div>

</div>