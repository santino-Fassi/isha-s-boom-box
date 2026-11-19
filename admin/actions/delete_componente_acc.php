<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $componente = Componente::get_x_id($id);

    if ($componente) {
        $componente->delete();
        Alerta::add_alerta("success", "Componente eliminado", "El componente fue eliminado del sistema.", false);
    }

} catch (Exception $e) {
    switch ($e->getCode()) {
        case 23000:
            Alerta::add_alerta("danger", "Eliminación bloqueada", "No se pudo eliminar el componente porque existen artefactos que lo utilizan.", false);
        default:
            Alerta::add_alerta("danger", "Error al eliminar", "No se pudo eliminar el componente.", false);
    }
}

header('Location: ../index.php?sec=admin_componentes');
