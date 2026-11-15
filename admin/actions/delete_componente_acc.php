<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $componente = Componente::get_x_id($id);

    if ($componente) {
        $componente->delete();
    }

} catch (Exception $e) {
    switch ($e->getCode()) {
        case 23000:
            die("No se pudo eliminar el componente, ya que hay artefactos usando el componente.");
        default:
            die("No se pudo eliminar el componente.");
    }
}

header('Location: ../index.php?sec=admin_componentes');
