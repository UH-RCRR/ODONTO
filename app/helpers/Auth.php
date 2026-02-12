<?php
function requireSubadmin() {
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'subadmin') {
        header("Location: /login");
        exit;
    }
}
